<?php
// ============================================================
// config.php
// Prize ladder, tier map, session helpers, auth helpers,
// leaderboard helpers. Required by every page.
// NO JavaScript. NO database. Sessions + cookies only.
// ============================================================

// ── Prize Ladder (levels 1-15) ───────────────────────────────
define('PRIZE_LADDER', [
    1  => '$100',
    2  => '$200',
    3  => '$300',
    4  => '$500',
    5  => '$1,000',      // safe haven
    6  => '$2,000',
    7  => '$4,000',
    8  => '$8,000',
    9  => '$16,000',
    10 => '$32,000',     // safe haven
    11 => '$64,000',
    12 => '$125,000',
    13 => '$250,000',
    14 => '$500,000',
    15 => '$1,000,000',
]);

// Safe-haven levels — wrong answer awards the last safe haven, not $0
define('SAFE_HAVENS', [5, 10]);

// ── Tier Map ─────────────────────────────────────────────────
// 'class' is echoed directly into the span class attribute
// to match the frontend CSS: .tier-badge.easy / .medium / .hard
define('TIER_MAP', [
    'easy'   => ['class' => 'easy',   'label' => 'Pop Culture & Web Basics'],
    'medium' => ['class' => 'medium', 'label' => 'Technology & CS Concepts'],
    'hard'   => ['class' => 'hard',   'label' => 'LeetCode Algorithm Tier'],
]);
define('USERS_FILE',  __DIR__ . '/data/users.json');
define('SCORES_FILE', __DIR__ . '/data/scores.json');

function load_json(string $path): array {
    if (!file_exists($path)) return [];
    $raw = file_get_contents($path);
    return json_decode($raw, true) ?? [];
}

function save_json(string $path, array $data): void {
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
}
// ── Tier for Level ────────────────────────────────────────────
function get_tier_for_level(int $level): string {
    if ($level <= 5)  return 'easy';
    if ($level <= 10) return 'medium';
    return 'hard';
}

// ── Prize string for a level ─────────────────────────────────
function get_prize_for_level(int $level): string {
    $ladder = PRIZE_LADDER;
    return $ladder[$level] ?? '$0';
}

// ── Banked prize (safe-haven fallback) ───────────────────────
// Returns the prize a player keeps after a wrong answer
function get_banked_prize(int $current_level): string {
    $banked = '$0';
    foreach (SAFE_HAVENS as $sh) {
        if ($current_level > $sh) {
            $banked = get_prize_for_level($sh);
        }
    }
    return $banked;
}

// ── Prize string → integer for leaderboard sorting ───────────
function prize_to_int(string $prize): int {
    return (int) preg_replace('/[^0-9]/', '', $prize);
}

// ── Ladder row CSS class ──────────────────────────────────────
// Called in game.php foreach — returns 'active'|'won'|'safe'|'future'
// All four classes are already in style.css
function get_ladder_class(int $lvl): string {
    $current = (int)($_SESSION['current_level'] ?? 1);
    if ($lvl === $current)                              return 'active';
    if ($lvl < $current && in_array($lvl, SAFE_HAVENS)) return 'safe';
    if ($lvl < $current)                               return 'won';
    return 'future';
}

// ── Auth guard ────────────────────────────────────────────────
// Call at the very top of every protected page
function require_login(): void {
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit;
    }
}

// ── User store ────────────────────────────────────────────────
// Flat session-based store — no database required
// $_SESSION['users'][lowercase_username] = [
//   'display'       => string  (original casing),
//   'email'         => string,
//   'password_hash' => string  (bcrypt),
// ]

function user_exists(string $username): bool {
    return isset($_SESSION['users'][strtolower(trim($username))]);
}

function register_user(string $username, string $email, string $password): void {
    if (!isset($_SESSION['users'])) {
        $_SESSION['users'] = [];
    }
    $_SESSION['users'][strtolower(trim($username))] = [
        'display'       => $username,
        'email'         => strtolower(trim($email)),
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
    ];
}

function verify_user(string $username, string $password): bool {
    $key = strtolower(trim($username));
    if (!isset($_SESSION['users'][$key])) {
        return false;
    }
    return password_verify($password, $_SESSION['users'][$key]['password_hash']);
}

// ── Leaderboard ───────────────────────────────────────────────
// $_SESSION['scores'][username] = [
//   'best_prize'   => '$32,000',
//   'best_level'   => 10,
//   'games_played' => 3,
// ]

function update_leaderboard(string $username, string $prize, int $level_reached): void {
    if (!isset($_SESSION['scores'])) {
        $_SESSION['scores'] = [];
    }
    $prev = $_SESSION['scores'][$username] ?? [
        'best_prize'   => '$0',
        'best_level'   => 0,
        'games_played' => 0,
    ];

    // Only update best if this game beat the previous record
    if ($level_reached > $prev['best_level']) {
        $prev['best_prize'] = $prize;
        $prev['best_level'] = $level_reached;
    }
    $prev['games_played']++;
    $_SESSION['scores'][$username] = $prev;
}

// Returns array indexed from 1, sorted by best_level desc
function get_sorted_scores(): array {
    $scores = $_SESSION['scores'] ?? [];
    uasort($scores, function ($a, $b) {
        if ($b['best_level'] !== $a['best_level']) {
            return $b['best_level'] - $a['best_level'];
        }
        return $a['games_played'] - $b['games_played'];
    });
    $ranked = [];
    $rank   = 1;
    foreach ($scores as $username => $data) {
        $ranked[$rank] = array_merge(['username' => $username], $data);
        $rank++;
    }
    return $ranked;
}

// ── AI Advisor — Anthropic API curl call ─────────────────────
// Returns a 2-3 sentence reasoning HINT (never the answer)
function get_ai_hint(string $question_text, array $visible_options): string {
    $api_key = getenv('ANTHROPIC_API_KEY');

    // Graceful fallback if key not configured
    if (!$api_key) {
        return 'Think carefully about each option. Eliminate answers you are confident are wrong before committing.';
    }

    // Build options list for the prompt
    $opts_text = '';
    foreach ($visible_options as $i => $opt) {
        $opts_text .= chr(65 + $i) . ') ' . $opt['text'] . "\n";
    }

    $prompt = "You are an AI Advisor in a Who Wants to Be a Millionaire game. "
            . "A player is stuck on this question:\n\n"
            . "QUESTION: {$question_text}\n\n"
            . "OPTIONS:\n{$opts_text}\n"
            . "Give the player a 2-3 sentence reasoning HINT that guides their thinking "
            . "WITHOUT revealing the correct answer. Focus on the concept being tested. "
            . "Be encouraging and analytical.";

    $payload = json_encode([
        'model'      => 'claude-sonnet-4-6',
        'max_tokens' => 200,
        'messages'   => [['role' => 'user', 'content' => $prompt]],
    ]);

    $ch = curl_init('https://api.anthropic.com/v1/messages');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'x-api-key: ' . $api_key,
            'anthropic-version: 2023-06-01',
        ],
        CURLOPT_TIMEOUT        => 15,
    ]);

    $response = curl_exec($ch);
    $err      = curl_error($ch);
    curl_close($ch);

    if ($err || !$response) {
        return 'Think carefully about each option. Eliminate answers you are confident are wrong before committing.';
    }

    $data = json_decode($response, true);
    return $data['content'][0]['text']
        ?? 'Think carefully about each option. Eliminate answers you are confident are wrong before committing.';
}

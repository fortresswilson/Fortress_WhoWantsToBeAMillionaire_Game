<?php
// ============================================================
// game.php  —  Core Game Engine
//
// Session variables set here (read directly by frontend HTML):
//   $_SESSION['current_level']  int     1–15
//   $_SESSION['current_prize']  string  '$1,000'
//   $_SESSION['tier_class']     string  'easy'|'medium'|'hard'
//   $_SESSION['tier_label']     string  human-readable tier name
//   $_SESSION['lifelines']      array   ['fifty_fifty'=>bool,'walk_away'=>bool,'ai_advisor'=>bool]
//
// PHP variables exposed to the view (frontend HTML reads these):
//   $question_text  string
//   $answers        array  [['text'=>string, 'eliminated'=>bool], ...]
//   $show_ai_panel  bool
//   $ai_hint        string
//   $prize_ladder   array  (PRIZE_LADDER constant — all 15 levels)
// ============================================================
session_start();
require_once 'config.php';
require_once 'questions.php';

// ── Auth guard ────────────────────────────────────────────────
require_login();

// ── Initialize a fresh game ───────────────────────────────────
// Runs only when no active question pool exists (new game / after result)
if (empty($_SESSION['questions'])) {
    $pool  = build_game_pool();   // 15 questions: 5 easy, 5 medium, 5 hard
    $tier  = get_tier_for_level(1);
    $tmap  = TIER_MAP;

    $_SESSION['questions']      = $pool;
    $_SESSION['current_level']  = 1;
    $_SESSION['current_prize']  = PRIZE_LADDER[1];
    $_SESSION['tier_class']     = $tmap[$tier]['class'];
    $_SESSION['tier_label']     = $tmap[$tier]['label'];
    $_SESSION['lifelines']      = [
        'fifty_fifty' => false,
        'walk_away'   => false,
        'ai_advisor'  => false,
    ];
    $_SESSION['eliminated']     = [];   // indices of 50:50-removed answers
    $_SESSION['ai_hint_cache']  = '';
    $_SESSION['show_ai_panel']  = false;
}

// ── Handle POST ───────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ── Lifeline activation ──────────────────────────────────
    if (isset($_POST['lifeline'])) {
        $lifeline = trim(filter_input(INPUT_POST, 'lifeline', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
        $allowed  = ['fifty_fifty', 'walk_away', 'ai_advisor'];

        if (in_array($lifeline, $allowed, true)) {

            switch ($lifeline) {

                // ── 50:50 ────────────────────────────────────
                // server picks 2 wrong indices at random,
                // stores in $_SESSION['eliminated'], frontend applies .eliminated class
                case 'fifty_fifty':
                    if (!$_SESSION['lifelines']['fifty_fifty']) {
                        $_SESSION['lifelines']['fifty_fifty'] = true;
                        $q_index     = $_SESSION['current_level'] - 1;
                        $question    = $_SESSION['questions'][$q_index];
                        $correct_idx = $question['correct_index'];

                        // Pick 2 wrong indices to eliminate
                        $wrong = [];
                        for ($i = 0; $i < 4; $i++) {
                            if ($i !== $correct_idx) $wrong[] = $i;
                        }
                        shuffle($wrong);
                        $_SESSION['eliminated'] = array_slice($wrong, 0, 2);
                    }
                    break;

                //  Walk Away: banks safe-haven prize (get_banked_prize),
                // updates leaderboard, sets outcome='walk', PRG to results.php
                // ── Walk Away ────────────────────────────────
                case 'walk_away':
                    if (!$_SESSION['lifelines']['walk_away']) {
                        $_SESSION['lifelines']['walk_away'] = true;
                        $level  = $_SESSION['current_level'];
                        $banked = get_banked_prize($level);

                        update_leaderboard(
                            $_SESSION['username'],
                            $banked,
                            prize_to_int($banked)
                        );

                        $_SESSION['outcome']        = 'walk';
                        $_SESSION['final_prize']    = $banked;
                        $_SESSION['correct_answer'] = '';

                        unset(
                            $_SESSION['questions'],
                            $_SESSION['eliminated'],
                            $_SESSION['ai_hint_cache'],
                            $_SESSION['show_ai_panel']
                        );

                        header('Location: results.php');
                        exit;
                    }
                    break;

                //  — AI Advisor: PHP curl POST to Anthropic API,
                // passes question + visible options, receives 2-3 sentence hint,
                // stored in $_SESSION['ai_hint_cache'], shown via $show_ai_panel
                // Tracked in $_SESSION['lifelines']['ai_advisor'] — one use per game
                // ── AI Advisor ───────────────────────────────
                case 'ai_advisor':
                    if (!$_SESSION['lifelines']['ai_advisor']) {
                        $_SESSION['lifelines']['ai_advisor'] = true;

                        $q_index  = $_SESSION['current_level'] - 1;
                        $question = $_SESSION['questions'][$q_index];

                        // Build visible options (respects 50:50 elimination)
                        $visible = [];
                        foreach ($question['options'] as $i => $opt) {
                            if (!in_array($i, $_SESSION['eliminated'] ?? [])) {
                                $visible[$i] = ['text' => $opt];
                            }
                        }

                        $_SESSION['ai_hint_cache'] = get_ai_hint($question['text'], $visible);
                        $_SESSION['show_ai_panel'] = true;
                    }
                    break;
            }
        }

        // PRG — reload game page after any lifeline
        header('Location: game.php');
        exit;
    }

        // SPRINT 3: PRG pattern — every answer POST immediately redirects (GET)
    // Prevents double-submission on refresh. $_SESSION updated before redirect.
    // ── Answer submission ────────────────────────────────────
    if (isset($_POST['answer_index'])) {
        $answer_index = (int) filter_input(INPUT_POST, 'answer_index', FILTER_SANITIZE_NUMBER_INT);
        $level        = $_SESSION['current_level'];
        $q_index      = $level - 1;
        $question     = $_SESSION['questions'][$q_index];
        $correct_idx  = $question['correct_index'];

        // Clear per-question state on every submission
        $_SESSION['show_ai_panel'] = false;
        $_SESSION['ai_hint_cache'] = '';
        $_SESSION['eliminated']    = [];

        if ($answer_index === $correct_idx) {

            // ── CORRECT ──────────────────────────────────────
            if ($level === 15) {
                // WIN — reached top of the ladder
                $prize = PRIZE_LADDER[15];
                update_leaderboard($_SESSION['username'], $prize, prize_to_int($prize));

                $_SESSION['outcome']        = 'win';
                $_SESSION['final_prize']    = $prize;
                $_SESSION['correct_answer'] = '';

                unset(
                    $_SESSION['questions'],
                    $_SESSION['eliminated'],
                    $_SESSION['ai_hint_cache'],
                    $_SESSION['show_ai_panel']
                );

                header('Location: results.php');
                exit;
            }

            // Advance to next level
            $next = $level + 1;
            $tmap = TIER_MAP;
            $tier = get_tier_for_level($next);

            $_SESSION['current_level'] = $next;
            $_SESSION['current_prize'] = PRIZE_LADDER[$next];
            $_SESSION['tier_class']    = $tmap[$tier]['class'];
            $_SESSION['tier_label']    = $tmap[$tier]['label'];

            // PRG — reload with updated session
            header('Location: game.php');
            exit;

        } else {

            // ── WRONG ────────────────────────────────────────
            $banked = get_banked_prize($level);
            update_leaderboard($_SESSION['username'], $banked, prize_to_int($banked));

            $_SESSION['outcome']        = 'loss';
            $_SESSION['final_prize']    = $banked;
            $_SESSION['correct_answer'] = $question['options'][$correct_idx];

            unset(
                $_SESSION['questions'],
                $_SESSION['eliminated'],
                $_SESSION['ai_hint_cache'],
                $_SESSION['show_ai_panel']
            );

            header('Location: results.php');
            exit;
        }
    }

    // Catch-all for malformed POST
    header('Location: game.php');
    exit;
}

// ── GET: prepare view variables ───────────────────────────────
$level         = $_SESSION['current_level'];
$q_index       = $level - 1;
$question      = $_SESSION['questions'][$q_index];
$question_text = $question['text'];

// Build $answers array — frontend iterates over this
$answers = [];
foreach ($question['options'] as $i => $opt) {
    $answers[$i] = [
        'text'       => $opt,
        'eliminated' => in_array($i, $_SESSION['eliminated'] ?? []),
    ];
}

$show_ai_panel = (bool) ($_SESSION['show_ai_panel'] ?? false);
$ai_hint       = (string)($_SESSION['ai_hint_cache']  ?? '');
$prize_ladder  = PRIZE_LADDER;

// ── Render — include header then frontend HTML shell ──────────
require_once 'header.php';
?>

<main class="game-layout">
  <section class="game-main">

    <div>
      <span class="tier-badge <?php echo strtolower($_SESSION['tier_class']); ?>">
        <?php echo htmlspecialchars($_SESSION['tier_label']); ?>
      </span>
    </div>

    <div class="question-card">
      <div class="q-level">LEVEL <?php echo $_SESSION['current_level']; ?> &bull; <?php echo $_SESSION['current_prize']; ?></div>
      <h2 class="q-text"><?php echo htmlspecialchars($question_text); ?></h2>
    </div>

    <div class="answers-grid">
      <?php foreach ($answers as $i => $answer): ?>
        <form method="POST" action="game.php">
          <input type="hidden" name="answer_index" value="<?php echo $i; ?>">
          <button type="submit"
                  class="answer-btn <?php echo $answer['eliminated'] ? 'eliminated' : ''; ?>">
            <span class="a-letter"><?php echo chr(65 + $i); ?></span>
            <?php echo htmlspecialchars($answer['text']); ?>
          </button>
        </form>
      <?php endforeach; ?>
    </div>

    <div class="lifelines-row">
      <span class="ll-label">Lifelines:</span>

      <form method="POST" action="game.php">
        <input type="hidden" name="lifeline" value="fifty_fifty">
        <button type="submit"
                class="lifeline-btn <?php echo $_SESSION['lifelines']['fifty_fifty'] ? 'used' : ''; ?>"
                <?php echo $_SESSION['lifelines']['fifty_fifty'] ? 'disabled' : ''; ?>>
          50:50
        </button>
      </form>

      <form method="POST" action="game.php">
        <input type="hidden" name="lifeline" value="walk_away">
        <button type="submit"
                class="lifeline-btn <?php echo $_SESSION['lifelines']['walk_away'] ? 'used' : ''; ?>"
                <?php echo $_SESSION['lifelines']['walk_away'] ? 'disabled' : ''; ?>>
          Walk Away
        </button>
      </form>

      <form method="POST" action="game.php">
        <input type="hidden" name="lifeline" value="ai_advisor">
        <button type="submit"
                class="lifeline-btn <?php echo $_SESSION['lifelines']['ai_advisor'] ? 'used' : ''; ?>"
                <?php echo $_SESSION['lifelines']['ai_advisor'] ? 'disabled' : ''; ?>>
          &#9733; AI Advisor
        </button>
      </form>
    </div>

    <?php if ($show_ai_panel): ?>
      <div class="ai-panel visible">
        <div class="ai-title">&#9733; AI Advisor &mdash; Reasoning Hint</div>
        <p class="ai-text">&ldquo;<?php echo htmlspecialchars($ai_hint); ?>&rdquo;</p>
      </div>
    <?php endif; ?>

  </section>

  <aside class="game-sidebar">
    <div class="ladder-title">Prize Ladder</div>
    <?php foreach (array_reverse($prize_ladder, true) as $lvl => $amt): ?>
      <div class="prize-row <?php echo get_ladder_class($lvl); ?>">
        <span class="prize-num"><?php echo $lvl; ?></span>
        <span class="prize-amt"><?php echo $amt; ?></span>
      </div>
    <?php endforeach; ?>
  </aside>
</main>

</body>
</html>

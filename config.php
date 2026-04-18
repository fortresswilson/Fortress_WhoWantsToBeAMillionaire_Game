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


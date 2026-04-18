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

<?php
// ============================================================
// results.php
// Reads outcome from $_SESSION, sets $outcome_icon / $outcome_title /
// $outcome_class / $final_prize / $correct_answer_text for the
// frontend HTML shell, then cleans up game session keys.
// ============================================================
session_start();
require_once 'config.php';

// Auth guard — must be logged in to see results
require_login();

// Guard — if no outcome set, game was never played
if (!isset($_SESSION['outcome'])) {
    header('Location: game.php');
    exit;
}

$outcome = $_SESSION['outcome'];

switch ($outcome) {
    case 'win':
        $outcome_icon  = '🏆';
        $outcome_title = 'You Are a Millionaire!';
        $outcome_class = 'win';
        break;
    case 'walk':
        $outcome_icon  = '🚶';
        $outcome_title = 'You Walked Away!';
        $outcome_class = 'walk';
        break;
    case 'loss':
    default:
        $outcome_icon  = '❌';
        $outcome_title = 'Unlucky — So Close!';
        $outcome_class = 'loss';
        break;
}

$final_prize         = $_SESSION['final_prize']    ?? '$0';
$correct_answer_text = $_SESSION['correct_answer'] ?? '';

// Clean up game-specific keys — preserve username + users + scores
unset(
    $_SESSION['outcome'],
    $_SESSION['final_prize'],
    $_SESSION['correct_answer'],
    $_SESSION['current_level'],
    $_SESSION['current_prize'],
    $_SESSION['tier_class'],
    $_SESSION['tier_label'],
    $_SESSION['lifelines'],
    $_SESSION['questions'],
    $_SESSION['eliminated'],
    $_SESSION['ai_hint_cache'],
    $_SESSION['show_ai_panel']
);

require_once 'header.php';
?>

<main class="result-wrap">
  <div class="result-icon">
    <?php echo $outcome_icon; ?>
  </div>

  <h1 class="result-title"><?php echo htmlspecialchars($outcome_title); ?></h1>

  <div class="result-prize <?php echo $outcome_class; ?>">
    <?php echo htmlspecialchars($final_prize); ?>
  </div>

  <?php if ($outcome_class === 'loss' && $correct_answer_text !== ''): ?>
    <p style="color:var(--text-muted);margin-bottom:24px;">
      The correct answer was:
      <strong style="color:var(--text-primary)"><?php echo htmlspecialchars($correct_answer_text); ?></strong>
    </p>
  <?php endif; ?>

  <div class="result-actions">
    <a href="leaderboard.php" class="btn-primary">View Leaderboard</a>
    <a href="game.php" class="btn-secondary">Play Again</a>
  </div>
</main>

</body>
</html>

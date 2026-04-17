<main class="result-wrap">
  <div class="result-icon">
    <?php echo $outcome_icon; // e.g. 🏆, ❌, 🚶‍♂️ ?>
  </div>
  <h1 class="result-title"><?php echo htmlspecialchars($outcome_title); ?></h1>
  
  <div class="result-prize <?php echo $outcome_class; ?>">
    <?php echo htmlspecialchars($final_prize); ?>
  </div>

  <?php if ($outcome_class === 'loss'): ?>
    <p style="color: var(--text-muted); margin-bottom: 24px;">
      The correct answer was: <strong style="color: var(--text-primary)"><?php echo htmlspecialchars($correct_answer_text); ?></strong>
    </p>
  <?php endif; ?>

  <div class="result-actions">
    <a href="leaderboard.php" class="btn-primary">View Leaderboard</a>
    <a href="index.php" class="btn-secondary">Play Again</a>
  </div>
</main>
<main class="game-layout">
  <section class="game-main">
    
    <div>
      <span class="tier-badge <?php echo strtolower($_SESSION['tier_class']); ?>">
        <?php echo htmlspecialchars($_SESSION['tier_label']); ?>
      </span>
    </div>

    <div class="question-card">
      <div class="q-level">LEVEL <?php echo $_SESSION['current_level']; ?> • <?php echo $_SESSION['current_prize']; ?></div>
      <h2 class="q-text"><?php echo htmlspecialchars($question_text); ?></h2>
    </div>

    <div class="answers-grid">
      <?php foreach ($answers as $i => $answer): ?>
        <form method="POST" action="game.php">
          <input type="hidden" name="answer_index" value="<?php echo $i; ?>">
          <button type="submit" class="answer-btn <?php echo (isset($answer['eliminated']) && $answer['eliminated']) ? 'eliminated' : ''; ?>">
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
        <button type="submit" class="lifeline-btn <?php echo $_SESSION['lifelines']['fifty_fifty'] ? 'used' : ''; ?>">
          50:50
        </button>
      </form>

      <form method="POST" action="game.php">
        <input type="hidden" name="lifeline" value="walk_away">
        <button type="submit" class="lifeline-btn">
          Walk Away
        </button>
      </form>

      <form method="POST" action="game.php">
        <input type="hidden" name="lifeline" value="ai_advisor">
        <button type="submit" class="lifeline-btn <?php echo $_SESSION['lifelines']['ai_advisor'] ? 'used' : ''; ?>">
          ★ AI Advisor
        </button>
      </form>
    </div>

    <?php if ($show_ai_panel): ?>
      <div class="ai-panel visible">
        <div class="ai-title">★ AI Advisor — Reasoning Hint</div>
        <p class="ai-text">"<?php echo htmlspecialchars($ai_hint); ?>"</p>
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
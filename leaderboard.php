<?php
// ============================================================
// leaderboard.php
// Reads $_SESSION['scores'], sorts via get_sorted_scores(),
// exposes $sorted_scores for the frontend table HTML.
// Frontend reads: $row['username'], $row['best_prize'],
//                 $row['games_played'], $_SESSION['username']
// ============================================================
session_start();
require_once 'config.php';

// Auth guard — leaderboard is only visible when logged in
require_login();

// get_sorted_scores() returns array indexed 1..N, sorted by best_level desc
$sorted_scores = get_sorted_scores();

require_once 'header.php';
?>

<main class="lb-wrap">
  <h1 class="lb-title">Leaderboard</h1>
  <table class="lb-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Player</th>
        <th>Best Prize</th>
        <th>Games Played</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($sorted_scores)): ?>
        <tr>
          <td colspan="4" style="text-align:center;color:var(--text-muted);padding:32px">
            No games played yet. Be the first on the board!
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($sorted_scores as $rank => $row): ?>
          <tr class="<?php echo ($row['username'] === $_SESSION['username']) ? 'me ' : ''; ?><?php echo ($rank <= 3) ? 'top' : ''; ?>">
            <td><span class="lb-rank"><?php echo $rank; ?></span></td>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td style="color:var(--gold);font-weight:600"><?php echo htmlspecialchars($row['best_prize']); ?></td>
            <td><?php echo (int)$row['games_played']; ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

  <div style="text-align:center;margin-top:32px">
    <a href="game.php" class="btn-primary">Play Again</a>
    <a href="index.php" class="btn-secondary" style="margin-left:12px">Home</a>
  </div>
</main>

</body>
</html>

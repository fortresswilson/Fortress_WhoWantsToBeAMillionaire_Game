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
      <?php foreach ($sorted_scores as $rank => $row): ?>
        <tr class="<?php echo ($row['username'] === $_SESSION['username']) ? 'me ' : ''; ?><?php echo ($rank <= 3) ? 'top' : ''; ?>">
          <td><span class="lb-rank"><?php echo $rank; ?></span></td>
          <td><?php echo htmlspecialchars($row['username']); ?></td>
          <td style="color: var(--gold); font-weight: 600;"><?php echo htmlspecialchars($row['best_prize']); ?></td>
          <td><?php echo (int)$row['games_played']; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Who Wants to Be a Millionaire | Home</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>
  <nav class="main-nav">
    <div class="nav-logo">Who Wants to Be a Millionaire</div>
    <div class="nav-user">
      <?php if (isset($_SESSION["username"])): ?>
          <span><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
          <a href="logout.php">Logout</a>
      <?php else: ?>
          <a href="login.php">Log In</a>
          <a href="register.php">Register</a>
      <?php endif; ?>
    </div>
  </nav>

  <main class="hero">
    <h1 class="hero-title">Who Wants to Be a Millionaire</h1>
    <p class="hero-subtitle">Test your programming knowledge, climb the prize ladder, and become a frontend millionaire.</p>
    <div class="cta-group">
      <a href="login.php" class="btn-primary">Sign In to Play</a>
      <a href="register.php" class="btn-secondary">Create Account</a>
    </div>
  </main>

  <section class="tier-preview">
    <div class="tier-card">
      <h3>Easy Tier</h3>
      <p>Levels 1-5. Warm-up questions covering basic Web Programming syntax, HTML structures, and CSS properties.</p>
    </div>
    <div class="tier-card">
      <h3>Medium Tier</h3>
      <p>Levels 6-10. Intermediate challenges requiring a deeper understanding of responsive design and system logic.</p>
    </div>
    <div class="tier-card">
      <h3>LeetCode Tier</h3>
      <p>Levels 11-15. Complex algorithmic questions and advanced concepts. Use your lifelines wisely to survive.</p>
    </div>
  </section>

</body>
</html>
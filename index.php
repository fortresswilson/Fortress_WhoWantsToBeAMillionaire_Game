<?php
// ============================================================
// index.php
// Public landing page. If user is already logged in, redirect
// directly to game.php. Otherwise show hero + tier preview.
// ============================================================
session_start();
require_once 'config.php';
g
// Redirect already-authenticated users straight to the game
if (isset($_SESSION['username'])) {
    header('Location: game.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Who Wants to Be a Millionaire | Home</title>
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>


<nav class="main-nav">
  <div class="nav-logo">Who Wants to Be a Millionaire</div>
  <div class="nav-user">
    <a href="login.php">Log In</a>
    <a href="register.php">Register</a>
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
    <p>Levels 1&ndash;5. Warm-up questions covering basic Web Programming syntax, HTML structures, and CSS properties.</p>
  </div>
  <div class="tier-card">
    <h3>Medium Tier</h3>
    <p>Levels 6&ndash;10. Intermediate challenges requiring a deeper understanding of responsive design and system logic.</p>
  </div>
  <div class="tier-card">
    <h3>LeetCode Tier</h3>
    <p>Levels 11&ndash;15. Complex algorithmic questions and advanced concepts. Use your lifelines wisely to survive.</p>
  </div>
</section>

</body>
</html>

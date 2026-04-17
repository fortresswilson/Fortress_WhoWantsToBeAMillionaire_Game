<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Who Wants to Be a Millionaire</title>
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
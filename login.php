<?php
// ============================================================
// login.php
// Authenticates credentials via verify_user(), sets $_SESSION,
// uses PRG redirect on success. Renders frontend HTML shell.
// ============================================================
session_start();
require_once 'config.php';

// Already logged in — go straight to game
if (isset($_SESSION['username'])) {
    header('Location: game.php');
    exit;
}

$login_error = '';
$registered  = (isset($_GET['registered']) && $_GET['registered'] === '1');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $login_error = 'Please enter both your username and password.';
    } elseif (!verify_user($username, $password)) {
        $login_error = 'Incorrect username or password. Please try again.';
    } else {
        // ── Successful login ─────────────────────────────
        session_regenerate_id(true);          // prevent session fixation
        $_SESSION['username'] = $username;    // key the frontend reads
        header('Location: game.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Who Wants to Be a Millionaire | Sign In</title>
  <link rel="stylesheet" href="css/style.css">
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


<main class="auth-wrap">
  <div class="auth-card">
    <div class="auth-logo">Sign In</div>
    <div class="auth-subtitle">Welcome back</div>

    <?php if ($registered): ?>
      <div class="error-box" style="background:rgba(46,204,113,0.1);border-left-color:var(--green-win);color:var(--green-win)">
        <p>Account created! Sign in to start playing.</p>
      </div>
    <?php endif; ?>

    <?php if (!empty($login_error)): ?>
      <div class="error-box">
        <p><?php echo htmlspecialchars($login_error); ?></p>
      </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="Your username" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <button type="submit" class="btn-primary" style="width:100%">Sign In to Play</button>
    </form>

    <p style="text-align:center;margin-top:16px;font-size:13px;color:var(--text-muted)">
      New player?
      <a href="register.php" style="color:var(--gold)">Create an account</a>
    </p>
  </div>
</main>

</body>
</html>

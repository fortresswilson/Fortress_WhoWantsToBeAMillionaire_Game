<?php
// ============================================================
// register.php
// Handles new-user registration.
// POST → validate → password_hash → register_user → PRG redirect
// GET  → render form (with sticky values on validation failure)
// ============================================================
session_start();
require_once 'config.php';

// Already logged in — go to landing page
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$errors       = [];
$old_username = '';
$old_email    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize inputs
    $username         = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
    $email            = trim(filter_input(INPUT_POST, 'email',    FILTER_SANITIZE_EMAIL)         ?? '');
    $password         = $_POST['password']         ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Preserve for sticky form re-render
    $old_username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    $old_email    = htmlspecialchars($email,    ENT_QUOTES, 'UTF-8');

    // ── Validation ─────────────────────────────────────────
    if ($username === '') {
        $errors[] = 'Username is required.';
    } elseif (strlen($username) < 3 || strlen($username) > 20) {
        $errors[] = 'Username must be between 3 and 20 characters.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors[] = 'Username may only contain letters, numbers, and underscores.';
    } elseif (user_exists($username)) {
        $errors[] = 'That username is already taken. Please choose another.';
    }

    if ($email === '') {
        $errors[] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    if ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match.';
    }

    // ── Register + PRG ─────────────────────────────────────
    if (empty($errors)) {
        register_user($username, $email, $password);
        header('Location: login.php?registered=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Who Wants to Be a Millionaire | Register</title>
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

<!-- Frontend HTML shell (teammate's file) — PHP variables injected above -->
<main class="auth-wrap">
  <div class="auth-card">
    <div class="auth-logo">Register</div>
    <div class="auth-subtitle">Create your account</div>

    <?php if (!empty($errors)): ?>
      <div class="error-box">
        <?php foreach ($errors as $e): ?>
          <p><?php echo htmlspecialchars($e); ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="register.php">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username"
               placeholder="Choose a username"
               value="<?php echo $old_username; ?>"
               required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email"
               placeholder="Your GSU email address"
               value="<?php echo $old_email; ?>"
               required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>
      </div>
      <button type="submit" class="btn-primary" style="width:100%">Create Account</button>
    </form>

    <p style="text-align:center;margin-top:16px;font-size:13px;color:var(--text-muted)">
      Already have an account?
      <a href="login.php" style="color:var(--gold)">Sign in</a>
    </p>
  </div>
</main>

</body>
</html>

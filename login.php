<main class="auth-wrap">
  <div class="auth-card">
    <div class="auth-logo">Sign In</div>
    <div class="auth-subtitle">Welcome back</div>
    
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
      <button type="submit" class="btn-primary" style="width: 100%">Sign In to Play</button>
    </form>
  </div>
</main>
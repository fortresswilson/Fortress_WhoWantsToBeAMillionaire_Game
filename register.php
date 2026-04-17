<main class="auth-wrap">
  <div class="auth-card">
    <div class="auth-logo">Register</div>
    <div class="auth-subtitle">Create your account</div>
    
    <?php if (!empty($errors)): ?>
      <div class="error-box">
        <?php foreach ($errors as $e) echo "<p>" . htmlspecialchars($e) . "</p>"; ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="register.php">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="Choose a username" value="<?php echo htmlspecialchars($old_username ?? ''); ?>" required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" placeholder="Your GSU email address" value="<?php echo htmlspecialchars($old_email ?? ''); ?>" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>
      </div>
      <button type="submit" class="btn-primary" style="width: 100%">Create Account</button>
    </form>
  </div>
</main>
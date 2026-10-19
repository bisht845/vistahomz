<?php
  /**
   * NOVAHOMZ Admin — Login Page
   */
  require_once __DIR__ . '/../config/db.php';
  require_once __DIR__ . '/../includes/auth.php';

  // Already logged in — redirect to dashboard
  if (isAdminLoggedIn()) {
      header('Location: ' . BASE_URL . '/admin/dashboard.php');
      exit;
  }

  $error = '';
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email    = trim($_POST['email'] ?? '');
      $password = trim($_POST['password'] ?? '');
      if (!$email || !$password) {
          $error = 'Please enter both email and password.';
      } elseif (!adminLogin($email, $password)) {
          $error = 'Invalid credentials. Please try again.';
          sleep(1); // brute-force throttle
      } else {
          header('Location: ' . BASE_URL . '/admin/dashboard.php');
          exit;
      }
  }
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — NOVAHOMZ</title>
    <link rel="icon" href="<?php echo BASE_URL; ?>/assets/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
      :root { --brown:#a56a4f; --beige:#f5f0eb; }
      * { box-sizing: border-box; }
      body { background: linear-gradient(135deg, #1a1a1a 0%, #2d1f17 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
      .login-card { background: #fff; border-radius: 20px; padding: 48px 40px; width: 100%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,0.4); }
      .login-logo { text-align: center; margin-bottom: 32px; }
      .login-logo img { width: 72px; height: 72px; }
      .login-logo h2 { font-weight: 800; font-size: 1.4rem; margin: 10px 0 2px; letter-spacing: 0.05em; }
      .login-logo p { color: #888; font-size: 0.82rem; }
      label { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #666; display: block; margin-bottom: 7px; }
      .form-control { border: 1.5px solid #e0e0e0; border-radius: 10px; padding: 11px 14px; font-size: 0.9rem; width: 100%; margin-bottom: 18px; outline: none; transition: border-color 0.2s; }
      .form-control:focus { border-color: var(--brown); }
      .btn-login { background: var(--brown); color: #fff; border: none; border-radius: 10px; padding: 13px; width: 100%; font-weight: 700; font-size: 0.95rem; cursor: pointer; letter-spacing: 0.04em; transition: background 0.2s; }
      .btn-login:hover { background: #8a5540; }
      .alert-error { background: rgba(200,0,0,0.08); color: #c00; border: 1px solid rgba(200,0,0,0.2); border-radius: 10px; padding: 12px 16px; font-size: 0.85rem; margin-bottom: 20px; }
      .back-link { display: block; text-align: center; margin-top: 20px; font-size: 0.82rem; color: #888; text-decoration: none; }
      .back-link:hover { color: var(--brown); }
    </style>
  </head>
  <body>
    <div class="login-card">
      <div class="login-logo">
        <img src="<?php echo BASE_URL; ?>/assets/images/logo.png" alt="NOVAHOMZ">
        <h2>VISTAHOMZ</h2>
        <p>Admin Control Panel</p>
      </div>

      <?php if ($error): ?>
      <div class="alert-error"><i class="bi bi-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <form method="POST">
        <label>Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="admin@vistahomz.com"
              value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required autofocus>
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        <button type="submit" class="btn-login">Sign In to Admin Panel</button>
      </form>

      <a href="<?php echo BASE_URL; ?>/index.php" class="back-link">← Back to Website</a>
    </div>
  </body>
  </html>

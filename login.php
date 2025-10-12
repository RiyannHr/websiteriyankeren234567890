<?php
// login.php
session_start();
include 'koneksi.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($username === '' || $password === '') {
        $err = 'Isi username dan password.';
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, username, password FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($res)) {
            // Untuk demo: password disimpan polos (admin/admin).
            // Pada proyek nyata gunakan password_hash() dan password_verify().
            if ($password === $row['password']) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                header("Location: dashboard.php");
                exit;
            } else {
                $err = 'Username atau password salah.';
            }
        } else {
            $err = 'Username atau password salah.';
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login - Warung Sederhana</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .wrap { max-width:420px; margin:2rem auto; background:#fff; padding:1.25rem; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.08); }
    label { display:block; margin-top:.5rem; font-weight:600; }
  </style>
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="brand">Warung Sederhana</div>
      <div><a href="index.php" class="btn btn-primary">Home</a></div>
    </div>
  </header>

  <main class="container">
    <div class="wrap">
      <h2>Login</h2>
      <?php if ($err): ?>
        <div style="color:#b00020; margin-bottom:.5rem;"><?= htmlspecialchars($err) ?></div>
      <?php endif; ?>
      <form method="post">
        <label>Username</label>
        <input class="input" type="text" name="username" required>
        <label>Password</label>
        <input class="input" type="password" name="password" required>
        <div style="margin-top:.75rem;">
          <button class="btn btn-primary" type="submit">Login</button>
        </div>
      </form>
      <p style="margin-top:.75rem; font-size:.9rem;">Demo login: <strong>admin / admin</strong></p>
    </div>
  </main>

  <footer class="site-footer">
    <div class="container">
      &copy; <span id="year"></span> Warung Sederhana
    </div>
  </footer>
  <script src="script.js"></script>
</body>
</html>

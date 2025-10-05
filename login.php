<?php
session_start();

// jika sudah login, langsung ke dashboard
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // autentikasi sederhana
    if ($username === 'admin' && $password === '123') {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container" style="max-width:400px; margin-top:80px;">
    <h2 style="text-align:center;">Login</h2>
    <?php if ($error): ?>
      <p style="color:red; text-align:center;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" style="display:flex; flex-direction:column; gap:.75rem;">
      <input type="text" name="username" placeholder="Username" required class="input">
      <input type="password" name="password" placeholder="Password" required class="input">
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>
</body>
</html>

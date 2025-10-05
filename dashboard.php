<?php
session_start();

// jika belum login, redirect ke login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// ambil username dari session
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <span class="brand">Dashboard</span>
      <nav>
        <a href="logout.php" class="btn btn-primary">Logout</a>
      </nav>
    </div>
  </header>

  <main class="container">
    <h2>Selamat datang, <?php echo htmlspecialchars($username); ?> 👋</h2>
    <p>Ini adalah halaman dashboard yang hanya bisa diakses setelah login.</p>

    <hr style="margin:1rem 0;">
    <a href="index.php" class="btn btn-primary">Kembali ke Halaman Utama</a>
  </main>

  <footer class="site-footer">
    <p>&copy; <span id="year"></span> Sistem Login PHP Sederhana</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>

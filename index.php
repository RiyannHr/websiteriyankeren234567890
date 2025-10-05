<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Halaman Utama</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <span class="brand">Sistem Pemesanan Makanan</span>
      <nav>
        <?php if (isset($_SESSION['username'])): ?>
          <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
          <a href="logout.php" class="btn btn-primary">Logout</a>
        <?php else: ?>
          <a href="login.php" class="btn btn-primary">Login</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main class="container">
    <h2>Selamat datang di Aplikasi Pemesanan!</h2>
    <p>Gunakan fitur pencarian dan pemesanan yang tersedia di bawah ini.</p>
    <hr style="margin:1rem 0;">
    
    <!-- form dan elemen dari script.js -->
    <form id="searchForm" class="search-form">
      <input type="text" id="searchInput" class="input-search" placeholder="Cari menu...">
      <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <section class="menu-section">
      <h2>Daftar Menu</h2>
      <ul class="menu-grid">
        <li class="menu-item">Nasi Goreng — Rp15.000</li>
        <li class="menu-item">Mie Ayam — Rp12.000</li>
        <li class="menu-item">Sate Ayam — Rp20.000</li>
        <li class="menu-item">Bakso — Rp13.000</li>
      </ul>
    </section>

    <hr style="margin:1rem 0;">
    <form id="orderForm">
      <input type="text" id="orderInput" class="input" placeholder="Masukkan nama menu...">
      <button type="submit" class="btn btn-primary">Pesan</button>
    </form>
  </main>

  <footer class="site-footer">
    <p>&copy; <span id="year"></span> Sistem Pemesanan</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>

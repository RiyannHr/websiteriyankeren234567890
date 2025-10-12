<?php
// index.php
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM menu ORDER BY created_at DESC");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Warung Sederhana - Home</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="brand">Warung Sederhana</div>
      <div>
        <a href="login.php" class="btn btn-primary">Login</a>
      </div>
    </div>
  </header>

  <main class="container">
    <section class="menu-section">
      <h2>Menu</h2>
      <form id="searchForm" class="search-form" onsubmit="return false;">
        <input id="searchInput" class="input-search" placeholder="Cari menu..." />
        <button class="btn btn-primary" onclick="document.getElementById('searchForm').dispatchEvent(new Event('submit'));">Cari</button>
      </form>

      <ul class="menu-grid">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
          <li class="menu-item">
            <strong><?= htmlspecialchars($row['nama']) ?></strong> — Rp <?= number_format($row['harga'],0,',','.') ?><br>
            <small><?= htmlspecialchars($row['kategori']) ?></small>
            <p><?= htmlspecialchars($row['deskripsi']) ?></p>
          </li>
        <?php endwhile; ?>
      </ul>
    </section>

    <section style="margin-top:1.25rem;">
      <h2>Pesan Sekarang</h2>
      <form id="orderForm">
        <input id="orderInput" class="input" placeholder="Nama menu yang ingin dipesan" />
        <button class="btn btn-primary" type="submit">Pesan</button>
      </form>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container">
      &copy; <span id="year"></span> Warung Sederhana
    </div>
  </footer>

  <script src="script.js"></script>
</body>
</html>

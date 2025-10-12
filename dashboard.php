<?php
// dashboard.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$notif = '';

// HANDLE CREATE
if (isset($_POST['tambah'])) {
    $nama = trim($_POST['nama']);
    $harga = (int)$_POST['harga'];
    $kategori = trim($_POST['kategori']);
    $deskripsi = trim($_POST['deskripsi']);

    $stmt = mysqli_prepare($conn, "INSERT INTO menu (nama, harga, kategori, deskripsi) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "siss", $nama, $harga, $kategori, $deskripsi);
    if (mysqli_stmt_execute($stmt)) {
        $notif = 'Menu berhasil ditambahkan.';
    } else {
        $notif = 'Gagal menambahkan menu.';
    }
}

// HANDLE DELETE
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $stmt = mysqli_prepare($conn, "DELETE FROM menu WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        $notif = 'Menu berhasil dihapus.';
    } else {
        $notif = 'Gagal menghapus menu.';
    }
}

// READ
$result = mysqli_query($conn, "SELECT * FROM menu ORDER BY id DESC");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard - Warung Sederhana</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .wrap { padding:1rem 0; }
    table { width:100%; border-collapse:collapse; margin-top:.75rem; }
    th, td { border:1px solid #e6e6e6; padding:.5rem; text-align:left; }
    th { background:#f6f6f6; }
    .actions a { margin-right:.5rem; text-decoration:none; }
    .topbar { display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-bottom:.75rem; }
    .form-inline input, .form-inline select { margin-right:.5rem; }
  </style>
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="brand">Dashboard - Warung Sederhana</div>
      <div>
        <span style="margin-right:.75rem;">Hi, <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="logout.php" class="btn btn-primary">Logout</a>
      </div>
    </div>
  </header>

  <main class="container wrap">
    <?php if ($notif): ?>
      <div style="background:#e8f5e9; padding:.5rem; border-radius:6px; margin-bottom:.75rem;"><?= htmlspecialchars($notif) ?></div>
    <?php endif; ?>

    <div class="topbar">
      <div style="flex:1;">
        <h2>Kelola Menu</h2>
      </div>
    </div>

    <div style="background:#fff; padding:1rem; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.04);">
      <h3>Tambah Menu</h3>
      <form method="post" class="form-inline">
        <input class="input" type="text" name="nama" placeholder="Nama menu" required>
        <input class="input" type="number" name="harga" placeholder="Harga" required>
        <input class="input" type="text" name="kategori" placeholder="Kategori">
        <input class="input" type="text" name="deskripsi" placeholder="Deskripsi">
        <button class="btn btn-primary" name="tambah" type="submit">Tambah</button>
      </form>

      <h3 style="margin-top:1rem;">Daftar Menu</h3>
      <table>
        <thead>
          <tr>
            <th>ID</th><th>Nama</th><th>Harga</th><th>Kategori</th><th>Deskripsi</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td>Rp <?= number_format($row['harga'],0,',','.') ?></td>
              <td><?= htmlspecialchars($row['kategori']) ?></td>
              <td><?= htmlspecialchars($row['deskripsi']) ?></td>
              <td class="actions">
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus menu ini?')">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
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

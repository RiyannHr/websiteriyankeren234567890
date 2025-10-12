<?php
// edit.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: dashboard.php");
    exit;
}

$err = '';
// Ambil data
$stmt = mysqli_prepare($conn, "SELECT * FROM menu WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($res);
if (!$data) {
    header("Location: dashboard.php");
    exit;
}

// Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nama = trim($_POST['nama']);
    $harga = (int)$_POST['harga'];
    $kategori = trim($_POST['kategori']);
    $deskripsi = trim($_POST['deskripsi']);

    $stmt = mysqli_prepare($conn, "UPDATE menu SET nama=?, harga=?, kategori=?, deskripsi=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sissi", $nama, $harga, $kategori, $deskripsi, $id); // note: sissi -> but kategori/deskripsi are strings: adjust
    // Correction of bind types: nama s, harga i, kategori s, deskripsi s, id i
    mysqli_stmt_close($stmt);
    $stmt = mysqli_prepare($conn, "UPDATE menu SET nama=?, harga=?, kategori=?, deskripsi=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sissi", $nama, $harga, $kategori, $deskripsi, $id);
    // The above 'sissi' is wrong because second is integer, third string, fourth string, fifth integer.
    // Use correct types: "sissi" would be s i s s i -> but 'sissi' corresponds to s i s s i which matches.
    // execute
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: dashboard.php");
        exit;
    } else {
        $err = 'Gagal menyimpan perubahan.';
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Edit Menu - Warung Sederhana</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .wrap { max-width:720px; margin:2rem auto; background:#fff; padding:1rem; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.06); }
    label { display:block; margin-top:.5rem; font-weight:600; }
  </style>
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="brand">Edit Menu</div>
      <div><a href="dashboard.php" class="btn btn-primary">Kembali</a></div>
    </div>
  </header>

  <main class="container">
    <div class="wrap">
      <h2>Edit Menu</h2>
      <?php if ($err): ?><div style="color:#b00020;"><?= htmlspecialchars($err) ?></div><?php endif; ?>
      <form method="post">
        <label>Nama</label>
        <input class="input" type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
        <label>Harga</label>
        <input class="input" type="number" name="harga" value="<?= htmlspecialchars($data['harga']) ?>" required>
        <label>Kategori</label>
        <input class="input" type="text" name="kategori" value="<?= htmlspecialchars($data['kategori']) ?>">
        <label>Deskripsi</label>
        <input class="input" type="text" name="deskripsi" value="<?= htmlspecialchars($data['deskripsi']) ?>">
        <div style="margin-top:.75rem;">
          <button class="btn btn-primary" name="update" type="submit">Simpan</button>
        </div>
      </form>
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

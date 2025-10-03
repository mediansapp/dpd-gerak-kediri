<?php
require 'config.php';

// Ambil semua berita
$res = $conn->query("SELECT * FROM berita ORDER BY tanggal DESC");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Daftar Berita - DPD Gerakan Rakyat Kota Kediri</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="home.php">DPD Gerakan Rakyat Kota Kediri</a>
  </div>
</nav>

<div class="container my-5">
  <h2>Daftar Berita</h2>
  <hr>
  <?php if($res->num_rows == 0): ?>
    <p>Belum ada berita.</p>
  <?php else: ?>
    <?php while($b=$res->fetch_assoc()): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($b['judul']) ?></h5>
          <small class="text-muted"><?= date("d M Y", strtotime($b['tanggal'])) ?></small>
          <p class="card-text mt-2"><?= substr(strip_tags($b['isi']),0,200) ?>...</p>
          <a href="berita_detail.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>

<footer class="bg-dark text-light text-center py-3 mt-5">
  &copy; <?= date('Y') ?> DPD Gerakan Rakyat Kota Kediri
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

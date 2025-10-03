<?php
session_start();
require 'config.php';
if(!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }

// Ambil data program
$pendek = $conn->query("SELECT * FROM program_kerja WHERE kategori='Jangka Pendek' ORDER BY tahun_mulai ASC");
$panjang = $conn->query("SELECT * FROM program_kerja WHERE kategori='Jangka Panjang' ORDER BY tahun_mulai ASC");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Program Kerja DPD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .timeline {border-left: 3px solid #e74c3c; margin:20px; padding-left:20px;}
    .timeline .event {margin-bottom:15px;}
    .timeline .event h6 {color:#e74c3c;}
  </style>
</head>
<body>
<div class="container my-4">
  <a href="index.php" class="btn btn-secondary mb-3">&laquo; Dashboard</a>
  <h3>Program Kerja DPD Gerakan Rakyat Kota Kediri</h3>

  <h4 class="mt-4">📌 Program Jangka Pendek</h4>
  <table class="table table-bordered">
    <thead><tr><th>#</th><th>Program</th><th>Tahun</th><th>Keterangan</th></tr></thead>
    <tbody>
    <?php $no=1; while($r=$pendek->fetch_assoc()): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($r['program']) ?></td>
        <td><?= $r['tahun_mulai'].' - '.$r['tahun_selesai'] ?></td>
        <td><?= htmlspecialchars($r['keterangan']) ?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>

  <h4 class="mt-4">📌 Program Jangka Panjang</h4>
  <table class="table table-bordered">
    <thead><tr><th>#</th><th>Program</th><th>Tahun</th><th>Keterangan</th></tr></thead>
    <tbody>
    <?php $no=1; while($r=$panjang->fetch_assoc()): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($r['program']) ?></td>
        <td><?= $r['tahun_mulai'].' - '.$r['tahun_selesai'] ?></td>
        <td><?= htmlspecialchars($r['keterangan']) ?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>

  <h4 class="mt-4">📅 Timeline 5 Tahun</h4>
  <div class="timeline">
    <?php
    $timeline = $conn->query("SELECT * FROM program_kerja ORDER BY tahun_mulai ASC");
    while($r=$timeline->fetch_assoc()): ?>
      <div class="event">
        <h6><?= $r['tahun_mulai']." - ".$r['tahun_selesai'] ?></h6>
        <strong><?= htmlspecialchars($r['program']) ?></strong><br>
        <small><?= htmlspecialchars($r['kategori']) ?> - <?= htmlspecialchars($r['keterangan']) ?></small>
      </div>
    <?php endwhile; ?>
  </div>
</div>
</body>
</html>

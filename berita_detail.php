<?php
require 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id <= 0){
    header("Location: home.php#berita");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM berita WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$berita = $res->fetch_assoc();
$stmt->close();

if(!$berita){
    echo "<h3>Berita tidak ditemukan.</h3>";
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($berita['judul']) ?> - DPD Gerakan Rakyat Kota Kediri</title>
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
  <h2><?= htmlspecialchars($berita['judul']) ?></h2>
  <small class="text-muted"><?= date("d M Y", strtotime($berita['tanggal'])) ?></small>
  <hr>
  <p><?= nl2br(htmlspecialchars($berita['isi'])) ?></p>
  <a href="home.php#berita" class="btn btn-secondary mt-3">&laquo; Kembali ke Berita</a>
</div>

<footer class="bg-dark text-light text-center py-3 mt-5">
  &copy; <?= date('Y') ?> DPD Gerakan Rakyat Kota Kediri
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
session_start();
require 'config.php';
if(!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard DPD Gerakan Rakyat Kota Kediri</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">DPD Kediri - Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="pengurus.php">Pengurus</a></li>
        <li class="nav-item"><a class="nav-link" href="berita.php">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
        <li class="nav-item"><a class="nav-link" href="program.php">Program Kerja</a></li>
        <li class="nav-item"><a class="nav-link text-info" href="home.php" target="_blank">🌐 Lihat Website Publik</a></li>
      </ul>
    </div>
    <div class="d-flex">
      <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container my-4">
  <div class="alert alert-success">
    Selamat datang di <b>Dashboard Admin</b> DPD Gerakan Rakyat Kota Kediri.
  </div>

  <h4>📌 Modul yang tersedia:</h4>
  <ul>
    <li><a href="pengurus.php">Manajemen Pengurus</a></li>
    <li><a href="berita.php">Manajemen Berita</a></li>
    <li><a href="kontak.php">Pesan Kontak</a></li>
    <li><a href="program.php">Program Kerja & Timeline</a></li>
    <li><a href="home.php" target="_blank">🌐 Lihat Website Publik</a></li>
  </ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

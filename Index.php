<?php
session_start();
require 'config.php';
if(!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-danger">
  <div class="container">
    <a class="navbar-brand" href="#">DPD Gerakan Rakyat</a>
    <a class="btn btn-light" href="logout.php">Logout</a>
  </div>
</nav>
<div class="container my-4">
  <h3>Dashboard Admin</h3>
  <p>
    <a href="pengurus.php" class="btn btn-primary">Kelola Pengurus</a>
    <a href="berita.php" class="btn btn-primary">Kelola Berita</a>
    <a href="kontak.php" class="btn btn-primary">Pesan Kontak</a>
  </p>
</div>
</body>
</html>

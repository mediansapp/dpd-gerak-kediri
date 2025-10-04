<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header("Location: login.php");
  exit;
}
  <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>

?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">DPD Gerakan Rakyat Kota Kediri</a>
    <div class="d-flex">
      <span class="navbar-text text-white me-3">Halo, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?></span>
      <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>

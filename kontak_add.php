<?php
session_start();
require 'config.php';
if(!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }

$err=''; $ok=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
    $nama=trim($_POST['nama']);
    $email=trim($_POST['email']);
    $pesan=trim($_POST['pesan']);
    $tanggal=date('Y-m-d H:i:s');

    if($nama && $email && $pesan){
        $stmt=$conn->prepare("INSERT INTO kontak (nama,email,pesan,tanggal) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss',$nama,$email,$pesan,$tanggal);
        if($stmt->execute()) $ok=true; else $err='Gagal simpan';
        $stmt->close();
    } else {
        $err='Semua field wajib diisi.';
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Pesan Kontak</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
  <a href="kontak.php" class="btn btn-secondary mb-3">&laquo; Kembali</a>
  <h3>Tambah Pesan Kontak</h3>
  <?php if($err): ?><div class="alert alert-danger"><?= $err ?></div><?php endif; ?>
  <?php if($ok): ?><div class="alert alert-success">Berhasil disimpan.</div><?php endif; ?>

  <form method="post">
    <div class="mb-3"><label class="form-label">Nama</label><input class="form-control" name="nama" required></div>
    <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required></div>
    <div class="mb-3"><label class="form-label">Pesan</label><textarea class="form-control" name="pesan" rows="5" required></textarea></div>
    <button class="btn btn-primary" type="submit">Simpan</button>
  </form>
</div>
</body>
</html>

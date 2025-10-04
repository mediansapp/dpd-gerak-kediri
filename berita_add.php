<?php
session_start();
require 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>

if($_SERVER['REQUEST_METHOD']==='POST'){
    $judul=trim($_POST['judul']);
    $isi=trim($_POST['isi']);
    $tanggal=$_POST['tanggal'] ?: date('Y-m-d');

    if($judul && $isi){
        $stmt=$conn->prepare("INSERT INTO berita (kategori,judul,isi,tanggal) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss',$judul,$isi,$tanggal,$kategori);
        if($stmt->execute()) $ok=true; else $err='Gagal simpan';
        $stmt->close();
    } else {
        $err='Judul & isi wajib diisi.';
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Berita</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
  <a href="berita.php" class="btn btn-secondary mb-3">&laquo; Kembali</a>
  <h3>Tambah Berita</h3>
  <?php if($err): ?><div class="alert alert-danger"><?= $err ?></div><?php endif; ?>
  <?php if($ok): ?><div class="alert alert-success">Berhasil disimpan.</div><?php endif; ?>

  <form method="post">
    <div class="mb-3">
    <label class="form-label">Kategori</label>
      <select class="form-control" name="kategori" required>
         <option value="Umum">Umum</option>
         <option value="Pendidikan">Pendidikan</option>
         <option value="Ekonomi">Ekonomi</option>
         <option value="Sosial">Sosial</option>
         <option value="Politik">Politik</option>
      </select>
    </div>

    <div class="mb-3"><label class="form-label">Judul</label><input class="form-control" name="judul" required></div>
    <div class="mb-3"><label class="form-label">Isi Berita</label><textarea class="form-control" name="isi" rows="6" required></textarea></div>
    <div class="mb-3"><label class="form-label">Tanggal</label><input type="date" class="form-control" name="tanggal" value="<?= date('Y-m-d') ?>"></div>
    <button class="btn btn-primary" type="submit">Simpan</button>
  </form>
</div>
</body>
</html>

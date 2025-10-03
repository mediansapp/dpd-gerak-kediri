<?php
session_start();
require 'config.php';
if(!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }

$err=''; $ok=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
    $nama = trim($_POST['nama']);
    $jabatan = trim($_POST['jabatan']);
    $no_identitas = trim($_POST['no_identitas']);
    $no_hp = trim($_POST['no_hp']);
    $foto = null;

    if(isset($_FILES['foto']) && $_FILES['foto']['error']===UPLOAD_ERR_OK){
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed=['jpg','jpeg','png'];
        if(in_array($ext,$allowed)){
            $fn = uniqid('foto_').'.'.$ext;
            $target='uploads/'.$fn;
            if(move_uploaded_file($_FILES['foto']['tmp_name'],$target)) $foto=$target;
        } else {
            $err='Format foto harus JPG/PNG.';
        }
    }

    if(!$err){
        $stmt=$conn->prepare("INSERT INTO pengurus (nama,jabatan,no_identitas,no_hp,foto) VALUES (?,?,?,?,?)");
        $stmt->bind_param('sssss',$nama,$jabatan,$no_identitas,$no_hp,$foto);
        if($stmt->execute()) $ok=true; else $err='Gagal simpan';
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Pengurus</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
  <a href="pengurus.php" class="btn btn-secondary mb-3">&laquo; Kembali</a>
  <h3>Tambah Pengurus</h3>
  <?php if($err): ?><div class="alert alert-danger"><?= $err ?></div><?php endif; ?>
  <?php if($ok): ?><div class="alert alert-success">Berhasil disimpan.</div><?php endif; ?>

  <form method="post" enctype="multipart/form-data">
    <div class="mb-3"><label class="form-label">Nama</label><input class="form-control" name="nama" required></div>
    <div class="mb-3"><label class="form-label">Jabatan</label><input class="form-control" name="jabatan" required></div>
    <div class="mb-3"><label class="form-label">No Identitas</label><input class="form-control" name="no_identitas" required></div>
    <div class="mb-3"><label class="form-label">No HP</label><input class="form-control" name="no_hp" required></div>
    <div class="mb-3"><label class="form-label">Pas Foto</label><input type="file" name="foto" class="form-control"></div>
    <button class="btn btn-primary" type="submit">Simpan</button>
  </form>
</div>
</body>
</html>

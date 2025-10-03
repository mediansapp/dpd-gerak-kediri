<?php
session_start();
require 'config.php';
if(!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }

$id = isset($_GET['id'])?(int)$_GET['id']:0;
if($id<=0){ header('Location: pengurus.php'); exit; }

$stmt = $conn->prepare("SELECT * FROM pengurus WHERE id=?");
$stmt->bind_param('i',$id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();

$err=''; $ok=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
    $nama=trim($_POST['nama']);
    $jabatan=trim($_POST['jabatan']);
    $no_identitas=trim($_POST['no_identitas']);
    $no_hp=trim($_POST['no_hp']);
    $foto_path=$row['foto'];

    if(isset($_FILES['foto']) && $_FILES['foto']['error']===UPLOAD_ERR_OK){
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed=['jpg','jpeg','png'];
        if(in_array($ext,$allowed)){
            $fn=uniqid('foto_').'.'.$ext;
            $target='uploads/'.$fn;
            if(move_uploaded_file($_FILES['foto']['tmp_name'],$target)){
                if($foto_path && file_exists($foto_path)) unlink($foto_path);
                $foto_path=$target;
            }
        } else {
            $err='Format foto salah.';
        }
    }

    if(!$err){
        $stmt=$conn->prepare("UPDATE pengurus SET nama=?, jabatan=?, no_identitas=?, no_hp=?, foto=? WHERE id=?");
        $stmt->bind_param('sssssi',$nama,$jabatan,$no_identitas,$no_hp,$foto_path,$id);
        if($stmt->execute()) $ok=true; else $err='Gagal update';
        $stmt->close();

        $stmt2=$conn->prepare("SELECT * FROM pengurus WHERE id=?");
        $stmt2->bind_param('i',$id);
        $stmt2->execute();
        $row=$stmt2->get_result()->fetch_assoc();
        $stmt2->close();
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Pengurus</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
  <a href="pengurus.php" class="btn btn-secondary mb-3">&laquo; Kembali</a>
  <h3>Edit Pengurus</h3>
  <?php if($err): ?><div class="alert alert-danger"><?= $err ?></div><?php endif; ?>
  <?php if($ok): ?><div class="alert alert-success">Berhasil diupdate.</div><?php endif; ?>

  <form method="post" enctype="multipart/form-data">
    <div class="mb-3"><label class="form-label">Nama</label>
      <input class="form-control" name="nama" value="<?= htmlspecialchars($row['nama']) ?>" required>
    </div>
    <div class="mb-3"><label class="form-label">Jabatan</label>
      <input class="form-control" name="jabatan" value="<?= htmlspecialchars($row['jabatan']) ?>" required>
    </div>
    <div class="mb-3"><label class="form-label">No Identitas</label>
      <input class="form-control" name="no_identitas" value="<?= htmlspecialchars($row['no_identitas']) ?>" required>
    </div>
    <div class="mb-3"><label class="form-label">No HP</label>
      <input class="form-control" name="no_hp" value="<?= htmlspecialchars($row['no_hp']) ?>" required>
    </div>
    <div class="mb-3"><label class="form-label">Pas Foto</label>
      <?php if($row['foto']): ?>
        <div><img src="<?= htmlspecialchars($row['foto']) ?>" style="height:80px;object-fit:cover;"></div>
      <?php endif; ?>
      <input type="file" name="foto" class="form-control">
    </div>
    <button class="btn btn-primary" type="submit">Simpan</button>
  </form>
</div>
</body>
</html>

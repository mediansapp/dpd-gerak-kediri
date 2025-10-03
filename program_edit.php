<?php
session_start();
require 'config.php';
if(!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }

$id = (int)$_GET['id'];
$stmt=$conn->prepare("SELECT * FROM program_kerja WHERE id=?");
$stmt->bind_param('i',$id);
$stmt->execute();
$row=$stmt->get_result()->fetch_assoc();
$stmt->close();

$err=''; $ok=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
    $kategori=$_POST['kategori'];
    $program=trim($_POST['program']);
    $mulai=$_POST['tahun_mulai'];
    $selesai=$_POST['tahun_selesai'];
    $ket=$_POST['keterangan'];

    if($program){
        $stmt=$conn->prepare("UPDATE program_kerja SET kategori=?, program=?, tahun_mulai=?, tahun_selesai=?, keterangan=? WHERE id=?");
        $stmt->bind_param('sssssi',$kategori,$program,$mulai,$selesai,$ket,$id);
        if($stmt->execute()) $ok=true; else $err='Gagal update';
        $stmt->close();

        // Refresh data
        $stmt2=$conn->prepare("SELECT * FROM program_kerja WHERE id=?");
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
  <title>Edit Program Kerja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
  <a href="program.php" class="btn btn-secondary mb-3">&laquo; Kembali</a>
  <h3>Edit Program Kerja</h3>
  <?php if($err): ?><div class="alert alert-danger"><?= $err ?></div><?php endif; ?>
  <?php if($ok): ?><div class="alert alert-success">Berhasil diupdate.</div><?php endif; ?>

  <form method="post">
    <div class="mb-3"><label>Kategori</label>
      <select class="form-control" name="kategori" required>
        <option <?= $row['kategori']=='Jangka Pendek'?'selected':'' ?>>Jangka Pendek</option>
        <option <?= $row['kategori']=='Jangka Panjang'?'selected':'' ?>>Jangka Panjang</option>
      </select>
    </div>
    <div class="mb-3"><label>Program</label>
      <input class="form-control" name="program" value="<?= htmlspecialchars($row['program']) ?>" required>
    </div>
    <div class="mb-3"><label>Tahun Mulai</label>
      <input type="number" class="form-control" name="tahun_mulai" value="<?= $row['tahun_mulai'] ?>" required>
    </div>
    <div class="mb-3"><label>Tahun Selesai</label>
      <input type="number" class="form-control" name="tahun_selesai" value="<?= $row['tahun_selesai'] ?>" required>
    </div>
    <div class="mb-3"><label>Keterangan</label>
      <textarea class="form-control" name="keterangan"><?= htmlspecialchars($row['keterangan']) ?></textarea>
    </div>
    <button class="btn btn-primary" type="submit">Simpan</button>
  </form>
</div>
</body>
</html>

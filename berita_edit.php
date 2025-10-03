<?php
session_start();
require 'config.php';
if(!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }

$id = isset($_GET['id'])?(int)$_GET['id']:0;
if($id<=0){ header('Location: berita.php'); exit; }

$stmt=$conn->prepare("SELECT * FROM berita WHERE id=?");
$stmt->bind_param('i',$id);
$stmt->execute();
$row=$stmt->get_result()->fetch_assoc();
$stmt->close();

$err=''; $ok=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
    $judul=trim($_POST['judul']);
    $isi=trim($_POST['isi']);
    $tanggal=$_POST['tanggal'] ?: date('Y-m-d');

    if($judul && $isi){
        $stmt=$conn->prepare("UPDATE berita SET judul=?, isi=?, tanggal=?, kategori=? WHERE id=?");
        $stmt->bind_param('ssssi',$judul,$isi,$tanggal,$kategori,$id);
        if($stmt->execute()) $ok=true; else $err='Gagal update';
        $stmt->close();

        // Refresh data
        $stmt2=$conn->prepare("SELECT * FROM berita WHERE id=?");
        $stmt2->bind_param('i',$id);
        $stmt2->execute();
        $row=$stmt2->get_result()->fetch_assoc();
        $stmt2->close();
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
  <title>Edit Berita</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
  <a href="berita.php" class="btn btn-secondary mb-3">&laquo; Kembali</a>
  <h3>Edit Berita</h3>
  <?php if($err): ?><div class="alert alert-danger"><?= $err ?></div><?php endif; ?>
  <?php if($ok): ?><div class="alert alert-success">Berhasil diupdate.</div><?php endif; ?>

  <form method="post">
      <div class="mb-3">
       <label class="form-label">Kategori</label>
       <select class="form-control" name="kategori" required>
         <option value="Umum" <?= ($row['kategori']=="Umum"?"selected":"") ?>>Umum</option>
         <option value="Pendidikan" <?= ($row['kategori']=="Pendidikan"?"selected":"") ?>>Pendidikan</option>
         <option value="Ekonomi" <?= ($row['kategori']=="Ekonomi"?"selected":"") ?>>Ekonomi</option>
         <option value="Sosial" <?= ($row['kategori']=="Sosial"?"selected":"") ?>>Sosial</option>
         <option value="Politik" <?= ($row['kategori']=="Politik"?"selected":"") ?>>Politik</option>
       </select>
    </div>
    <div class="mb-3"><label class="form-label">Judul</label>
      <input class="form-control" name="judul" value="<?= htmlspecialchars($row['judul']) ?>" required>
    </div>
    <div class="mb-3"><label class="form-label">Isi Berita</label>
      <textarea class="form-control" name="isi" rows="6" required><?= htmlspecialchars($row['isi']) ?></textarea>
    </div>
    <div class="mb-3"><label class="form-label">Tanggal</label>
      <input type="date" class="form-control" name="tanggal" value="<?= $row['tanggal'] ?>">
    </div>
    <button class="btn btn-primary" type="submit">Simpan</button>
  </form>
</div>
</body>
</html>

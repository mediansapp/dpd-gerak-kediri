<?php
session_start();
require 'config.php';
if(!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }

// Hapus berita
if(isset($_GET['delete'])){
    $id=(int)$_GET['delete'];
    $stmt=$conn->prepare("DELETE FROM berita WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->close();
    header('Location: berita.php'); exit;
}

$res = $conn->query("SELECT * FROM berita ORDER BY tanggal DESC");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kelola Berita</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
  <a href="index.php" class="btn btn-secondary mb-3">&laquo; Dashboard</a>
  <h3>Daftar Berita</h3>
  <a href="berita_add.php" class="btn btn-success mb-3">Tambah Berita</a>

  <table class="table table-bordered">
    <thead><tr>
      <th>#</th>
      <th>Judul</th>
      <th>Tanggal</th>
      <th>Aksi</th>
    </tr></thead>
    <tbody>
    <?php $no=1; while($r=$res->fetch_assoc()): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($r['judul']) ?></td>
        <td><?= $r['tanggal'] ?></td>
        <td>
          <a href="berita_edit.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
          <a href="berita.php?delete=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
          <a href="berita_detail.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-info" target="_blank">Lihat Publik</a>
   </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>

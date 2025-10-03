<?php
session_start();
require 'config.php';
if(!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }

// Hapus pesan
if(isset($_GET['delete'])){
    $id=(int)$_GET['delete'];
    $stmt=$conn->prepare("DELETE FROM kontak WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->close();
    header('Location: kontak.php'); exit;
}

$res = $conn->query("SELECT * FROM kontak ORDER BY tanggal DESC");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pesan Kontak</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
  <a href="index.php" class="btn btn-secondary mb-3">&laquo; Dashboard</a>
  <h3>Pesan Kontak</h3>

  <table class="table table-bordered">
    <thead><tr>
      <th>#</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Pesan</th>
      <th>Tanggal</th>
      <th>Aksi</th>
    </tr></thead>
    <tbody>
    <?php $no=1; while($r=$res->fetch_assoc()): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($r['nama']) ?></td>
        <td><?= htmlspecialchars($r['email']) ?></td>
        <td><?= nl2br(htmlspecialchars($r['pesan'])) ?></td>
        <td><?= $r['tanggal'] ?></td>
        <td>
          <a href="kontak.php?delete=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus pesan ini?')">Hapus</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>

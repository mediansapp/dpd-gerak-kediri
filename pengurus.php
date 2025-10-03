<?php
session_start();
require 'config.php';
if(!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }

// Hapus data
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("SELECT foto FROM pengurus WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $r=$stmt->get_result();
    if($r->num_rows){
        $row=$r->fetch_assoc();
        if($row['foto'] && file_exists($row['foto'])) unlink($row['foto']);
    }
    $stmt->close();

    $stmt2 = $conn->prepare("DELETE FROM pengurus WHERE id=?");
    $stmt2->bind_param('i',$id);
    $stmt2->execute();
    $stmt2->close();

    header('Location: pengurus.php'); exit;
}

$result = $conn->query("SELECT * FROM pengurus ORDER BY id DESC");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kelola Pengurus</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
  <a href="index.php" class="btn btn-secondary mb-3">&laquo; Dashboard</a>
  <h3>Daftar Pengurus</h3>
  <a href="pengurus_add.php" class="btn btn-success mb-3">Tambah Pengurus</a>

  <div class="table-responsive">
  <table class="table table-bordered">
    <thead><tr>
      <th>#</th>
      <th>Foto</th>
      <th>Nama</th>
      <th>Jabatan</th>
      <th>No Identitas</th>
      <th>No HP</th>
      <th>Aksi</th>
    </tr></thead>
    <tbody>
    <?php $no=1; while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td>
          <?php if($row['foto']): ?>
            <img src="<?= htmlspecialchars($row['foto']) ?>" style="height:60px;object-fit:cover;">
          <?php else: ?> - <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= htmlspecialchars($row['jabatan']) ?></td>
        <td><?= htmlspecialchars($row['no_identitas']) ?></td>
        <td><?= htmlspecialchars($row['no_hp']) ?></td>
        <td>
          <a href="pengurus_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
          <a href="pengurus.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
  </div>
</div>
</body>
</html>


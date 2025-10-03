<?php
require 'config.php';

// Ambil kategori dari URL
$kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : "";
if(!$kategori){
    header("Location: berita_list.php");
    exit;
}

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Hitung total berita per kategori
$stmtTotal = $conn->prepare("SELECT COUNT(*) as total FROM berita WHERE kategori=?");
$stmtTotal->bind_param("s", $kategori);
$stmtTotal->execute();
$total = $stmtTotal->get_result()->fetch_assoc()['total'];
$stmtTotal->close();

$totalPages = ceil($total / $limit);

// Ambil data berita per kategori
$stmt = $conn->prepare("SELECT * FROM berita WHERE kategori=? ORDER BY tanggal DESC LIMIT ?,?");
$stmt->bind_param("sii", $kategori, $offset, $limit);
$stmt->execute();
$res = $stmt->get_result();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Kategori <?= htmlspecialchars($kategori) ?> - DPD Gerakan Rakyat Kota Kediri</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="home.php">DPD Gerakan Rakyat Kota Kediri</a>
  </div>
</nav>

<div class="container my-5">
  <h2>Berita Kategori: <?= htmlspecialchars($kategori) ?></h2>
  <hr>

  <?php if($total == 0): ?>
    <p>Tidak ada berita dalam kategori ini.</p>
  <?php else: ?>
    <?php while($b=$res->fetch_assoc()): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($b['judul']) ?></h5>
          <small class="text-muted"><?= date("d M Y", strtotime($b['tanggal'])) ?> | <?= $b['kategori'] ?></small>
          <p class="card-text mt-2"><?= substr(strip_tags($b['isi']),0,200) ?>...</p>
          <a href="berita_detail.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
        </div>
      </div>
    <?php endwhile; ?>

    <!-- Pagination -->
    <nav>
      <ul class="pagination justify-content-center">
        <?php if($page > 1): ?>
          <li class="page-item"><a class="page-link" href="?kategori=<?= urlencode($kategori) ?>&page=<?= $page-1 ?>">Sebelumnya</a></li>
        <?php endif; ?>

        <?php for($i=1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= ($i==$page)?'active':'' ?>">
            <a class="page-link" href="?kategori=<?= urlencode($kategori) ?>&page=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>

        <?php if($page < $totalPages): ?>
          <li class="page-item"><a class="page-link" href="?kategori=<?= urlencode($kategori) ?>&page=<?= $page+1 ?>">Berikutnya</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  <?php endif; ?>
</div>

<footer class="bg-dark text-light text-center py-3 mt-5">
  &copy; <?= date('Y') ?> DPD Gerakan Rakyat Kota Kediri
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

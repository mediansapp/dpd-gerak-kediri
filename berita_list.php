<?php
require 'config.php';

// --- Ambil daftar kategori unik ---
$kategoriRes = $conn->query("SELECT DISTINCT kategori FROM berita ORDER BY kategori ASC");
$kategoriList = [];
while($row = $kategoriRes->fetch_assoc()){
    $kategoriList[] = $row['kategori'];
}

// --- Pencarian & Filter ---
$keyword = isset($_GET['q']) ? trim($_GET['q']) : "";
$kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : "";

// --- Pagination ---
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// --- Query total ---
$sqlBase = "FROM berita WHERE 1=1";
$params = [];
$types = "";

if($keyword){
    $sqlBase .= " AND (judul LIKE ? OR isi LIKE ?)";
    $like = "%$keyword%";
    $params[] = &$like;
    $params[] = &$like;
    $types .= "ss";
}
if($kategori){
    $sqlBase .= " AND kategori = ?";
    $params[] = &$kategori;
    $types .= "s";
}

// Hitung total
$stmtTotal = $conn->prepare("SELECT COUNT(*) as total ".$sqlBase);
if($params) call_user_func_array([$stmtTotal,"bind_param"], array_merge([$types], $params));
$stmtTotal->execute();
$total = $stmtTotal->get_result()->fetch_assoc()['total'];
$stmtTotal->close();
$totalPages = ceil($total / $limit);

// Ambil data berita
$sql = "SELECT * ".$sqlBase." ORDER BY tanggal DESC LIMIT ?,?";
$params2 = $params;
$types2 = $types."ii";
$params2[] = &$offset;
$params2[] = &$limit;

$stmt = $conn->prepare($sql);
if($params2) call_user_func_array([$stmt,"bind_param"], array_merge([$types2], $params2));
$stmt->execute();
$res = $stmt->get_result();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Daftar Berita - DPD Gerakan Rakyat Kota Kediri</title>
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
  <div class="row">
    <!-- Sidebar -->
    <aside class="col-md-3 mb-4">
      <h5>Kategori</h5>
      <ul class="list-group">
        <li class="list-group-item <?= $kategori==""?'active':'' ?>">
          <a href="berita_list.php" class="text-decoration-none <?= $kategori==""?'text-white':'' ?>">Semua</a>
        </li>
        <?php foreach($kategoriList as $kat): ?>
          <li class="list-group-item <?= $kategori==$kat?'active':'' ?>">
            <a href="berita_list.php?kategori=<?= urlencode($kat) ?>" class="text-decoration-none <?= $kategori==$kat?'text-white':'' ?>">
              <?= $kat ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </aside>

    <!-- Konten utama -->
    <main class="col-md-9">
      <h2>Daftar Berita</h2>
      <hr>

      <!-- Form Pencarian -->
      <form method="get" class="mb-4 d-flex">
        <input type="text" name="q" class="form-control me-2" placeholder="Cari berita..." value="<?= htmlspecialchars($keyword) ?>">
        <?php if($kategori): ?>
          <input type="hidden" name="kategori" value="<?= htmlspecialchars($kategori) ?>">
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">Cari</button>
      </form>

      <?php if($total == 0): ?>
        <p>Tidak ada berita ditemukan.</p>
      <?php else: ?>
        <?php while($b=$res->fetch_assoc()): ?>
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($b['judul']) ?></h5>
              <small class="text-muted"><?= date("d M Y", strtotime($b['tanggal'])) ?> | 
                <a href="berita_list.php?kategori=<?= urlencode($b['kategori']) ?>" class="badge bg-info text-dark"><?= $b['kategori'] ?></a>
              </small>
              <p class="card-text mt-2"><?= substr(strip_tags($b['isi']),0,200) ?>...</p>
              <a href="berita_detail.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
            </div>
          </div>
        <?php endwhile; ?>

        <!-- Pagination -->
        <nav>
          <ul class="pagination justify-content-center">
            <?php if($page > 1): ?>
              <li class="page-item"><a class="page-link" href="?q=<?= urlencode($keyword) ?>&kategori=<?= urlencode($kategori) ?>&page=<?= $page-1 ?>">Sebelumnya</a></li>
            <?php endif; ?>

            <?php for($i=1; $i <= $totalPages; $i++): ?>
              <li class="page-item <?= ($i==$page)?'active':'' ?>">
                <a class="page-link" href="?q=<?= urlencode($keyword) ?>&kategori=<?= urlencode($kategori) ?>&page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>

            <?php if($page < $totalPages): ?>
              <li class="page-item"><a class="page-link" href="?q=<?= urlencode($keyword) ?>&kategori=<?= urlencode($kategori) ?>&page=<?= $page+1 ?>">Berikutnya</a></li>
            <?php endif; ?>
          </ul>
        </nav>
      <?php endif; ?>
    </main>
  </div>
</div>

<footer class="bg-dark text-light text-center py-3 mt-5">
  &copy; <?= date('Y') ?> DPD Gerakan Rakyat Kota Kediri
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

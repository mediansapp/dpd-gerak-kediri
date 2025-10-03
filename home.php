<?php
require 'config.php';

// Ambil data pengurus inti (contoh 5 orang pertama)
$pengurus = $conn->query("SELECT * FROM pengurus ORDER BY id ASC LIMIT 5");

// Ambil 3 berita terbaru
$berita = $conn->query("SELECT * FROM berita ORDER BY tanggal DESC LIMIT 3");

// Ambil program kerja singkat
$program = $conn->query("SELECT * FROM program_kerja ORDER BY tahun_mulai ASC LIMIT 5");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>DPD Gerakan Rakyat Kota Kediri</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="home.php">DPD Gerakan Rakyat Kota Kediri</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPublic">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navPublic">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#profil">Profil</a></li>
        <li class="nav-item"><a class="nav-link" href="#pengurus">Pengurus</a></li>
        <li class="nav-item"><a class="nav-link" href="#berita">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="#program">Program Kerja</a></li>
        <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container my-5" id="profil">
  <h2>Profil Singkat</h2>
  <p>
    <b>DPD Gerakan Rakyat Kota Kediri</b> adalah organisasi masyarakat yang berkomitmen pada 
    pemberdayaan rakyat, memperkuat solidaritas, serta membangun kolaborasi untuk 
    kemajuan Kota Kediri.
  </p>
</div>

<div class="container my-5" id="pengurus">
  <h2>Pengurus Inti</h2>
  <div class="row">
    <?php while($p=$pengurus->fetch_assoc()): ?>
      <div class="col-md-3 text-center mb-3">
        <?php if($p['foto']): ?>
          <img src="uploads/<?= $p['foto'] ?>" class="img-thumbnail" style="width:150px;height:150px;object-fit:cover;">
        <?php else: ?>
          <img src="https://via.placeholder.com/150" class="img-thumbnail">
        <?php endif; ?>
        <h6 class="mt-2"><?= htmlspecialchars($p['nama']) ?></h6>
        <small><?= htmlspecialchars($p['jabatan']) ?></small>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<div class="container my-5" id="berita">
  <h2>Berita Terbaru</h2>
  <?php while($b=$berita->fetch_assoc()): ?>
    <div class="card mb-3">
      <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($b['judul']) ?></h5>
        <p class="card-text"><?= substr(strip_tags($b['isi']),0,150) ?>...</p>
        <a href="#" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<div class="container my-5" id="program">
  <h2>Program Kerja</h2>
  <table class="table table-bordered">
    <thead><tr><th>Program</th><th>Tahun</th><th>Keterangan</th></tr></thead>
    <tbody>
    <?php while($r=$program->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($r['program']) ?></td>
        <td><?= $r['tahun_mulai'].' - '.$r['tahun_selesai'] ?></td>
        <td><?= htmlspecialchars($r['keterangan']) ?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>

<div class="container my-5" id="kontak">
  <h2>Hubungi Kami</h2>
  <?php
  if($_SERVER['REQUEST_METHOD']==='POST'){
      $nama=$_POST['nama']; $email=$_POST['email']; $pesan=$_POST['pesan'];
      $tgl=date('Y-m-d H:i:s');
      $stmt=$conn->prepare("INSERT INTO kontak (nama,email,pesan,tanggal) VALUES (?,?,?,?)");
      $stmt->bind_param('ssss',$nama,$email,$pesan,$tgl);
      $stmt->execute();
      echo '<div class="alert alert-success">Pesan berhasil dikirim.</div>';
  }
  ?>
  <form method="post">
    <div class="mb-3"><label>Nama</label><input type="text" name="nama" class="form-control" required></div>
    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
    <div class="mb-3"><label>Pesan</label><textarea name="pesan" class="form-control" rows="4" required></textarea></div>
    <button type="submit" class="btn btn-primary">Kirim</button>
  </form>
</div>

<footer class="bg-dark text-light text-center py-3 mt-5">
  &copy; <?= date('Y') ?> DPD Gerakan Rakyat Kota Kediri
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

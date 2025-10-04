-- create_database.sql
CREATE DATABASE IF NOT EXISTS b17_40091018_db_dpd_kediri CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE b17_40091018_db_dpd_kediri;

-- tabel admin
CREATE TABLE IF NOT EXISTS admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL
);

-- tabel berita
CREATE TABLE IF NOT EXISTS berita (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kategori VARCHAR(100),
  judul VARCHAR(250) NOT NULL,
  isi TEXT NOT NULL,
  tanggal DATE NOT NULL
);

-- tabel pengurus

CREATE TABLE IF NOT EXISTS pengurus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(100) NOT NULL,
    no_identitas VARCHAR(50) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    foto VARCHAR(255) DEFAULT NULL
);


-- tabel kontak
CREATE TABLE IF NOT EXISTS kontak (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL,
  pesan TEXT NOT NULL,
  tanggal DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS program_kerja (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategori ENUM('Jangka Pendek','Jangka Panjang') NOT NULL,
    program VARCHAR(255) NOT NULL,
    tahun_mulai YEAR NOT NULL,
    tahun_selesai YEAR NOT NULL,
    keterangan TEXT
);
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE,
  password VARCHAR(255),
  nama_lengkap VARCHAR(100),
  level ENUM('admin','pengurus') DEFAULT 'admin'
);

-- Contoh akun admin (password = admin123)
INSERT INTO users (username, password, nama_lengkap, level)
VALUES ('admin', MD5('admin123'), 'Administrator', 'admin');

-- sample admin (username: admin, password: admin123)
INSERT INTO admin (username, password_hash) VALUES
('admin', '$2y$10$k8nGZ0hZr9O8q0j0R0aE4u2p9b8qvQXy2xZQF8J0wWqz1p6d1Yq6'); 
-- password_hash di atas adalah contoh hash (hash('admin123') sebaiknya diganti). 

-- sample berita
INSERT INTO berita (kategori,judul, isi, tanggal) VALUES
('Pelantikan Pengurus Baru DPD Gerakan Rakyat Kota Kediri',
'Pada tanggal 25 September 2025, Musyawarah Daerah Gerakan Rakyat Kota Kediri resmi menetapkan susunan pengurus baru periode 2025-2030. Acara ini dihadiri oleh perwakilan DPW Jawa Timur, tokoh masyarakat, dan berbagai undangan lainnya.',
'2025-09-25');

-- sample pengurus (sesuai gambar Anda)
INSERT INTO pengurus (nama, jabatan, no_identitas, no_hp, foto) VALUES
('H. Dawud Syamsuri, M.Pdi', 'Ketua Dewan Penasihat', '000000000000', '000000000000',[NULL]),
('Shokhib, SH', 'Sekretaris Dewan Penasihat', '0822-3416-5075', '0822-3416-5075',NULL),
('Dian Ermawan, SE', 'Ketua DPD', '081235922332', '081235922332',NULL),
('Sunanto', 'Wakil Ketua', '0812-3401-8354', '0812-3401-8354',NULL),
('Makinudin', 'Wakil Ketua', '0857-3519-1888', '0857-3519-1888',NULL),
('Djoko Susilo', 'Wakil Ketua', '0852-3321-1981', '0852-3321-1981',NULL),
('Moch. Abidin', 'Sekretaris', '0812-1616-336', '0812-1616-336',NULL),
('Erna Ningsih', 'Wakil Sekretaris', '0858-5375-0168', '0858-5375-0168',NULL),
('Nicky Suryo Prayogo', 'Wakil Sekretaris', '0813-3072-5385', '0813-3072-5385',NULL),
('Erna Fitri Tjahjani D.', 'Wakil Sekretaris', '0822-3416-5075', '0822-3416-5075',NULL),
('Siti Ruqqayah', 'Bendahara', '0821-3232-7642', '0821-3232-7642',NULL),
('Humaida', 'Wakil Bendahara', '0853-3028-6779', '0853-3028-6779',NULL),
('Indri Sukowati, SKM', 'Wakil Bendahara', '0858-5069-6220', '0858-5069-6220',NULL);

-- Program Jangka Pendek (2025-2026)
INSERT INTO program_kerja (kategori, program, tahun_mulai, tahun_selesai, keterangan) VALUES
('Jangka Pendek', 'Penguatan Soliditas Organisasi melalui pelatihan kader', 2025, 2025, 'Melakukan pelatihan internal kepemimpinan dan organisasi'),
('Jangka Pendek', 'Program Beasiswa Pendidikan untuk Pemuda', 2025, 2026, 'Memberikan beasiswa kepada pelajar berprestasi dari keluarga kurang mampu'),
('Jangka Pendek', 'Pemberdayaan UMKM Lokal Kota Kediri', 2025, 2026, 'Mengadakan pelatihan kewirausahaan dan akses permodalan untuk UMKM'),
('Jangka Pendek', 'Gerakan Sosial Peduli Lingkungan', 2026, 2026, 'Aksi bersih sungai, penghijauan, dan edukasi lingkungan ke sekolah-sekolah');

-- Program Jangka Panjang (2025-2030)
INSERT INTO program_kerja (kategori, program, tahun_mulai, tahun_selesai, keterangan) VALUES
('Jangka Panjang', 'Membangun Pusat Pendidikan & Pelatihan Ormas Gerakan Rakyat', 2025, 2028, 'Gedung pusat pelatihan kader dan masyarakat'),
('Jangka Panjang', 'Penguatan Ekonomi Rakyat melalui Koperasi Bersama', 2025, 2030, 'Mendirikan koperasi untuk simpan pinjam & usaha bersama masyarakat'),
('Jangka Panjang', 'Digitalisasi Ormas & Database Keanggotaan', 2026, 2027, 'Membangun sistem informasi keanggotaan berbasis web & mobile'),
('Jangka Panjang', 'Kolaborasi Sosial & Kemitraan Strategis', 2026, 2030, 'Bekerja sama dengan pemerintah, kampus, dan dunia usaha'),
('Jangka Panjang', 'Pengembangan Generasi Muda & Inkubator Startup Sosial', 2027, 2030, 'Membentuk wadah anak muda untuk inovasi sosial & ekonomi');

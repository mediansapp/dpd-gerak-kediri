# 🌐 Website DPD Gerakan Rakyat Kota Kediri

Aplikasi website berbasis **PHP + MySQL** untuk organisasi **DPD Gerakan Rakyat Kota Kediri**.  
Website ini berfungsi sebagai portal informasi publik dan sistem manajemen internal pengurus.

---

## ✨ Fitur Utama
- **Home Page** → Profil singkat & informasi organisasi.
- **Berita**
  - Tambah/Edit/Hapus berita (admin)
  - Daftar berita terbaru & detail berita (publik)
  - Pencarian berita
  - Filter kategori berita
  - Arsip berita per tahun
- **Pengurus**
  - Data pengurus (nama, jabatan, identitas, no HP, pasfoto)
  - CRUD pengurus untuk admin
- **Program Kerja**
  - Jangka pendek & jangka panjang
  - Timeline 5 tahun ke depan
- **Kontak**
  - CRUD kontak organisasi
  - Form publik untuk masyarakat

---

## 📂 Struktur Folder


---

## ⚙️ Instalasi Lokal

### 1. Clone Repository
```bash
git clone https://github.com/mediansapp/dpd-gerak-kediri.git
cd dpd-gerak-kediri

## ⚙️ Instalasi Lokal

### 1. Clone Repository
```bash
git clone https://github.com/mediansapp/dpd-gerak-kediri.git
cd dpd-gerak-kediri
````

### 2. Setup Server

* Install **XAMPP** / **Laragon**
* Pindahkan folder `dpd-gerak-kediri` ke:

  * `htdocs/` (XAMPP)
  * atau `www/` (Laragon)

### 3. Import Database

* Buka `http://localhost/phpmyadmin`
* Buat database baru: `dpd_gerak_kediri`
* Import file: `/sql/create_database.sql`

### 4. Konfigurasi `config.php`

```
<?php
$host = "localhost";
$user = "root";     // default user MySQL
$pass = "";         // default password kosong
$db   = "dpd_gerak_kediri";
$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error){
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
```

### 5. Jalankan Aplikasi

* Start Apache & MySQL dari XAMPP/Laragon
* Akses di browser:

```
http://localhost/dpd-gerak-kediri/home.php
```

## 🚀 Deploy ke Hosting Gratis

GitHub tidak bisa langsung menjalankan PHP.
Gunakan hosting gratis seperti:

* [InfinityFree](https://infinityfree.net)
* [000Webhost](https://www.000webhost.com)
* [ByetHost](https://byet.host)

### Langkah:

1. Upload semua file project ke hosting
2. Buat database MySQL di hosting
3. Import `create_database.sql`
4. Ubah `config.php` sesuai kredensial hosting:

   <?php
   $host = "sqlxxx.epizy.com";
   $user = "epiz_123456";
   $pass = "passwordAnda";
   $db   = "epiz_123456_dpd";
   <?/>
   
6. Akses via domain/subdomain dari hosting.

## 👨‍💻 Kontributor

* **Ketua DPD Gerakan Rakyat Kota Kediri**
* **Tim IT & Dokumentasi**

## 📜 Lisensi

Aplikasi ini dibuat untuk keperluan internal organisasi DPD Gerakan Rakyat Kota Kediri.
Penggunaan di luar organisasi membutuhkan izin tertulis dari pengurus.



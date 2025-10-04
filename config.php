<?php
// config.php - sesuaikan kredensial database
$DB_HOST = 'localhost';
$DB_USER = 'b17_40091018';
$DB_PASS = 'd14nAki;';
$DB_NAME = 'b17_40091018_db_dpd_kediri';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) { die("Koneksi gagal: " . $conn->connect_error); }
$conn->set_charset('utf8mb4');
?>

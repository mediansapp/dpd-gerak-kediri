<?php
session_start();
require 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=MD5(?) LIMIT 1");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 1) {
  $user = $res->fetch_assoc();

  $_SESSION['user_id'] = $user['id'];
  $_SESSION['username'] = $user['username'];
  $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
  $_SESSION['level'] = $user['level'];

  header("Location: dashboard.php");
  exit;
} else {
  header("Location: login.php?error=Username atau password salah");
  exit;
}
?>

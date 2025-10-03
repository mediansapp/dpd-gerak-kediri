<?php
session_start();
require 'config.php';
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    $stmt = $conn->prepare("SELECT id, password_hash FROM admin WHERE username=? LIMIT 1");
    $stmt->bind_param('s',$user);
    $stmt->execute();
    $res=$stmt->get_result();
    if($res->num_rows===1){
        $row=$res->fetch_assoc();
        if(password_verify($pass,$row['password_hash'])){
            $_SESSION['admin_id']=$row['id'];
            header('Location: index.php'); exit;
        }
    }
    $err='Login gagal';
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container" style="max-width:400px;margin-top:50px;">
  <h3>Login Admin</h3>
  <?php if($err): ?><div class="alert alert-danger"><?= $err ?></div><?php endif; ?>
  <form method="post">
    <div class="mb-3"><label>Username</label><input name="username" class="form-control" required></div>
    <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
    <button class="btn btn-primary" type="submit">Login</button>
  </form>
</div>
</body>
</html>

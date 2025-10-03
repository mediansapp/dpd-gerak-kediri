<?php
session_start();
require 'config.php';
if(!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }

$id = isset($_GET['id'])?(int)$_GET['id']:0;
if($id>0){
    $stmt=$conn->prepare("SELECT foto FROM pengurus WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $r=$stmt->get_result();
    if($r->num_rows){
        $row=$r->fetch_assoc();
        if($row['foto'] && file_exists($row['foto'])) unlink($row['foto']);
    }
    $stmt->close();

    $stmt2=$conn->prepare("DELETE FROM pengurus WHERE id=?");
    $stmt2->bind_param('i',$id);
    $stmt2->execute();
    $stmt2->close();
}

header('Location: pengurus.php'); exit;

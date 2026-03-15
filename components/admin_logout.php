<?php 
include 'connect.php';
setcookie('admin_id', true, time() - 1, '/');
header('Location: ../admin panel/login.php');
exit();
?>
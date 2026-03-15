<?php 
include 'connect.php';
setcookie('user_id', true, time() - 1, '/');
header('Location: ../index.php');
exit();
?>
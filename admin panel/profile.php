<?php
include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('Location: login.php');
    exit();
}

$select_products = $conn->prepare("SELECT COUNT(*) FROM products");
$select_products->execute();
$total_products = $select_products->fetchColumn();

$select_orders = $conn->prepare("SELECT COUNT(*) FROM orders");
$select_orders->execute();
$total_orders = $select_orders->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon System - Admin profile page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>

<div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    <section class="admin-profile">
        <div class="heading">
            <h1>Profile Details</h1>
            <img src="../image/separator-img.png" >
        </div>
        <div class="details">
            <div class="admin">
                <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
                <h3 class="name"><?= $fetch_profile['name']; ?></h3>
                <span>Admin</span>
                <a href="update.php" class="btn">update profile</a>
            </div>
            <div class="flex">
                <div class="box">
                    <span><?= $total_products; ?></span>
                    <p>Total Products</p>
                    <a href="view_products.php" class="btn">view products</a>
                </div>
                <div class="box">
                    <span><?= $total_orders; ?></span>
                    <p>Total Orders Placed</p>
                    <a href="view_orders.php" class="btn">view orders</a>
                </div>
            </div>
        </div>
 </section>
</div>

<!-- sweetalert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Allert.php to display messages -->
    <?php include '../components/alert.php'; ?>

    <!-- custom JS link -->
    <script src="../js/admin_script.js"></script>
    
</body>
</html>
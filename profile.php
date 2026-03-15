<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('Location: login.php');
    exit();
}

$select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
$select_orders->execute([$user_id]);
$total_orders = $select_orders->rowCount();

$select_messages = $conn->prepare("SELECT * FROM `message` WHERE user_id = ?");
$select_messages->execute([$user_id]);
$total_messages = $select_messages->rowCount();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon System - User profile page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
    <?php include 'components/user_header.php';?>
    <div class="banner">
        <div class="detail">
            <h1>Profile Detail</h1>
            <p>Welcome to our online store! Please log in to access your account and start shopping.</p>
            <span>
                <a href="index.php">home</a>
                <i class="bx bx-right-arrow-alt"></i>Profile
            </span>
        </div>
    </div>

    <section class="profile">
        <div class="heading">
            <h1>Profile Detail</h1>
            <img src="image/separator-img(1).png" alt="">
        </div>
        <div class="details">
            <div class="user">
                <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
                <h3><?= $fetch_profile['name']; ?></h3>
                <p>user</p>
                <a href="update.php" class="btn">update profile</a>
            </div>
            <div class="box-container">
                <div class="box">
                    <div class="flex">
                        <i class="bx bxs-folder-minus"></i>
                        <h3><?= $total_orders; ?></h3>
                        <p>Total Orders Placed</p>
                    </div>
                    <a href="orders.php" class="btn">view orders</a>  
                </div>
                <div class="box">
                    <div class="flex">
                        <i class="bx bxs-chat"></i>
                        <h3><?= $total_messages; ?></h3>
                        <p>Total Messages Sent</p>
                    </div>
                    <a href="index.php" class="btn">view messages</a>  
                </div>
            </div>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>

    <!-- sweetalert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Allert.php to display messages -->
    <?php include 'components/alert.php'; ?>

    <!-- custom JS link -->
    <script src="js/user_script.js"></script>
    
</body>
</html>
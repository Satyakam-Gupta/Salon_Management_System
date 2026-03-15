<?php
    include_once '../components/connect.php';

    if(isset($_COOKIE['admin_id'])){
        $admin_id = $_COOKIE['admin_id'];
    }else{
        $admin_id = '';
        header('Location: login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon System - Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="dashboard">
            <div class="heading">
                <h1>dashboard</h1>
                <img src="../image/separator-img.png">
            </div>
            <div class="box-container">
                <div class="box">
                    <h3>Welcome !</h3>
                    <p><?=$fetch_profile['name']; ?></p>
                    <a href="update.php" class="btn">update profile</a>
                </div>
                <div class="box">
                    <?php
                    $select_message = $conn->prepare("SELECT * FROM `message`");
                    $select_message->execute();
                    $number_of_msg = $select_message->rowCount();
                    ?>
                    <h3><?= $number_of_msg; ?></h3>
                    <p>messages</p>
                    <a href="admin_message.php" class="btn">save message</a>
                </div>
                <div class="box">
                    <?php
                    $select_products = $conn->prepare("SELECT * FROM `products`");
                    $select_products->execute();
                    $number_of_products = $select_products->rowCount();
                    ?>
                    <h3><?= $number_of_products; ?></h3>
                    <p>products added</p>
                    <a href="add_products.php" class="btn">add product</a>
                </div>
                <div class="box">
                    <?php
                    $select_active_products = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
                    $select_active_products->execute(['active']);
                    $number_of_active_products = $select_active_products->rowCount();
                    ?>
                    <h3><?= $number_of_active_products; ?></h3>
                    <p>tatal active products</p>
                    <a href="view_products.php" class="btn">active product</a>
                </div>
                <div class="box">
                    <?php
                    $select_deactive_products = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
                    $select_deactive_products->execute(['deactive']);
                    $number_of_deactive_products = $select_deactive_products->rowCount();
                    ?>
                    <h3><?= $number_of_deactive_products; ?></h3>
                    <p>total deactive products</p>
                    <a href="view_products.php" class="btn">Deactive product</a>
                </div>
                <div class="box">
                    <?php
                    $select_users = $conn->prepare("SELECT * FROM `users`");
                    $select_users->execute();
                    $number_of_users = $select_users->rowCount();
                    ?>
                    <h3><?= $number_of_users; ?></h3>
                    <p>users account</p>
                    <a href="user_accounts.php" class="btn">see users</a>
                </div>
                <div class="box">
                    <?php
                    $select_admins = $conn->prepare("SELECT * FROM `admins`");
                    $select_admins->execute();
                    $number_of_admins = $select_admins->rowCount();
                    ?>
                    <h3><?= $number_of_admins; ?></h3>
                    <p>admins account</p>
                    <a href="view_admins.php" class="btn">see admins</a>
                </div>
                <div class="box">
                    <?php
                    $select_orders = $conn->prepare("SELECT * FROM `orders`");
                    $select_orders->execute();
                    $number_of_orders = $select_orders->rowCount();
                    ?>
                    <h3><?= $number_of_orders; ?></h3>
                    <p>total orders placed</p>
                    <a href="admin_orders.php" class="btn">total orders</a>
                </div>
                <div class="box">
                    <?php
                    $select_confirm_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
                    $select_confirm_orders->execute(['in progress']);
                    $number_of_confirm_orders = $select_confirm_orders->rowCount();
                    ?>
                    <h3><?= $number_of_confirm_orders; ?></h3>
                    <p>total confirmed orders</p>
                    <a href="admin_orders.php" class="btn">confirm orders</a>
                </div>
                <div class="box">
                    <?php
                    $select_canceled_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
                    $select_canceled_orders->execute(['canceled']);
                    $number_of_canceled_orders = $select_canceled_orders->rowCount();
                    ?>
                    <h3><?= $number_of_canceled_orders; ?></h3>
                    <p>total canceled orders</p>
                    <a href="admin_orders.php" class="btn">canceled orders</a>
                </div>
                <div class="box">
                    <?php
                    $select_delivered_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
                    $select_delivered_orders->execute(['order delivered']);
                    $number_of_delivered_orders = $select_delivered_orders->rowCount();
                    ?>
                    <h3><?= $number_of_delivered_orders; ?></h3>
                    <p>total delivered orders</p>
                    <a href="admin_orders.php" class="btn">delivered orders</a>
                </div>
                <div class="box">
                    <?php
                    $select_appointments = $conn->prepare("SELECT * FROM `appointments`");
                    $select_appointments->execute();
                    $number_of_appointments = $select_appointments->rowCount();
                    ?>
                    <h3><?= $number_of_appointments; ?></h3>
                    <p>total appointments booked</p>
                    <a href="admin_appointments.php" class="btn">view appointments</a>
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
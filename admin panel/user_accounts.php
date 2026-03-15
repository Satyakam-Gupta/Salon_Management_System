<?php
include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
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
    <title>Salon System - Registered Users Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="user-container">
            <div class="heading">
                <h1>registered users</h1>
                <img src="../image/separator-img.png">
            </div>
            <div class="box-container">
                <?php 
                $select_users = $conn->prepare("SELECT * FROM `users`");
                $select_users->execute();

                if($select_users->rowCount() > 0){
                    while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
                        $user_id = $fetch_users['user_id'];
                        ?>
                        <div class="box">
                            <img src="../uploaded_files/<?= htmlspecialchars($fetch_users['image']); ?>" alt="User Image">
                            <p>User ID: <span><?= htmlspecialchars($user_id); ?></span></p>
                            <p>User Name: <span><?= htmlspecialchars($fetch_users['name']); ?></span></p>
                            <p>User Email: <span><?= htmlspecialchars($fetch_users['email']); ?></span></p>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div class="empty">
                    <p> no registered users!</p>
                    </div>';
                }
                ?>
            </div>
        </section>
    </div>
    <!-- sweetalert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom JS link -->
    <script src="../js/admin_script.js"></script>

    <!-- Allert.php to display messages -->
    <?php include '../components/alert.php'; ?>
</body>
</html>
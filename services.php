<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon System - Our Services Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <div class="banner">
        <video autoplay muted loop class="background-video">
            <source src="image/video.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="detail">
            <h1>Services Section</h1>
            <p>Explore our range of beauty and wellness services</p>
            <span>
                <a href="index.php">home</a>
                <i class="bx bx-right-arrow-alt"></i>Our Services
            </span>
        </div>
    </div>
    <div class="services">
        <div class="heading">
            <h1>Our Latest Services</h1>
            <img src="image/separator-img(1).png" alt="">
        </div>
        <div class="box-container">
            <?php
            $select_services = $conn->prepare("SELECT * FROM `services` WHERE status = ?");
            $select_services->execute(['active']);
            if ($select_services->rowCount() > 0) {
                while ($fetch_services = $select_services->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form action="" method="post" class="box">
                <img src="uploaded_files/<?= $fetch_services['image']; ?>" class="image">
                <div class="content">
                    <div class="button">
                        <div>
                            <h3 class="name"><?= $fetch_services['name']; ?></h3>
                        </div>
                        <div>
                            <a href="view_services.php?sid=<?= $fetch_services['id']; ?>" class="bx bx-show"></a>
                        </div>
                    </div>
                    <p class="price">Price: ₹<?= $fetch_services['price']; ?>/-</p>
                    <input type="hidden" name="service_id" value="<?= $fetch_services['id']; ?>">
                    <div class="flex-btn">
                        <a href="book_appointment.php?get_id=<?= $fetch_services['id']; ?>" class="btn">Book Appointment</a>
                    </div>
                </div>
            </form>
            <?php
                }
            } else {
                echo '<div class="empty">
                <p>No services added yet!</p>
                </div>';
            }
            ?>
        </div>
    </div>
    </div><?php include 'components/footer.php'; ?>

    <!-- sweetalert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom JS link -->
    <script src="js/user_script.js"></script>


    <!-- Allert.php to display messages -->
    <?php include 'components/alert.php'; ?>
</body>
</html>
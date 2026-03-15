<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('');
}

$sid = $_GET['sid'];
include 'components/add_wishlist.php';
include 'components/add_cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Detail Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>Service detail</h1>
            <p>Here aur Some Amazing Services</p>
            <span>
                <a href="index.php">home</a>
                <i class="bx bx-right-arrow-alt"></i>service detail
            </span>
        </div>
    </div>

    <section class="view_page">
        <div class="heading">
            <h1>Service Detail</h1>
            <img src="image/separator-img(1).png" alt="">
        </div>
        <?php
        if (isset($_GET['sid'])) {
            $sid = $_GET['sid'];

            $select_services = $conn->prepare("SELECT * FROM `services` WHERE id = ?");
            $select_services->execute([$sid]);
            if ($select_services->rowCount() > 0) {
                while ($fetch_services = $select_services->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form action="" method="post" class="box">
                <div class="img-box">
                    <img src="uploaded_files/<?= $fetch_services['image']; ?>">
                </div>
                <div class="detail">
                    <p class="price">₹<?= $fetch_services['price']; ?>/-</p>
                    <div class="name"><?= $fetch_services['name']; ?></div>
                    <p class="service-detail"><?= $fetch_services['service_detail']; ?></p>
                    <input type="hidden" name="service_id" value="<?= $fetch_services['id']; ?>">
                    <div class="flex-btn">
                        <a href="book_appointment.php?get_id=<?= $fetch_services['id']; ?>" class="btn">Book Appointment</a>
                    </div>
                </div>
            </form>
            <?php 
                }
            }
        } ?>
    </section>
    <div class="services">
        <div class="heading">
            <h1>Similar services</h1>
            <p>Explore more services similar to this. Discover high-quality salon services selected to give you the best experience.</p>
            <img src="image/separator-img(1).png">
        </div>
        <?php include 'components/services.php'; ?>
    </div>

    <?php include 'components/footer.php'; ?>

    <!-- sweetalert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom JS link -->
    <script src="js/user_script.js"></script>


    <!-- Allert.php to display messages -->
    <?php include 'components/alert.php'; ?>
</body>
</html>
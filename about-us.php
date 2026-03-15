<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>About Us</h1>
            <p>Welcome to our salon! We are a team of professional stylists dedicated to providing the best hair care and beauty services.</p>
            <span>
                <a href="index.php">home</a>
                <i class="bx bx-right-arrow-alt"></i>About Us
            </span>
        </div>
    </div>

    <div class="lead">
        <div class="box-container">
            <div class="box">
                <div class="heading">
                    <span>Lorem, ipsum.</span>
                    <h1>Lorem, ipsum dolor.</h1>
                    <img src="image/separator-img(1).png" alt="">
                </div>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusantium repellat iusto iste voluptas ducimus enim nostrum dolorem ipsum, nam doloribus.</p>
                <div class="flex-btn">
                    <a href="" class="btn">explore our page</a>
                    <a href="services.php" class="btn">visit our page</a>
                </div>
            </div>
            <div class="box">
                <img src="image/team-4.png" alt="">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="box-container">
            <div class="img-box">
                <img src="image/team-3.png" alt="">
            </div>
            <div class="box">
                <div class="heading">
                    <h1>Lorem ipsum dolor sit amet.</h1>
                    <img src="image/separator-img(1).png" alt="">
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas, ratione.</p>
                <a href="" class="btn">Learn More</a>
            </div>
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
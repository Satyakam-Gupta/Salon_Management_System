<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}


if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    // Prepare the sql statement
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? and password = ?");
    $select_user->execute([$email, $pass]);

    //fetch the user's data
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        setcookie('user_id', $row['user_id'], time() + 60 * 60 * 24 * 30, '/');
        header('Location: index.php');
        exit();
        
    } else {
        // set a warning if credentials are incorrect
        $warning_msg[] = 'Incorrect email or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon System - User Ligin Page</title>
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
            <h1>login</h1>
            <p>login your account</p>
            <span>
                <a href="index.php">home</a>
                <i class="bx bx-right-arrow-alt"></i>login
            </span>
        </div>
    </div>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="login">
            <h3>Login Now</h3>

            <div class="input-field">
                <p>Your Email <span>*</span></p>
                <input type="email" name="email" placeholder="Enter your email" maxlength="50" required class="box">
            </div>

            <div class="input-field">
                <p>Your Password <span>*</span></p>
                <input type="Password" name="pass" placeholder="Enter your password" maxlength="50" required class="box">
            </div>

            <p class="link">Do not have an account? <a href ="register.php">register now</a></p>
            <p class="link"><a href ="admin panel/login.php">Login As Admin</a></p>
            <input type="submit" name="submit" value="login now" class="btn">
        </form>
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
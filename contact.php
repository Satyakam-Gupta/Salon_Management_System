<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['send_message'])) {
    if ($user_id != '') {
        $id = unique_id();
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
        $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

        $verify_message = $conn->prepare("SELECT * FROM `message` WHERE user_id = ? AND name = ? AND email = ? AND subject = ? AND message = ?");
        $verify_message->execute([$user_id, $name, $email, $subject, $message]);

        if ($verify_message->rowCount() > 0) {
            $warning_msg[] = 'You have already sent this message!';
        } else {
            $insert_message = $conn->prepare("INSERT INTO `message`(id, user_id, name, email, subject, message) VALUES(?,?,?,?,?,?)");
            $insert_message->execute([$id, $user_id, $name, $email, $subject, $message]);
            $success_msg[] = 'Message sent successfully!';
        }
    }else {
        $warning_msg[] = 'Please login to book an appointment';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact us Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <h1>Contact us Page</h1>
            <p>Contact us for any queries</p>
            <span>
                <a href="index.php">home</a>
                <i class="bx bx-right-arrow-alt"></i>Contact Us
            </span>
        </div>
    </div>

    <div class="services">
        <div class="heading">
            <h1>Our Services</h1>
            <p>Just a few clicks to book an appointment, saving your time and money</p>
            <img src="image/separator-img(1).png" alt="">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="image/0.png" alt="">
                <div>
                    <h1>Free Shipping Fast</h1>
                    <p>Get your products delivered fast and for free</p>
                </div>
            </div>
            <div class="box">
                <img src="image/1.png" alt="">
                <div>
                    <h1>Money Back Gauarantee</h1>
                    <p>We will refund your money if you are not satisfied</p>
                </div>
            </div>
            <div class="box">
                <img src="image/2.png" alt="">
                <div>
                    <h1>24/7 Customer Support</h1>
                    <p>Our support team is available around the clock to assist you</p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-container">
        <div class="heading">
            <h1>Drop us a line</h1>
            <p>Just a few clicks to book an appointment, saving your time and money</p>
            <img src="image/separator-img(1).png" alt="">
        </div>
        <form action="" method="post" class="register">
            <div class="input-field">
                <label>name <sup>*</sup></label>
                <input type="text" name="name" required placeholder="Enter Your Name" class="box">
            </div>
            <div class="input-field">
                <label>Email <sup>*</sup></label>
                <input type="email" name="email" required placeholder="Enter Your Email" class="box">
            </div>
            <div class="input-field">
                <label>Subject <sup>*</sup></label>
                <input type="text" name="subject" required placeholder="Reason...." class="box">
            </div>
            <div class="input-field">
                <label>Comment <sup>*</sup></label>
                <textarea name="message" cols="30" rows="10" required placeholder="Your Comment...." class="box"></textarea>
            </div>
            <button type="submit" name="send_message" class="btn">Send Message</button>
        </form>
    </div>

    <div class="address">
        <div class="heading">
            <h1>Contact Information</h1>
            <p>Just a few clicks to book an appointment, saving your time and money</p>
            <img src="image/separator-img(1).png" alt="">
        </div>
        <div class="box-container">
            <div class="box">
                <i class="bx bxs-map-alt"></i>
                <div>
                    <h4>Address</h4>
                    <p>123 Main Street, City, Country</p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-phone-incoming"></i>
                <div>
                    <h4>Phone Number</h4>
                    <p>+91 1234567890</p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-envelope"></i>
                <div>
                    <h4>Email</h4>
                    <p>info@salon.com</p>
                </div>
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
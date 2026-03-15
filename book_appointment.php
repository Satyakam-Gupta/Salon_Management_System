<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

$service_name = '';

if (isset($_GET['get_id'])) {
    $service_id = $_GET['get_id'];

    $select_service = $conn->prepare("SELECT * FROM `services` WHERE id = ?");
    $select_service->execute([$service_id]);
    $fetch_service = $select_service->fetch(PDO::FETCH_ASSOC);

    if ($fetch_service) {
        $service_name = $fetch_service['name'];
    } else {
        $warning_msg[] = 'service not found';
    }
}

if (isset($_POST['book_appointment'])) {
    if ($user_id != '') {
        $id = unique_id();
        $full_name = filter_var($_POST['full_name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
        $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
        $date = $_POST['date'];
        $time = $_POST['time'];
        $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

        if (!$service_name) {
            $warning_msg[] = 'service type is missing';
        } else {
            $verify_appointment = $conn->prepare("SELECT * FROM `appointments` WHERE user_id = ? AND date = ? AND time = ?");
            $verify_appointment->execute([$user_id, $date, $time]);

            if ($verify_appointment->rowCount() > 0) {
                $warning_msg[] = 'Appointment already exists for this time slot';
            } else {
                $insert_appointment = $conn->prepare("INSERT INTO `appointments` (id, user_id, full_name, email, phone, address, service, date, time, message, status) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                $insert_appointment->execute([$id, $user_id, $full_name, $email, $phone, $address, $service_name, $date, $time, $message, 'pending']);

                $success_msg[] = 'Appointment booked successfully';
            }
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
    <title>Salon System - Book Appointment</title>
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
            <h1>Book Appointment</h1>
            <p>Book your preferred service at your convenience</p>
            <span>
                <a href="index.php">home</a>
                <i class="bx bx-right-arrow-alt"></i>Book Appointment
            </span>
        </div>
    </div>

    <div class="form-container">
        <div class="heading">
            <h1>Book Your Appointment Now</h1>
            <p>Fill the form below to schedule your appointment</p>
            <img src="image/separator-img(1).png" alt="">
        </div>

        <form action="" method="post" class="register">
            <div class="flex-container">
                <div class="input-field">
                    <label>Service Type</label>
                    <input type="text" name="service" value="<?= htmlspecialchars($service_name); ?>" class="box" readonly>
                </div>

                <div class="input-field">
                    <label>Preferred Date <sup>*</sup></label>
                    <input type="date" name="date" required class="box">
                </div>

                <div class="input-field">
                    <label>Preferred Time <sup>*</sup></label>
                    <input type="time" name="time" required class="box">
                </div>

                <div class="input-field">
                    <label>Full Name <sup>*</sup></label>
                    <input type="text" name="full_name" required placeholder="Enter your full name" class="box">
                </div>

                <div class="input-field">
                    <label>Email <sup>*</sup></label>
                    <input type="email" name="email" required placeholder="Enter your email" class="box">
                </div>

                <div class="input-field">
                    <label>Phone Number <sup>*</sup></label>
                    <input type="text" name="phone" required placeholder="Enter your phone number" class="box">
                </div>

                <div class="input-field">
                    <label>Address</label>
                    <input type="text" name="address" placeholder="Enter your address" class="box">
                </div>
            </div>
            <div class="input-field">
                <label>Special Requirements</label>
                <textarea name="message" cols="30" rows="10" placeholder="Any specific requests or information" class="box"></textarea>
            </div>
            <button type="submit" name="book_appointment" class="btn">Book Appointment</button>
        </form>
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

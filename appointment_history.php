<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon System - Appointment History</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>My Appointment</h1>
            <p>View your past and upcoming appointments</p>
            <span>
                <a href="index.php">home</a>
                <i class="bx bx-right-arrow-alt"></i>Appointment History
            </span>
        </div>
    </div>
    <div class="orders">
        <div class="heading">
            <h1>My Appointment History</h1>
            <p>View your past and upcoming appointments</p>
            <img src="image/separator-img(1).png" alt="">
        </div>
    
        <div class="box-container">
            <?php 
            $select_appointments = $conn->prepare("
                SELECT appointments.*, services.price 
                FROM `appointments`
                INNER JOIN `services` ON appointments.service = services.name
                WHERE appointments.user_id = ?
                ORDER BY appointments.date DESC
                ");
            $select_appointments->execute([$user_id]);

            if($select_appointments->rowCount() > 0){
                while($fetch_appointment = $select_appointments->fetch(PDO::FETCH_ASSOC)){
                    $service_name = $fetch_appointment['service'];

                    $select_service = $conn->prepare("SELECT * FROM `services` WHERE name = ?");
                    $select_service->execute([$service_name]);

                    if($select_service->rowCount() > 0){
                        $fetch_service = $select_service->fetch(PDO::FETCH_ASSOC);
                        $service_image = $fetch_service['image'];
                    } else {
                        $service_image = 'image/service_image_placeholder.png';
                    }
            ?>
            <div class="box" <?php  if ($fetch_appointment['status'] == 'canceled') {echo 'style="border: 2px solid red"';} ?>>
                <a href="view_appointments.php?get_id=<?= $fetch_appointment['id']; ?>">
                    <img src="uploaded_files/<?= $service_image ?>" class="image" alt="<?= $service_name ?>">
                    <p class="date">
                        <i class="bx bxs-calender-alt"></i> <?= $fetch_appointment['date'] ?>
                    </p>
                    <div class="content">
                        <img src="image/shape-19.png" class="shap" alt="shape">
                        <div class="row">
                            <h3 class="name"><?= $service_name ?></h3>
                            <p class="price">Price: ₹<?= $fetch_appointment['price'] ?>/-</p>
                            <p class="status" style="color: 
                            <?php
                            if ($fetch_appointment['status'] == 'confirmed'){
                                echo 'green';
                            } elseif ($fetch_appointment['status'] == 'canceled'){
                                echo 'red';
                            } else {
                                echo 'orange';
                            }
                            ?>">
                            <?= $fetch_appointment['status'] ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <?php
                }
            } else {
                echo '<p class="empty">No appointments have been scheduled yet!</p>';
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
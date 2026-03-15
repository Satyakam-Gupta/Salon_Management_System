<?php
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];  
}else{
   $user_id = 'location: appointment_history.php';
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:orders.php');
}

if(isset($_POST['cancel'])){
    $update_appointment = $conn->prepare("UPDATE `appointments` SET status = ? WHERE id = ?");
    $update_appointment->execute(['cancelled', $get_id]);
    header('location:appointment_history.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Boxicons cdn link -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

    <?php include 'components/user_header.php';?>
    <div class="banner">
        <div class="detail">
            <h1>View Appointments</h1>
            <p>Welcome to our online store! Please log in to access your account and start shopping.</p>
            <span>
                <a href="index.php">home</a>
                <i class="bx bx-right-arrow-alt"></i>appointment details
            </span>
        </div>
    </div> 
    
    <div class="order-detail">
        <div class="heading">
            <h1>My Appointment details</h1>
            
            <img src="image/separator-img(1).png" alt="Seperator image">
        </div>
        <div class="box-container">
            <?php
                $select_appointment = $conn->prepare("
                SELECT appointments.*, services.price, services.image as service_image, services.name as service_name
                FROM `appointments`
                INNER JOIN `services` ON appointments.service = services.name
                WHERE appointments.id = ? 
                LIMIT 1
                ");
                $select_appointment->execute([$get_id]);

                 if($select_appointment->rowCount() > 0){
                    while($fetch_appointment = $select_appointment->fetch(PDO::FETCH_ASSOC)){
                        $service_name = $fetch_appointment['service'];
                        $select_service = $conn->prepare("SELECT * FROM `services` WHERE name = ? LIMIT 1");
                        $select_service->execute([$service_name]);

                         if($select_service->rowCount() > 0){
                            $fetch_service = $select_service->fetch(PDO::FETCH_ASSOC);
                            $service_image = $fetch_service['image'];
                         } else {
                            $service_image = 'image/service_image_placeholder.png';
                         }
            ?>
            <div class="box">
                <div class="col">
                    <p class="title">
                        <i class="bx bxs-calendar-alt"></i><span><?= $fetch_appointment['date']; ?></span>
                    </p>
                    <img src="uploaded_files/<?= $service_image; ?>"class="image" alt="<?= $service_name; ?>"> 
                    <h3 class="name"><?= $service_name; ?></h3>
                    <p class="grand-total">
                        Total payable amount:<span>₹<?= $fetch_appointment['price']; ?>/-</span>
                    </p>
                </div>
                <div class="col">
                    <p class="title">Billing Address</p>
                    <p class="user">
                        <i class="bi bi-person-bounding-box"></i><span><?= $fetch_appointment['full_name']; ?></span>
                    </p>
                    <p class="user">
                        <i class="bi bi-phone"></i><span><?= $fetch_appointment['phone']; ?></span>
                    </p>
                    <p class="user">
                        <i class="bi bi-envelope"></i><span><?= $fetch_appointment['email']; ?></span>
                    </p>
                    <p class="user">
                        <i class="bi bi-pin-map-fill"></i><span><?= ucwords($fetch_appointment['address']); ?></span>
                    </p>
                    <p class="status" style="color:
                        <?php
                        if($fetch_appointment['status'] == 'delivered'){
                            echo 'green';
                        }elseif($fetch_appointment['status'] == 'cancelled'){
                            echo 'red';
                        }else{
                            echo 'orange';
                        }
                        ?>">
                        <?= $fetch_appointment['status']; ?>
                    </p>

                    <?php if($fetch_appointment['status']=='cancelled'){?>
                        <a href="book_appointment.php?get_id=<?= $fetch_service['id']; ?>" class="btn" style="line-height:3">Order Again</a>
                    <?php }else{ ?>
                        <form action="" method="post">
                            <button type="submit" name="cancel" class="btn" style="line-height:3" onclick="return confirm('Are you sure you want to cancel this appointment?');">Cancel Appointment</button>
                        </form>
                    <?php } ?>
                    

                </div>
            </div>
            <?php
                    }
                } else {
                    echo '<div class="empty"><p>No Appointment Details Found!</p></div>';
                }
                ?>
        </div>
    </div>
    
    <?php include 'components/footer.php'; ?>
    <!-- sweetalert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Allert.php to display messages -->
    <?php include 'components/alert.php'; ?>

    <!-- custom JS link -->
    <script src="js/user_script.js"></script>

</body>
</html>
<?php
include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('Location: login.php');
    exit();
}
//update appointment status
if (isset($_POST['update_status']) && isset($_POST['appointment_id'])) {
   $appointment_id = filter_var($_POST['appointment_id'], FILTER_SANITIZE_STRING);
   $new_status = filter_var($_POST['new_status'], FILTER_SANITIZE_STRING);

   if(in_array($new_status, ['pending', 'confirmed', 'canceled'])) {
      $update_stmt = $conn->prepare("UPDATE `appointments` SET status = ? WHERE id = ?");
      $update_stmt->execute([$new_status, $appointment_id]);
      $success_msg[] = 'Appointment status updated';
   } else {
      $error_msg[] = 'Invalid status selected';
   }
}

//Delete appointment
if (isset($_POST['delete_appointment'])) {
   $appointment_id = filter_var($_POST['appointment_id'], FILTER_SANITIZE_STRING);

   $delete_stmt = $conn->prepare("DELETE FROM `appointments` WHERE id = ?");
   $delete_stmt->execute([$appointment_id]);
   $success_msg[] = 'Appointment deleted';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View Appointments</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="order-container">
            <div class="heading">
                <h1>All Appointments</h1>
                <img src="../image/separator-img.png">
            </div>
            <div class="box-container">
                <?php
                $select_appointments = $conn->prepare("SELECT a.*, u.name as username, s.price as service_price FROM `appointments` a INNER JOIN `users` u ON a.user_id = u.user_id INNER JOIN `services` s ON a.service = s.name");
                $select_appointments->execute();

                if ($select_appointments->rowCount() > 0) {
                    while ($appointment = $select_appointments->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="box">
                        <div class="status" style="color: <?php if ($appointment['status'] == 'confirmed') {echo 'limegreen'; } elseif ($appointment['status'] == 'canceled') {echo 'red'; } else {echo 'orange'; } ?>">
                            <?= htmlspecialchars($appointment['status']); ?>
                        </div>

                        <div class="details">
                            <p>User Name: <span><?= htmlspecialchars($appointment['username']); ?></span></p>
                            <p>User ID: <span><?= htmlspecialchars($appointment['user_id']); ?></span></p>
                            <p>Appointment Date: <span><?= htmlspecialchars($appointment['date']); ?></span></p>
                            <p>User Number: <span><?= htmlspecialchars($appointment['phone']); ?></span></p>
                            <p>User Email: <span><?= htmlspecialchars($appointment['email']); ?></span></p>
                            <p>Total Price: <span><?= htmlspecialchars($appointment['service_price']); ?></span></p>
                            <p>User Address: <span><?= htmlspecialchars($appointment['address']); ?></span></p>
                        </div>

                        <form action="" method="post">
                            <input type="hidden" name="appointment_id" value="<?= htmlspecialchars($appointment['id']); ?>">
                            <select name="new_status" class="box" style="width: 90%;">
                                <option value="pending" <?= $appointment['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="confirmed" <?= $appointment['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                <option value="canceled" <?= $appointment['status'] == 'canceled' ? 'selected' : '' ?>>Canceled</option>
                            </select>
                            <div class="flex-btn">
                                <input type="submit" name="update_status" value="Update Status" class="btn">
                                <input type="submit" name="delete_appointment" value="Delete Appointment" class="btn" onclick="return confirm('Delete This Appointment');">
                            </div>
                        </form>
                    </div>
                    <?php
                    }
                } else {
                    echo '<div class="empty">
                    <p> no appointments found!</p>
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
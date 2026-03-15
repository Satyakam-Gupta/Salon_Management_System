<?php
include '../components/connect.php';

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    // Prepare the sql statement
    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE email = ? and password = ?");
    $select_admin->execute([$email, $pass]);

    //fetch the admin's data
    $row = $select_admin->fetch(PDO::FETCH_ASSOC);

    if ($select_admin->rowCount() > 0) {
        setcookie('admin_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
        header('Location: dashboard.php');
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
    <title>Salon System - Admin Ligin Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body>
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

            <input type="submit" name="submit" value="login now" class="btn">
        </form>
    </div>

    <!-- sweetalert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Allert.php to display messages -->
    <?php
    include '../components/alert.php';
    ?>
</body>

</html>
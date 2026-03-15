<?php
include '../components/connect.php';

if(isset($_POST['submit'])){
    $id = unique_id();

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);

    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id().'.'.$ext;

    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/'.$rename;

    //check if admin email already exist
    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE email = ?");
    $select_admin->execute([$email]);

    if($select_admin->rowCount() > 0){
        $warning_msg[] = 'Email already exist!';
    }else{
        if($pass != $cpass){
            $warning_msg[] = 'Confirm password not matched!';
        }else{
            $insert_admin = $conn->prepare("INSERT INTO `admins`(id, name, email, password, image) VALUES(?,?,?,?,?)");
            $insert_admin->execute([$id, $name, $email, $cpass, $rename]);

            if($insert_admin){
            move_uploaded_file($image_tmp_name, $image_folder);
            $success_msg[] = 'New admin added Successfully!';
            }else{
                $warning_msg[] = 'Registration failed, try again!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon system - Add Admin </title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    
</head>
<body>
    <div class="form-container">
        <form action="" method="Post" enctype="multipart/form-data" class="register">
            <h3>Add New Admin</h3>
            <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p> Your Name <span>*</span></p>
                        <input type ="text" name="name" placeholder="Enter your Name" required class="box" maxlength="50">
                    </div>
                    <div class="input-field">
                        <p> Your Email <span>*</span></p>
                        <input type ="email" name="email" placeholder="Enter your Email" required class="box" maxlength="50">
                    </div>
                </div>
                <div class="col">
                    <div class="input-field">
                        <p> Your Password <span>*</span></p>
                        <input type ="Password" name="pass" placeholder="Enter your Password" required class="box" maxlength="50">
                    </div>
                    <div class="input-field">
                        <p> Confirm Password <span>*</span></p>
                        <input type ="Password" name="cpass" placeholder="Enter your Password" required class="box" maxlength="50">
                    </div>
                </div>
            </div>
            <div class="input-field">
                <p> Your profile <span>*</span></p>
                <input type="file" name="image" accept="image/*" required class="box">
            </div>

            <p class="link">Back to Dashboard <a href ="dashboard.php">Admin Dahboard</a></p>
            <input type = "submit" name="submit" value="add now" class="btn">
        </form>
    </div>

    <!-- sweetalert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom JS link -->
    <script src="../js/admin_script.js"></script>


    <!-- Allert.php to display messages -->
    <?php include '../components/alert.php'; ?>

</body>
</html>
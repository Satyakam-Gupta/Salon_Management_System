<?php
include '../components/connect.php';
if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('Location: login.php');
    exit();
}

// delete product 
if (isset($_POST['delete'])) {
    $s_id = $_POST['service_id'];
    $s_id = filter_var($s_id, FILTER_SANITIZE_STRING);
    $delete_service = $conn->prepare("DELETE FROM `services` WHERE id = ?");
    $delete_service->execute([$s_id]);
    $success_msg[] = 'Service Deleted Successfully!';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon System - View Services</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php' ?>
        <section class="show-post">
            <div class="heading">
                <h1>Your Services</h1>
                <img src="../image/separator-img.png" >
            </div>
            <div class="box-container">
                <?php
                $select_services = $conn->prepare("SELECT * FROM `services`");
                $select_services->execute();
                if($select_services->rowCount() > 0){
                    while($fetch_services = $select_services->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <form action="" method="post" class="box">
                            <input type="hidden" name="service_id" value="<?= $fetch_services['id']; ?>">
                            <?php if($fetch_services['image'] != '') { ?>
                                <img src="../uploaded_files/<?= $fetch_services['image']; ?>" class="image">
                            <?php } ?>
                            <div class="status" style="color: <?php if($fetch_services['status'] == 'active') {echo 'limegreen'; } else {echo 'coral';} ?>;">
                                <?= $fetch_services['status'] ?>
                            </div>
                            <div class="price">₹<?= $fetch_services['price']; ?>/-</div>
                            <div class="content">
                                <div class="title"><?= $fetch_services['name']; ?></div>
                                <div class="flex-btn">
                                    <a href="edit_service.php?id=<?= $fetch_services['id']; ?>" class="btn">edit</a>
                                    <button type="submit" name="delete" class="btn" onclick="return confirm('Delete this Service'); ">delete</button>
                                    <a href="read_service.php?post_id=<?= $fetch_services['id']; ?>" class="btn">read</a>
                                </div> 
                            </div>
                        </form>
                        <?php
                    }
                } else {
                    echo '<div class="empty">
                    <p>No Services Added Yet! <br> <a href="add_services.php" class="btn" style="margin-top:1.5rem; ">add services</a></p>
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
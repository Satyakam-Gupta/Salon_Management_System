<?php 
include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('Location: login.php');
    exit();
}
$get_id =$_GET['post_id'];
// Delete service
if (isset($_POST['delete'])) {

    $s_id = $_POST['service_id'];
    $s_id = filter_var($s_id, FILTER_SANITIZE_STRING);

    $delete_image = $conn->prepare("SELECT * FROM `services` WHERE id = ?");
    $delete_image->execute([$s_id]);
    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

    if ($fetch_delete_image && !empty($fetch_delete_image['image'])) {
        unlink('../uploaded_files/' . $fetch_delete_image['image']);
    }

    $delete_service = $conn->prepare("DELETE FROM `services` WHERE id = ?");
    $delete_service->execute([$s_id]);

    $success_msg[] = 'service deleted successfully';

    header('Location: view_services.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon System - Service Detail Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="read-post">
            <div class="heading">
                <h1>service details</h1>
                <img src="../image/separator-img.png">
            </div>
            <div class="box-container">
                <?php 
                $select_service = $conn->prepare("SELECT * FROM `services` WHERE id = ?");
                $select_service->execute([$get_id]);
                if($select_service->rowCount() > 0){
                    while($fetch_service = $select_service->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <form action="" method="post" class="box">
                            <input type="hidden" name="service_id" value="<?= $fetch_service['id']; ?>">
                            <div class="status" style="color: <?php if($fetch_service['status'] == 'active') { echo 'limegreen'; } else { echo 'coral'; } ?>;">
                                <?= $fetch_service['status']; ?>
                            </div>
                            <?php if ($fetch_service['image'] != '') { ?>
                                <img src="../uploaded_files/<?= $fetch_service['image']; ?>" class="image">      
                            <?php } ?>
                            <div class="price">₹<?= $fetch_service['price']; ?>/-</div>
                            <div class="title"><?= $fetch_service['name']; ?></div>
                            <div class="content"><?= $fetch_service['service_detail']; ?></div>

                            <div class="flex-btn">
                                <a href="edit_services.php?id=<?= $fetch_service['id']; ?>" class="btn">edit</a>
                                <button type="submit" name="delete" class="btn" onclick="return confirm('Delete this Service')">delete</button>
                                <a href="view_services.php?post_id=<?= $fetch_service['id']; ?>" class="btn">go back</a>
                            </div>
                        </form>
                        <?php
                    }
                } else {
                    ?>
                    <div class="empty">
                        <p>no services added yet! <br> <a href="add_services.php" class="btn" style="margin-top: 1.5rem;">Add Services</a></p>
                    </div>
                <?php } ?>
            </div>
        </section>
    </div>

    <!-- sweetalert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Allert.php to display messages -->
    <?php include '../components/alert.php'; ?>

    <!-- custom JS link -->
    <script src="../js/admin_script.js"></script>

</body>
</html>
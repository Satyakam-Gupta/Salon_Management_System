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
// Delete product
if (isset($_POST['delete'])) {

    $p_id = $_POST['product_id'];
    $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

    $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_image->execute([$p_id]);
    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

    if ($fetch_delete_image && !empty($fetch_delete_image['image'])) {
        unlink('../uploaded_files/' . $fetch_delete_image['image']);
    }

    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$p_id]);

    $success_msg[] = 'product deleted successfully';

    header('Location: view_products.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon System - Product Detail Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="read-post">
            <div class="heading">
                <h1>product details</h1>
                <img src="../image/separator-img.png">
            </div>
            <div class="box-container">
                <?php 
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_product->execute([$get_id]);
                if($select_product->rowCount() > 0){
                    while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <form action="" method="post" class="box">
                            <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                            <div class="status" style="color: <?php if($fetch_product['status'] == 'active') { echo 'limegreen'; } else { echo 'coral'; } ?>;">
                                <?= $fetch_product['status']; ?>
                            </div>
                            <?php if ($fetch_product['image'] != '') { ?>
                                <img src="../uploaded_files/<?= $fetch_product['image']; ?>" class="image">      
                            <?php } ?>
                            <div class="price">₹<?= $fetch_product['price']; ?>/-</div>
                            <div class="title"><?= $fetch_product['name']; ?></div>
                            <div class="content"><?= $fetch_product['product_detail']; ?></div>

                            <div class="flex-btn">
                                <a href="edit_product.php?id=<?= $fetch_product['id']; ?>" class="btn">edit</a>
                                <button type="submit" name="delete" class="btn" onclick="return confirm('Delete this Product')">delete</button>
                                <a href="view_products.php?post_id=<?= $fetch_product['id']; ?>" class="btn">go back</a>
                            </div>
                        </form>
                        <?php
                    }
                } else {
                    ?>
                    <div class="empty">
                        <p>no products added yet! <br> <a href="add_products.php" class="btn" style="margin-top: 1.5rem;">Add Products</a></p>
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
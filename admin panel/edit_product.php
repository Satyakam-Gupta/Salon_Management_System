<?php
include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('Location: login.php');
    exit();
}

// retriving product id from form
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
} elseif (isset($_GET['id'])) {
    $product_id = $_GET['id'];
} else {
    $product_id = '';
}

// Edit Product
if (isset($_POST['update'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $stock = filter_var($_POST['stock'], FILTER_SANITIZE_STRING);
    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);


    // Update product Detail in database
    $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, product_detail = ?, stock = ?, status = ? WHERE id = ?");
    $update_product->execute([$name, $price, $description, $stock, $status, $product_id]);
    $success_msg[] = 'Product Updated Successfully!';
    // handle image update
    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $image;

    $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
    $select_image->execute([$image]);

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $warning_msg[] = 'Image size exceeds 2MB limit';
        } elseif ($select_image->rowCount() > 0 && $image != '') {
            $warning_msg[] = 'Please rename the image to avoid Conflicts!';
        } else {
            // update the image in the database
            $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
            $update_image->execute([$image, $product_id]);

            // move the image to the folder
            move_uploaded_file($image_tmp_name, $image_folder);

            // remove the old image if it's different and not empty
            if ($old_image != $image && !empty($old_image)) {
                unlink("../uploaded_files/" . $old_image);
            }
            $success_msg[] = "Image updated Successfuly!";
        }
    }
}
// delete image
if (isset($_POST['delete_image'])) {

    $product_id = $_POST['product_id'];
    $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

    //fetch product details
    $delete_image = $conn->prepare("SELECT image FROM `products` WHERE id = ?");
    $delete_image->execute([$product_id]);
    $fetch_image = $delete_image->fetch(PDO::FETCH_ASSOC);

    if ($fetch_image && !empty($fetch_image['image'])) {

        unlink('../uploaded_files/' . $fetch_image['image']);

        $update_image = $conn->prepare("UPDATE `products` SET image = '' WHERE id = ?");
        $update_image->execute([$product_id]);

        $success_msg[] = 'image deleted successfully';
    }
}
// Delete product
if (isset($_POST['delete_product'])) {

    $product_id = $_POST['product_id'];
    $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

    $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_image->execute([$product_id]);
    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

    if ($fetch_delete_image && !empty($fetch_delete_image['image'])) {
        unlink('../uploaded_files/' . $fetch_delete_image['image']);
    }

    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$product_id]);

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
    <title>Salon System - Edit Product</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="post-editor">
            <div class="heading">
                <h1>edit product</h1>
                <img src="../image/separator-img.png">
            </div>

            <div class="box-container">
                <?php
                $product_id = $_GET['id'];
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_product->execute([$product_id]);

                if ($select_product->rowCount() > 0) {
                    while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <div class="form-container">
                            <form action="" method="post" enctype="multipart/form-data" class="register">
                                <input type="hidden" name="old_image" value="<?= $fetch_product['image']; ?>">
                                <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">

                                <div class="input-field">
                                    <p>product status <span>*</span></p>
                                    <select name="status" class="box">
                                        <option value="<?= $fetch_product['status']; ?>" selected><?= $fetch_product['status']; ?></option>
                                        <option value="active">active</option>
                                        <option value="deactive">deactive</option>
                                    </select>
                                </div>

                                <div class="input-field">
                                    <p>product name <span>*</span></p>
                                    <input type="text" name="name" value="<?= $fetch_product['name']; ?>" class="box">
                                </div>

                                <div class="input-field">
                                    <p>product price <span>*</span></p>
                                    <input type="text" name="price" value="<?= $fetch_product['price']; ?>" class="box">
                                </div>
                                <div class="input-field">
                                    <p>product description <span>*</span></p>
                                    <textarea name="description" class="box"><?= $fetch_product['product_detail']; ?></textarea>
                                </div>
                                <div class="input-field">
                                    <p>product stock <span>*</span></p>
                                    <input type="number" name="stock" value="<?= $fetch_product['stock']; ?>" class="box" min="0" max="999999999" maxlength="10">
                                </div>
                                <div class="input-field">
                                    <p>product image <span>*</span></p>
                                    <input type="file" name="image" accept="image/*" class="box">
                                    <?php if ($fetch_product['image'] != '') { ?>
                                        <img src="../uploaded_files/<?= $fetch_product['image']; ?>" class="image">
                                        <div class="flex-btn">
                                            <input type="submit" name="delete_image" class="btn" value="delete image">
                                            <a href="view_products.php" class="btn" style="width: 49%; text-align: center; height: 3.2rem; margin-top: .7rem;">go back</a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="flex-btn">
                                    <input type="submit" name="update" class="btn" value="update product">
                                    <input type="submit" name="delete_product" class="btn" value="delete product">
                                </div>
                            </form>
                        <?php
                    }
                } else {
                        ?>
                        <div class="empty">
                            <p>no product added yet!</p>
                        </div>
                    <?php } ?>
                        </div>
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
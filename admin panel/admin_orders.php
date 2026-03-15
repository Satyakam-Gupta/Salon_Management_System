<?php
include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('Location: login.php');
    exit();
}

if (isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $order_id = filter_var($order_id, FILTER_SANITIZE_STRING);
    $update_payment = $_POST['update_payment'];
    $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);

    $update_pay = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
    $update_pay->execute([$update_payment, $order_id]);

    $success_msg[] = 'Order status updated!';
}

// delete order
if (isset($_POST['delete_order'])) {
    $delete_id = $_POST['order_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
    $verify_delete->execute([$delete_id]);

    if ($verify_delete->rowCount() > 0) {
        $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
        $delete_order->execute([$delete_id]);
        $success_msg[] = 'Order deleted successfully!';
    } else {
        $warning_msg[] = 'Order already deleted!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon System - Manage Orders</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="order-container">
            <div class="heading">
                <h1>total orders placed</h1>
                <img src="../image/separator-img.png">
            </div>
            <div class="box-container">
                <?php
                $select_order = $conn->prepare("SELECT * FROM `orders`");
                $select_order->execute();
                if ($select_order->rowCount() > 0) {
                    while ($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <div class="box">
                            <div class="status" style="color: <?php if ($fetch_order['status'] == 'in progress') {echo 'limegreen';} else {echo 'red';} ?>;">
                                <?= $fetch_order['status']; ?>
                            </div>
                            <div class="details">
                                <p>user name: <span><?= $fetch_order['name']; ?></span></p>
                                <p>user id: <span><?= $fetch_order['user_id']; ?></span></p>
                                <p>placed on: <span><?= $fetch_order['date']; ?></span></p>
                                <p>user number: <span><?= $fetch_order['number']; ?></span></p>
                                <p>user email: <span><?= $fetch_order['email']; ?></span></p>
                                <p>total price: <span><?= $fetch_order['price']; ?></span></p>
                                <p>payment method: <span><?= $fetch_order['method']; ?></span></p>
                                <p>user address: <span><?= $fetch_order['address']; ?></span></p>
                            </div>
                            <form action="" method="post">
                                <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
                                <select name="update_payment" class="box" style="width:90%;">
                                    <option disabled selected><?= $fetch_order['status']; ?></option>
                                    <option value="Pending">Pending</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Shipped">Shipped</option>
                                    <option value="Out for Delivery">Out for Delivery</option>
                                    <option value="Order Delivered">Order Delivered</option>
                                    <option value="Canceled">Canceled</option>
                                    <option value="Returned">Returned</option>
                                    <option value="Refunded">Refunded</option>
                                </select>

                                <div class="flex-btn">
                                    <input type="submit" name="update_order" value="Update Status" class="btn">
                                    <input type="submit" name="delete_order" value="Delete Order" class="btn"
                                        onclick="return confirm('Delete this order')">
                                </div>
                            </form>
                        </div>
                <?php
                    }
                } else {
                    echo '<div class="empty">
                    <p>No order placed yet!</p>
                    </div>';
                }
                ?>
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
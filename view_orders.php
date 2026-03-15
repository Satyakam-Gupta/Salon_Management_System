<?php
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];  
}else{
   $user_id = 'location:login.php';
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:orders.php');
}

if(isset($_POST['cancel'])){
    $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
    $update_order->execute(['cancelled', $get_id]);
    header('location:orders.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View my page</title>
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
            <h1>View Orders</h1>
            <p>Welcome to our online store! Please log in to access your account and start shopping.</p>
            <span>
                <a href="index.php">home</a>
                <i class="bx bx-right-arrow-alt"></i>Order details
            </span>
        </div>
    </div> 
    
    <div class="order-detail">
        <div class="heading">
            <h1>My Order details</h1>
            
            <img src="image/separator-img(1).png" alt="Seperator image">
        </div>
        <div class="box-container">
            <?php
                $grand_total = 0; 
                $select_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ? AND user_id = ? LIMIT 1");
                $select_order->execute([$get_id, $user_id]);

                 if($select_order->rowCount() > 0){
                    while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){
                        $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                        $select_product->execute([$fetch_order['product_id']]);

                         if($select_product->rowCount() > 0){
                            while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
                                $sub_total = $fetch_order['price'] * $fetch_order['qty'];
                                $grand_total += $sub_total;
            ?>
            <div class="box">
                <div class="col">
                    <p class="title">
                        <i class="bx bxs-calendar-alt"></i><span><?= $fetch_order['date']; ?></span>
                    </p>
                    <img src="uploaded_files/<?= $fetch_product['image']; ?>"class="image" alt="<?= $fetch_product['name']; ?>"> 
                    <p class="price">₹<?= $fetch_product['price']; ?>/-</p>
                    <h3 class="name"><?= $fetch_product['name']; ?></h3>
                    <p class="grand-total">
                        Total payable amount:<span>₹<?= $grand_total; ?>/-</span>
                    </p>
                </div>
                <div class="col">
                    <p class="title">Billing Address</p>
                    <p class="user">
                        <i class="bi bi-person-bounding-box"></i><span><?= $fetch_order['name']; ?></span>
                    </p>
                    <p class="user">
                        <i class="bi bi-phone"></i><span><?= $fetch_order['number']; ?></span>
                    </p>
                    <p class="user">
                        <i class="bi bi-envelope"></i><span><?= $fetch_order['email']; ?></span>
                    </p>
                    <p class="user">
                        <i class="bi bi-pin-map-fill"></i><span><?= ucwords($fetch_order['address']); ?></span>
                    </p>
                    <p class="status" style="color:
                        <?php
                        if($fetch_order['status'] == 'delivered'){
                            echo 'green';
                        }elseif($fetch_order['status'] == 'cancelled'){
                            echo 'red';
                        }else{
                            echo 'orange';
                        }
                        ?>">
                        <?= $fetch_order['status']; ?>
                    </p>

                    <?php if($fetch_order['status']=='cancelled'){?>
                        <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn" style="line-height:3">Order Again</a>
                    <?php }else{ ?>
                        <form action="" method="post">
                            <button type="submit" name="cancel" class="btn" style="line-height:3" onclick="return confirm('Are you sure you want to cancel this order?');">Cancel Order</button>
                        </form>
                    <?php } ?>
                    

                </div>
            </div>
            <?php
                            }
                        }
                    }
                }else{
                    echo '<div class="empty"><p>No order found!</p></div>';
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
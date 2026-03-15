<?php
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];  
}else{
   $user_id = '';
   header('location:login.php');    
}

$get_id = $_GET['get_id'] ?? '';

if(isset($_POST['place_order'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    
    $number = sha1($_POST['number']);
    $number = filter_var($number, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $address = $_POST['flat'].' '. $_POST['street'].' '. $_POST['city'].' '. $_POST['country'].' - '. $_POST['pincode'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);

    $address_type = $_POST['address_type'];
    $address_type = filter_var($address_type, FILTER_SANITIZE_STRING);

    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);

    $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $verify_cart->execute([$user_id]);

    if(isset($_GET['get_id'])){
        $get_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?LIMIT 1");
        $get_product->execute([$_GET['get_id']]);

        if($get_product->rowCount() > 0){
            while($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)){
                $admin_id = $fetch_p['admin_id'];

                $insert_order = $conn->prepare("INSERT INTO `orders`(id ,user_id, admin_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                $insert_order->execute([unique_id(), $user_id, $admin_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $fetch_p['price'],1]);
                header('location:orders.php');
            }
        }else{
            $warning_msg[] = 'Something went wrong';
        }
    }else if($verify_cart->rowCount() > 0){
        while($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)){
            $s_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?LIMIT 1");
            $s_product->execute([$f_cart['product_id']]);
            $f_product = $s_product->fetch(PDO::FETCH_ASSOC);
            $admin_id = $f_product['admin_id'];

            $insert_order = $conn->prepare("INSERT INTO `orders`(id ,user_id, admin_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
            $insert_order->execute([unique_id(), $user_id, $admin_id, $name, $number, $email, $address, $address_type, $method, $f_cart['product_id'], $f_product['price'], $f_cart['qty']]);   

        }
        if($insert_order){
            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);
            header('location:orders.php');
        }
    }else{
        $warning_msg[] = 'Something went wrong!';
    }
       
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>
    <?php include 'components/user_header.php';?>
    <div class="banner">
        <div class="detail">
            <h1>Checkout</h1>
            <p>Welcome to our online store! Please log in to access your account and start shopping.</p>
            <span>
                <a href="index.php">home</a>
                <i class="bx bx-right-arrow-alt"></i>Checkout
            </span>
        </div>
    </div>    

    <div class="checkout">
        <div class="heading">
            <h1>Checkout Summary</h1>
            <img src="image/separator-img(1).png" alt="">
        </div>
        <div class="row">
            <form action="" method="POST" class="register">
                <input type="hidden" name="p_id" value="<?= $get_id ?>">
                <h3>billing details</h3>
                <div class="flex">
                    <div class="box">
                        <div class="input-field">
                            <p>Your Name <span>*</span></p>
                            <input type="text" name="name" required maxlength="50" placeholder="Enter your name" class="input">
                        </div>
                        <div class="input-field">
                            <p>Your Number <span>*</span></p>
                            <input type="text" name="number" required maxlength="50" placeholder="Enter your number" class="input">
                        </div>
                        <div class="input-field">
                            <p>Your Email <span>*</span></p>
                            <input type="text" name="email" required maxlength="50" placeholder="Enter your email" class="input">
                        </div>
                        <div class="input-field">
                            <p>Payment method <span>*</span></p>
                            <select name="method" class="input" required>
                                <option value="" disabled selected>select payment method</option>
                                <option value="cash on delivery">cash on delivery</option>
                                <option value="credit card">credit card</option>
                                <option value="UPI or Rupay">UPI or Rupay</option>
                                <option value="Net Banking">Net Banking</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <p>Address type <span>*</span></p>
                            <select name="address_type" class="input" required>
                                <option value="" disabled selected>select address type</option>
                                <option value="home">home</option>
                                <option value="office">office</option>
                                <option value="other">other</option>
                            </select>
                        </div>
                    </div>
                    <div class="box">
                        <div class="input-field">
                            <p>Address line 01 <span>*</span></p>
                            <input type="text" name="flat" required maxlength="50" placeholder="e.g., Flat or building name" class="input">
                        </div>
                        <div class="input-field">
                            <p>Address line 02 <span>*</span></p>
                            <input type="text" name="street" required maxlength="50" placeholder="e.g., Street name" class="input">
                        </div>
                        <div class="input-field">
                            <p>City name <span>*</span></p>
                            <input type="text" name="city" required maxlength="50" placeholder="e.g., City name" class="input">
                        </div>
                        <div class="input-field">
                            <p>State name <span>*</span></p>
                            <input type="text" name="country" required maxlength="50" placeholder="e.g., State name" class="input">
                        </div>
                        <div class="input-field">
                            <p>Pincode <span>*</span></p>
                            <input type="text" name="pincode" required maxlength="50" placeholder="e.g., Pincode" class="input">
                        </div>
                    </div>
                </div>
                <button type="submit" name="place_order" class="btn">Place Order</button>
            </form>
            <div class="summary">
                <h3>My bag</h3>
                <div class="box-container">
                    <?php
                        $grand_total = 0;
                        if(isset($_GET['get_id'])){
                            $select_get = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                            $select_get->execute([$_GET['get_id']]);
                            while($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)){
                                $sub_total = $fetch_get['price'];
                                $grand_total += $sub_total;
                    ?>
                    <div class="flex">
                        <img src="uploaded_files/<?= $fetch_get['image'] ?>"class="image">
                        <div>
                            <h3 class="name"><?= $fetch_get['name']; ?></h3>
                            <p class="price">₹<?= $fetch_get['price']; ?>/-</p>
                        </div>
                    </div>
                    <?php
                            }
                        }else{
                            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                            $select_cart->execute([$user_id]);
                            if($select_cart->rowCount() > 0){
                                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                                    $select_products->execute([$fetch_cart['product_id']]);
                                    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                                    $sub_total = $fetch_products['price'] * $fetch_cart['qty'];
                                    $grand_total += $sub_total;   
                    ?>
                    <div class="flex">
                        <img src="uploaded_files/<?= $fetch_products['image'] ?>"class="image">
                        <div>
                            <h3 class="name"><?= $fetch_products['name']; ?></h3>
                            <p class="price">₹<?= $fetch_products['price']; ?>X<?= $fetch_cart['qty']; ?></p>
                        </div>
                    </div>
                    <?php
                                }
                            }else{
                                echo '<p class="empty">your cart is empty</p>';
                            }
                        }
                    ?>
                </div>
                <div class="grand-total">
                    <p>Grand Total : ₹<?= $grand_total; ?>/-</p>
                </div>
            </div>
        </div>
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
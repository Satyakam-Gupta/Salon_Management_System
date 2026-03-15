<?php
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];  
}else{
   $user_id = 'location:login.php';
}

//update quantity in cart
if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);

   //prepare the statement to update the quantity in the cart
   $update_qty = $conn->prepare("UPDATE `cart` SET qty = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);

   $success_msg[] = 'Cart Quantity Updated!'; 
   
}

if(isset($_POST['delete_item'])){
   $cart_id = $_POST['cart_id'];
   $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

   //verify if the cart item exists before deleting
   $verify_delete_item = $conn->prepare("SELECT * FROM `cart` WHERE id = ?");
   $verify_delete_item->execute([$cart_id]);


    if($verify_delete_item->rowCount() > 0){
        $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
        $delete_cart_id->execute([$cart_id]);
        $success_msg[] = 'Cart item Deleted!';
    }else{
        $warning_msg[] = 'Cart item Already Deleted!';
    }
}

//Empty the cart
if(isset($_POST['empty_cart'])){
   //verify if the cart has items before emptying
   $verify_empty_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $verify_empty_cart->execute([$user_id]);

   if($verify_empty_cart->rowCount() > 0){
      $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart_id->execute([$user_id]);
      $success_msg[] = 'Cart Emptied Successfully!';
   }else{
      $warning_msg[] = 'Your Cart is Already Empty!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User cart page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>

    <?php include 'components/user_header.php';?>
    <div class="banner">
        <video autoplay muted loop class="background-video">
            <source src="images/video.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="detail">
            <h1>My Cart</h1>
            <p>Welcome to our online store! Please log in to access your account and start shopping.</p>
            <span>
                <a href="index.php">home</a>
                <i class="bx bx-right-arrow-alt"></i>login
            </span>
        </div>
    </div>

    <div class="products">
        <div class="heading">
            <h1>My Cart</h1>
            <img src="image/separator-img(1).png">
        </div>
        <div class="box-container">
            <?php
                $grand_total = 0;
                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $select_cart->execute([$user_id]);
                if($select_cart->rowCount() > 0){
                    while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_products->execute([$fetch_cart['product_id']]);

                        if($select_products->rowCount() > 0){
                            $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                    
            ?>
            <form action="" method="post" class="box" <?php if($fetch_products['stock'] == 0){echo 'disabled';} ?>>
                <input type ="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                <img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">
                <?php if($fetch_products['stock'] >9) { ?>
                    <span class="stock" style="color: green;">In Stock</span>
                <?php } elseif($fetch_products['stock'] == 0) { ?>
                    <span class="stock" style="color: red;">Out of Stock</span>
                <?php } else { ?>
                    <span class="stock" style="color: red;">Hurry, only <?= $fetch_products['stock'] ?> left!</span>
                <?php } ?>

                <div class="content">
                    <h3 class="name"><?= $fetch_products['name']; ?></h3>

                    <div class="flex-btn">
                        <p class="price">Price: ₹<?= $fetch_products['price']; ?>/-</p>
                        <input type="number" name="qty" class="qty" required min="1" value="<?= $fetch_cart['qty']; ?>"max="99" maxlength="2" class="qty">
                        <button type="submit" name="update_cart" class="fa fa-edit box">update</button>
                    </div>
                    <div class="flex-btn">
                        <p class ="sub-total">Sub Total :<span><?= $sub_total = $fetch_products['price'] * $fetch_cart['qty']; ?></span>/-</p>
                        <button type="submit" name="delete_item" class="btn" onclick="return confirm('Remove from cart?');">Delete</button>
                    </div>
                </div>

            </form>
            <?php
                    $grand_total += $sub_total;
                }else{
                    echo '<div class="empty"><p>your cart is empty</p></div>';
                }
                    }
                }else{
                    echo'<div class="empty"><p>No products added yet!</p></div>';
                }
                ?>
        </div>
        <?php if($grand_total > 0){ ?>
            <div class="cart-total">
                <p>Total payable Amount : <span>Rs. <?= $grand_total; ?>/-</span></p>
                <div class="button">    
                    <form action="" method="post">
                        <button type="submit" name="empty_cart" class="btn" onclick="return confirm('Are you sure you want to empty your cart?');">Empty Cart</button>
                    </form>
                    <a href="checkout.php" class="btn">Proceed to checkout</a>
                </div>
            </div>
        <?php } ?>
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
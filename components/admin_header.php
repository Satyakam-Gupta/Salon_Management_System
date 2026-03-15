<?php
include_once '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   header('location:login.php');
   exit();
}

$select_profile = $conn->prepare("SELECT * FROM admins WHERE id = ?");
$select_profile->execute([$admin_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
?>
<header>
    <div class="logo">
        <img src="../image/logo.png" width="200">
    </div>
    <div class="right">
        <div class="bx bxs-user" id="user-btn"></div>
        <div class="bx bx-menu toggle-btn"></div>
    </div>
    <div class="profile-detail">
        <!-- <?php
        $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
        $select_profile->execute([$admin_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?> -->
        <div class="profile">
            <?php if($fetch_profile){ ?>
            <img src="../uploaded_files/<?php echo $fetch_profile['image']; ?>" class="logo-img" width=150>
            <p><?php echo $fetch_profile['name']; ?></p>
            <?php } ?>
            <div class="flex-btn">
                <a href="profile.php" class="btn">profile</a>
                <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="btn">Logout</a>
            </div>
        </div>
        <?php } ?>
    </div>
</header>

<div class="sidebar-container">
    <div class="sidebar">
        <!-- <?php
        $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
        $select_profile->execute([$admin_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?> -->
        <div class="profile">
            <?php if($fetch_profile){ ?>
            <img src="../uploaded_files/<?php echo $fetch_profile['image']; ?>" class="logo-img" width=100>
            <p><?php echo $fetch_profile['name']; ?></p>
            <?php } ?>
        </div>
        <?php } ?>
        
        <h5>Menu</h5>
        <div class="navbar">
            <ul>
                <li><a href="dashboard.php"><i class="bx bxs-home-smile"></i>Dashboard</a></li>
                <li><a href="register.php"><i class="bx bxs-user-detail"></i>Add Admin</a></li>
                <li><a href="add_products.php"><i class="bx bxs-shopping-bags"></i>Add Products</a></li>
                <li><a href="view_products.php"><i class="bx bxs-food-menu"></i>View Products</a></li>
                <li><a href="add_services.php"><i class="bx bxs-briefcase"></i>Add Services</a></li>
                <li><a href="view_services.php"><i class="bx bxs-briefcase"></i>View Services</a></li>
                <li><a href="user_accounts.php"><i class="bx bxs-user-detail"></i>Accounts</a></li>
                <li><a href="../components/admin_logout.php" onclick="return confirm('logout from this website');"><i class="bx bxs-log-out"></i>Logout</a></li>
            </ul>
        </div>
        <h5>Find Us</h5>
        <div class="social-links">
            <i class="bx bxl-facebook"></i>
            <i class="bx bxl-instagram"></i>
            <i class="bx bxl-linkedin"></i>
            <i class="bx bxl-twitter"></i>
        </div>
    </div>
</div>
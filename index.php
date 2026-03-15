<?php
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];  
}else{
   $user_id = '';
//    header("Location: login.php");
//    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon System - home page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Boxicons cdn link -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>

    <?php include 'components/user_header.php'; ?>
    
    <!--slider section start-->
    <div class="slider-container">
        <div class="slider">
            <div class="slidebox active">
                <div class="textbox">
                    <h1 style="text-transform: uppercase;">Welcome to our salon<br></h1>
                    <p>Experience the art of beauty and relaxation at our salon. Indulge in a wide range of services designed to enhance your natural beauty and leave you feeling pampered and rejuvenated.</p>
                    <a href="menu.php" class="btn">Shop now</a>
                </div>
                <div class="imgbox">
                    <img src="image/slider.jpg" alt="">
                </div>
            </div>
            <div class="slidebox">
                <div class="textbox">
                    <h1 style="text-transform: uppercase;">Luxury spa resort<br></h1>
                    <p>Experience the art of beauty and relaxation at our salon. Indulge in a wide range of services designed to enhance your natural beauty and leave you feeling pampered and rejuvenated.</p>
                    <a href="menu.php" class="btn">Shop now</a>
                </div>
                <div class="imgbox">
                    <img src="image/slider0.jpg" alt="">
                </div>
            </div>
        </div>
        <ul class="controls">
            <li onclick="nextslide();"class="next"><i class="bx bx-right-arrow-alt"></i></li>
            <li onclick="prevslide();"class="next"><i class="bx bx-left-arrow-alt"></i></li>
        </ul>
    </div>

    <!-- slider section end-->
    <!-- service section starts-->

    <div class="service">
        <div class="box-container">
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services.png" class="img1">
                        <img src="image/services (1).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Delivery</h4>
                    <span>100% secure</span>
                </div>
            </div>

            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services (2).png" class="img1">
                        <img src="image/services (3).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>payment</h4>
                    <span>100% secure</span>
                </div>
            </div>
            
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services (5).png" class="img1">
                        <img src="image/services (6).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Support</h4>
                    <span>24/7 assistance</span>
                </div>
            </div>

            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services (7).png" class="img1">
                        <img src="image/services (8).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Gift service</h4>
                    <span>Support for gift-giving</span>
                </div>
            </div>

            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/service.png" class="img1">
                        <img src="image/service (1).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Returns</h4>
                    <span>100% hassle-free</span>
                </div>
            </div>

            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services.png" class="img1">
                        <img src="image/services (1).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Delivery</h4>
                    <span>100% secure</span>
                </div>
            </div>
        </div>
    </div>

    <!-- service section ends-->
    <div class="categories">
        <div class="heading">
            <h1>Service types</h1>
            <img src="image/separator-img(1).png" alt="">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="image/categories.jpg">
                <a href="services.php" class="btn">Body massage</a>
            </div>
            <div class="box">
                <img src="image/categories0.jpg">
                <a href="services.php" class="btn">Haircut</a>
            </div>
            <div class="box">
                <img src="image/categories2.jpg">
                <a href="services.php" class="btn">hair Wash</a>
            </div>
            <div class="box">
                <img src="image/categories1.jpg">
                <a href="services.php" class="btn">Facial</a>
            </div>
        </div>
    </div>

    <!-- categories section ends-->

    <img src="image/menu-banner.jpg" class="menu-banner">
    <div class="taste">
        <div class="heading">
            <h1>buy any item and get a free gift</h1>
            <imcg src="image/separator-img.png" alt="">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="image/item1.jpg" alt="">
                <div class="detail">
                    <h1>Skincare</h1>
                </div>
            </div>
            <div class="box">
                <img src="image/item2.jpg" alt="">
                <div class="detail">
                    <h1>Perfume for Men</h1>
                </div>
            </div>
            <div class="box">
                <img src="image/item3.jpg" alt="">
                <div class="detail">
                    <h1>Soap</h1>
                </div>
            </div>
        </div>
    </div>

    <!--Taste section ends -->
    <div class="ice-container">
        <div class="overlay"></div>
            <div class="detail">
                <h1>Session of Relaxation<br> make an appointment in just few clicks</h1>
                <p>you owe yourself a moment of relaxation and self-care. book an appointment with us and let our skilled professionals take care of you. experience the ultimate pampering and rejuvenation that you deserve.</p>
                <a href="menu.php" class="btn">shop now</a>
        </div>
    </div>

    <!-- container section ends-->
    <div class="taste2">
        <div class="t-banner">
            <div class="overlay"></div>
            <div class="detail">
                <h1>Find your blissful beauty</h1>
                <p>treat yourself or a loved one to a moment of blissful beauty. book an appointment with us and let our skilled professionals pamper you with luxurious treatments that will leave you feeling radiant and rejuvenated.</p>
                <a href="menu.php" class="btn">shop now</a>
            </div>
        </div>
        <div class="box-container">
            <div class="box">
                <div class="box-overlay"></div>
                <img src = "image/product-1.jpg" alt="Product 1">
                <div class="box-details FadeIn-bottom">
                    <h1>handmade Soap</h1>
                    <p> find your blissful beauty</p>
                    <a href="menu.php" class="btn">Explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src = "image/product-2.jpg" alt="Product 2">
                <div class="box-details FadeIn-bottom">
                    <h1>handmade Soap</h1>
                    <p> find your blissful beauty</p>
                    <a href="menu.php" class="btn">Explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src = "image/product-3.jpg" alt="Product 3">
                <div class="box-details FadeIn-bottom">
                    <h1>handmade Soap</h1>
                    <p> find your blissful beauty</p>
                    <a href="menu.php" class="btn">Explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src = "image/product-4.jpg" alt="Product 4">
                <div class="box-details FadeIn-bottom">
                    <h1>handmade Soap</h1>
                    <p> find your blissful beauty</p>
                    <a href="menu.php" class="btn">Explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src = "image/product-5.jpg" alt="Product 5">
                <div class="box-details FadeIn-bottom">
                    <h1>handmade Soap</h1>
                    <p> find your blissful beauty</p>
                    <a href="menu.php" class="btn">Explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src = "image/product-6.jpg" alt="Product 6">
                <div class="box-details FadeIn-bottom">
                    <h1>handmade Soap</h1>
                    <p> find your blissful beauty</p>
                    <a href="menu.php" class="btn">Explore more</a>
                </div>
            </div>
        </div>
    </div>

    <!--taste2 section ends-->
    <div class="flavor">
        <div class="box-container">
            <img src="image/left-banner2.jpg" alt="Promotional banner">
            <div class="detail">
                <h1>Hot Deals! sale upto <span>20% off</span></h1>
                <p>expired</p>
                <a href="menu.php" class="btn">shop now</a>
            </div>
        </div>
    </div>
    <div class="usage">
        <div class="heading">
            <h1>how it works</h1>
            <img src="image/separator-img(1).png" alt="seperator image">
        </div>
        <div class="row">
            <div class="box-container">
                <div class="box">
                    <i class="bx bx-spa" style="font-size: 48px;"></i>
                    <div class="detail">
                        <h3>relaxing massage</h3>
                        <p>Experience the ultimate relaxation with our soothing massages, designed to melt away stress and rejuvenate your body and mind.</p>
                    </div>
                </div>
                <div class="box">
                    <i class="bx bx-face" style="font-size: 48px;"></i>
                    <div class="detail">
                        <h3>Facial treatments</h3>
                        <p>Refresh and revitalize your skin with our luxurious facial treatments, tailored to your unique needs for a radiant and youthful complexion.</p>
                    </div>
                </div>
                <div class="box">
                    <i class="bx bx-body" style="font-size: 48px;"></i>
                    <div class="detail">
                        <h3>Body scrubs</h3>
                        <p>Refresh and revitalize your skin with our luxurious body scrubs, designed to exfoliate and nourish your skin for a smooth and radiant finish.</p>
                    </div>
                </div>
            </div>
            <img src="image/sub-banner.png" class="divider">
            <div class="box-container">
                <div class="box">
                    <i class="fa fa-hand-sparkles" style="font-size: 48px;"></i>
                    <div class="detail">
                        <h3>Manicure & Pedicure</h3>
                        <p>pamper your hands and feet with our luxurious manicure and pedicure services, designed to nourish and beautify your nails while providing a relaxing experience.</p>
                    </div>
                </div>
                <div class="box">
                    <i class="fa fa-oil-can" style="font-size: 48px;"></i>
                    <div class="detail">
                        <h3>Aromatherapy</h3>
                        <p>Indulge in the therapeutic benefits of essential oils with our aromatherapy sessions, designed to promote relaxation and well-being.</p>
                    </div>
                </div>
                <div class="box">
                    <i class="bx bx-gift" style="font-size: 48px;"></i>
                    <div class="detail">
                        <h3>Spa packages</h3>
                        <p>Experience a complete wellness journey with our curated spa packages, combining multiple treatments for a truly indulgent experience.</p>
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
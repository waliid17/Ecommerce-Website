<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATShop</title>
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,900&display=swap"
        rel="stylesheet">
    <!-- boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- app css -->
    <link rel="stylesheet" href="index.css">
</head>

<body>

    <!-- header -->
    <header>
        <!-- mobile menu -->
        <div class="mobile-menu bg-second">
            <a href="#" class="mb-logo">9al9alo-Shop</a>
            <span class="mb-menu-toggle" id="mb-menu-toggle">
                <i class='bx bx-menu'></i>
            </span>
        </div>
        <!-- end mobile menu -->
        <!-- main header -->
        <div class="header-wrapper" id="header-wrapper">
            <span class="mb-menu-toggle mb-menu-close" id="mb-menu-close">
                <i class='bx bx-x'></i>
            </span>
            <!-- mid header -->
            <div class="bg-main">
                <div class="mid-header container">
                    <div class="logo">
                        <a href="index.php"><img src="images/prooutil.gif" alt="LOGO"></a>
                    </div>

                    <div class="search">
                        <input type="text" placeholder="Search">
                        <i class='bx bx-search-alt'></i>
                    </div>
                    <ul class="user-menu">
                        <li><a href="#"><i class='bx bx-bell'></i></a></li>
                        <li><a href="#"><i class='bx bx-user-circle'></i></a></li>
                        <li><a href="#"><i class='bx bx-cart'></i></a></li>
                    </ul>
                    <?php
                    session_start();
                    if (isset($_SESSION['user_id'])) {
                        $connection = new mysqli("localhost", "root", "", "base");
                        if ($connection->connect_error) {
                            die("Connection failed: " . $connection->connect_error);
                        }

                        $id = $_SESSION['user_id'];
                        $query = "SELECT `first-name` FROM `utilisateur` WHERE id=$id";
                        $result = $connection->query($query);
                        if ($result->num_rows > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $user = $row['first-name'];
                            echo "<a href='
                            user.php' class='btn'>
                        <div class='login'>
                           welcome $user
                        </div>
                    </a>
                    <a href='logout.php'><div class='logout'><i class='fas fa-sign-out-alt'></i></div></a>"

                            ;
                        } else {
                            unset($_SESSION['user_id']);
                        }
                    } else {
                        # code...
                    
                        ?>
                        <a href="login_signup.html" class="btn">
                            <div class="login">
                                Connexion
                            </div>
                        </a>
                        <a href="login_signup.html?slide=signup" class="btn">
                            <div class="login">
                                Inscription
                            </div>
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <!-- end mid header -->
            <!-- bottom header -->
            <div class="bg-second">
                <div class="bottom-header container">
                    <ul class="main-menu">
                        <li><a href="index.php">home</a></li>
                        <!-- mega menu -->
                        <li class="mega-dropdown">
                            <a href="./products.html">Shop</a>
                        </li>
                        <!-- end mega menu -->
                        <li><a href="#">blog</a></li>
                        <li><a href="#">contact</a></li>
                    </ul>
                </div>
            </div>
            <!-- end bottom header -->
        </div>
        <!-- end main header -->
    </header>
    <!-- end header -->

    <!-- hero section -->
    <div class="hero">
        <div class="slider">
            <div class="container">
                <!-- slide item -->
                <div class="slide active">
                    <div class="info">
                        <div class="info-content">
                            <h2 class="top-down trans-delay-0-2">
                                Bienvenue chez Pro Outil
                            </h2>
                            <p class="top-down trans-delay-0-4">
                                Toutes les marques et les catégories sont disponibles chez Pro Outil.
                            </p>
                            <div class="top-down trans-delay-0-6">
                                <button class="btn-flat btn-hover">
                                    <span>shop now</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="img top-down">
                        <img src="./images/man2" alt="">
                    </div>
                </div>
                <!-- end slide item -->
                <!-- slide item -->
                <div class="slide">
                    <div class="info">
                        <div class="info-content">
                            <h3 class="top-down">
                                JBL Quantum ONE
                            </h3>
                            <h2 class="top-down trans-delay-0-2">
                                Ipsum dolor
                            </h2>
                            <p class="top-down trans-delay-0-4">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. A optio, voluptatum aperiam
                                nobis quis maxime corporis porro alias soluta sunt quae consectetur aliquid blanditiis
                                perspiciatis labore cumque, ullam, quam eligendi!
                            </p>
                            <div class="top-down trans-delay-0-6">
                                <button class="btn-flat btn-hover">
                                    <span>shop now</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="img right-left">
                        <img src="./images/man1.png" alt="">
                    </div>
                </div>
                <!-- end slide item -->
                <!-- slide item -->
                <div class="slide">
                    <div class="info">
                        <div class="info-content">
                            <h3 class="top-down">
                                JBL JR 310BT
                            </h3>
                            <h2 class="top-down trans-delay-0-2">
                                Consectetur Elit
                            </h2>
                            <p class="top-down trans-delay-0-4">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Explicabo aut fugiat, libero
                                magnam nemo inventore in tempora beatae officiis temporibus odit deserunt molestiae amet
                                quam, asperiores, iure recusandae nulla labore!
                            </p>
                            <div class="top-down trans-delay-0-6">
                                <button class="btn-flat btn-hover">
                                    <span>shop now</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="img left-right">
                        <img src="./images/man3.png" alt="">
                    </div>
                </div>
                <!-- end slide item -->
            </div>
            <!-- slider controller -->
            <button class="slide-controll slide-next">
                <i class='bx bxs-chevron-right'></i>
            </button>
            <button class="slide-controll slide-prev">
                <i class='bx bxs-chevron-left'></i>
            </button>
            <!-- end slider controller -->
        </div>
    </div>
    <!-- end hero section -->

    <!-- promotion section -->
    <div class="promotion">
        <div class="row">
            <div class="col-4 col-md-12 col-sm-12">
                <div class="promotion-box">
                    <div class="text">
                        <h3>Headphone & Earbuds</h3>
                        <button class="btn-flat btn-hover"><span>shop collection</span></button>
                    </div>
                    <img src="./images/p1.jpeg" alt="">
                </div>
            </div>
            <div class="col-4 col-md-12 col-sm-12">
                <div class="promotion-box">
                    <div class="text">
                        <h3>JBL Quantum Series</h3>
                        <button class="btn-flat btn-hover"><span>shop collection</span></button>
                    </div>
                    <img src="./images/p2.jpeg" alt="">
                </div>
            </div>
            <div class="col-4 col-md-12 col-sm-12">
                <div class="promotion-box">
                    <div class="text">
                        <h3>True Wireless Earbuds</h3>
                        <button class="btn-flat btn-hover"><span>shop collection</span></button>
                    </div>
                    <img src="./images/p3.jpeg" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- end promotion section -->

    <!-- product list -->
    <div class="section">
        <div class="container">
            <div class="section-header">
                <h2>NOS PRODUITS</h2>
            </div>
            <div class="row" id="latest-products">
                <?php
                $connection = new mysqli("localhost", "root", "", "base");

                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                $query = "SELECT * FROM `products` LIMIT 4";
                $result = $connection->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $name = htmlspecialchars($row["name"]);
                        $image = htmlspecialchars("uploads/" . $row["image"]);
                        $old_price = htmlspecialchars($row["old_price"]);
                        $curr_price = htmlspecialchars($row["curr_price"]);
                        $id = htmlspecialchars($row["id"]);

                        echo "<div class='col-3 col-md-6 col-sm-12'>
                <div class='product-card'>
                    <div class='product-card-img'>
                        <img src='$image' alt='$name'>
                        <img src='$image' alt='$name'>
                    </div>
                    <div class='product-card-info'>
                        <div class='product-btn'>
                        <a href='product-detail.php?id=$id' class='btn-flat btn-hover btn-shop-now'>shop now</a>

                            <button class='btn-flat btn-hover btn-cart-add'>
                                <i class='bx bxs-cart-add'></i>
                            </button>
                            <button class='btn-flat btn-hover btn-cart-add'>
                                <i class='bx bxs-heart'></i>
                            </button>
                        </div>
                        <div class='product-card-name'>
                            $name
                        </div>
                        <div class='product-card-price'>
                            <span><del>$$old_price</del></span>
                            <span class='curr-price'>$$curr_price</span>
                        </div>
                    </div>
                </div>
            </div>";
                    }
                } else {
                    echo "No products found.";
                }

                $connection->close();
                ?>

            </div>

            <div class="section-footer">
                <a href="./products.html" class="btn-flat btn-hover">view all</a>
            </div>
        </div>
    </div>
    <!-- end product list -->
    <!-- blogs -->
    <div class="section">
        <div class="container">
            <div class="section-header">
                <h2>latest blog</h2>
            </div>
            <div class="blog">
                <div class="blog-img">
                    <img src="./images/m1.jpg" alt="">
                </div>
                <div class="blog-info">
                    <div class="blog-title">
                        Lorem ipsum dolor sit amet
                    </div>
                    <div class="blog-preview">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quasi, eligendi dolore. Sapiente omnis
                        numquam mollitia asperiores animi, veritatis sint illo magnam, voluptatum labore, quam ducimus!
                        Nisi doloremque praesentium laudantium repellat.
                    </div>
                    <button class="btn-flat btn-hover">read more</button>
                </div>
            </div>
            <div class="blog row-revere">
                <div class="blog-img">
                    <img src="./images/m2.jpg" alt="">
                </div>
                <div class="blog-info">
                    <div class="blog-title">
                        Lorem ipsum dolor sit amet
                    </div>
                    <div class="blog-preview">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quasi, eligendi dolore. Sapiente omnis
                        numquam mollitia asperiores animi, veritatis sint illo magnam, voluptatum labore, quam ducimus!
                        Nisi doloremque praesentium laudantium repellat.
                    </div>
                    <button class="btn-flat btn-hover">read more</button>
                </div>
            </div>
            <div class="section-footer">
                <a href="#" class="btn-flat btn-hover">view all</a>
            </div>
        </div>
    </div>
    <!-- end blogs -->

    <!-- footer -->
    <footer class="bg-second">
        <div class="container">
            <div class="row">
                <div class="col-3 col-md-6">
                    <h3 class="footer-head">Products</h3>
                    <ul class="menu">
                        <li><a href="#">Help center</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="#">product help</a></li>
                        <li><a href="#">warranty</a></li>
                        <li><a href="#">order status</a></li>
                    </ul>
                </div>
                <div class="col-3 col-md-6">
                    <h3 class="footer-head">services</h3>
                    <ul class="menu">
                        <li><a href="#">Help center</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="#">product help</a></li>
                        <li><a href="#">warranty</a></li>
                        <li><a href="#">order status</a></li>
                    </ul>
                </div>
                <div class="col-3 col-md-6">
                    <h3 class="footer-head">support</h3>
                    <ul class="menu">
                        <li><a href="#">Help center</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="#">product help</a></li>
                        <li><a href="#">warranty</a></li>
                        <li><a href="#">order status</a></li>
                    </ul>
                </div>
                <div class="col-3 col-md-6 col-sm-12">
                    <div class="contact">
                        <h3 class="contact-header">
                            <img src="images/prooutil1.png" alt="LOGO">
                        </h3>
                        <ul class="contact-socials">
                            <li><a href="#">
                                    <i class='bx bxl-facebook-circle'></i>
                                </a></li>
                            <li><a href="#">
                                    <i class='bx bxl-instagram-alt'></i>
                                </a></li>
                            <li><a href="#">
                                    <i class='bx bxl-youtube'></i>
                                </a></li>
                            <li><a href="#">
                                    <i class='bx bxl-twitter'></i>
                                </a></li>
                        </ul>
                    </div>
                    <div class="subscribe">
                        <input type="email" placeholder="ENTER YOUR EMAIL">
                        <button>subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end footer -->

    <!-- app js -->
    <script src="./js/app.js"></script>
    <script src="./js/index.js"></script>
    <script>document.addEventListener("DOMContentLoaded", () => {
            setInterval(() => {
                console.log("This message is logged every second");
            }, 1000);
        });</script>
</body>

</html>
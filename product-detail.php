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
    <!-- app css -->
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "base";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $id = $_GET["id"];
    // Fetch all products
    $sql = "SELECT name, image, curr_price, brand,prod_desc,image2,image3 FROM products where id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = htmlspecialchars($row["name"]);
            $image = htmlspecialchars("uploads/" . $row["image"]);
            $curr_price = htmlspecialchars($row["curr_price"]);
            $brand = htmlspecialchars($row["brand"]);
            $prod_desc = htmlspecialchars($row["prod_desc"]);
            $image2 = htmlspecialchars("uploads/" . $row["image2"]);
            $image3 = htmlspecialchars("uploads/" . $row["image3"]);
            ?>
            <!-- header -->
            <header>
                <!-- mobile menu -->
                <div class="mobile-menu bg-second">
                    <div class="logo">
                        <img src="images/prooutil.png" alt="LOGO">
                    </div>
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

            <!-- product-detail content -->
            <div class="bg-main">
                <div class="container">
                    <div class="box">
                        <div class="breadcumb">
                            <a href="index.php">home</a>
                            <span><i class='bx bxs-chevrons-right'></i></span>
                            <a href="./product-detail.php?id=<?= $id ?>"><?= $name ?></a>
                        </div>
                    </div>
                    <div class="row product-row">
                        <div class="col-5 col-md-12">
                            <div class="product-img " id="product-img">
                                <img class="inner-container" src="<?= $image ?>" alt="">
                            </div>
                            <div class="box">
                                <div class="product-img-list ">
                                    <div class="product-img-item">
                                        <img src="<?= $image ?>" alt="">
                                    </div>
                                    <div class="product-img-item">
                                        <img src="<?= $image2 ?>" alt="">
                                    </div>
                                    <div class="product-img-item">
                                        <img src="<?= $image3 ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        // db_connection.php
                

                        echo "   <div class='col-7 col-md-12'>
                    <div class='product-info'>
                        <h1>
                        $name
                        </h1>
                        <div class='product-info-detail'>
                            <span class='product-info-detail-title'>Brand:</span>
                            <a href='#'>$brand</a>
                        </div>
                        <div class='product-info-detail'>
                            <span class='product-info-detail-title'>Rated:</span>
                            <span class='rating'>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </span>
                        </div>
                        <p class='product-description'>
                            $prod_desc
                        </p>
                        <div class='product-info-price'>$curr_price</div>
                        <div class='product-quantity-wrapper'>
                            <span class='product-quantity-btn'>
                                <i class='bx bx-minus'></i>
                            </span>
                            <span class='product-quantity'>1</span>
                            <span class='product-quantity-btn'>
                                <i class='bx bx-plus'></i>
                            </span>
                        </div>
                        <div>
                            <button class='btn-flat btn-hover'>add to cart</button>
                        </div>
                    </div>
                </div>
            </div>";
        }
    } else {
        echo "No products found.";
    }

    $conn->close();
    ?>
            </div>
            <!-- end product-detail content -->

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
            <script src="./js/product-detail.js"></script>
</body>

</html>
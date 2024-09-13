<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATShop</title>
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,900&display=swap"
        rel="stylesheet">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <!-- App CSS -->
    <link rel="stylesheet" href="index.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    // Fetch product details and the brand name from the `marque` table
    $sql = "SELECT outil.nom, outil.image, outil.prix_actuel, outil.description, marque.nom_marque 
        FROM outil 
        INNER JOIN marque ON outil.id_marque = marque.id_marque
        WHERE outil.id_outil = $id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = htmlspecialchars($row["nom"]);
        $image = htmlspecialchars("uploads/" . $row["image"]);
        $curr_price = htmlspecialchars($row["prix_actuel"]);
        $brand = htmlspecialchars($row["nom_marque"]); // Fetching brand name from the `marque` table
        $prod_desc = htmlspecialchars($row["description"]);
        ?>

        <!-- Header -->
        <header>
            <!-- Mobile Menu -->
            <div class="mobile-menu bg-second">
                <div class="logo">
                    <img src="images/prooutil.png" alt="LOGO">
                </div>
                <span class="mb-menu-toggle" id="mb-menu-toggle">
                    <i class='bx bx-menu'></i>
                </span>
            </div>
            <!-- End Mobile Menu -->

            <!-- Main Header -->
            <div class="header-wrapper" id="header-wrapper">
                <span class="mb-menu-toggle mb-menu-close" id="mb-menu-close">
                    <i class='bx bx-x'></i>
                </span>

                <!-- Mid Header -->
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
                            <li><a href="user.php"><i class='bx bx-user-circle'></i></a></li>
                            <li><a href="user.php#Wishlist"><i class='bx bx-cart'></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Mid Header -->

                <!-- Bottom Header -->
                <div class="">
                    <div class="bottom-header container">
                        <ul class="main-menu">
                            <li><a href="index.php">ACCUEIL</a></li>
                            <li><a href="products.php">OUTILS</a></li>
                            <li><a href="index.php#about">À PROPOS</a></li>
                            <li><a href="index.php#contact">CONTACT</a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Bottom Header -->
            </div>
            <!-- End Main Header -->
        </header>
        <!-- End Header -->

        <!-- Product Detail Content -->
        <div class="bg-main">
            <div class="container">
                <div class="box">
                    <div class="breadcumb">
                        <a href="products.php">TOUS LES OUTILS</a>
                        <span><i class='bx bxs-chevrons-right'></i></span>
                        <a href="./product-detail.php?id=<?= $id ?>"><?= $name ?></a>
                    </div>
                </div>
                <div class="row product-row">
                    <div class="col-5 col-md-12">
                        <div class="product-img" id="product-img">
                            <img class="inner-container" src="<?= $image ?>" alt="">
                        </div>
                        <div class="box">
                            <div class="product-img-list">
                                <div class="product-img-item">
                                    <img src="<?= $image ?>" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-7 col-md-12">
                        <div class="product-info">
                            <h1><?= $name ?></h1>
                            <div class="product-info-detail">
                                <span class="product-info-detail-title">Marque:</span>
                                <a href="#"><?= $brand ?></a>
                            </div>
                            <div class="product-info-detail">
                                <span class="product-info-detail-title">Rated:</span>
                                <span class="rating">
                                    <i class="bx bxs-star"></i>
                                    <i class="bx bxs-star"></i>
                                    <i class="bx bxs-star"></i>
                                    <i class="bx bxs-star"></i>
                                    <i class="bx bxs-star"></i>
                                </span>
                            </div>
                            <p class="product-description"><?= $prod_desc ?></p>
                            <div class="product-info-price"><?= $curr_price ?> DA</div>
                            <div class="product-quantity-wrapper">
                                <span class="product-quantity-btn" id="minus">
                                    <i class="bx bx-minus"></i>
                                </span>
                                <span class="product-quantity" id="quantity">1</span>
                                <span class="product-quantity-btn" id="plus">
                                    <i class="bx bx-plus"></i>
                                </span>
                            </div>
                            <br>
                            <div>
                                <button class="btn-flat btn-hover" id="add-to-cart">AJOUTER AU PANIER</button>
                            </div>

                            <script>
                                function showSuccessAlert() {
                                    Swal.fire({
                                        text: "Le produit a été ajouté à votre panier.",
                                        icon: "success",
                                        iconColor: "orange", // Icon color
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "orange", // Button color
                                        customClass: {
                                            title: "swal2-title",
                                            content: "swal2-content",
                                            confirmButton: "swal2-confirm",
                                            icon: "swal2-icon"
                                        },
                                        didClose: () => {
                                            window.location.href = "products.php";
                                        }
                                    });
                                }

                                document.addEventListener("DOMContentLoaded", function () {
                                    const addToCartButton = document.getElementById("add-to-cart");
                                    if (addToCartButton) {
                                        addToCartButton.addEventListener("click", function () {
                                            showSuccessAlert();
                                        });
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Product Detail Content -->

        <script>
            document.getElementById('add-to-cart').addEventListener('click', function () {
                const product = {
                    id: <?= $id ?>,
                    name: '<?= $name ?>',
                    image: '<?= $image ?>',
                    price: <?= $curr_price ?>,
                    quantity: parseInt(document.getElementById('quantity').textContent)
                };

                addToWishlist(product);
            });

            function addToWishlist(product) {
                let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

                // Check if the product already exists in the wishlist
                const existingProductIndex = wishlist.findIndex(item => item.id === product.id);

                if (existingProductIndex !== -1) {
                    // Product already exists, update the quantity
                    wishlist[existingProductIndex].quantity += product.quantity;
                } else {
                    // Product does not exist, add it to the wishlist
                    wishlist.push(product);
                }

                localStorage.setItem('wishlist', JSON.stringify(wishlist));
            }
        </script>

        <?php
    } else {
        echo "<p>No products found.</p>";
    }
    $conn->close();
    ?>

    <!-- footer -->
    <footer class="bg-second">
        <div class="container">
            <div class="row">
                <div class="col-3 col-md-6">
                    <h3 class="footer-head">SERVICES</h3>
                    <ul class="menu">
                        <li><a href="products.php">Nos Outils</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="#bloge">À propos</a></li>
                    </ul>
                </div>
                <div class="col-3 col-md-6">
                    <h3 class="footer-head">Nos Avantages</h3>
                    <ul class="menu">
                        <li>Livraison Rapide</li>
                        <li>Des Outils De Marque</li>
                        <li>Garantie</li>
                    </ul>
                </div>
                <div class="col-3 col-md-6">
                    <h3 class="footer-head">CONTACTEZ NOUS</h3>
                    <ul class="menu">
                        <li>Algérie, Alger, Route de bridja, Staoueli</li>
                        <li>
                            <i class="bx bx-phone-call"></i>
                            : 055******** 7/7J 24/24H
                        </li>

                        <ul>
                            <li>
                                <i class="bx bx-envelope"></i>
                                : prooutil00@gmail.com
                            </li>
                        </ul>

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
    <style>
        .subscribe {
            visibility: hidden;
        }
    </style>
    <!-- App JS -->
    <script src="./js/app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const quantityElement = document.getElementById('quantity');
            const plusButton = document.getElementById('plus');
            const minusButton = document.getElementById('minus');

            plusButton.addEventListener('click', () => {
                let currentQuantity = parseInt(quantityElement.textContent);
                quantityElement.textContent = currentQuantity + 1;
            });

            minusButton.addEventListener('click', () => {
                let currentQuantity = parseInt(quantityElement.textContent);
                if (currentQuantity > 1) {
                    quantityElement.textContent = currentQuantity - 1;
                }
            });
        });
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pro-outil</title>
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
            <a href="#" class="mb-logo">Pro-outil</a>
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
                    if (isset($_SESSION['user-id'])) {
                        $connection = new mysqli("localhost", "root", "", "base");
                        if ($connection->connect_error) {
                            die("Connection failed: " . $connection->connect_error);
                        }

                        $id = $_SESSION['user-id'];
                        $query = "SELECT `prenom` FROM `client` WHERE id_client =$id";
                        $result = $connection->query($query);
                        if ($result->num_rows > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $user = $row['prenom'];
                            echo "<a href='
                            user.php' class='btn'>
                        <div class='login'>
                           welcome $user
                        </div>
                    </a>
                    <a href='logout.php'><div class='logout'><i class='fas fa-sign-out-alt'></i></div></a>"

                            ;
                        } else {
                            unset($_SESSION['user-id']);
                        }
                    } else {

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
            <div class="">
                <div class="bottom-header container">
                    <ul class="main-menu">
                        <li><a href="index.php">ACCUEIL</a></li>
                        <!-- mega menu -->
                        <li class="mega-dropdown">
                            <a href="./products.html">PRODUITS</a>
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
                                Bienvenue chez
                            </h2>
                            <p class="top-down trans-delay-0-4">
                                Toutes les marques et les catégories sont disponibles chez nous.
                            </p>
                            <div class="top-down trans-delay-0-6">
                                <button class="btn-flat btn-hover">
                                    <span>NOS PRODUITS</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="img top-down">
                        <img src="./images/4" alt="" class="animated-image">
                    </div>
                </div>
                <!-- end slide item -->
                <!-- slide item -->
                <div class="slide">
                    <div class="info">
                        <div class="info-content">
                            <h2 class="top-down trans-delay-0-2">
                                DES PRODUITS DE MARQUE
                            </h2>
                            <div class="top-down trans-delay-0-6">
                                <button class="btn-flat btn-hover">
                                    <span>NOS PRODUITS</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="img right-left">
                        <img src="./images/6.png" alt="">
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
                        <h3>CLE A CHOC</h3>
                        <button class="btn-flat btn-hover"><span>shop collection</span></button>
                    </div>
                    <img src="./images/p4.jpeg" alt="">
                </div>
            </div>
            <div class="col-4 col-md-12 col-sm-12">
                <div class="promotion-box">
                    <div class="text">
                        <h3>CLE A CHOC</h3>
                        <button class="btn-flat btn-hover"><span>shop collection</span></button>
                    </div>
                    <img src="./images/p2.jpeg" alt="">
                </div>
            </div>
            <div class="col-4 col-md-12 col-sm-12">
                <div class="promotion-box">
                    <div class="text">
                        <h3>CLE A CHOC</h3>
                        <button class="btn-flat btn-hover"><span>shop collection</span></button>
                    </div>
                    <img src="./images/p6.jpeg" alt="">
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

                $query = "SELECT * FROM `outil` LIMIT 4";
                $result = $connection->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $name = htmlspecialchars($row["nom"]);
                        $image = htmlspecialchars("uploads/" . $row["image"]);
                        $old_price = htmlspecialchars($row["ancien_prix"]);
                        $curr_price = htmlspecialchars($row["prix_actuel"]);
                        $id = htmlspecialchars($row["id_outil"]);

                        echo "<div class='col-3 col-md-6 col-sm-12'>
                <div class='product-card'>
                    <div class='product-card-img'>
                        <img src='$image' alt='$name'>
                        <img src='$image' alt='$name'>
                    </div>
                    <div class='product-card-info'>
                        <div class='product-btn'>
                        <a href='product-detail.php?id=$id' class='btn-flat btn-hover btn-shop-now'>Acheter</a>

                            <button class='btn-flat btn-hover btn-cart-add'>
                                <i class='bx bxs-cart-add'></i>
                            </button>
                        </div>
                        <div class='product-card-name'>
                            $name
                        </div>
                        <div class='product-card-price'>
                            <span><del>$old_price DA</del></span>
                            <span class='curr-price'>$curr_price DA</span>
                        </div>
                    </div>
                </div>
            </div>";
                    }
                } else {
                    echo "Aucun produit trouvé.";
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
                <h2>blog</h2>
            </div>
            <div class="blog">
                <div class="blog-img">
                    <img src="./images/m1.jpg" alt="">
                </div>
                <div class="blog-info">
                    <div class="blog-title">
                        Découvrez Pro Outil Algérie
                    </div>
                    <div class="blog-preview">
                        Naviguez sur notre site pour découvrir notre vaste sélection d’outillage professionnel à des
                        prix compétitifs. Basée en Algérie, notre entreprise vous assure un service de qualité à chaque
                        commande. Notre plateforme logistique à Alger permet une préparation et une expédition efficaces
                        de vos colis.
                    </div>
                </div>
            </div>
            <div class="blog row-revere">
                <div class="blog-img">
                    <img src="./images/m2.jpg" alt="">
                </div>
                <div class="blog-info">
                    <div class="blog-title">
                        Excellence et Réactivité à Votre Service
                    </div>
                    <div class="blog-preview">
                        Chez Pro Outil Algérie, nous comprenons l'importance d'avoir des outils fiables et de qualité.
                        C'est pourquoi nous nous engageons à vous fournir non seulement les meilleurs produits, mais
                        aussi un service clientèle exceptionnel. Notre équipe dédiée est toujours prête à répondre à vos
                        questions et à vous conseiller sur les produits les mieux adaptés à vos besoins spécifiques.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end blogs -->

    <!-- footer -->
    <footer class="bg-second">
        <div class="container">
            <div class="row">
                <div class="col-3 col-md-6">
                    <h3 class="footer-head">PRODUITS</h3>
                    <ul class="menu">
                        <li><a href="#">Centre d'Aide</a></li>
                        <li><a href="#">Contactez-nous</a></li>
                        <li><a href="#">Aide Produit</a></li>
                        <li><a href="#">Garantie</a></li>
                    </ul>
                </div>
                <div class="col-3 col-md-6">
                    <h3 class="footer-head">SERVICES</h3>
                    <ul class="menu">
                        <li><a href="#">Livraison Rapide</a></li>
                        <li><a href="#">Retours Gratuits</a></li>
                        <li><a href="#">Installation et Réparation</a></li>
                        <li><a href="#">Conseils Personnalisés</a></li>
                    </ul>
                </div>
                <div class="col-3 col-md-6">
                    <h3 class="footer-head">CONTACTEZ NOUS</h3>
                    <ul class="menu">
                        <li>Algérie, Alger, Route de bridja, Staoueli</li>
                        <li>Tél : 055******** 7/7J 24/24H</li>
                        <li>contact@pro-outil.com</li>
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
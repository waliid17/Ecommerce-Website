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
            $query = "SELECT `prenom`, `role` FROM `client` WHERE id_client = $id";
            $result = $connection->query($query);
            if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                $user = $row['prenom'];
                $role = $row['role'];

                if ($role == 'admin') {
                    echo "<a href='admin/admin.php' class='btn'>
                            <div class='login'>
  Welcome $user <i class='fa-solid fa-crown'></i>
</div>

                          </a>
                          <a href='logout.php'><div class='logout'><i class='fas fa-sign-out-alt'></i></div></a>";
                } else {
                    echo "<a href='user.php' class='btn'>
                            <div class='login'>
                                Welcome $user
                            </div>
                          </a>
                          <a href='logout.php'><div class='logout'><i class='fas fa-sign-out-alt'></i></div></a>";
                }
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
                            <a href="./products.html">OUTILS</a>
                        </li>
                        <!-- end mega menu -->
                        <li><a href="#">à propos</a></li>
                        <li><a href="#">SERVICES</a></li>
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
                                <a href="products.php"> <button class="btn-flat btn-hover">
                                        <span>NOS OUTILS</span>
                                    </button></a>
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
                                    <span>NOS MARQUES</span>
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

    <!-- brands section -->
    <div class="brands-carousel">
        <div class="section-header">
            <h2>NOS MARQUES</h2>
        </div>
        <div class="carousel-inner">
            <img src="./images/logo1.png" alt="Brand Logo 1">
            <img src="./images/logo2.png" alt="Brand Logo 2">
            <img src="./images/logo3.png" alt="Brand Logo 3">
            <img src="./images/logo4.png" alt="Brand Logo 4">
            <img src="./images/logo5.png" alt="Brand Logo 5">
            <img src="./images/logo6.png" alt="Brand Logo 6">
            <img src="./images/logo7.png" alt="Brand Logo 7">
        </div>
    </div>
    <!-- end brands section -->

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const carouselInner = document.querySelector('.carousel-inner');
            const logos = document.querySelectorAll('.carousel-inner img');

            // Clone the logos for seamless looping
            logos.forEach(logo => {
                const clone = logo.cloneNode(true);
                carouselInner.appendChild(clone);
            });

            let offset = 0;
            const logoWidth = logos[0].clientWidth;
            const speed = 0.5; // Speed of the transition
            const intervalTime = 20; // Time between each pixel movement

            function slideCarousel() {
                offset += speed;
                if (offset >= logoWidth * logos.length) {
                    offset = 0;
                }
                carouselInner.style.transform = `translateX(-${offset}px)`;
            }

            setInterval(slideCarousel, intervalTime);
        });
    </script>


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
                <a href="./products.php" class="btn-flat btn-hover">view all</a>
            </div>
        </div>
    </div>
    <!-- end product list -->
    <!-- blogs -->
    <div class="section">
        <div class="container">
            <div class="section-header">
                <h2>À PROPOS</h2>
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
    <div class="container">
        <div class="section-header">
            <h2>CONTACT</h2>
        </div>
    </div>
    <!-- section contact -->
    <section id="contact">
        <div class="contact-container">
            <div class="contact-info">
                <h2 class="section-title">Notre Adresse</h2>
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3197.268053857073!2d2.8747272764389673!3d36.74013647108209!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x128fa5d800390b4f%3A0xe885582e7ab8a554!2sMovent%20Agency!5e0!3m2!1sfr!2sdz!4v1719618253374!5m2!1sfr!2sdz"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <address>Algérie, Alger, Route de bridja, Staoueli</address>
            </div>
            <div class="contact-form-container">
                <h2 class="section-title">Envoyer un message</h2>
                <form action="message.php" method="POST" class="contact-form">
                    <div class="input-group">
                        <div class="input-container">
                            <div class="icon"><i class="fas fa-user"></i></div>
                            <input type="text" name="prenom" placeholder="Prénom" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-container">
                            <div class="icon"><i class="fas fa-user"></i></div>
                            <input type="text" name="nom" placeholder="Nom" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-container">
                            <div class="icon"><i class="fas fa-phone"></i></div>
                            <input type="tel" name="phone" placeholder="Numéro de téléphone" required
                                pattern="[0-9]{10}">
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-container">
                            <div class="icon"><i class="fas fa-envelope"></i></div>
                            <input type="email" name="email" placeholder="Adresse Mail" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-container">
                            <div class="icon"><i class="fas fa-comment-alt"></i></div>
                            <input type="text" name="sujet" placeholder="sujet" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-container">
                            <div class="iconm"><i class="fas fa-comment"></i></div>
                            <textarea name="contenu" cols="30" rows="10" placeholder="contenu" required></textarea>
                        </div>
                    </div>
                    <input type="submit" value="Envoyer" class="submit-btn">
                </form>
            </div>
        </div>
    </section>

    <!-- end section contact -->

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
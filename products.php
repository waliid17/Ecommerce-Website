<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ATShop</title>
  <!-- google font -->
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,900&display=swap"
    rel="stylesheet" />
  <!-- boxicons -->
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <!-- app css -->
  <link rel="stylesheet" href="index.css" />
</head>

<body>
  <!-- header -->
  <header>
    <!-- mobile menu -->
    <div class="mobile-menu bg-second">
      <a href="#" class="mb-logo">pro-outil</a>
      <span class="mb-menu-toggle" id="mb-menu-toggle">
        <i class="bx bx-menu"></i>
      </span>
    </div>
    <!-- end mobile menu -->
    <!-- main header -->
    <div class="header-wrapper" id="header-wrapper">
      <span class="mb-menu-toggle mb-menu-close" id="mb-menu-close">
        <i class="bx bx-x"></i>
      </span>
      <!-- mid header -->
      <div class="bg-main">
        <div class="mid-header container">
          <div class="logo">
            <a href="index.php"><img src="images/prooutil.gif" alt="LOGO" /></a>
          </div>
          <div class="search">
            <input type="text" placeholder="Search" />
            <i class="bx bx-search-alt"></i>
          </div>
          <ul class="user-menu">
            <li>
              <a href="#"><i class="bx bx-bell"></i></a>
            </li>
            <li>
              <a href="#"><i class="bx bx-user-circle"></i></a>
            </li>
            <li>
              <a href="#"><i class="bx bx-cart"></i></a>
            </li>
          </ul>
        </div>
      </div>
      <!-- end mid header -->
      <!-- bottom header -->
      <div class="">
        <div class="bottom-header container">
          <ul class="main-menu">
            <li><a href="#">ACCUEIL</a></li>
            <li><a href="#">PRODUITS</a></li>
            <li><a href="#">BLOG</a></li>
            <li><a href="#">CONTACT</a></li>
          </ul>
        </div>
      </div>
      <!-- end bottom header -->
    </div>
    <!-- end main header -->
  </header>
  <!-- end header -->

  <!-- products content -->
  <div class="bg-main">
    <div class="container">
      <div class="box">
        <div class="breadcumb">
          <a href="./index.html">home</a>
          <span><i class="bx bxs-chevrons-right"></i></span>
          <a href="./products.html">all products</a>
        </div>
      </div>
      <div class="box">
        <div class="row">
          <div class="col-3 filter-col" id="filter-col">
            <div class="box filter-toggle-box">
              <button class="btn-flat btn-hover" id="filter-close">
                close
              </button>
            </div>
            <div class="box">
              <span class="filter-header"> Catégories </span>
              <ul class="filter-list">
                <li><a href="#">MAÇON</a></li>
                <li><a href="#">ELECTRICIEN</a></li>
                <li><a href="#">PLOMBIER</a></li>
                <li><a href="#">JARDINIER</a></li>
              </ul>
            </div>
            <div class="price-box">
              <span class="filter-header"> Prix </span>
              <div class="price-range">
                <div class="price-input">
                  <label for="prixMin">Prix Min (DA):</label>
                  <input type="text" id="prixMin" name="prixMin" />
                </div>
                <div class="price-input">
                  <label for="prixMax">Prix Max (DA):</label>
                  <input type="text" id="prixMax" name="prixMax" />
                </div>
              </div>
            </div>

            <div class="box">
              <ul class="filter-list">
                <li>
                  <div class="group-checkbox">
                    <input type="checkbox" id="status1" />
                    <label for="status1">
                      En solde
                      <i class="bx bx-check"></i>
                    </label>
                  </div>
                </li>
                <li>
                  <div class="group-checkbox">
                    <input type="checkbox" id="status2" />
                    <label for="status2">
                      En stock
                      <i class="bx bx-check"></i>
                    </label>
                  </div>
                </li>
              </ul>
            </div>
            <div class="box">
              <span class="filter-header"> Marques </span>
              <ul class="filter-list">
                <li>
                  <div class="group-checkbox">
                    <input type="checkbox" id="remember1" checked="checked" />
                    <label for="remember1">
                      YATO
                      <i class="bx bx-check"></i>
                    </label>
                  </div>
                </li>
                <li>
                  <div class="group-checkbox">
                    <input type="checkbox" id="remember2" />
                    <label for="remember2">
                      HONESTPRO
                      <i class="bx bx-check"></i>
                    </label>
                  </div>
                </li>
                <li>
                  <div class="group-checkbox">
                    <input type="checkbox" id="remember3" />
                    <label for="remember3">
                      BODA
                      <i class="bx bx-check"></i>
                    </label>
                  </div>
                </li>
                <li>
                  <div class="group-checkbox">
                    <input type="checkbox" id="remember4" />
                    <label for="remember4">
                      HOTECHE
                      <i class="bx bx-check"></i>
                    </label>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-9 col-md-12">
            <div class="box filter-toggle-box">
              <button class="btn-flat btn-hover" id="filter-toggle">
                filter
              </button>
            </div>
            <!-- product list -->
            <div class="section">
              <div class="container">
                <div class="row" id="latest-products">
                  <?php
                  $connection = new mysqli("localhost", "root", "", "base");

                  if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                  }

                  $query = "SELECT * FROM `outil` ";
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
                <div class="box">
                  <ul class="pagination">
                    <li>
                      <a href="#"><i class="bx bxs-chevron-left"></i></a>
                    </li>
                    <li><a href="#" class="active">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li>
                      <a href="#"><i class="bx bxs-chevron-right"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end products content -->
    </div>
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
                <img src="images/prooutil1.png" alt="LOGO" />
              </h3>
              <ul class="contact-socials">
                <li>
                  <a href="#">
                    <i class="bx bxl-facebook-circle"></i>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="bx bxl-instagram-alt"></i>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="bx bxl-youtube"></i>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="bx bxl-twitter"></i>
                  </a>
                </li>
              </ul>
            </div>
            <div class="subscribe">
              <input type="email" placeholder="ENTER YOUR EMAIL" />
              <button>subscribe</button>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- end footer -->

    <!-- app js -->
    <script src="./js/app.js"></script>
    <script src="./js/products.js"></script>
</body>

</html>
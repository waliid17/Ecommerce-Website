<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>pro-outil</title>
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
              <a href="user.php"><i class="bx bx-user-circle"></i></a>
            </li>
            <li>
              <a href="user.php#Wishlist"><i class="bx bx-cart"></i></a>
            </li>
          </ul>
        </div>
      </div>
      <!-- end mid header -->
      <!-- bottom header -->
      <div class="">
        <div class="bottom-header container">
          <ul class="main-menu">
            <li><a href="index.php">ACCUEIL</a></li>
            <li><a href="products.php">OUTILS</a></li>
            <li><a href="index.php#about">à propos</a></li>
            <li><a href="index.php#contact">contact</a></li>
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
          <a href="./index.php">ACCUEIL</a>
          <span><i class="bx bxs-chevrons-right"></i></span>
          <a href="./products.php">TOUS LES PRODUITS</a>
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
                <li><a href="#">Electroportatif</a></li>
                <li><a href="#">Outillage à main</a></li>
                <li><a href="#">Chantier</a></li>
                <li><a href="#">Sécurité</a></li>
                <li><a href="#">Jardin</a></li>
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
                    TOLSEN
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

                  $items_per_page = 12;
                  $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                  $offset = ($page - 1) * $items_per_page;

                  $query = "SELECT * FROM `outil` LIMIT $items_per_page OFFSET $offset";
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
                          <button class='btn-flat btn-hover btn-cart-add' data-id='$id'>
                              <i class='bx bxs-cart-add'></i>
                          </button>
                      </div>
                      <div class='product-card-name'>
                          $name
                      </div>
                      <div class='product-card-price'>
                          <span><del>$old_price DA</del></span><br>
                          <span class='curr-price'>$curr_price DA</span>
                      </div>
                  </div>
              </div>
          </div>";
                      echo '<script>
          if (typeof products === "undefined") {
              var products = {};
          }
          products["' . $id . '"] = {
              id: ' . $id . ',
              name: "' . $name . '",
              image: "' . $image . '",
              price: ' . $curr_price . ',
              quantity: 1
          };
      </script>';
                    }
                  } else {
                    echo "Aucun produit trouvé.";
                  }

                  $total_query = "SELECT COUNT(*) AS total FROM `outil`";
                  $total_result = $connection->query($total_query);
                  $total_row = $total_result->fetch_assoc();
                  $total_items = $total_row['total'];
                  $total_pages = ceil($total_items / $items_per_page);

                  $connection->close();
                  ?>
                </div>
              </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
              document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll(".btn-cart-add").forEach(function (button) {
                  button.addEventListener("click", function () {
                    let dataId = this.getAttribute("data-id");
                    let product = products[dataId];

                    if (!product) {
                      alert("Error: Product not found!");
                    } else {
                      addToWishlist(product);
                    }
                  });
                });

                function addToWishlist(product) {
                  let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
                  const existingProductIndex = wishlist.findIndex(item => item.id === product.id);

                  if (existingProductIndex !== -1) {
                    // Product already exists, update the quantity
                    wishlist[existingProductIndex].quantity += product.quantity;
                  } else {
                    // Product does not exist, add it to the wishlist
                    wishlist.push(product);
                  }
                  localStorage.setItem("wishlist", JSON.stringify(wishlist));

                  Swal.fire({
                    title: 'Added!',
                    text: `${product.name} has been added to your wishlist.`,
                    icon: 'success',
                    confirmButtonText: 'OK'
                  });
                }
              });
            </script>
            <!-- end product list -->

            <!-- pagination -->
            <div class="box">
              <ul class="pagination">
                <?php
                if ($page > 1) {
                  echo "<li><a href='products.php?page=" . ($page - 1) . "'><i class='bx bxs-chevron-left'></i></a></li>";
                }

                for ($i = 1; $i <= $total_pages; $i++) {
                  if ($i == $page) {
                    echo "<li><a class='active' href='products.php?page=$i'>$i</a></li>";
                  } else {
                    echo "<li><a href='products.php?page=$i'>$i</a></li>";
                  }
                }

                if ($page < $total_pages) {
                  echo "<li><a href='products.php?page=" . ($page + 1) . "'><i class='bx bxs-chevron-right'></i></a></li>";
                }
                ?>
              </ul>
            </div>
            <!-- end pagination -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end products content -->

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
                            <li><a href="#">Conseils Personnalisés</a></li>
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
  <!-- app js -->
  <script src="js/app.js"></script>
</body>

</html>
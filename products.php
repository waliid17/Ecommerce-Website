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
              <li><a href="#" data-filter="category" data-value="Electroportatif">Electroportatif</a></li>
              <li><a href="#" data-filter="category" data-value="Outillage à main">Outillage à main</a></li>
              <li><a href="#" data-filter="category" data-value="Chantier">Chantier</a></li>
              <li><a href="#" data-filter="category" data-value="Sécurité">Sécurité</a></li>
              <li><a href="#" data-filter="category" data-value="Jardin">Jardin</a></li>
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
            <span class="filter-header"> Marques </span>
            <ul class="filter-list">
              <li>
                <div class="group-checkbox">
                  <input type="checkbox" id="remember1" data-filter="brand" data-value="YATO" />
                  <label for="remember1">
                    YATO
                    <i class="bx bx-check"></i>
                  </label>
                </div>
              </li>
              <li>
                <div class="group-checkbox">
                  <input type="checkbox" id="remember2" data-filter="brand" data-value="HONESTPRO" />
                  <label for="remember2">
                    HONESTPRO
                    <i class="bx bx-check"></i>
                  </label>
                </div>
              </li>
              <li>
                <div class="group-checkbox">
                  <input type="checkbox" id="remember3" data-filter="brand" data-value="BODA" />
                  <label for="remember3">
                    BODA
                    <i class="bx bx-check"></i>
                  </label>
                </div>
              </li>
              <li>
                <div class="group-checkbox">
                  <input type="checkbox" id="remember4" data-filter="brand" data-value="TOLSEN" />
                  <label for="remember4">
                    TOLSEN
                    <i class="bx bx-check"></i>
                  </label>
                </div>
              </li>
            </ul>
            <div class="container"><br>
              <button class="filter-button" id="filter-button">
              Filtrer
              </button>
            </div>
          </div>
        </div>
        <div class="col-9 col-md-12">
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

                // Capture filters
                $categories = isset($_GET['category']) ? $_GET['category'] : [];
                $brands = isset($_GET['brand']) ? $_GET['brand'] : [];
                $status = isset($_GET['status']) ? $_GET['status'] : [];
                $prixMin = isset($_GET['prixMin']) ? (float) $_GET['prixMin'] : 0;
                $prixMax = isset($_GET['prixMax']) ? (float) $_GET['prixMax'] : PHP_INT_MAX;

                // Build the WHERE clause
                $whereClauses = ["prix_actuel BETWEEN $prixMin AND $prixMax"];

                if (!empty($categories)) {
                  $categories = array_map([$connection, 'real_escape_string'], $categories);
                  $whereClauses[] = "category IN ('" . implode("','", $categories) . "')";
                }
                if (!empty($brands)) {
                  $brands = array_map([$connection, 'real_escape_string'], $brands);
                  $whereClauses[] = "marque IN ('" . implode("','", $brands) . "')";
                }
                if (!empty($status)) {
                  $status = array_map([$connection, 'real_escape_string'], $status);
                  $whereClauses[] = "status IN ('" . implode("','", $status) . "')";
                }

                // Combine all clauses
                $whereClause = implode(' AND ', $whereClauses);
                $query = "SELECT * FROM `outil` WHERE $whereClause LIMIT $items_per_page OFFSET $offset";

                echo "<!-- Query: $query -->"; // Debugging line

                $result = $connection->query($query);

                if ($result) {
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
                } else {
                  echo "Erreur de requête : " . $connection->error; // Debugging line
                }

                $total_query = "SELECT COUNT(*) AS total FROM `outil` WHERE $whereClause";
                $total_result = $connection->query($total_query);
                if ($total_result) {
                  $total_row = $total_result->fetch_assoc();
                  $total_items = $total_row['total'];
                  $total_pages = ceil($total_items / $items_per_page);
                } else {
                  echo "Erreur de requête : " . $connection->error; // Debugging line
                }
                ?>

              </div>
              <div class="pagination">
                <?php if ($page > 1) : ?>
                  <a href="?page=<?php echo $page - 1; ?>" class="pagination-btn">&laquo; Précédent</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                  <a href="?page=<?php echo $i; ?>" class="pagination-btn <?php if ($i == $page) echo 'active'; ?>">
                    <?php echo $i; ?>
                  </a>
                <?php endfor; ?>
                <?php if ($page < $total_pages) : ?>
                  <a href="?page=<?php echo $page + 1; ?>" class="pagination-btn">Suivant &raquo;</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('filter-button').addEventListener('click', function () {
      var categories = [];
      var brands = [];
      var status = [];
      var prixMin = document.getElementById('prixMin').value;
      var prixMax = document.getElementById('prixMax').value;

      document.querySelectorAll('input[data-filter="category"]:checked').forEach(function (checkbox) {
        categories.push(checkbox.getAttribute('data-value'));
      });

      document.querySelectorAll('input[data-filter="brand"]:checked').forEach(function (checkbox) {
        brands.push(checkbox.getAttribute('data-value'));
      });

      document.querySelectorAll('input[data-filter="status"]:checked').forEach(function (checkbox) {
        status.push(checkbox.getAttribute('data-value'));
      });

      var queryString = '?';
      if (categories.length) queryString += 'category[]=' + categories.join('&category[]=') + '&';
      if (brands.length) queryString += 'brand[]=' + brands.join('&brand[]=') + '&';
      if (status.length) queryString += 'status[]=' + status.join('&status[]=') + '&';
      if (prixMin) queryString += 'prixMin=' + encodeURIComponent(prixMin) + '&';
      if (prixMax) queryString += 'prixMax=' + encodeURIComponent(prixMax) + '&';

      queryString = queryString.slice(0, -1); // Remove trailing '&'

      window.location.href = 'products.php' + queryString;
    });
  });
</script>

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
      .container {
    padding: 10px;
}

.button-flat {
    background-color: #ff840a; /* Orange background */
    border: none;
    color: white;
    padding: 12px 24px; /* Increased padding for a wider button */
    font-size: 18px; /* Slightly larger font size */
    cursor: pointer;
    border-radius: 6px; /* Slightly more rounded corners */
    transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease; /* Added transition for scale effect */
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); /* Subtle shadow */
    text-align: center; /* Center text */
    display: block; /* Block display to ensure full width */
    width: 100%; /* Full width of its container */
    max-width: 200px; /* Maximum width for the button */
    margin: 0 auto; /* Center align button horizontally */
}

.button-flat:hover {
    background-color: #e67503; /* Darker orange on hover */
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3); /* Slightly larger shadow on hover */
    transform: scale(1.05); /* Slightly enlarge button on hover */
}

.button-text-bold {
    font-weight: bold; /* Makes the text bold */
    text-transform: uppercase; /* Uppercase text */
}

#filter-button {
    display: inline-block;
}
    }
    /* Pagination container */
.pagination {
  display: flex;
  justify-content: center;
  list-style: none;
  padding: 0;
  margin: 0;
}

/* Pagination links */
.pagination a {
  display: block;
  padding: 8px 16px;
  margin: 0 4px;
  border: 1px solid #ddd;
  color: #333;
  text-decoration: none;
  border-radius: 4px;
}

/* Active page */
.pagination a.active {
  background-color: #ff840a;
  color: white;
  border-color: #ff840a;
}

/* Hover effect */
.pagination a:hover {
  background-color: #e67503;
  color: white;
  border-color: #e67503;
}

/* Previous and next buttons */
.pagination i {
  font-size: 18px;
}
/* Base styling for the filter button */
.filter-button {
  background: linear-gradient(135deg, #ff840a, #e67503); /* Gradient background */
  border: none;
  color: white;
  padding: 12px 20px;
  font-size: 16px;
  font-weight: bold;
  text-transform: uppercase;
  border-radius: 8px; /* Rounded corners */
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Hover state for the filter button */
.filter-button:hover {
  background: linear-gradient(135deg, #e67503, #ff840a); /* Reverse gradient */
  transform: translateY(-2px); /* Slight lift effect */
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}

/* Focus state for accessibility */
.filter-button:focus {
  outline: none;
  box-shadow: 0 0 0 4px rgba(255, 132, 10, 0.3); /* Focus ring */
}

/* Active state for button press */
.filter-button:active {
  background: linear-gradient(135deg, #d06501, #cc6e02); /* Darker gradient */
  transform: translateY(1px); /* Pressed effect */
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}


  </style>
  <!-- app js -->
  <script src="js/app.js"></script>
</body>

</html>
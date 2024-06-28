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
          <a href="./index.php">home</a>
          <span><i class="bx bxs-chevrons-right"></i></span>
          <a href="./products.php">all products</a>
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
          <h3 class="footer-head">Products</h3>
          <ul class="menu">
            <li><a href="#">Prices drop</a></li>
            <li><a href="#">New products</a></li>
            <li><a href="#">Best sales</a></li>
            <li><a href="#">Contact us</a></li>
            <li><a href="#">Sitemap</a></li>
          </ul>
        </div>
        <div class="col-3 col-md-6">
          <h3 class="footer-head">Our company</h3>
          <ul class="menu">
            <li><a href="#">Delivery</a></li>
            <li><a href="#">Legal Notice</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Secure payment</a></li>
            <li><a href="#">Sitemap</a></li>
          </ul>
        </div>
        <div class="col-3 col-md-6">
          <h3 class="footer-head">Your account</h3>
          <ul class="menu">
            <li><a href="#">Addresses</a></li>
            <li><a href="#">Credit slips</a></li>
            <li><a href="#">Orders</a></li>
            <li><a href="#">Personal info</a></li>
          </ul>
        </div>
        <div class="col-3 col-md-6">
          <h3 class="footer-head">Store information</h3>
          <ul class="menu">
            <li>
              <a href="#"><i class="bx bx-location-plus"></i>Company name, store</a>
            </li>
            <li>
              <a href="#"><i class="bx bx-phone-call"></i>0123456789</a>
            </li>
            <li>
              <a href="#"><i class="bx bx-envelope"></i>support@company.com</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <!-- end footer -->

  <!-- app js -->
  <script src="js/app.js"></script>
</body>

</html>
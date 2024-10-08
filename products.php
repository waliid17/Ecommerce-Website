<?php
$connection = new mysqli("localhost", "root", "", "base");

if ($connection->connect_error) {
  die("Connection failed: " . $connection->connect_error);
}
$sql = "SELECT * FROM categorie";
$result = $connection->query($sql);
$categorie = [];

if ($result->num_rows > 0) {
  // Step 2: Store the results in a variable
  while ($row = $result->fetch_assoc()) {
    $categorie[] = $row;  // Store each row in the $categories array
  }
}
// Fetch brands from the new table
$brands = [];
$sql_brands = "SELECT id_marque, nom_marque FROM marque";
$result_brands = $connection->query($sql_brands);

if ($result_brands->num_rows > 0) {
  while ($row = $result_brands->fetch_assoc()) {
    $brands[] = $row;
  }
}
$selectedbrands = isset($_GET['brand']) ? $_GET['brand'] : [];
$selectedcategories = isset($_GET['category']) ? $_GET['category'] : [];
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>pro-outil</title>
  <!-- Favicon -->
  <link rel="icon" href="images/e.png" type="image/png">
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
      <div class="logo">
        <a href="index.php">
          <img src="images/prooutil1.png" alt="LOGO">
        </a>
      </div>
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
            <a href="index.php">
              <img src="images/prooutil.gif" alt="LOGO">
            </a>
          </div>
          <form action="products.php" method="GET">
            <div class="search">
              <input type="text" <?= !empty($searchTerm) ? "value='$searchTerm'" : ""; ?> name="search" placeholder="Search">
              <button type="submit" class="searchh"><i class='bx bx-search-alt'></i></button>
            </div>
          </form>
          <ul class="user-menu">
            <li><a href='#'><i class='bx bx-bell' style='display: none;'></i></a></li>
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
          <a href="./products.php">TOUS LES OUTILS</a>
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
              <?php
              // Display categories
              if (!empty($categorie)) {
                echo "<ul class='filter-list'>";
                foreach ($categorie as $category) {
                  $selcted = in_array($category['id_cat'], $selectedcategories) ? 'checked' : '';
                  echo '<li>
              <div class="group-checkbox">
                <input type="checkbox" id="cat' . $category['id_cat'] . '" data-filter="category" data-value="' . $category['id_cat'] . '"' . $selcted . ' />
                <label for="cat' . $category['id_cat'] . '">' . $category['nom_cat'] . '
                  <i class="bx bx-check"></i>
                </label>
              </div>
            </li>';
                }
                echo "</ul>";
              }
              ?>
            </div>

            <div class="price-box">
              <span class="filter-header"> Prix </span>
              <div class="price-range">
                <div class="price-input">
                  <label for="prixMin">Prix Min (DA):</label>
                  <input type="text" id="prixMin" name="prixMin" <?= isset($_GET['prixMin']) ? 'value="' . (float) $_GET['prixMin'] . '"' : ' ' ?> />
                </div>
                <div class="price-input">
                  <label for="prixMax">Prix Max (DA):</label>
                  <input type="text" id="prixMax" name="prixMax" <?= isset($_GET['prixMax']) ? 'value="' . (float) $_GET['prixMax'] . '"' : ' ' ?> />
                </div>
              </div>
            </div>
            <div class="box">
              <span class="filter-header">Marques</span>
              <ul class="filter-list">
                <?php foreach ($brands as $brand): ?>
                  <li>
                    <div class="group-checkbox">
                      <input type="checkbox" id="brand_<?php echo $brand['id_marque']; ?>" data-filter="brand"
                        data-value="<?php echo htmlspecialchars($brand['id_marque']); ?>" <?php echo in_array($brand['id_marque'], $selectedbrands) ? 'checked' : ''; ?> />
                      <label for="brand_<?php echo $brand['id_marque']; ?>">
                        <?php echo htmlspecialchars($brand['nom_marque']); ?>
                        <i class="bx bx-check"></i>
                      </label>
                    </div>
                  </li>
                <?php endforeach; ?>
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
                  // Check if the search term is present
                  $items_per_page = 12;
                  $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                  $offset = ($page - 1) * $items_per_page;

                  // Capture filters
                  $prixMin = isset($_GET['prixMin']) ? (float) $_GET['prixMin'] : 0;
                  $prixMax = isset($_GET['prixMax']) ? (float) $_GET['prixMax'] : PHP_INT_MAX;
                  $brands = isset($_GET['brand']) ? $_GET['brand'] : [];
                  $categories = isset($_GET['category']) ? $_GET['category'] : [];

                  // Build the WHERE clause
                  $whereClauses = ["prix_actuel BETWEEN $prixMin AND $prixMax"];

                  if (!empty($brands)) {
                    $brands = array_map([$connection, 'real_escape_string'], $brands);
                    $whereClauses[] = "id_marque IN ('" . implode("','", $brands) . "')";
                  }

                  if (!empty($categories)) {
                    $categories = array_map('intval', $categories);  // Ensure category IDs are integers
                    $whereClauses[] = "id_cat IN (" . implode(",", $categories) . ")";
                  }

                  // Combine all clauses
                  $whereClause = implode(' AND ', $whereClauses);
                  $query = "SELECT * FROM `outil` WHERE $whereClause LIMIT $items_per_page OFFSET $offset";
                  if (!empty($searchTerm)) {
                    $searchTerm = "%" . $connection->real_escape_string($searchTerm) . "%"; 
                    $query = "SELECT * FROM `outil` WHERE $whereClause AND (nom LIKE '$searchTerm' OR description LIKE '$searchTerm') LIMIT $items_per_page OFFSET $offset";
                }else{
                  $query = "SELECT * FROM `outil` WHERE $whereClause LIMIT $items_per_page OFFSET $offset";
                }
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
                  <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>" class="pagination-btn">&laquo; Précédent</a>
                  <?php endif; ?>
                  <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="pagination-btn <?php if ($i == $page)
                         echo 'active'; ?>">
                      <?php echo $i; ?>
                    </a>
                  <?php endfor; ?>
                  <?php if ($page < $total_pages): ?>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('filter-button').addEventListener('click', function () {
        var categories = [];
        var brands = [];
        var prixMin = document.getElementById('prixMin').value;
        var prixMax = document.getElementById('prixMax').value;

        // Collecting checked category checkboxes
        document.querySelectorAll('input[data-filter="category"]:checked').forEach(function (checkbox) {
          categories.push(checkbox.getAttribute('data-value'));
        });

        // Collecting checked brand checkboxes
        document.querySelectorAll('input[data-filter="brand"]:checked').forEach(function (checkbox) {
          brands.push(checkbox.getAttribute('data-value'));
        });

        var queryString = '?';

        if (categories.length) {
          queryString += 'category[]=' + categories.join('&category[]=') + '&';
        }

        if (brands.length) {
          queryString += 'brand[]=' + brands.join('&brand[]=') + '&';
        }

        if (prixMin) queryString += 'prixMin=' + encodeURIComponent(prixMin) + '&';
        if (prixMax) queryString += 'prixMax=' + encodeURIComponent(prixMax) + '&';

        queryString = queryString.slice(0, -1); // Remove trailing '&'

        // Redirect to the filtered URL
        window.location.href = 'products.php' + queryString;
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll(".btn-cart-add").forEach(function (button) {
        button.addEventListener("click", function () {
          let dataId = this.getAttribute("data-id");
          let product = products[dataId];

          if (!product) {
            console.error("Error: Product not found!");
          } else {
            addToWishlist(product);
          }
        });
      });

      function addToWishlist(product) {
        let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
        const existingProductIndex = wishlist.findIndex(item => item.id === product.id);

        if (existingProductIndex !== -1) {
          wishlist[existingProductIndex].quantity += product.quantity;
        } else {
          wishlist.push(product);
        }
        localStorage.setItem("wishlist", JSON.stringify(wishlist));

        Swal.fire({
          title: 'ajouté!',
          text: `${product.name} a été ajouté à votre panier.`,
          icon: 'success',
          confirmButtonText: 'OK'
        });
      }
    });
  </script>

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

      .container {
        padding: 10px;
      }

      .button-flat {
        background-color: #ff840a;
        /* Orange background */
        border: none;
        color: white;
        padding: 12px 24px;
        /* Increased padding for a wider button */
        font-size: 18px;
        /* Slightly larger font size */
        cursor: pointer;
        border-radius: 6px;
        /* Slightly more rounded corners */
        transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
        /* Added transition for scale effect */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        /* Subtle shadow */
        text-align: center;
        /* Center text */
        display: block;
        /* Block display to ensure full width */
        width: 100%;
        /* Full width of its container */
        max-width: 200px;
        /* Maximum width for the button */
        margin: 0 auto;
        /* Center align button horizontally */
      }

      .button-flat:hover {
        background-color: #e67503;
        /* Darker orange on hover */
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3);
        /* Slightly larger shadow on hover */
        transform: scale(1.05);
        /* Slightly enlarge button on hover */
      }

      .button-text-bold {
        font-weight: bold;
        /* Makes the text bold */
        text-transform: uppercase;
        /* Uppercase text */
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
      background: linear-gradient(135deg, #ff840a, #e67503);
      /* Gradient background */
      border: none;
      color: white;
      padding: 12px 20px;
      font-size: 16px;
      font-weight: bold;
      text-transform: uppercase;
      border-radius: 8px;
      /* Rounded corners */
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Hover state for the filter button */
    .filter-button:hover {
      background: linear-gradient(135deg, #e67503, #ff840a);
      /* Reverse gradient */
      transform: translateY(-2px);
      /* Slight lift effect */
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }

    /* Focus state for accessibility */
    .filter-button:focus {
      outline: none;
      box-shadow: 0 0 0 4px rgba(255, 132, 10, 0.3);
      /* Focus ring */
    }

    /* Active state for button press */
    .filter-button:active {
      background: linear-gradient(135deg, #d06501, #cc6e02);
      /* Darker gradient */
      transform: translateY(1px);
      /* Pressed effect */
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }
  </style>
  <!-- app js -->
  <script src="js/app.js"></script>
</body>

</html>
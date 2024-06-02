<?php
// Ensure session_start() is called at the beginning of the script
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user rank from session or database
$rank = $_SESSION['rank'] ?? '';

// Database connection and fetching user data
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT `first-name`, `last-name`, email, `phone_number`, `address_line`, `rank` FROM utilisateur WHERE id = ?";
$stmt = $connection->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName, $email, $phoneNumber, $addressLine, $rankFromDb);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error preparing statement: " . $connection->error;
}

$connection->close();

// Use the rank fetched from the database if available
if ($rankFromDb) {
    $rank = $rankFromDb;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATShop</title>
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <!-- App CSS -->
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="user.css">
</head>

<body style="display: flex; flex-direction: column; min-height: 100vh;">
    <!-- Header -->
    <header>
        <!-- Mobile Menu -->
        <div class="mobile-menu bg-second">
            <div class="logo">
                <img src="images/prooutil.gif" alt="LOGO">
            </div>
            <span class="mb-menu-toggle" id="mb-menu-toggle">
                <i class='bx bx-menu'></i>
            </span>
        </div>
        <!-- Main Header -->
        <div class="header-wrapper" id="header-wrapper">
            <span class="mb-menu-toggle mb-menu-close" id="mb-menu-close">
                <i class='bx bx-x'></i>
            </span>
            <div class="bg-main">
                <div class="mid-header container">
                    <div class="logo">
                        <a href="index.php"><img src="images/prooutil.gif" alt="LOGO"></a>
                    </div>
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
                    <?php
                    if ($rank == "admin") {
                        echo '<a href="#" class="btn">
                            <div class="login">
                                Admin
                            </div>
                        </a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </header>

    <div class="profile-container">
        <div class="profile-header">
            <h1 class="user-name"><?php echo htmlspecialchars($firstName . " " . $lastName); ?></h1>
            <p class="user-email"><?php echo htmlspecialchars($email); ?></p>
        </div>
        <div class="profile-body">
            <div class="tabs">
                <button class="tablink active" onclick="openTab(event, 'PersonalInfo')">Informations
                    Personnelles</button>
                <?php if ($rank != 'admin') { ?>
                    <button class="tablink" onclick="openTab(event, 'Wishlist')">Liste de Souhaits</button>
                    <button class="tablink" onclick="openTab(event, 'Address')">Adresse</button>
                <?php } else { ?>
                    <button class="tablink" onclick="openTab(event, 'AddProducts')">Add Products</button>
                <?php } ?>
            </div>
            <div id="PersonalInfo" class="tabcontent active">
                <h2>Informations Personnelles</h2>
                <form class="form" method="post" action="user_edit.php">
                    <div class="form-group">
                        <label for="name">Nom :</label>
                        <input type="text" id="name" name="lastname" value="<?php echo htmlspecialchars($lastName); ?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="name">Prénom :</label>
                        <input type="text" id="name" name="firstname"
                            value="<?php echo htmlspecialchars($firstName); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Adresse e-mail :</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Numéro de téléphone :</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phoneNumber); ?>"
                            required>
                    </div>
                    <button type="submit" name="save1" class="save-btn">Save</button>
                </form>
            </div>
            <?php if ($rank != 'admin') { ?>
                <div id="Wishlist" class="tabcontent">
                    <h2>Liste de Souhaits</h2>
                    <ul class="wishlist">
                        <li>
                            <p>Product 1</p>
                            <button class="remove-btn" onclick="removeFromWishlist(this)">Remove</button>
                        </li>
                        <li>
                            <p>Product 2</p>
                            <button class="remove-btn" onclick="removeFromWishlist(this)">Remove</button>
                        </li>
                    </ul>
                </div>
                <div id="Address" class="tabcontent">
                    <h2>Adresse</h2>
                    <form class="form" method="post" action="user_edit.php" id="addressForm">
                        <div class="form-group">
                            <label for="address1">Adresse Ligne :</label>
                            <input type="text" id="address1" name="address"
                                value="<?php echo htmlspecialchars($addressLine); ?>" required>
                        </div>
                        <button type="submit" name="save2" class="save-btn">Save</button>
                    </form>
                </div>
            <?php } ?>
            <?php if ($rank == 'admin') { ?>
                <div id="AddProducts" class="tabcontent">
                    <h2>Add Products</h2>
                    <form action="add_product.php" method="post" enctype="multipart/form-data">
                        <table class="form-table">
                            <tr>
                                <td><label for="name">Nom du produit :</label></td>
                                <td><input type="text" id="name" name="name" placeholder="Entrez le nom du produit"
                                        required></td>
                            </tr>
                            <tr>
                                <td><label for="prod_desc">Description du produit :</label></td>
                                <td><input type="text" id="prod_desc" name="prod_desc"
                                        placeholder="Entrez la description du produit" required></td>
                            </tr>
                            <tr>
                                <td><label for="old_price">Ancien prix :</label></td>
                                <td><input type="text" id="old_price" name="old_price" placeholder="Entrez l'ancien prix"
                                        required></td>
                            </tr>
                            <tr>
                                <td><label for="curr_price">Prix actuel :</label></td>
                                <td><input type="text" id="curr_price" name="curr_price" placeholder="Entrez le prix actuel"
                                        required></td>
                            </tr>
                            <tr>
                                <td><label for="brand">Marque :</label></td>
                                <td><input type="text" id="brand" name="brand" placeholder="Entrez la marque" required></td>
                            </tr>
                            <tr>
                                <td><label for="image">Photo du produit :</label></td>
                                <td>
                                    <div class="file-input-container">
                                        <label for="image" class="file-input-label">Choisissez une photo</label>
                                        <input type="file" id="image" name="image" class="file-input" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><button type="submit" class="button">
                                        <span class="button__text">Ajouter le produit</span>
                                        <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round"
                                                stroke-linecap="round" stroke="currentColor" height="24" fill="none"
                                                class="svg">
                                                <line y2="19" y1="5" x2="12" x1="12"></line>
                                                <line y2="12" y1="12" x2="19" x1="5"></line>
                                            </svg></span>
                                    </button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- Scripts -->
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
                tabcontent[i].classList.remove("active");
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabName).style.display = "block";
            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.classList.add("active");
        }

        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("PersonalInfo").style.display = "block";
            document.querySelector(".tablink").classList.add("active");
        });

        function removeFromWishlist(button) {
            var item = button.parentNode;
            item.parentNode.removeChild(item);
        }
    </script>
</body>

</html>
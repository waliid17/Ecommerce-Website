<?php
// Ensure session_start() is called at the beginning of the script
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user is not logged in
if (!isset($_SESSION['user-id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user rank from session or database
$rank = $_SESSION['role'] ?? '';

// Database connection and fetching user data
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$user_id = $_SESSION['user-id'];
$sql = "SELECT `prenom`, `nom`, `email`, `telephone`, `adresse`, `role` FROM client WHERE `id_client` = ?";
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

// Use the rank fetched from the database if available
if ($rankFromDb) {
    $rank = $rankFromDb;
}

// Function to fetch messages
function fetchMessages($connection)
{
    $messages = [];
    $sql = "SELECT `id`, `prenom`, `nom`, `phone`, `email`, `sujet`, `contenu`, `date` FROM `message`";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
    }

    return $messages;
}

$messages = fetchMessages($connection);

// Function to fetch products (for admin only)
function fetchProducts($connection)
{
    $products = [];
    $sql = "SELECT `id_outil`, `nom`, `description`, `ancien_prix`, `prix_actuel`, `image`, `marque` FROM `outil`";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    return $products;
}

if ($rank == 'admin') {
    $products = fetchProducts($connection);
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pro-outil</title>
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
                    <?php
                    if ($rank == "admin") {
                        echo '<a href="#" class="btn">
                            <div class="login">
                                Admin
                            </div>
                        </a>';
                    } else {
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
                    <button class="tablink" onclick="openTab(event, 'ShowMessages')">Afficher Messages</button>
                    <button class="tablink" onclick="openTab(event, 'ShowProducts')">Afficher Produits</button>
                <?php } ?>
            </div>
            <div id="PersonalInfo" class="tabcontent active">
                <h2>Informations Personnelles</h2>
                <form class="form" method="post" action="user_edit.php">
                    <div class="form-group">
                        <label for="name">Nom :</label>
                        <input type="text" id="name" name="nom" value="<?php echo htmlspecialchars($lastName); ?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="name">Prénom :</label>
                        <input type="text" id="name" name="prenom" value="<?php echo htmlspecialchars($firstName); ?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="email">Adresse e-mail :</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Numéro de téléphone :</label>
                        <input type="tel" id="phone" name="telephone"
                            value="<?php echo htmlspecialchars($phoneNumber); ?>" required>
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
                            <input type="text" id="address1" name="adresse"
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
                                <td><input type="text" id="name" name="nom" placeholder="Entrez le nom du produit" required>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="prod_desc">Description du produit :</label></td>
                                <td><input type="text" id="prod_desc" name="description"
                                        placeholder="Entrez la description du produit" required></td>
                            </tr>
                            <tr>
                                <td><label for="old_price">Ancien prix :</label></td>
                                <td><input type="text" id="old_price" name="ancien_prix" placeholder="Entrez l'ancien prix">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="curr_price">Prix actuel :</label></td>
                                <td><input type="text" id="curr_price" name="prix_actuel"
                                        placeholder="Entrez le prix actuel" required></td>
                            </tr>
                            <tr>
                                <td><label for="brand">Marque :</label></td>
                                <td><input type="text" id="brand" name="marque" placeholder="Entrez la marque" required>
                                </td>
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
                <div id="ShowMessages" class="tabcontent">
                    <h2>Messages</h2>
                    <table class="message-table">
                        <thead>
                            <tr>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Sujet</th>
                                <th>Contenu</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $message) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($message['prenom']); ?></td>
                                    <td><?php echo htmlspecialchars($message['nom']); ?></td>
                                    <td><?php echo htmlspecialchars($message['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($message['email']); ?></td>
                                    <td><?php echo htmlspecialchars($message['sujet']); ?></td>
                                    <td><?php echo htmlspecialchars($message['contenu']); ?></td>
                                    <td><?php echo htmlspecialchars($message['date']); ?></td>
                                    <td>
                                        <form action="delete_message.php" method="post" class="action-buttons"
                                            style="display: inline;">
                                            <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                                            <button class="delete-button">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 69 14"
                                                    class="svgIcon bin-top">
                                                    <g clip-path="url(#clip0_35_24)">
                                                        <path fill="black"
                                                            d="M20.8232 2.62734L19.9948 4.21304C19.8224 4.54309 19.4808 4.75 19.1085 4.75H4.92857C2.20246 4.75 0 6.87266 0 9.5C0 12.1273 2.20246 14.25 4.92857 14.25H64.0714C66.7975 14.25 69 12.1273 69 9.5C69 6.87266 66.7975 4.75 64.0714 4.75H49.8915C49.5192 4.75 49.1776 4.54309 49.0052 4.21305L48.1768 2.62734C47.3451 1.00938 45.6355 0 43.7719 0H25.2281C23.3645 0 21.6549 1.00938 20.8232 2.62734ZM64.0023 20.0648C64.0397 19.4882 63.5822 19 63.0044 19H5.99556C5.4178 19 4.96025 19.4882 4.99766 20.0648L8.19375 69.3203C8.44018 73.0758 11.6746 76 15.5712 76H53.4288C57.3254 76 60.5598 73.0758 60.8062 69.3203L64.0023 20.0648Z">
                                                        </path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_35_24">
                                                            <rect fill="white" height="14" width="69"></rect>
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 69 57"
                                                    class="svgIcon bin-bottom">
                                                    <g clip-path="url(#clip0_35_22)">
                                                        <path fill="black"
                                                            d="M20.8232 -16.3727L19.9948 -14.787C19.8224 -14.4569 19.4808 -14.25 19.1085 -14.25H4.92857C2.20246 -14.25 0 -12.1273 0 -9.5C0 -6.8727 2.20246 -4.75 4.92857 -4.75H64.0714C66.7975 -4.75 69 -6.8727 69 -9.5C69 -12.1273 66.7975 -14.25 64.0714 -14.25H49.8915C49.5192 -14.25 49.1776 -14.4569 49.0052 -14.787L48.1768 -16.3727C47.3451 -17.9906 45.6355 -19 43.7719 -19H25.2281C23.3645 -19 21.6549 -17.9906 20.8232 -16.3727ZM64.0023 1.0648C64.0397 0.4882 63.5822 0 63.0044 0H5.99556C5.4178 0 4.96025 0.4882 4.99766 1.0648L8.19375 50.3203C8.44018 54.0758 11.6746 57 15.5712 57H53.4288C57.3254 57 60.5598 54.0758 60.8062 50.3203L64.0023 1.0648Z">
                                                        </path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_35_22">
                                                            <rect fill="white" height="57" width="69"></rect>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div id="ShowProducts" class="tabcontent">
                    <h2>Produits</h2>
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Ancien Prix</th>
                                <th>Prix Actuel</th>
                                <th>Image</th>
                                <th>Marque</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['nom']); ?></td>
                                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                                    <td><?php echo htmlspecialchars($product['ancien_prix']); ?></td>
                                    <td><?php echo htmlspecialchars($product['prix_actuel']); ?></td>
                                    <td><img src="images/<?php echo htmlspecialchars($product['image']); ?>"
                                            alt="<?php echo htmlspecialchars($product['nom']); ?>" width="100"></td>
                                    <td><?php echo htmlspecialchars($product['marque']); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="edit-button"
                                                onclick="toggleEditForm(<?php echo $product['id_outil']; ?>)">Éditer</button>
                                            <form action="delete_product.php" method="post" style="display: inline;">
                                                <input type="hidden" name="id_outil"
                                                    value="<?php echo $product['id_outil']; ?>">
                                                <button class="delete-button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 69 14"
                                                        class="svgIcon bin-top">
                                                        <g clip-path="url(#clip0_35_24)">
                                                            <path fill="black"
                                                                d="M20.8232 2.62734L19.9948 4.21304C19.8224 4.54309 19.4808 4.75 19.1085 4.75H4.92857C2.20246 4.75 0 6.87266 0 9.5C0 12.1273 2.20246 14.25 4.92857 14.25H64.0714C66.7975 14.25 69 12.1273 69 9.5C69 6.87266 66.7975 4.75 64.0714 4.75H49.8915C49.5192 4.75 49.1776 4.54309 49.0052 4.21305L48.1768 2.62734C47.3451 1.00938 45.6355 0 43.7719 0H25.2281C23.3645 0 21.6549 1.00938 20.8232 2.62734ZM64.0023 20.0648C64.0397 19.4882 63.5822 19 63.0044 19H5.99556C5.4178 19 4.96025 19.4882 4.99766 20.0648L8.19375 69.3203C8.44018 73.0758 11.6746 76 15.5712 76H53.4288C57.3254 76 60.5598 73.0758 60.8062 69.3203L64.0023 20.0648Z">
                                                            </path>
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_35_24">
                                                                <rect fill="white" height="14" width="69"></rect>
                                                            </clipPath>
                                                        </defs>
                                                    </svg>

                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 69 57"
                                                        class="svgIcon bin-bottom">
                                                        <g clip-path="url(#clip0_35_22)">
                                                            <path fill="black"
                                                                d="M20.8232 -16.3727L19.9948 -14.787C19.8224 -14.4569 19.4808 -14.25 19.1085 -14.25H4.92857C2.20246 -14.25 0 -12.1273 0 -9.5C0 -6.8727 2.20246 -4.75 4.92857 -4.75H64.0714C66.7975 -4.75 69 -6.8727 69 -9.5C69 -12.1273 66.7975 -14.25 64.0714 -14.25H49.8915C49.5192 -14.25 49.1776 -14.4569 49.0052 -14.787L48.1768 -16.3727C47.3451 -17.9906 45.6355 -19 43.7719 -19H25.2281C23.3645 -19 21.6549 -17.9906 20.8232 -16.3727ZM64.0023 1.0648C64.0397 0.4882 63.5822 0 63.0044 0H5.99556C5.4178 0 4.96025 0.4882 4.99766 1.0648L8.19375 50.3203C8.44018 54.0758 11.6746 57 15.5712 57H53.4288C57.3254 57 60.5598 54.0758 60.8062 50.3203L64.0023 1.0648Z">
                                                            </path>
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_35_22">
                                                                <rect fill="white" height="57" width="69"></rect>
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </button>

                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="edit-form-<?php echo $product['id_outil']; ?>" class="edit-form-row"
                                    style="display: none;">
                                    <td colspan="8">
                                        <form action="update_product.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_outil"
                                                value="<?php echo htmlspecialchars($product['id_outil']); ?>">
                                            <table class="form-table">
                                                <tr>
                                                    <td><label for="name">Nom du produit :</label></td>
                                                    <td><input type="text" id="name" name="nom"
                                                            value="<?php echo htmlspecialchars($product['nom']); ?>" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="prod_desc">Description du produit :</label></td>
                                                    <td><input type="text" id="prod_desc" name="description"
                                                            value="<?php echo htmlspecialchars($product['description']); ?>"
                                                            required></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="old_price">Ancien prix :</label></td>
                                                    <td><input type="text" id="old_price" name="ancien_prix"
                                                            value="<?php echo htmlspecialchars($product['ancien_prix']); ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="curr_price">Prix actuel :</label></td>
                                                    <td><input type="text" id="curr_price" name="prix_actuel"
                                                            value="<?php echo htmlspecialchars($product['prix_actuel']); ?>"
                                                            required></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="brand">Marque :</label></td>
                                                    <td><input type="text" id="brand" name="marque"
                                                            value="<?php echo htmlspecialchars($product['marque']); ?>"
                                                            required></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="image">Photo du produit :</label></td>
                                                    <td>
                                                        <input type="text"
                                                            value="<?php echo htmlspecialchars($product['image']); ?>"
                                                            name="current_image" style="display: none;">
                                                        <img src="images/<?php echo htmlspecialchars($product['image']); ?>"
                                                            alt="<?php echo htmlspecialchars($product['nom']); ?>" width="100">
                                                        <input type="file" id="image" name="image">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <button type="submit">save</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
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
        function toggleEditForm(productId) {
            // Hide any currently visible edit forms
            const openForms = document.querySelectorAll('.edit-form-row');
            openForms.forEach(form => {
                if (form.id !== `edit-form-${productId}`) {
                    form.style.display = 'none';
                }
            });

            // Toggle the display of the clicked edit form
            const formRow = document.getElementById(`edit-form-${productId}`);
            formRow.style.display = formRow.style.display === 'none' ? 'table-row' : 'none';
        }

    </script>
</body>

</html>
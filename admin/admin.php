<!DOCTYPE html>
<html lang="pt" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/google_fonts.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="user.css" />

    <!-- emoji favicon  -->
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📲</text></svg>" />
    <title>ADMIN</title>
</head>

<body>
    <?php
    // Database connection and fetching user data
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "base";

    $connection = new mysqli($servername, $username, $password, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Fetch clients
    $clients = [];
    $sql = "SELECT id_client, prenom, nom, email, telephone, adresse FROM client";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $clients[] = $row;
        }
    }
    // Fetch categories
    $sqlCategories = "SELECT id_cat, nom_cat FROM categorie";
    $resultCategories = $connection->query($sqlCategories);
    $categories = [];

    if ($resultCategories->num_rows > 0) {
        while ($row = $resultCategories->fetch_assoc()) {
            $categories[] = $row;
        }
    }

    // Fetch products with category names
    $products = [];
    $sql = "
    SELECT 
        o.id_outil, 
        o.nom, 
        o.description, 
        o.ancien_prix, 
        o.prix_actuel, 
        o.image, 
        c.nom_cat, 
        o.id_cat, 
        m.nom_marque
    FROM 
        outil o
    LEFT JOIN 
        categorie c ON o.id_cat = c.id_cat
    LEFT JOIN 
        marque m ON o.id_marque = m.id_marque
";

    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    // Fetch the list of brands
    $brands = [];
    $sql_brands = "SELECT id_marque, nom_marque FROM marque";
    $result_brands = $connection->query($sql_brands);

    if ($result_brands->num_rows > 0) {
        while ($row = $result_brands->fetch_assoc()) {
            $brands[] = $row;
        }
    }

    // Fetch unique statuses from the commande table
    $sqlStatuses = "SELECT DISTINCT statut FROM commande";
    $resultStatuses = $connection->query($sqlStatuses);

    $statuses = [];
    $statuses[] = 'En attente';
    $statuses[] = 'Confirmée';
    $statuses[] = 'Expédiée';
    $statuses[] = 'Livrée';
    $statuses[] = 'Annulée';

    // Fetch messages
    function fetchMessages($connection)
    {
        $messages = [];
        $sql = "SELECT id, prenom, nom, phone, email, sujet, contenu, date FROM message";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $messages[] = $row;
            }
        }
        return $messages;
    }

    $messages = fetchMessages($connection);

    // Close the database connection
    $connection->close();
    ?>

    <nav class="sidebar closed">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="assets/img/admin.jpg" alt="logo" />
                </span>

                <div class="text header-text">
                    <?php
                    session_start();
                    if (isset($_SESSION['user-id'])) {
                        $connection = new mysqli("localhost", "root", "", "base");
                        if ($connection->connect_error) {
                            die("Connection failed: " . $connection->connect_error);
                        }

                        $id = $_SESSION['user-id'];
                        // Ensure that the ID is properly sanitized
                        $id = $connection->real_escape_string($id);

                        $query = "SELECT `nom_ad` FROM `admin` WHERE id_ad = $id";
                        $result = $connection->query($query);

                        if (!$result) {
                            die("Query failed: " . $connection->error);
                        }

                        if ($result->num_rows > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $user = $row['nom_ad'];
                            echo "<h3>SALUT $user</h3>";
                        } else {
                            echo "<h3>Bonjour, Admin</h3>";
                        }
                    } else {
                        echo "<h3>Bonjour, Invité</h3>";
                    }
                    ?>

                </div>
            </div>
            <i class="bx bx-chevron-left toggle"></i>
        </header>
        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="#" class="nav-item" data-target="accueil-content">
                            <i class="bx bx-home-alt icon"></i>
                            <span class="text nav-text">ACCUEIL</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#" class="nav-item" data-target="users-content">
                            <i class="bx bx-user icon"></i>
                            <span class="text nav-text">LES UTILISATEURS</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#" class="nav-item" data-target="outil-content">
                            <i class="bx bx-store-alt icon"></i>
                            <span class="text nav-text">LES OUTILS</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#" class="nav-item" data-target="messages-content">
                            <i class="bx bx-message icon"></i>
                            <span class="text nav-text">LES MESSAGES</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#" class="nav-item" data-target="commandes-content">
                            <i class="bx bx-package icon"></i>
                            <span class="text nav-text">LES COMMANDES</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#" class="nav-item" data-target="marques-content">
                            <i class="bx bx-image icon"></i>
                            <span class="text nav-text">LES MARQUES</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#" class="nav-item" data-target="wilayas-content">
                            <i class="bx bx-map icon"></i>
                            <span class="text nav-text">LES WILAYAS</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li>
                    <a href="logout_admin.php">
                        <i class="bx bx-log-out icon"></i>
                        <span class="text nav-text">Déconnexion</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>

    <section class="home">
        <div class="content" id="accueil-content">
            <h2>BIENVENUE ADMIN</h2>
            <div class="dashboard-summary">
                <?php include 'count.php'; ?>

                <div class="Main">
                    <div class="MainCard">
                        <div class="Card">
                            <div>
                                <div class="num"><?php echo $countUsers; ?></div>
                                <div class="name">UTILISATEURS</div>
                            </div>
                            <div class="icons">
                                <a href="?targetId=users-content">
                                    <i class="fa-solid fa-users"></i>
                                </a>
                            </div>
                        </div>
                        <div class="Card">
                            <div>
                                <div class="num"><?php echo $countTools; ?></div>
                                <div class="name">OUTILS</div>
                            </div>
                            <div class="icons">
                                <a href="?targetId=outil-content">
                                    <i class="fa-solid fa-shop"></i>
                                </a>
                            </div>
                        </div>
                        <div class="Card">
                            <div>
                                <div class="num"><?php echo $countMessages; ?></div>
                                <div class="name">MESSAGES</div>
                            </div>
                            <div class="icons">
                                <a href="?targetId=messages-content">
                                    <i class="fa-solid fa-message"></i>
                                </a>
                            </div>
                        </div>
                        <div class="Card">
                            <div>
                                <div class="num"><?php echo $countOrders; ?></div>
                                <div class="name">COMMANDES</div>
                            </div>
                            <div class="icons">
                                <a href="?targetId=commandes-content">
                                    <i class="fa-solid fa-boxes-packing"></i>
                                </a>
                            </div>
                        </div>
                        <div class="Card">
                            <div>
                                <div class="num"><?php echo $countMarques; ?></div>
                                <div class="name">MARQUES</div>
                            </div>
                            <div class="icons">
                                <a href="?targetId=marques-content">
                                    <i class="bx bxs-image-add icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class="Card">
                            <div>
                                <div class="num"><?php echo $countWilayas; ?></div>
                                <div class="name">WILAYAS</div>
                            </div>
                            <div class="icons">
                                <a href="?targetId=wilayas-content">
                                    <i class="bx bxs-map icon"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="content" id="users-content">
            <h2>LES UTILISATEURS :</h2><br>
            <table class="client-table">
                <thead>
                    <tr>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($clients)) {
                        foreach ($clients as $client) {
                            echo "<tr data-client-id='{$client['id_client']}'>
                            <td>{$client['prenom']}</td>
                            <td>{$client['nom']}</td>
                            <td>{$client['email']}</td>
                            <td>{$client['telephone']}</td>
                            <td>{$client['adresse']}</td>
                          </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No clients found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="content" id="outil-content" style="display: none;">
            <div id="ShowProducts" class="tabcontent">
                <h2>LES OUTILS :</h2>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Ancien Prix</th>
                            <th>Prix Actuel</th>
                            <th>Image</th>
                            <th>Marque</th>
                            <th>Catégorie</th>
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
                                <td><img src="../images/<?php echo htmlspecialchars($product['image']); ?>"
                                        alt="<?php echo htmlspecialchars($product['nom']); ?>" width="100"></td>
                                <td><?php echo htmlspecialchars($product['nom_marque']); ?></td>
                                <td><?php echo $product['nom_cat']; ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="edit-button"
                                            onclick="toggleEditForm(<?php echo $product['id_outil']; ?>)">Éditer</button>
                                        <form action="../delete_product.php" method="post" style="display: inline;">
                                            <input type="hidden" name="id_outil"
                                                value="<?php echo $product['id_outil']; ?>">
                                            <button class="delete-button2">
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
                                    <form action="../update_product.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id_outil"
                                            value="<?php echo htmlspecialchars($product['id_outil']); ?>">
                                        <table class="form-table">
                                            <tr>
                                                <td><label for="category">Catégorie :</label></td>
                                                <td>
                                                    <select id="category" name="id_cat" required>
                                                        <?php
                                                        // Loop through categories and create options
                                                        foreach ($categories as $category) {
                                                            // Check if the current category should be selected
                                                            $selected = $product['id_cat'] == $category['id_cat'] ? ' selected' : '';
                                                            echo '<option value="' . htmlspecialchars($category['id_cat']) . '"' . $selected . '>' . htmlspecialchars($category['nom_cat']) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
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
                                                <td>
                                                    <select id="brand" name="id_marque" required>
                                                        <?php
                                                        // Loop through brands and create options
                                                        foreach ($brands as $brand) {
                                                            // Ensure $product['id_marque'] is set and compare correctly
                                                            $selected = isset($product['id_marque']) && $product['id_marque'] == $brand['id_marque'] ? ' selected' : '';
                                                            echo '<option value="' . htmlspecialchars($brand['id_marque']) . '"' . $selected . '>' . htmlspecialchars($brand['nom_marque']) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="image">Photo du produit :</label></td>
                                                <td>
                                                    <input type="text"
                                                        value="<?php echo htmlspecialchars($product['image']); ?>"
                                                        name="current_image" style="display: none;">
                                                    <img src="../images/<?php echo htmlspecialchars($product['image']); ?>"
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
                <button id="addProductBtn" class="add-product-btn">
                    <span class="btn-icon">+</span> Ajouter un produit
                </button>
                <!-- Modal Structure -->
                <div id="productModal" class="modal">
                    <div class="modal-content">
                        <span class="close-btn">&times;</span>
                        <h2>Ajouter un produit</h2>
                        <form action="add_product.php" method="post" enctype="multipart/form-data">
                            <table class="form-table">
                                <tr>
                                    <td><label for="category">Catégorie :</label></td>
                                    <td>
                                        <select id="category" name="id_cat" required>
                                            <?php
                                            // Loop through categories and create options
                                            foreach ($categories as $category) {
                                                // Check if the current category should be selected
                                                $selected = isset($product['id_cat']) && $product['id_cat'] == $category['id_cat'] ? ' selected' : '';
                                                echo '<option value="' . htmlspecialchars($category['id_cat']) . '"' . $selected . '>' . htmlspecialchars($category['nom_cat']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="name">Nom du produit :</label></td>
                                    <td><input type="text" id="name" name="nom" required></td>
                                </tr>
                                <tr>
                                    <td><label for="prod_desc">Description du produit :</label></td>
                                    <td><input type="text" id="prod_desc" name="description" required></td>
                                </tr>
                                <tr>
                                    <td><label for="old_price">Ancien prix :</label></td>
                                    <td><input type="text" id="old_price" name="ancien_prix"></td>
                                </tr>
                                <tr>
                                    <td><label for="curr_price">Prix actuel :</label></td>
                                    <td><input type="text" id="curr_price" name="prix_actuel" required></td>
                                </tr>
                                <tr>
                                    <td><label for="brand">Marque :</label></td>
                                    <td>
                                        <select id="brand" name="id_marque" required>
                                            <?php
                                            // Loop through brands and create options
                                            foreach ($brands as $brand) {
                                                // Ensure $product['id_marque'] is set and compare correctly
                                                $selected = isset($product['id_marque']) && $product['id_marque'] == $brand['id_marque'] ? ' selected' : '';
                                                echo '<option value="' . htmlspecialchars($brand['id_marque']) . '"' . $selected . '>' . htmlspecialchars($brand['nom_marque']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="image">Photo du produit :</label></td>
                                    <td>
                                        <input type="text" name="current_image" style="display: none;">
                                        <img id="productImage" src="" alt="Product Image" width="100">
                                        <input type="file" id="image" name="image">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <button type="submit">Save</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <script>
                    // Show the modal when the button is clicked
                    document.getElementById('addProductBtn').addEventListener('click', function () {
                        document.getElementById('productModal').style.display = 'block';
                    });

                    // Hide the modal when the close button is clicked
                    document.querySelector('.close-btn').addEventListener('click', function () {
                        document.getElementById('productModal').style.display = 'none';
                    });

                    // Hide the modal when clicking outside of the modal content
                    window.addEventListener('click', function (event) {
                        if (event.target === document.getElementById('productModal')) {
                            document.getElementById('productModal').style.display = 'none';
                        }
                    });

                </script>
            </div>
        </div><br><br>
        <!-- Edit Success Modal -->
        <div id="editModal" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <span id="closeEditModalBtn" class="close">&times;</span>
                    <div class="modal-body">
                        <i class="fas fa-check-circle success-icon"></i>
                        <p>Produit mis à jour avec succès !</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-ok">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Success Modal -->
        <div id="deleteModal2" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <span id="closeDeleteModalBtn" class="close">&times;</span>
                    <div class="modal-body">
                        <i class="fas fa-check-circle success-icon"></i>
                        <p>Produit supprimé avec succès !</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-ok-delete" onclick="delete_product()">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Font Awesome for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const editForms = document.querySelectorAll('.edit-form-row form'); // Select all edit forms
                const deleteButtons = document.querySelectorAll('.delete-btn'); // Select all delete buttons
                const editModal = document.getElementById('editModal'); // Edit modal element
                const deleteModal = document.getElementById('deleteModal'); // Delete modal element
                const closeEditModalBtn = document.getElementById('closeEditModalBtn'); // Button to close edit modal
                const closeDeleteModalBtn = document.getElementById('closeDeleteModalBtn'); // Button to close delete modal
                const okEditButton = document.querySelector('.btn-ok'); // OK button in edit modal
                const okDeleteButton = document.querySelector('.btn-ok-delete'); // OK button in delete modal

                // Handle form submission for edit
                editForms.forEach(form => {
                    form.addEventListener('submit', function (event) {
                        event.preventDefault(); // Prevent default form submission

                        const formData = new FormData(form); // Create FormData object from the form

                        // Submit form using Fetch API
                        fetch(form.action, {
                            method: 'POST',
                            body: formData
                        })
                            .then(response => response.json()) // Expect JSON response
                            .then(data => {
                                if (data.status === 'success') {
                                    showEditModal(); // Show edit modal if update is successful
                                } else {
                                    console.error('Update failed:', data.message); // Handle errors
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error); // Handle fetch errors
                            });
                    });
                });

                // Show the edit modal
                function showEditModal() {
                    editModal.style.display = 'block'; // Display the edit modal
                }


                // Close the edit modal when the close button is clicked
                closeEditModalBtn.onclick = function () {
                    editModal.style.display = 'none';
                };

                // Close the edit modal when clicking outside the modal
                window.onclick = function (event) {
                    if (event.target === editModal) {
                        editModal.style.display = 'none';
                    }
                    if (event.target === deleteModal) {
                        deleteModal.style.display = 'none';
                    }
                };

                // Handle OK button click to close the edit modal and refresh the page
                okEditButton.onclick = function () {
                    editModal.style.display = 'none';
                    location.reload(); // Refresh the page after closing the modal
                };

            });
        </script>
        <div class="content" id="messages-content" style="display: none;">
            <div id="ShowMessages" class="tabcontent">
                <h2>LES MESSAGES :</h2>
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
                                    <form action="../delete_message.php" method="post" class="action-buttons"
                                        style="display: inline;">
                                        <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                                        <button class="delete-button" type="submit">
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
        </div>
        <!-- Modal Structure -->
        <div id="myModal" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <span id="closeModalBtn" class="close">&times;</span>
                    <div class="modal-body">
                        <div class="modal-icon">
                            <!-- Success Icon SVG -->
                            <svg viewBox="0 0 24 24" class="success-icon" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" fill="none" stroke="#ff840a" stroke-width="2" />
                                <path d="M7 12l3 3 7-7" fill="none" stroke="#ff840a" stroke-width="2" />
                            </svg>
                        </div>
                        <h2>Succès</h2>
                        <p>Message supprimé avec succès.</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-ok" onclick="delete_message()">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript to Control Modal -->
        <script>
            // Get modal elements
            const modal = document.getElementById('myModal');
            const deleteModal2 = document.getElementById('deleteModal2');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const okButton = document.querySelector('.btn-ok');
            const deleteButtons = document.querySelectorAll('.delete-button');
            const deleteButtons2 = document.querySelectorAll('.delete-button2');

            // Variable to store the current form to be submitted
            let formToSubmit = null;

            // Add click event listeners to all delete buttons
            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();  // Prevent form submission

                    // Store the form associated with the clicked delete button
                    formToSubmit = button.closest('form');

                    // Show modal
                    modal.style.display = 'block';
                });
            });
            deleteButtons2.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();  // Prevent form submission

                    // Store the form associated with the clicked delete button
                    formToSubmit = button.closest('form');

                    // Show modal
                    deleteModal2.style.display = 'block';
                });
            });

            // Confirm and submit form using AJAX when clicking the OK button
            function delete_message() {
                if (formToSubmit) {
                    // Create a FormData object from the form
                    const formData = new FormData(formToSubmit);

                    // Send the form data using AJAX
                    fetch(formToSubmit.action, {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.text())
                        .then(data => {
                            // Refresh the page content or remove the row from the table
                            formToSubmit.closest('tr').remove();
                            closeModal();  // Close the modal
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            closeModal();  // Close the modal even if there's an error
                        });
                }
            };

            // Close modal when clicking the close button
            closeModalBtn.onclick = function () {
                closeModal();  // Close the modal
            };

            // Close modal when clicking outside the modal content
            window.onclick = function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            };

            function closeModal() {
                modal.style.display = 'none';
                formToSubmit = null;  // Clear the stored form
            }
            function delete_product() {
                if (formToSubmit) {
                    // Create a FormData object from the form
                    const formData = new FormData(formToSubmit);

                    // Send the form data using AJAX
                    fetch(formToSubmit.action, {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.text())
                        .then(data => {
                            // Refresh the page content or remove the row from the table
                            formToSubmit.closest('tr').remove();
                            closedeletModal();  // Close the modal
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            closedeletModal();  // Close the modal even if there's an error
                        });
                }
            };

            // Close modal when clicking the close button
            closeModalBtn.onclick = function () {
                closedeletModal();  // Close the modal
            };

            // Close modal when clicking outside the modal content
            window.onclick = function (event) {
                if (event.target === modal) {
                    closedeletModal();
                }
            };

            function closedeletModal() {
                document.getElementById('deleteModal2').style.display = 'none';
                formToSubmit = null;  // Clear the stored form
            }
        </script>
        <?php
        // Database connection
        $host = 'localhost';
        $dbname = 'base';
        $username = 'root';
        $password = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Query to get client orders including product prices
            $query = "SELECT w.wilaya AS wilaya,w.delivery_price, c.id_client, c.prenom AS client_prenom, c.nom AS client_nom, c.telephone AS client_phone, 
           com.id_com, com.date_com, com.statut, co.id_outil, co.Qte_com, o.prix_actuel AS product_price
    FROM commande com
    LEFT JOIN wilaya w ON com.id_wilaya = w.id_wilaya
    JOIN effectuer_com ec ON com.id_com = ec.id_com
    JOIN client c ON ec.id_client = c.id_client
    LEFT JOIN conteniroutil co ON com.id_com = co.id_com
    LEFT JOIN outil o ON co.id_outil = o.id_outil
    ";

            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch product details
            $product_query = "
        SELECT id_outil, nom, image, prix_actuel
        FROM outil
    ";
            $product_stmt = $pdo->prepare($product_query);
            $product_stmt->execute();
            $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

            // Map product ID to details
            $product_details = [];
            foreach ($products as $product) {
                $product_details[$product['id_outil']] = $product;
            }

            // Organize orders by id_com
            $order_details = [];
            foreach ($orders as $order) {
                $order_id = $order['id_com'];
                if (!isset($order_details[$order_id])) {
                    $order_details[$order_id] = [
                        'client_id' => $order['id_client'],
                        'client_prenom' => $order['client_prenom'],
                        'client_nom' => $order['client_nom'],
                        'client_phone' => $order['client_phone'],
                        'date_com' => $order['date_com'],
                        'statut' => $order['statut'],
                        'wilaya' => $order['wilaya'],
                        'delivery_price' => $order['delivery_price'],
                        'products' => [],
                        'total_price' => 0 // Initialize total price
                    ];
                }
                $product_price = $order['product_price'];
                $quantity = $order['Qte_com'];
                $total_product_price = $product_price * $quantity;

                // Add product details and price to the order
                $order_details[$order_id]['products'][] = [
                    'id_outil' => $order['id_outil'],
                    'Qte_com' => $order['Qte_com'],
                    'product' => $product_details[$order['id_outil']] ?? null,
                    'price' => $total_product_price
                ];

                // Update the total price for the order
                $order_details[$order_id]['total_price'] += $total_product_price;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>

        <div class="content" id="commandes-content">
            <h2>LES COMMANDES :</h2><br>
            <?php if (!empty($order_details)): ?>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Numéro de téléphone</th>
                            <th>Date Commande</th>
                            <th>Statut</th>
                            <th>wilaya</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_details as $order_id => $order_data): ?>
                            <!-- Order Row -->
                            <tr class="order-row" data-order-id="<?php echo htmlspecialchars($order_id); ?>">
                                <td><?php echo htmlspecialchars($order_data['client_prenom']) . ' ' . htmlspecialchars($order_data['client_nom']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($order_data['client_phone']); ?></td>
                                <td><?php echo htmlspecialchars($order_data['date_com']); ?></td>
                                <td>
                                    <select class="status-select" data-order-id="<?php echo htmlspecialchars($order_id); ?>">
                                        <?php foreach ($statuses as $status): ?>
                                            <option <?= ($status == $order_data['statut']) ? 'selected' : '' ?>
                                                value="<?php echo htmlspecialchars($status); ?>">
                                                <?php echo htmlspecialchars($status); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <td><?php echo htmlspecialchars($order_data['wilaya']); ?></td>
                                <td><button class="toggle-details">Show Details</button></td>
                            </tr>

                            <!-- Details Row -->
                            <tr class="details-row" id="details-<?php echo htmlspecialchars($order_id); ?>"
                                style="display: none;">
                                <td colspan="6">
                                    <div class="details-content">
                                        <?php foreach ($order_data['products'] as $product): ?>
                                            <div class="order-detail">
                                                <p><strong></strong>
                                                    <?php echo $product['product'] ? htmlspecialchars($product['product']['nom']) : 'N/A'; ?>
                                                </p>
                                                <p> <?php if ($product['product'] && $product['product']['image']): ?><img
                                                            src="../images/<?php echo htmlspecialchars($product['product']['image']); ?>"
                                                            alt="<?php echo htmlspecialchars($product['product']['nom']); ?>"><?php else: ?>No
                                                        Image<?php endif; ?></p>
                                                <p><strong>Quantité:</strong> <?php echo htmlspecialchars($product['Qte_com']); ?>
                                                </p>
                                                <p><strong>Prix Unitaire:</strong>
                                                    <?php echo htmlspecialchars($product['product']['prix_actuel']); ?> DA</p>
                                                <p><strong>Prix Total:</strong> <?php echo htmlspecialchars($product['price']); ?>
                                                    DA</p>
                                            </div>

                                        <?php endforeach; ?>
                                    </div>
                                    <div class="order-summary">
                                        <p><strong>Total Commande:
                                            </strong><?php echo htmlspecialchars($order_data['total_price']); ?> DA</p>
                                        <p><strong>Frais de Livraison:
                                            </strong><?php echo htmlspecialchars($order_data['delivery_price']); ?> DA</p>
                                        <p><strong>Total à Payer:
                                            </strong><?php echo htmlspecialchars($order_data['total_price'] + $order_data['delivery_price']); ?>
                                            DA</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune commande trouvée.</p>
            <?php endif; ?>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.status-select').forEach(select => {
                    select.addEventListener('change', function () {
                        const orderId = this.dataset.orderId;
                        const status = this.value;

                        fetch('update_status.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: new URLSearchParams({
                                order_id: orderId,
                                status: status
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Status updated successfully.');
                                } else {
                                    alert('Failed to update status.');
                                }
                            });
                    });
                });
            });
        </script>

        <script>
            document.querySelectorAll('.toggle-details').forEach(button => {
                button.addEventListener('click', function () {
                    const orderId = this.closest('.order-row').dataset.orderId;
                    const detailsRow = document.getElementById('details-' + orderId);

                    // Hide all details rows
                    document.querySelectorAll('.details-row').forEach(row => {
                        if (row !== detailsRow) {
                            row.style.display = 'none';
                            row.previousElementSibling.querySelector('.toggle-details').textContent = 'Show Details';
                        }
                    });

                    // Toggle the clicked row
                    if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                        detailsRow.style.display = 'table-row';
                        this.textContent = 'Hide Details';
                    } else {
                        detailsRow.style.display = 'none';
                        this.textContent = 'Show Details';
                    }
                });
            });
        </script>



        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "base";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle image deletion
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_image_id'])) {
            $delete_id = intval($_POST['delete_image_id']);
            $delete_sql = "DELETE FROM marque WHERE id_marque = ?";
            $stmt = $conn->prepare($delete_sql);
            $stmt->bind_param("i", $delete_id);
            if ($stmt->execute()) {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script><script>
        Swal.fire({
            title: 'Success!',
            text: 'Your operation was successful.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>";
            } else {
                echo "Error deleting image: " . $conn->error;
            }
            $stmt->close();
        }

        // Handle image upload
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $upload_dir = '../uploads/';
            $image_name = basename($_FILES['image']['name']);
            $target_file = $upload_dir . $image_name;
            $image_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if the file is an actual image
            $check = getimagesize($_FILES['image']['tmp_name']);
            if ($check === false) {
                echo "File is not an image.";
                exit;
            }

            // Check file size (optional, e.g., limit to 2MB)
            if ($_FILES['image']['size'] > 10000000) {
                echo "Sorry, your file is too large.";
                exit;
            }

            // Allow certain file formats
            if ($image_type != "jpg" && $image_type != "png" && $image_type != "jpeg" && $image_type != "gif") {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                exit;
            }

            // Move the uploaded file to the upload directory
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image_url = "uploads/" . $image_name;

                // Insert image path into the database
                $insert_sql = "INSERT INTO marque (url_marque) VALUES (?)";
                $stmt = $conn->prepare($insert_sql);
                $stmt->bind_param("s", $image_url);
                if ($stmt->execute()) {
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script><script>
            Swal.fire({
                title: 'Success!',
                text: 'Image uploaded successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>";
                } else {
                    echo "Error saving image to database: " . $conn->error;
                }
                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        // Fetch all images from the database
        $sql = "SELECT id_marque, url_marque FROM marque";
        $result = $conn->query($sql);

        $images = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $images[] = $row;
            }
        }

        $conn->close();
        ?>
        <div class="content" id="marques-content" style="display: block;">
            <h2>LES MARQUES :</h2>
            <!-- Brand Images Table -->
            <?php if (!empty($images)): ?>
                <table class="brand-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($images as $image): ?>
                            <tr>
                                <td><img src="../<?php echo htmlspecialchars($image['url_marque']); ?>" alt="Brand Image"
                                        width="100"></td>
                                <td>
                                    <form method="post" style="display:inline;">
                                        <input type="hidden" name="delete_image_id" value="<?php echo $image['id_marque']; ?>">
                                        <button type="submit">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune image de marque trouvée.</p>
            <?php endif; ?>
            <div class="add-image-section">
                <h3>Ajouter une nouvelle image de marque</h3>
                <form method="post" enctype="multipart/form-data" class="add-image-form">
                    <input type="file" name="image" class="custom-file-inputt" id="image" required>
                    <div id="image-preview" style="margin-top: 20px;">
                        <!-- Image preview will be displayed here -->
                    </div>
                    <button type="submit" class="add-image-button">Ajouter</button>
                </form>
            </div>
        </div>

        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "base";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle delete operations
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $query = "DELETE FROM wilaya WHERE id_wilaya = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $id);
            if ($stmt->execute()) {
                echo "<p>Wilaya deleted successfully.</p>";
                echo "<meta http-equiv='refresh' content='0'>"; // Refresh the page to reflect changes
            } else {
                echo "Error deleting record: " . $conn->error;
            }
            $stmt->close();
        }

        // Handle price update
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_wilaya']) && isset($_POST['delivery_price'])) {
            $id = $_POST['id_wilaya'];
            $price = $_POST['delivery_price'];
            $updateQuery = "UPDATE wilaya SET delivery_price = ? WHERE id_wilaya = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param('di', $price, $id);
            if ($stmt->execute()) {
                echo "<script>document.addEventListener('DOMContentLoaded', function() { showSuccessModal(); });</script>";
            } else {
                echo "Error updating price: " . $conn->error;
            }
            $stmt->close();
        }

        // Close the connection
        $conn->close();
        ?>

        <div class="content" id="wilayas-content">
            <h2>LISTE DES WILAYAS :</h2><br>
            <table class="wilaya-table">
                <thead>
                    <tr>
                        <th>Wilaya</th>
                        <th>Delivery Price (DZD)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Re-open the connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $query = "SELECT * FROM wilaya";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr data-wilaya-id='{$row['id_wilaya']}'>
                            <td>{$row['wilaya']}</td>
                           <td>
    <span class='price-display' data-wilaya-id='{$row['id_wilaya']}'>{$row['delivery_price']}</span>
    <input type='text' class='price-input' data-wilaya-id='{$row['id_wilaya']}' value='{$row['delivery_price']}' style='display: none;' />
    <button class='save-price' data-wilaya-id='{$row['id_wilaya']}' style='display: none;' title='Save Price'>
        <i class='fas fa-save'></i>
    </button>
</td>

                            <td>
                            <div class='action-buttons'>
                              <button class='edit-button' data-wilaya-id='{$row['id_wilaya']}' title='Edit Price'>
                                    Éditer
                                </button>
                              <button class='delete-wilaya' data-wilaya-id='{$row['id_wilaya']}' title='Delete'>
  <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 69 14' class='svgIcon bin-top'>
    <g clip-path='url(#clip0_35_24)'>
      <path fill='black'
        d='M20.8232 2.62734L19.9948 4.21304C19.8224 4.54309 19.4808 4.75 19.1085 4.75H4.92857C2.20246 4.75 0 6.87266 0 9.5C0 12.1273 2.20246 14.25 4.92857 14.25H64.0714C66.7975 14.25 69 12.1273 69 9.5C69 6.87266 66.7975 4.75 64.0714 4.75H49.8915C49.5192 4.75 49.1776 4.54309 49.0052 4.21305L48.1768 2.62734C47.3451 1.00938 45.6355 0 43.7719 0H25.2281C23.3645 0 21.6549 1.00938 20.8232 2.62734ZM64.0023 20.0648C64.0397 19.4882 63.5822 19 63.0044 19H5.99556C5.4178 19 4.96025 19.4882 4.99766 20.0648L8.19375 69.3203C8.44018 73.0758 11.6746 76 15.5712 76H53.4288C57.3254 76 60.5598 73.0758 60.8062 69.3203L64.0023 20.0648Z'>
      </path>
    </g>
    <defs>
      <clipPath id='clip0_35_24'>
        <rect fill='white' height='14' width='69'></rect>
      </clipPath>
    </defs>
  </svg>
  <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 69 57' class='svgIcon bin-bottom'>
    <g clip-path='url(#clip0_35_22)'>
      <path fill='black'
        d='M20.8232 -16.3727L19.9948 -14.787C19.8224 -14.4569 19.4808 -14.25 19.1085 -14.25H4.92857C2.20246 -14.25 0 -12.1273 0 -9.5C0 -6.8727 2.20246 -4.75 4.92857 -4.75H64.0714C66.7975 -4.75 69 -6.8727 69 -9.5C69 -12.1273 66.7975 -14.25 64.0714 -14.25H49.8915C49.5192 -14.25 49.1776 -14.4569 49.0052 -14.787L48.1768 -16.3727C47.3451 -17.9906 45.6355 -19 43.7719 -19H25.2281C23.3645 -19 21.6549 -17.9906 20.8232 -16.3727ZM64.0023 1.0648C64.0397 0.4882 63.5822 0 63.0044 0H5.99556C5.4178 0 4.96025 0.4882 4.99766 1.0648L8.19375 50.3203C8.44018 54.0758 11.6746 57 15.5712 57H53.4288C57.3254 57 60.5598 54.0758 60.8062 50.3203L64.0023 1.0648Z'>
      </path>
    </g>
    <defs>
      <clipPath id='clip0_35_22'>
        <rect fill='white' height='57' width='69'></rect>
      </clipPath>
    </defs>
  </svg>
</button>
</div>

                          </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No wilayas found.</td></tr>";
                    }

                    // Close the connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Success Modal Structure -->
        <div id="successModal" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <span id="closeSuccessModalBtn" class="close">&times;</span>
                    <div class="modal-body">
                        <div class="modal-icon">
                            <svg viewBox="0 0 24 24" class="success-icon" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" fill="none" stroke="#ff840a" stroke-width="2" />
                                <path d="M7 12l3 3 7-7" fill="none" stroke="#ff840a" stroke-width="2" />
                            </svg>
                        </div>
                        <h2>Succès</h2>
                        <p>Prix de livraison mis à jour avec succès.</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-ok" id="btn-ok-wilaya">OK</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Delete Confirmation Modal Structure -->
        <div id="deleteConfirmationModal" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <span id="closeDeleteConfirmationModalBtn" class="close">&times;</span>
                    <div class="modal-body">
                        <h2>Confirmation</h2>
                        <p>Êtes-vous sûr de vouloir supprimer cette wilaya ?</p>
                    </div>
                    <div class="modal-footer">
                        <button id="confirmDeleteBtn" class="btn btn-ok">Confirmer</button>
                        <button id="cancelDeleteBtn" class="btn">Annuler</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const successModal = document.getElementById('successModal');
                const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
                const closeSuccessModalBtn = document.getElementById('closeSuccessModalBtn');
                const okButtonSuccess = document.querySelector('.btn-ok');
                const okButtonwilaya = document.getElementById('btn-ok-wilaya');
                const closeDeleteConfirmationModalBtn = document.getElementById('closeDeleteConfirmationModalBtn');
                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
                const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
                let currentDeleteId = null;
                let currentEditingId = null; // Track the currently edited Wilaya ID

                // Function to show the success modal for price updates
                function showSuccessModal() {
                    successModal.style.display = 'block';
                }

                // Function to close the success modal and refresh the content
                function closeSuccessModalAndRefresh() {
                    successModal.style.display = 'none';
                }

                // Function to close the delete confirmation modal
                function closeDeleteConfirmationModal() {
                    deleteConfirmationModal.style.display = 'none';
                }

                // Function to show delete confirmation modal
                function showDeleteConfirmationModal(id) {
                    currentDeleteId = id;
                    deleteConfirmationModal.style.display = 'block';
                }

                // Function to toggle edit mode
                function toggleEditMode(wilayaId) {
                    // If there's another Wilaya being edited, cancel its edit mode
                    if (currentEditingId && currentEditingId !== wilayaId) {
                        const previousPriceDisplay = document.querySelector(`.price-display[data-wilaya-id='${currentEditingId}']`);
                        const previousPriceInput = document.querySelector(`.price-input[data-wilaya-id='${currentEditingId}']`);
                        previousPriceDisplay.style.display = 'block';
                        previousPriceInput.style.display = 'none';
                    }

                    // Now handle the current edit mode
                    const priceDisplay = document.querySelector(`.price-display[data-wilaya-id='${wilayaId}']`);
                    const priceInput = document.querySelector(`.price-input[data-wilaya-id='${wilayaId}']`);
                    const isEditing = priceInput.style.display === 'block';

                    if (isEditing) {
                        // Save changes
                        const newPrice = priceInput.value;
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                priceDisplay.textContent = newPrice;
                                showSuccessModal();
                            } else {
                                alert('Error updating price');
                            }
                        };
                        xhr.send(`id_wilaya=${wilayaId}&delivery_price=${encodeURIComponent(newPrice)}`);
                    }

                    priceDisplay.style.display = isEditing ? 'block' : 'none';
                    priceInput.style.display = isEditing ? 'none' : 'block';
                    if (!isEditing) priceInput.focus();

                    // Update the currently edited Wilaya ID
                    currentEditingId = isEditing ? null : wilayaId;
                }

                // Add click event listeners to all "Edit Price" buttons
                function bindEvents() {
                    document.querySelectorAll('.edit-button').forEach(button => {
                        button.addEventListener('click', function (event) {
                            event.preventDefault();
                            const wilayaId = this.getAttribute('data-wilaya-id');
                            toggleEditMode(wilayaId);
                        });
                    });

                    // Add click event listeners to all "Delete" links
                    document.querySelectorAll('.delete-wilaya').forEach(link => {
                        link.addEventListener('click', function (event) {
                            event.preventDefault();
                            const wilayaId = this.getAttribute('data-wilaya-id');
                            showDeleteConfirmationModal(wilayaId);
                        });
                    });
                }

                // Confirm delete action
                confirmDeleteBtn.addEventListener('click', function () {
                    if (currentDeleteId) {
                        const xhr = new XMLHttpRequest();
                        xhr.open('GET', `?delete=${currentDeleteId}`, true);
                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                closeDeleteConfirmationModal(); // Hide the confirmation modal
                                location.reload(); // Reload the current page to reflect changes
                            }
                        };
                        xhr.send();
                    }
                });

                // Cancel delete action
                cancelDeleteBtn.addEventListener('click', function () {
                    closeDeleteConfirmationModal();
                });

                // Close modals when clicking the close button
                closeSuccessModalBtn.addEventListener('click', closeSuccessModalAndRefresh);
                okButtonwilaya.addEventListener('click', closeSuccessModalAndRefresh);
                closeDeleteConfirmationModalBtn.addEventListener('click', closeDeleteConfirmationModal);

                // Close modals when clicking outside the modal content
                window.addEventListener('click', function (event) {
                    if (event.target === successModal) {
                        closeSuccessModalAndRefresh();
                    }
                    if (event.target === deleteConfirmationModal) {
                        closeDeleteConfirmationModal();
                    }
                });

                // Close success modal and refresh the page when clicking "OK"
                okButtonSuccess.addEventListener('click', closeSuccessModalAndRefresh);

                // Initial binding of events
                bindEvents();
            });

        </script>

    </section>

    <!-- Scripts -->
    <script>
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

    <script src="assets/js/app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentOpenForm = null;

            document.querySelectorAll('.edit-role').forEach(function (editIcon) {
                editIcon.addEventListener('click', function (event) {
                    event.preventDefault();
                    const clientId = this.getAttribute('data-client-id');
                    const row = this.closest('tr');
                    const roleDisplay = row.querySelector('.role-display');
                    const form = row.querySelector('.edit-role-form');

                    if (currentOpenForm && currentOpenForm !== form) {
                        // Hide the previously opened form
                        const prevRow = currentOpenForm.closest('tr');
                        const prevRoleDisplay = prevRow.querySelector('.role-display');
                        currentOpenForm.style.display = 'none';
                        prevRoleDisplay.style.display = 'inline-block';
                    }

                    if (form) {
                        if (form.style.display === 'none' || form.style.display === '') {
                            // Show the current form and hide role
                            roleDisplay.style.display = 'none';
                            form.style.display = 'flex';
                            currentOpenForm = form;
                        } else {
                            // Hide form and show role
                            roleDisplay.style.display = 'inline-block';
                            form.style.display = 'none';
                            currentOpenForm = null;
                        }
                    }
                });
            });
        });
    </script>




</body>

</html>
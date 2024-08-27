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
  <title>Sidebar Menu</title>
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
$sql = "SELECT id_client, prenom, nom, email, role, telephone, adresse FROM client";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
}

// Fetch products
$products = [];
$sql = "SELECT id_outil, nom, description, ancien_prix, prix_actuel, image, marque FROM outil";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

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
            $query = "SELECT `prenom` FROM `client` WHERE id_client = $id";
            $result = $connection->query($query);
            if ($result->num_rows > 0) {
              $row = mysqli_fetch_assoc($result);
              $user = $row['prenom'];
              echo "<h3>HELLO $user</h3>";
            }
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
              <span class="text nav-text">USERS</span>
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
        </ul>
      </div>

      <div class="bottom-content">
        <li>
          <a href="../logout.php">
            <i class="bx bx-log-out icon"></i>
            <span class="text nav-text">Logout</span>
          </a>
        </li>
      </div>
    </div>
  </nav>

  <section class="home">
    <div class="content" id="accueil-content">
      <h2>WELCOME ADMIN</h2>
      <div class="dashboard-summary">
      <?php include 'count.php'; ?>

<div class="Main">
    <div class="MainCard">
        <div class="Card">
            <div>
                <div class="num"><?php echo $countUsers; ?></div>
                <div class="name">USERS</div>
            </div>
            <div class="icons">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
        <div class="Card">
            <div>
                <div class="num"><?php echo $countTools; ?></div>
                <div class="name">OUTILS</div>
            </div>
            <div class="icons">
                <i class="fa-solid fa-shop"></i>
            </div>
        </div>
        <div class="Card">
            <div>
                <div class="num"><?php echo $countMessages; ?></div>
                <div class="name">MESSAGES</div>
            </div>
            <div class="icons">
                <i class="fa-solid fa-message"></i>
            </div>
        </div>
        <div class="Card">
            <div>
                <div class="num"><?php echo $countOrders; ?></div>
                <div class="name">COMMANDES</div>
            </div>
            <div class="icons">
                <i class="fa-solid fa-boxes-packing"></i>
            </div>
        </div>
    </div>
</div>
      </div>
      </div>
      <div class="content" id="users-content">
    <h2>Client List</h2>
    <table class="client-table">
        <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Role</th>
                <th>Téléphone</th>
                <th>Adresse</th>
                <th>Modifier le rôle</th> <!-- Column for Edit Icon -->
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
                            <td>
                                <span class='role-display {$client['role']}'>".ucfirst($client['role'])."</span>
                                <div class='edit-role-form'>
                                    <form action='edit_role.php' method='POST'>
                                        <input type='hidden' name='id_client' value='{$client['id_client']}'>
                                        <label for='role-{$client['id_client']}' style='display: none;'>Select New Role:</label>
                                        <select id='role-{$client['id_client']}' name='role' required>
                                            <option value='admin' ".($client['role'] == 'admin' ? 'selected' : '').">Admin</option>
                                            <option value='user' ".($client['role'] == 'user' ? 'selected' : '').">User</option>
                                        </select>
                                        <button type='button' class='edit-role-button'>Modifier le rôle</button>
                                    </form>
                                </div>
                            </td>
                            <td>{$client['telephone']}</td>
                            <td>{$client['adresse']}</td>
                            <td>
                                <a href='#' class='edit-role' data-client-id='{$client['id_client']}' title='Edit Role'>
                                    <i class='fas fa-edit'></i>
                                </a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No clients found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal Structure -->
<div id="userModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <span id="closeUserModalBtn" class="close">&times;</span>
            <div class="modal-body">
                <div class="modal-icon">
                    <svg viewBox="0 0 24 24" class="success-icon" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" fill="none" stroke="#ff840a" stroke-width="2"/>
                        <path d="M7 12l3 3 7-7" fill="none" stroke="#ff840a" stroke-width="2"/>
                    </svg>
                </div>
                <h2>Succès</h2>
                <p>Rôle mis à jour avec succès.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-ok">OK</button>
            </div>
        </div>
    </div>
</div>
<script>
  // Get modal elements
const userModal = document.getElementById('userModal');
const closeUserModalBtn = document.getElementById('closeUserModalBtn');
const okButtonUser = document.querySelector('.btn-ok');
const editRoleButtons = document.querySelectorAll('.edit-role-button');

// Variable to store the current form to be submitted
let formToSubmitUser = null;

// Function to close the modal and refresh the page
function closeModalAndRefresh() {
    userModal.style.display = 'none';
    location.reload();  // Refresh the page to show updated role
}

// Add click event listeners to all "Modifier le rôle" buttons
editRoleButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();  // Prevent default form submission

        // Store the form associated with the clicked button
        formToSubmitUser = button.closest('form');

        // Create a FormData object from the form
        const formData = new FormData(formToSubmitUser);

        // Send the form data using AJAX
        fetch(formToSubmitUser.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Assuming successful update, show the modal
            userModal.style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

// Close modal when clicking the close button
closeUserModalBtn.addEventListener('click', closeModalAndRefresh);

// Close modal when clicking outside the modal content
window.addEventListener('click', function(event) {
    if (event.target === userModal) {
        closeModalAndRefresh();
    }
});

// Close modal and refresh the page when clicking "OK"
okButtonUser.addEventListener('click', closeModalAndRefresh);

</script>
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
                  <td><?php echo htmlspecialchars($product['marque']); ?></td>
                  <td>
                    <div class="action-buttons">
                      <button class="edit-button"
                        onclick="toggleEditForm(<?php echo $product['id_outil']; ?>)">Éditer</button>
                      <form action="../delete_product.php" method="post" style="display: inline;">
                        <input type="hidden" name="id_outil" value="<?php echo $product['id_outil']; ?>">
                        <button class="delete-button">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 69 14" class="svgIcon bin-top">
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
                <tr id="edit-form-<?php echo $product['id_outil']; ?>" class="edit-form-row" style="display: none;">
                  <td colspan="8">
                    <form action="../update_product.php" method="post" enctype="multipart/form-data">
                      <input type="hidden" name="id_outil" value="<?php echo htmlspecialchars($product['id_outil']); ?>">
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
                              value="<?php echo htmlspecialchars($product['description']); ?>" required></td>
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
                              value="<?php echo htmlspecialchars($product['prix_actuel']); ?>" required></td>
                        </tr>
                        <tr>
                          <td><label for="brand">Marque :</label></td>
                          <td><input type="text" id="brand" name="marque"
                              value="<?php echo htmlspecialchars($product['marque']); ?>" required></td>
                        </tr>
                        <tr>
                          <td><label for="image">Photo du produit :</label></td>
                          <td>
                            <input type="text" value="<?php echo htmlspecialchars($product['image']); ?>"
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
                <tr id="edit-form-<?php echo $product['id_outil']; ?>" class="edit-form-row"
                                    style="display: none;">
                                    <td colspan="8">
                                        <form action="../update_product.php" method="post" enctype="multipart/form-data">
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
      </div>
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
                        <circle cx="12" cy="12" r="10" fill="none" stroke="#ff840a" stroke-width="2"/>
                        <path d="M7 12l3 3 7-7" fill="none" stroke="#ff840a" stroke-width="2"/>
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
const closeModalBtn = document.getElementById('closeModalBtn');
const okButton = document.querySelector('.btn-ok');
const deleteButtons = document.querySelectorAll('.delete-button');

// Variable to store the current form to be submitted
let formToSubmit = null;

// Add click event listeners to all delete buttons
deleteButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();  // Prevent form submission

        // Store the form associated with the clicked delete button
        formToSubmit = button.closest('form');

        // Show modal
        modal.style.display = 'block';  
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
closeModalBtn.onclick = function() {
    closeModal();  // Close the modal
};

// Close modal when clicking outside the modal content
window.onclick = function(event) {
    if (event.target === modal) {
        closeModal();
    }
};

function closeModal() {
    modal.style.display = 'none';
    formToSubmit = null;  // Clear the stored form
}
</script>



<!-- CSS for Modal -->
<style>
/* Modal Styling */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4); /* Black background with opacity */
}

.modal-dialog {
    position: relative;
    margin: 15% auto;
    padding: 0;
    width: 80%;
    max-width: 400px;
    animation: fadeIn 0.5s ease;
}

.modal-content {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    position: relative;
}

.close {
    position: absolute;
    top: 10px;
    right: 15px;
    color: #333;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
}

.modal-body {
    margin-top: 20px;
}

.modal-icon {
    margin-bottom: 15px;
}

.success-icon {
    width: 60px;
    height: 60px;
}

.modal-footer {
    margin-top: 20px;
}

.btn {
    background-color: #ff840a;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #e67503;
}
</style>
<?php
// Database connection
$host = 'localhost'; // or your host
$dbname = 'base'; // your database name
$username = 'root'; // your username
$password = ''; // your password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to get client orders
    $query = "
        SELECT c.prenom AS client_prenom, c.nom AS client_nom, com.date_com, com.statut, co.id_outil, co.Qte_com
        FROM commande com
        JOIN effectuer_com ec ON com.id_com = ec.id_com
        JOIN client c ON ec.id_client = c.id_client
        LEFT JOIN conteniroutil co ON com.id_com = co.id_com
        WHERE c.role = 'user'
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch product details
    $product_query = "
        SELECT id_outil, nom, image
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
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<div class="content" id="commandes-content" style="display: block;">
    <h2>Les commandes :</h2>
    <?php if (!empty($orders)): ?>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Date Commande</th>
                    <th>Statut</th>
                    <th>Produit</th>
                    <th>Image</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <?php
                        $product = $product_details[$order['id_outil']] ?? null;
                        $status_class = 'status-' . strtolower($order['statut']);
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['client_prenom']) . ' ' . htmlspecialchars($order['client_nom']); ?></td>
                        <td><?php echo htmlspecialchars($order['date_com']); ?></td>
                        <td class="<?php echo $status_class; ?>"><?php echo htmlspecialchars($order['statut']); ?></td>
                        <td><?php echo $product ? htmlspecialchars($product['nom']) : 'N/A'; ?></td>
                        <td>
                            <?php if ($product && $product['image']): ?>
                                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($order['Qte_com']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune commande trouvée.</p>
    <?php endif; ?>
</div>
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
document.addEventListener('DOMContentLoaded', function() {
    let currentOpenForm = null;

    document.querySelectorAll('.edit-role').forEach(function(editIcon) {
        editIcon.addEventListener('click', function(event) {
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
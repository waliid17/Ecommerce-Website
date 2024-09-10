<?php
require 'check_user.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user-id'])) {
    header("Location: login.php");
    exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$user_id = $_SESSION['user-id'];
$sql = "SELECT `prenom`, `nom`, `email`, `telephone`, `adresse` FROM client WHERE `id_client` = ?";
$stmt = $connection->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName, $email, $phoneNumber, $addressLine);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error preparing statement: " . $connection->error;
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    <!-- bottom header -->
                    <div class="">
                        <div class="bottom-header container">
                            <ul class="main-menu">
                                <li><a href="index.php">ACCUEIL</a></li>
                                <!-- mega menu -->
                                <li class="mega-dropdown">
                                    <a href="./products.php">OUTILS</a>
                                </li>
                                <!-- end mega menu -->
                                <li><a href="index.php#about">à propos</a></li>
                                <li><a href="index.php#contact">contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- end bottom header -->
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
                <button class="tablink" onclick="openTab(event, 'Wishlist')">Panier</button>
                <button class="tablink" onclick="openTab(event, 'statuts')">statuts</button>
            </div>
            <div id="PersonalInfo" class="tabcontent active">
                <h2>Informations Personnelles :</h2>

                <form class="contact-form" method="post" action="user_edit.php">
                    <!-- Nom -->
                    <div class="input-group">
                        <div class="input-container">
                            <div class="icon"><i class="fas fa-user"></i></div>
                            <input type="text" name="nom" value="<?php echo htmlspecialchars($lastName); ?>"
                                placeholder="Nom" required readonly>
                            <div class="edit-icon" onclick="toggleEdit('nom')"><i class="fa-solid fa-pen"></i></div>
                        </div>
                    </div>

                    <!-- Prénom -->
                    <div class="input-group">
                        <div class="input-container">
                            <div class="icon"><i class="fas fa-user"></i></div>
                            <input type="text" name="prenom" value="<?php echo htmlspecialchars($firstName); ?>"
                                placeholder="Prénom" required readonly>
                            <div class="edit-icon" onclick="toggleEdit('prenom')"><i class="fa-solid fa-pen"></i></div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="input-group">
                        <div class="input-container">
                            <div class="icon"><i class="fas fa-envelope"></i></div>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"
                                placeholder="Adresse e-mail" required readonly>
                            <div class="edit-icon" onclick="toggleEdit('email')"><i class="fa-solid fa-pen"></i></div>
                        </div>
                    </div>

                    <!-- Téléphone -->
                    <div class="input-group">
                        <div class="input-container">
                            <div class="icon"><i class="fas fa-phone"></i></div>
                            <input type="tel" name="telephone" value="<?php echo htmlspecialchars($phoneNumber); ?>"
                                placeholder="Numéro de téléphone" required pattern="[0-9]{10}" readonly>
                            <div class="edit-icon" onclick="toggleEdit('telephone')"><i class="fa-solid fa-pen"></i>
                            </div>
                        </div>
                    </div>

                    <!-- adresse -->
                    <div class="input-group">
                        <div class="input-container">
                            <div class="icon"><i class="fa-solid fa-location-dot"></i></div>
                            <input type="text" name="adresse" value="<?php echo htmlspecialchars($addressLine); ?>"
                                placeholder="adresse" required readonly>
                            <div class="edit-icon" onclick="toggleEdit('adresse')"><i class="fa-solid fa-pen"></i></div>
                        </div>
                    </div>
                    <input type="submit" name="save1" value="Save" class="submit-btn">
                </form>
            </div>
            <div id="Wishlist" class="tabcontent">
                <h2>Panier</h2>
                <form id="wishlistForm">
                    <ul id="wishlistItems" class="wishlist-items">
                        <!-- Wishlist items will be dynamically inserted here -->
                    </ul>
                    <div id="wishlistTotal" class="wishlist-total">
                        <!-- Total price will be displayed here -->
                    </div>
                    <!-- New button to show the delivery form -->
                    <button id="showDeliveryForm" type="button" class="btn-confirm">Passer à la commande</button>
                </form>
            </div>

            <!-- Delivery Form Section -->
            <div id="deliveryFormContainer" class="tabcontent" style="display:none;">
                <!-- Back to Panier button -->
                <button id="backToWishlist" type="button" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Retour au panier
                </button>
                <h2>Livraison</h2>
                <form id="deliveryForm">
                    <div class="form-group">
                        <label for="wilaya">Wilaya de livraison:</label>
                        <select id="wilaya" name="wilaya" class="form-control" required>
                            <option value="">Sélectionnez votre wilaya</option>
                            <?php
                            $query = "SELECT * FROM wilaya";
                            $result = $connection->query($query); // Assuming $conn is your MySQLi connection
                            
                            // Loop through each wilaya and create an <option> element
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option wilaya-price="' . $row['delivery_price'] . '" value="' . $row['id_wilaya'] . '">' . $row['wilaya'] . '</option>';
                                }
                            } else {
                                echo '<option value="">No wilayas found</option>';
                            }
                            $connection->close();
                            ?>
                        </select>
                    </div>
                    <div id="deliveryPrice" class="delivery-price">
                        <!-- Delivery price based on the selected Wilaya will be displayed here -->
                    </div>
                    <div class="form-group">
                        <label for="address">Adresse de livraison:</label>
                        <input type="text" id="address" name="address" class="form-control"
                            placeholder="Entrez votre adresse" required>
                    </div>
                    <!-- Total price including delivery will be displayed here -->
                    <div id="deliveryTotal" class="delivery-total"></div>
                    <!-- Confirm order button -->
                    <button id="confirmOrder" type="button" class="btn-confirm">Commander</button>
                </form>
            </div>


            <script>
                // Function to update total price including delivery
                function updateTotalPrice() {
                    const wilaya = document.getElementById('wilaya');
                    var selectedOption = wilaya.options[wilaya.selectedIndex];
                    var wilayaPrice = selectedOption.getAttribute('wilaya-price');
                    const deliveryPrice = wilayaPrice ? wilayaPrice : 0;
                    document.getElementById('deliveryPrice').innerText = `Prix de livraison: ${deliveryPrice} DA`;

                    // Calculate the total price of wishlist items
                    const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                    let totalPrice = wishlist.reduce((total, item) => total + (item.price * item.quantity), 0);

                    // Add delivery price to the total price
                    const totalWithDelivery = parseFloat(totalPrice) + parseFloat(deliveryPrice);

                    // Update the total price display on the delivery form
                    const deliveryFormTotalContainer = document.getElementById('deliveryTotal');
                    deliveryFormTotalContainer.innerHTML = `
            <h3>Total avec livraison: <span class="total-price">${totalWithDelivery.toFixed(2)} DA</span></h3>
        `;
                }
                // Event listener for "Retour au panier" button
                document.getElementById('backToWishlist').addEventListener('click', function () {
                    // Show the wishlist and hide the delivery form
                    document.getElementById('Wishlist').style.display = 'block';
                    document.getElementById('deliveryFormContainer').style.display = 'none';

                    // Change the active tab to 'Panier'
                    openTab({ currentTarget: document.querySelector(".tablink[onclick*='Wishlist']") }, 'Wishlist');
                });

            </script>
            <?php

            if (!isset($_SESSION['user-id'])) {
                die("User not logged in.");
            }

            $client_id = $_SESSION['user-id'];
            $connection = new mysqli("localhost", "root", "", "base");

            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            // Fetch the client's commands
            $stmt = $connection->prepare("
    SELECT c.id_com, c.date_com
    FROM commande c
    JOIN effectuer_com e ON c.id_com = e.id_com
    WHERE e.id_client = ?
");
            $stmt->bind_param("i", $client_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $orders = $result->fetch_all(MYSQLI_ASSOC);

            $stmt->close();
            $connection->close();
            ?>

            <!-- HTML to Display the Orders -->
            <div id="statuts" class="tabcontent">
                <h2 class="order-status-title">Suivi de votre commande</h2>
                <table class="order-status-table">
                    <thead>
                        <tr>
                            <th class="order-status-header">ID Commande</th>
                            <th class="order-status-header">Date</th>
                            <th class="order-status-header">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr class="order-status-row">
                                <td class="order-status-cell"><?php echo htmlspecialchars($order['id_com']); ?></td>
                                <td class="order-status-cell"><?php echo htmlspecialchars($order['date_com']); ?></td>
                                <td class="order-status-cell">
                                    <button class="order-status-button"
                                        onclick="showStatus(<?php echo htmlspecialchars($order['id_com']); ?>)">Voir le
                                        statut</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Order Status Modal -->
            <div id="orderStatusModal" class="status-modal">
                <div class="status-modal-content">
                    <span class="status-close">&times;</span>
                    <h2>Suivi de votre commande</h2>
                    <div class="status-progress">
                        <div class="status-step" data-status="En attente">
                            <div class="status-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <p>En attente</p>
                        </div>
                        <div class="status-step" data-status="Confirmée">
                            <div class="status-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <p>Confirmée</p>
                        </div>
                        <div class="status-step" data-status="Expédiée">
                            <div class="status-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <p>Expédiée</p>
                        </div>
                        <div class="status-step" data-status="Livrée">
                            <div class="status-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <p>Livrée</p>
                        </div>
                        <div class="status-step" data-status="Annulée">
                            <div class="status-icon">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <p>Annulée</p>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function showStatus(orderId) {
                    // Fetch the status via AJAX
                    fetch(`getOrderStatus.php?id=${orderId}`)
                        .then(response => response.json())
                        .then(data => {
                            const orderStatus = data.status;
                            const statusOrder = ['En attente', 'Confirmée', 'Expédiée', 'Livrée', 'Annulée'];
                            const steps = document.querySelectorAll('.status-step');

                            const updateStatusSteps = (steps, orderStatus) => {
                                steps.forEach(step => {
                                    const stepStatus = step.getAttribute('data-status');
                                    const stepIndex = statusOrder.indexOf(stepStatus);
                                    const orderIndex = statusOrder.indexOf(orderStatus);

                                    // Reset classes
                                    step.classList.remove('active', 'cancelled', 'pending');

                                    if (orderStatus === 'Annulée') {
                                        step.classList.add('cancelled');
                                        if (stepIndex < statusOrder.indexOf('Annulée')) {
                                            step.style.opacity = 0.5; // Dim all previous steps
                                        }
                                    } else if (stepIndex <= orderIndex) {
                                        step.classList.add('active');
                                    }

                                    if (stepStatus === 'En attente') {
                                        step.classList.add('pending');
                                    }
                                });
                            };

                            updateStatusSteps(steps, orderStatus);

                            // Display the modal with fade-in effect
                            const modal = document.getElementById('orderStatusModal');
                            modal.style.display = 'flex'; // Use flexbox to center
                            setTimeout(() => modal.style.opacity = 1, 10); // Trigger fade-in effect
                        })
                        .catch(error => console.error('Error:', error));
                }

                // Close the modal
                document.querySelector('.status-close').addEventListener('click', () => {
                    const modal = document.getElementById('orderStatusModal');
                    modal.style.opacity = 0;
                    setTimeout(() => modal.style.display = 'none', 300); // Ensure transition ends before hiding
                });

                // Close the modal when clicking outside
                window.addEventListener('click', (event) => {
                    if (event.target === document.getElementById('orderStatusModal')) {
                        const modal = document.getElementById('orderStatusModal');
                        modal.style.opacity = 0;
                        setTimeout(() => modal.style.display = 'none', 300); // Ensure transition ends before hiding
                    }
                });

            </script>



            <!-- FontAwesome for icons -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

            <!-- Scripts -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                // Function to render the wishlist items
                function renderWishlist() {
                    const wishlistItemsContainer = document.getElementById('wishlistItems');
                    const wishlistTotalContainer = document.getElementById('wishlistTotal');
                    const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                    wishlistItemsContainer.innerHTML = ''; // Clear existing items

                    let totalPrice = 0;

                    wishlist.forEach(item => {
                        totalPrice += item.price * item.quantity; // Calculate total price

                        const itemElement = document.createElement('li');
                        itemElement.className = 'wishlist-item';
                        itemElement.innerHTML = `
            <img src="${item.image}" alt="${item.name}">
            <div class="item-details">
                <h3>${item.name}</h3>
                <p>Prix: <span class="item-price">${(item.price * item.quantity).toFixed(2)} DA</span></p>
                Quantité :
                <div class="quantity-controls">
                    <button class="quantity-btn minus" data-id="${item.id}">-</button>
                    <input type="number" class="item-quantity" value="${item.quantity}" min="1" data-id="${item.id}">
                    <button class="quantity-btn plus" data-id="${item.id}">+</button>
                </div>
            </div>
            <div class="item-actions">
                <button type="button" onclick="removeItem(${item.id})">Supprimer</button>
            </div>
        `;
                        wishlistItemsContainer.appendChild(itemElement);
                    });

                    // Display the total price
                    wishlistTotalContainer.innerHTML = `
        <h3>Total: <span class="total-price">${totalPrice.toFixed(2)} DA</span></h3>
    `;

                    // Attach event listeners to quantity buttons
                    document.querySelectorAll('.quantity-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            const itemId = parseInt(this.getAttribute('data-id'));
                            const action = this.classList.contains('plus') ? 'increase' : 'decrease';
                            updateQuantity(itemId, action);
                        });
                    });

                    // Attach event listeners to quantity inputs
                    document.querySelectorAll('.item-quantity').forEach(input => {
                        input.addEventListener('change', function () {
                            const itemId = parseInt(this.getAttribute('data-id'));
                            const newQuantity = parseInt(this.value);
                            updateQuantity(itemId, newQuantity);
                        });
                    });

                    // Attach event listener to the "Commander" button
                    document.getElementById('confirmOrder').addEventListener('click', function () {
                        confirmOrder();
                    });
                }

                // Function to update the quantity and price of an item
                function updateQuantity(itemId, actionOrNewQuantity) {
                    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                    wishlist = wishlist.map(item => {
                        if (item.id === itemId) {
                            if (typeof actionOrNewQuantity === 'string') {
                                item.quantity = actionOrNewQuantity === 'increase' ? item.quantity + 1 : Math.max(item.quantity - 1, 1);
                            } else {
                                item.quantity = actionOrNewQuantity;
                            }
                            item.price = item.price;
                        }
                        return item;
                    });
                    localStorage.setItem('wishlist', JSON.stringify(wishlist));
                    renderWishlist();
                    window.location.href = 'go_to_wishlist.php';
                }

                // Function to remove an item from the wishlist
                function removeItem(itemId) {
                    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                    wishlist = wishlist.filter(item => item.id !== itemId);
                    localStorage.setItem('wishlist', JSON.stringify(wishlist));
                    renderWishlist();
                }

                // Function to handle order confirmation
                function confirmOrder() {
                    const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

                    if (wishlist.length === 0) {
                        Swal.fire({
                            title: 'Votre panier est vide',
                            text: 'Veuillez ajouter des articles à votre panier avant de continuer.',
                            icon: 'warning',
                            confirmButtonText: 'D\'accord',
                            confirmButtonColor: '#ff840a', // Your preferred button color
                            background: '#fff', // Background color
                            color: '#333' // Text color
                        });
                        return; // Prevent showing the delivery form and stay on the wishlist page
                    }

                    const wilayaSelect = document.getElementById('wilaya');
                    const selectedWilaya = wilayaSelect.value;

                    if (selectedWilaya === '') {
                        Swal.fire({
                            title: 'Sélection nécessaire',
                            text: 'Veuillez sélectionner votre wilaya.',
                            icon: 'warning',
                            confirmButtonText: 'D\'accord',
                            confirmButtonColor: '#ff840a', // Your preferred button color
                            background: '#fff', // Background color
                            color: '#333' // Text color
                        });
                        return;
                    }

                    // Collect items for the order
                    const items = wishlist.map(item => ({
                        id_com: null, // This will be set on the server
                        id_outil: item.id,
                        Qte_com: item.quantity
                    }));
                    var wilayaId = document.getElementById('wilaya').options[document.getElementById('wilaya').selectedIndex].value;
                    var data = {
                        wilayaId: wilayaId,
                        userId: <?= $user_id ?>
                    };

                    async function createOrderAndAddItems(data, items) {
                        try {
                            // Send order data to the server
                            const orderResponse = await fetch('createOrder.php', {
                                method: 'POST',
                                body: JSON.stringify(data) // Ensure this is properly handled in PHP
                            });

                            const orderData = await orderResponse.json();

                            if (orderData.orderId) {
                                // Assign orderId to each item
                                const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                                const items = wishlist.map(item => ({
                                    id_com: null, // This will be set on the server
                                    id_outil: item.id,
                                    Qte_com: item.quantity
                                }));
                                items.forEach(item => {
                                    item.id_com = orderData.orderId;
                                });

                                // Send items data to the server
                                const itemsResponse = await fetch('addItemsToOrder.php', {
                                    method: 'POST',
                                    body: JSON.stringify({ items })
                                });

                                const itemsData = await itemsResponse.json();

                                if (itemsData.status === 'success') {
                                    // Clear wishlist from localStorage
                                    localStorage.removeItem('wishlist');

                                    // Show success message
                                    await Swal.fire({
                                        title: 'Commande confirmée',
                                        text: 'Votre commande a été confirmée avec succès.',
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#ff840a', // Your preferred button color
                                        background: '#fff', // Background color
                                        color: '#333' // Text color
                                    });

                                    // Redirect to the homepage
                                    window.location.href = "index.php";
                                } else {
                                    throw new Error('Failed to add items to order.');
                                }

                                // Clear the wishlist display
                                renderWishlist();
                            } else {
                                throw new Error('Failed to create order.');
                            }
                        } catch (error) {
                            console.error('Error:', error);

                            // Show error message
                            await Swal.fire({
                                title: 'Erreur',
                                text: 'Une erreur s\'est produite lors de la confirmation de votre commande.',
                                icon: 'error',
                                confirmButtonText: 'D\'accord',
                                confirmButtonColor: '#ff840a', // Your preferred button color
                                background: '#fff', // Background color
                                color: '#333' // Text color
                            });
                        }
                    }

                    // Example usage
                    createOrderAndAddItems(data, items);
                }

                // Event listener for "Passer à la commande" button
                document.getElementById('showDeliveryForm').addEventListener('click', function () {
                    const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                    if (wishlist.length === 0) {
                        Swal.fire({
                            title: 'Votre panier est vide',
                            text: 'Veuillez ajouter des articles à votre panier avant de continuer.',
                            icon: 'warning',
                            confirmButtonText: 'D\'accord',
                            confirmButtonColor: '#ff840a', // Your preferred button color
                            background: '#fff', // Background color
                            color: '#333' // Text color
                        });
                        return;
                    }

                    // Proceed with showing the delivery form
                    document.getElementById('Wishlist').style.display = 'none';
                    document.getElementById('deliveryFormContainer').style.display = 'block';
                    updateTotalPrice(); // Ensure total price is updated when showing the delivery form
                });

                // Event listener for wilaya change
                document.getElementById('wilaya').addEventListener('change', function () {
                    updateTotalPrice(); // Update total price when wilaya is changed
                });

                // Initial render
                document.addEventListener("DOMContentLoaded", function () {
                    renderWishlist();

                    const hash = window.location.hash;
                    if (hash) {
                        // Remove hash from URL
                        history.replaceState(null, null, 'user.php');

                        // Open the specific tab
                        const tabName = hash.substring(1); // Get the tab name without '#'
                        openTab({ currentTarget: document.querySelector(`.tablink[onclick*='${tabName}']`) }, tabName);
                    }
                });

                // Function to open tabs
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

                // Handle input field editing
                let currentlyEditing = null;

                function toggleEdit(name) {
                    // Get the input field and its corresponding edit icon
                    const input = document.querySelector(`input[name="${name}"]`);
                    const inputContainer = input.closest('.input-container');

                    // If there is another field currently being edited, reset it
                    if (currentlyEditing && currentlyEditing !== input) {
                        currentlyEditing.setAttribute('readonly', true);
                        currentlyEditing.classList.remove('edit-mode');
                    }

                    // Toggle the readonly attribute and edit mode for the clicked field
                    if (input.hasAttribute('readonly')) {
                        input.removeAttribute('readonly');
                        input.focus();
                        input.classList.add('edit-mode');
                        currentlyEditing = input;
                    } else {
                        input.setAttribute('readonly', true);
                        input.classList.remove('edit-mode');
                        currentlyEditing = null;
                    }
                }

            </script>
</body>

</html>
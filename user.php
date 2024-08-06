<?php
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
                                <li><a href="#">à propos</a></li>
                                <li><a href="#">SERVICES</a></li>
                                <li><a href="#">contact</a></li>
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
                <button class="tablink" onclick="openTab(event, 'Address')">Adresse</button>
            </div>
            <div id="PersonalInfo" class="tabcontent active">
                <h2>Informations Personnelles</h2>

                <form class="contact-form" method="post" action="user_edit.php">
                    <div class="input-group">
                        <div class="input-container">
                            <div class="icon"><i class="fas fa-user"></i></div>
                            <input type="text" name="nom" value="<?php echo htmlspecialchars($lastName); ?>"
                                placeholder="Nom" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-container">
                            <div class="icon"><i class="fas fa-user"></i></div>
                            <input type="text" name="prenom" value="<?php echo htmlspecialchars($firstName); ?>"
                                placeholder="Prénom" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-container">
                            <div class="icon"><i class="fas fa-envelope"></i></div>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"
                                placeholder="Adresse e-mail" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-container">
                            <div class="icon"><i class="fas fa-phone"></i></div>
                            <input type="tel" name="telephone" value="<?php echo htmlspecialchars($phoneNumber); ?>"
                                placeholder="Numéro de téléphone" required pattern="[0-9]{10}">
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
                    <button id="confirmOrder" type="button" class="btn-confirm">Commander</button>
                </form>
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
                    // Ensure price is correctly updated, if needed
                    item.price = item.price;
                }
                return item;
            });
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            renderWishlist();
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
                alert('Votre panier est vide.');
                return;
            }

            // Collect items for the order
            const items = wishlist.map(item => ({
                id_com: null, // This will be set on the server
                id_outil: item.id,
                Qte_com: item.quantity
            }));

            // Send order data to the server
            fetch('createOrder.php', {
                method: 'POST',
                body: JSON.stringify({ userId: <?= $user_id ?> })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.orderId) {
                        items.forEach(item => {
                            item.id_com = data.orderId;
                        });

                        return fetch('addItemsToOrder.php', {
                            method: 'POST',
                            body: JSON.stringify({ items })
                        });
                    } else {
                        throw new Error('Failed to create order.');
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        localStorage.removeItem('wishlist');
                        alert('Votre commande a été confirmée avec succès.');
                        renderWishlist(); // Clear the wishlist display
                    } else {
                        throw new Error('Failed to add items to order.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur s\'est produite lors de la confirmation de votre commande.');
                });
        }

        // Initial render
        renderWishlist();


    </script>
</body>

</html>
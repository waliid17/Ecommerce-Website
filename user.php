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
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <i class='bx bx-search-alt'></i>
                    </div>
                    <ul class="user-menu">
                        <li><a href="#"><i class='bx bx-bell'></i></a></li>
                        <li><a id="showDivButton" href="#"><i class='bx bx-user-circle'></i></a></li>
                        <li><a href="#"><i class='bx bx-cart'></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php"); // Redirect to login if user is not logged in
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
    // Default null values to empty strings
    $firstName = $firstName ?? '';
    $lastName = $lastName ?? '';
    $email = $email ?? '';
    $phoneNumber = $phoneNumber ?? '';
    $addressLine = $addressLine ?? '';
    $user_id = $_SESSION['user_id']; // Get user ID from session
    $sql = "SELECT `first-name`, `last-name`, email, `phone_number`, `address_line` FROM utilisateur WHERE id = ?";
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

    $connection->close();
    ?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profil Utilisateur</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <div class="profile-container">
            <div class="profile-header">
                <h1 class="user-name"><?php echo htmlspecialchars($firstName . " " . $lastName); ?></h1>
                <p class="user-email"><?php echo htmlspecialchars($email); ?></p>
            </div>
            <div class="profile-body">
                <div class="tabs">
                    <button class="tablink active" onclick="openTab(event, 'PersonalInfo')">Informations
                        Personnelles</button>
                    <button class="tablink" onclick="openTab(event, 'Wishlist')">Liste de Souhaits</button>
                    <button class="tablink" onclick="openTab(event, 'Address')">Adresse</button>
                </div>
                <div id="PersonalInfo" class="tabcontent active">
                    <h2>Informations Personnelles</h2>
                    <form class="form" method="post" action="user_edit.php">
                        <div class="form-group">
                            <label for="name">Nom :</label>
                            <input type="text" id="name" name="lastname"
                                value="<?php echo htmlspecialchars($lastName); ?>" required>
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
                            <input type="tel" id="phone" name="phone"
                                value="<?php echo htmlspecialchars($phoneNumber); ?>" required>
                        </div>
                        <button type="submit" name="save1" class="save-btn">Save</button>
                    </form>
                </div>
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
            </div>
        </div>
    </body>

    </html>

</body>

</html>

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
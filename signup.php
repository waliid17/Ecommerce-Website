<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pro-outil</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .swal2-popup {
            font-family: 'Arial', sans-serif;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .swal2-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .swal2-content {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 1rem;
        }
        .swal2-confirm {
            background-color: #007bff;
            border: 2px solid #0056b3;
            color: #fff;
            border-radius: 8px;
            font-size: 1.1rem;
            padding: 12px 24px;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .swal2-confirm:hover {
            background-color: #0056b3;
            border-color: #004080;
        }
        .swal2-icon {
            border-color: #007bff;
            color: #007bff;
        }
        .swal2-popup .swal2-icon {
            border-width: 2px;
        }
        .swal2-container {
            padding: 20px;
        }
    </style>
</head>

<body></body>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$firstname = $_POST['prenom'];
$lastname = $_POST['nom'];
$email = $_POST['email'];
$password = $_POST['mot_de_passe'];
$confirm_password = $_POST['confirm_password'];
$phone_number = $_POST['telephone'];
$address_line = $_POST['adresse'];

$errors = array();

if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_password) || empty($phone_number) || empty($address_line)) {
    $errors[] = "Veuillez remplir tous les champs.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format d'email invalide.";
}

if ($password !== $confirm_password) {
    $errors[] = "Les mots de passe ne correspondent pas.";
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
} else {
    $query = $connection->prepare("INSERT INTO client (`prenom`, `nom`, `email`, `mot_de_passe`, `telephone`, `adresse`) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssssss", $firstname, $lastname, $email, $password, $phone_number, $address_line);

    if ($query->execute()) {
        echo '<script>
            Swal.fire({
                title: "Compte créé !",
                text: "Votre compte a été créé avec succès.",
                icon: "success",
                iconColor: "#007bff", // Icon color
                confirmButtonText: "OK",
                confirmButtonColor: "#007bff", // Button color
                customClass: {
                    title: "swal2-title",
                    content: "swal2-content",
                    confirmButton: "swal2-confirm",
                    icon: "swal2-icon"
                },
                didClose: () => {
                    window.location.href = "login_signup.html";
                }
            });
        </script>';
    } else {
        echo "Error: " . $query->error;
    }

    if (isset($query)) {
        $query->close();
    }
}

$connection->close();
?>

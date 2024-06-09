<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pro-outi</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
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
        echo "<script>
                Swal.fire({
                  title: 'Compte créé !',
                  text: 'Votre compte a été créé avec succès.',
                  icon: 'success',
                  confirmButtonText: 'OK',
                  didClose: () => {
                    window.location.href = 'login_signup.html';
                  }
                });
              </script>";
    } else {

        echo "Error: " . $query->error;
    }
}

if (isset($query)) {
    $query->close();
}
$connection->close();
?>
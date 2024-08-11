<?php
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed']);
    exit();
}

$firstname = $_POST['prenom'] ?? '';
$lastname = $_POST['nom'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['mot_de_passe'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$phone_number = $_POST['telephone'] ?? '';
$address_line = $_POST['adresse'] ?? '';

if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_password) || empty($phone_number) || empty($address_line)) {
    echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs.']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Format d\'email invalide.']);
    exit();
}

if ($password !== $confirm_password) {
    echo json_encode(['status' => 'error', 'message' => 'Les mots de passe ne correspondent pas.']);
    exit();
}

$query = $connection->prepare("INSERT INTO client (prenom, nom, email, mot_de_passe, telephone, adresse) VALUES (?, ?, ?, ?, ?, ?)");
$query->bind_param("ssssss", $firstname, $lastname, $email, $password, $phone_number, $address_line);

if ($query->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Votre compte a été créé avec succès.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la création du compte.']);
}

$query->close();
$connection->close();
?>

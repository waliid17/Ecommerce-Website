<?php
session_start();

if (!isset($_SESSION['user-id'])) {
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
if (isset($_POST['save1'])) {

    $firstname = $_POST['prenom'];
    $lastname = $_POST['nom'];
    $email = $_POST['email'];
    $phonenumber = $_POST['telephone'];
    $id = $_SESSION['user-id'];
    $query = "UPDATE `client` SET `prenom` = '$firstname',`nom` = '$lastname', `email` = '$email', `telephone` = '$phonenumber' WHERE `client`.`id_client` = $id";
    if ($connection->query($query)) {
        header("Location: user.php");
        exit();
    } else {
        echo "404";
    }

} elseif (isset($_POST['save2'])) {

    $address = $_POST['adresse'];
    $id = $_SESSION['user-id'];
    $query = "UPDATE `client` SET `adresse` = '$address' WHERE `client`.`id_client` = $id";
    if ($connection->query($query)) {
        header("Location: user.php");
        exit();
    } else {
        echo "404";
    }

} else {

    echo "Form was submitted but neither button was clicked!";
}
?>
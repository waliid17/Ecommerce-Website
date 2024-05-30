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
if (isset($_POST['save1'])) {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phone'];
    $id = $_SESSION['user_id'];
    $query = "UPDATE `utilisateur` SET `first-name` = '$firstname',`last-name` = '$lastname', `email` = '$email', `phone_number` = '$phonenumber' WHERE `utilisateur`.`id` = $id";
    if ($connection->query($query)) {
        header("Location: user.php");
        exit();
    } else {
        echo "404";
    }

} elseif (isset($_POST['save2'])) {

    $address = $_POST['address'];
    $id = $_SESSION['user_id'];
    $query = "UPDATE `utilisateur` SET `address_line` = '$address' WHERE `utilisateur`.`id` = $id";
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
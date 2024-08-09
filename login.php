<?php
$connection = new mysqli("localhost", "root", "", "base");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
$password = $_POST['mot_de_passe'];
$email = $_POST['email'];

$query = "SELECT `email`,`mot_de_passe`,`id_client` FROM `client` WHERE email='$email'";
$result = $connection->query($query);
if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($password == $row['mot_de_passe']) {
        session_start();
        $_SESSION['user-id'] = $row['id_client'];
        header("Location: /pro-outil/");
    } else {
        echo "mot de passe incorrect";
    }
} else {
    echo "créer un compte";
}
?>
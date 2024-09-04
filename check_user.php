<?php
$connection = new mysqli("localhost", "root", "", "base");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user-id'])) {
    include 'create_account_template.php';
    exit();
}

$id_client = $_SESSION['user-id'];
$query = "SELECT `activation` FROM `client` WHERE id_client = $id_client";
$result = $connection->query($query);

if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($row['activation'] == 0) {
        include 'resend_activation.html';
        exit();
    }
} else {
    header("Location: login_signup.html");
    exit();
}
?>

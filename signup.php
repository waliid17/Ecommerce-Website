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

// Collect POST data
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$phone_number = $_POST['phone_number'];
$address_line = $_POST['address_line'];

// Validate inputs
if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_password) || empty($phone_number) || empty($address_line)) {
    die("Please fill in all fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

if ($password !== $confirm_password) {
    die("Passwords do not match.");
}
// Prepare and bind
$query = $connection->prepare("INSERT INTO utilisateur (`first-name`, `last-name`, `email`, `password`, `phone_number`, `address_line`) VALUES (?, ?, ?, ?, ?, ?)");
$query->bind_param("ssssss", $firstname, $lastname, $email, $password, $phone_number, $address_line);

// Execute the statement
if ($query->execute()) {
    echo "New record created successfully. Last inserted ID is: " . $connection->insert_id;
} else {
    echo "Error: " . $query->error;
}

// Close connections
$query->close();
$connection->close();
?>
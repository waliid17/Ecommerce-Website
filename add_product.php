<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO products (name, prod_desc, old_price, curr_price, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdds", $name, $prod_desc, $old_price, $curr_price, $image);

    // Set parameters and execute
    $name = $_POST['name'];
    $prod_desc = $_POST['prod_desc'];
    $old_price = $_POST['old_price'];
    $curr_price = $_POST['curr_price'];
    $image = $_FILES['image']['name'];

    // Move uploaded file to desired location
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // Execute prepared statement
    $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

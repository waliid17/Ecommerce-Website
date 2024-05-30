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
    $stmt = $conn->prepare("INSERT INTO products (name, prod_desc, old_price, curr_price, image, image2, image3, brand) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddssss", $name, $prod_desc, $old_price, $curr_price, $image, $image2, $image3, $brand);

    // Set parameters and execute
    $name = $_POST['name'];
    $prod_desc = $_POST['prod_desc'];
    $old_price = $_POST['old_price'];
    $curr_price = $_POST['curr_price'];
    $brand = $_POST['brand'];

    // Handle file uploads
    $target_dir = "uploads/";
    $image = basename($_FILES["image"]["name"]);
    $image2 = basename($_FILES["image2"]["name"]);
    $image3 = basename($_FILES["image3"]["name"]);

    $target_file_image = $target_dir . $image;
    $target_file_image2 = $target_dir . $image2;
    $target_file_image3 = $target_dir . $image3;

    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file_image);
    move_uploaded_file($_FILES["image2"]["tmp_name"], $target_file_image2);
    move_uploaded_file($_FILES["image3"]["tmp_name"], $target_file_image3);

    // Execute prepared statement
    $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
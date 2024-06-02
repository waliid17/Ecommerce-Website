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
    $stmt = $conn->prepare("INSERT INTO products (name, prod_desc, old_price, curr_price, image, brand) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddss", $name, $prod_desc, $old_price, $curr_price, $image, $brand);

    // Set parameters and execute
    $name = $_POST['name'];
    $prod_desc = $_POST['prod_desc'];
    $old_price = $_POST['old_price'];
    $curr_price = $_POST['curr_price'];
    $brand = $_POST['brand'];

    // Handle file uploads
    $target_dir = "uploads/";
    $image = basename($_FILES["image"]["name"]);

    $target_file_image = $target_dir . $image;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file_image)) {
        // Execute prepared statement
        $stmt->execute();
        echo "Product added successfully";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
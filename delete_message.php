<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID parameter is passed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Sanitize and validate the ID
    $id = $_POST['id'];

    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM message WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Attempt to execute the statement
    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    // Handle invalid requests or redirect
    echo "Invalid request";
}

// Close connection
$conn->close();
?>
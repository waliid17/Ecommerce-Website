<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_outil'])) {
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "base";

    // Establishing connection
    $connection = new mysqli($servername, $username, $password, $dbname);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Prepare and bind parameters
    $stmt = $connection->prepare("DELETE FROM `outil` WHERE `id_outil`=?");
    $stmt->bind_param("i", $id_outil);

    // Set parameters and execute
    $id_outil = $_POST['id_outil'];

    // Execute the delete
    if ($stmt->execute()) {
        header("Location: ./admin/admin.php"); // Redirect back to user.php or any other page
    } else {
        echo "Error deleting product: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $connection->close();
} else {
    // Handle invalid request or direct access attempts
    echo "Invalid request";
}
?>
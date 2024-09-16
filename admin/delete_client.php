<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_client'])) {
    $id_client = intval($_POST['id_client']); // Sanitize the input

    $sql = "DELETE FROM client WHERE id_client = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_client);
        if ($stmt->execute()) {
            // Pass the target ID and success message in the URL
            echo "<script>
                    window.location.href='admin.php?message=success&targetId=users-content';
                  </script>";
        } else {
            echo "Error deleting client: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "SQL error: " . $conn->error;
    }
}

$conn->close();
?>

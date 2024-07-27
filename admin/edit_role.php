<?php
// edit_role.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base";

// Create a new connection to the database
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle POST request to update role
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_client = intval($_POST['id_client']);
    $new_role = $_POST['role'];

    if (in_array($new_role, ['admin', 'user'])) {
        $stmt = $connection->prepare("UPDATE client SET role = ? WHERE id_client = ?");
        $stmt->bind_param('si', $new_role, $id_client);
        
        if ($stmt->execute()) {
            header("Location: http://localhost/pro-outil/admin/admin.php"); // Redirect back to the dashboard
            exit();
        } else {
            die("Error updating role: " . $stmt->error);
        }
    } else {
        die("Invalid role selected.");
    }
    
    $stmt->close();
    $connection->close();
    exit();
}

// Handle GET request to display the form
$id_client = intval($_GET['id']);

// Fetch current role for display
$stmt = $connection->prepare("SELECT role FROM client WHERE id_client = ?");
$stmt->bind_param('i', $id_client);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $current_role = $result->fetch_assoc()['role'];
    // Display the form with the current role selected
    echo "<h2>Edit Role</h2>
          <form action='edit_role.php' method='POST'>
              <input type='hidden' name='id_client' value='{$id_client}'>
              <label for='role'>Select New Role:</label>
              <select id='role' name='role' required>
                  <option value='admin' ".($current_role == 'admin' ? 'selected' : '').">Admin</option>
                  <option value='user' ".($current_role == 'user' ? 'selected' : '').">User</option>
              </select>
              <button type='submit'>Update Role</button>
          </form>";
} else {
    echo "Client not found.";
}

$stmt->close();
$connection->close();
?>

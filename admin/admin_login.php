<?php
// Database connection
$connection = new mysqli("localhost", "root", "", "base");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Retrieve POST data
$email = $_POST['admin_email'];
$password = $_POST['admin_password'];

// Prepare and execute query
$query = $connection->prepare("SELECT `id_ad`, `pwd_ad` FROM `admin` WHERE email_ad = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

// Check if email exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verify password
    if ($password === $row['pwd_ad']) {
        // Start session and set session variables
        session_start();
        $_SESSION['admin-id'] = $row['id_ad'];

        // Redirect to admin dashboard
        header("Location: /pro-outil/admin/admin.php");
        exit();
    } else {
        // Redirect back to login page with error
        header("Location: admin_login.html?error=mdp");
        exit();
    }
} else {
    // Redirect back to login page with error
    header("Location: admin_login.html?error=email");
    exit();
}
?>

<?php
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

// Handle AJAX request to add a category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nom_cat'])) {
    $nom_cat = $conn->real_escape_string($_POST['nom_cat']); // Escape user input

    // Insert the new category
    $sql = "INSERT INTO categorie (nom_cat) VALUES ('$nom_cat')";

    $response = [];
    if ($conn->query($sql) === TRUE) {
        $response = ['success' => true, 'message' => 'Catégorie ajoutée avec succès.'];
    } else {
        $response = ['success' => false, 'message' => 'Error adding category.'];
    }

    // Close connection
    $conn->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>

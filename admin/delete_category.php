<?php
if (isset($_GET['id_cat'])) {
    $id_cat = $_GET['id_cat'];
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

    // Delete the category
    $sql = "DELETE FROM categorie WHERE id_cat = $id_cat";

    $response = [];
    if ($conn->query($sql) === TRUE) {
        $response = ['success' => true, 'message' => 'La catégorie a été supprimée avec succès.'];
    } else {
        $response = ['success' => false, 'message' => 'Une erreur est survenue lors de la suppression.'];
    }

    // Close connection
    $conn->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>

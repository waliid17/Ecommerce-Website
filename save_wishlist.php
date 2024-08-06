<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base";

$connexion = new mysqli($servername, $username, $password, $dbname);

if ($connexion->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get the JSON input
$input = file_get_contents('php://input');

print_r($_POST);  // or var_dump($_POST);

// Decode the JSON input to a PHP array
$data = json_decode($input, true);


// Check if JSON decoding was successful
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
    exit;
}

// Extract user ID and wishlist from the input data
$userId = $data['userId'];
$wishlist = $data['wishlist'];

// Start a transaction
$connexion->begin_transaction();

try {
    // Step 1: Create a new 'commande' with the status 'panier'
    $sql = "INSERT INTO commande (date_com, statut) VALUES (CURDATE(), 'panier')";
    if ($connexion->query($sql) === TRUE) {
        $commandeId = $connexion->insert_id;
    } else {
        throw new Exception("Error creating commande: " . $connexion->error);
    }

    // Step 2: Insert the user ID and commande ID into the 'effectuer_com' table
    $sql = "INSERT INTO effectuer_com (id_com, id_client) VALUES (?, ?)";
    if ($stmt = $connexion->prepare($sql)) {
        $stmt->bind_param("ii", $commandeId, $userId);
        $stmt->execute();
        $stmt->close();
    } else {
        throw new Exception("Error preparing statement for effectuer_com: " . $connexion->error);
    }

    // Step 3: Insert each wishlist item into the 'conteniroutil' table
    $sql = "INSERT INTO contenirotil (id_com, id_outil, Qte_com) VALUES (?, ?, ?)";
    if ($stmt = $connexion->prepare($sql)) {
        foreach ($wishlist as $item) {
            $stmt->bind_param("iii", $commandeId, $item['id'], $item['quantity']);
            $stmt->execute();
        }
        $stmt->close();
    } else {
        throw new Exception("Error preparing statement for contenirotil: " . $connexion->error);
    }

    // Commit the transaction
    $connexion->commit();

    // Send a success response
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    // Roll back the transaction in case of an error
    $connexion->rollback();
    // Send an error response
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

// Close the database connection
$connexion->close();
?>
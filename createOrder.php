<?php
session_start();
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = $data['userId'];
    $wilayaId = $data['wilayaId'];

    // Create new order
    $stmt = $connection->prepare("INSERT INTO commande (date_com, statut, id_wilaya) VALUES (NOW(), 'pending', $wilayaId)");
    $stmt->execute();
    $orderId = $stmt->insert_id;

    // Link order with client
    $stmt = $connection->prepare("INSERT INTO effectuer_com (id_com, id_client) VALUES (?, ?)");
    $stmt->bind_param('ii', $orderId, $userId);
    $stmt->execute();

    echo json_encode(['orderId' => $orderId]);
}
?>

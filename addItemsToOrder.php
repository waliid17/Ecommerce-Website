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
    $items = $data['items'];

    // Add items to the order
    foreach ($items as $item) {
        $stmt = $connection->prepare("INSERT INTO conteniroutil (id_com, id_outil, Qte_com) VALUES (?, ?, ?)");
        $stmt->bind_param('iii', $item['id_com'], $item['id_outil'], $item['Qte_com']);
        $stmt->execute();
    }

    echo json_encode(['status' => 'success']);
}
?>

<?php
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $orderId = intval($_GET['id']);
    $pdo = new PDO('mysql:host=localhost;dbname=base;charset=utf8mb4', 'root', '');
    $query = $pdo->prepare('SELECT statut FROM commande WHERE id_com = :id_com');
    $query->execute(['id_com' => $orderId]);
    $status = $query->fetchColumn();

    echo json_encode(['status' => $status]);
} else {
    echo json_encode(['status' => '']);
}
?>

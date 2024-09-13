<?php
// Database connection
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

// Fetch unique statuses
$status_sql = "SELECT DISTINCT statut FROM commande_facture";
$status_result = $conn->query($status_sql);

$statuses = [];
while ($row = $status_result->fetch_assoc()) {
    $statuses[] = $row['statut'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    if ($order_id && $status) {
        $sql = "UPDATE commande_facture SET statut = ? WHERE id_com = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $status, $order_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode([
        'success' => false,
        'statuses' => $statuses
    ]);
}
?>

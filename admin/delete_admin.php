<?php
$mysqli = new mysqli("localhost", "root", "", "base");

if (isset($_POST['id'])) {
    $id_ad = $_POST['id'];

    // Check the total number of admins
    $result = $mysqli->query("SELECT COUNT(*) as total FROM admin");
    $row = $result->fetch_assoc();

    // Prevent deletion if there's only one admin
    if ($row['total'] > 1) {
        $stmt = $mysqli->prepare("DELETE FROM admin WHERE id_ad = ?");
        $stmt->bind_param("i", $id_ad);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete admin']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Vous ne pouvez pas supprimer le dernier admin']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No admin ID provided']);
}
$mysqli->close();
?>

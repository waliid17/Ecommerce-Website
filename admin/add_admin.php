<?php
$mysqli = new mysqli("localhost", "root", "", "base");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_ad = $_POST['nom_ad'];
    $email_ad = $_POST['email_ad'];
    $pwd_ad = $_POST['pwd_ad'];

    // Add the new admin
    $stmt = $mysqli->prepare("INSERT INTO admin (nom_ad, email_ad, pwd_ad) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nom_ad, $email_ad, $pwd_ad);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Administrateur ajouté avec succès']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de l\'administrateur']);
    }
}

$mysqli->close();
?>

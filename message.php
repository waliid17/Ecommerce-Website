<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Get form data
$prenom = $_POST['prenom'] ?? '';
$nom = $_POST['nom'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$sujet = $_POST['sujet'] ?? '';
$contenu = $_POST['contenu'] ?? '';
$date = date('Y-m-d H:i:s');

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO message (prenom, nom, phone, email, sujet, contenu, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $prenom, $nom, $phone, $email, $sujet, $contenu, $date);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Votre message a été bien envoyé ! Merci pour votre message"]);
} else {
    echo json_encode(["status" => "error", "message" => "Erreur: " . $stmt->error]);
}

// Close connection
$stmt->close();
$conn->close();
?>

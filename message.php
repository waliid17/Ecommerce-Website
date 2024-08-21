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

// Validate input data
if (empty($prenom) || empty($nom) || empty($phone) || empty($email) || empty($sujet) || empty($contenu)) {
    echo json_encode(["status" => "error", "message" => "Tous les champs doivent être remplis."]);
    $conn->close();
    exit;
}

// Check how many messages this user has sent in the last 24 hours
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM message WHERE email = ? AND date >= DATE_SUB(NOW(), INTERVAL 1 DAY)");
if (!$checkStmt) {
    echo json_encode(["status" => "error", "message" => "Erreur dans la préparation de la requête: " . $conn->error]);
    $conn->close();
    exit;
}

$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkStmt->bind_result($messageCount);
$checkStmt->fetch();
$checkStmt->close();

// Debugging information
error_log("Message count for $email: $messageCount");

// Check if message count exceeds the limit
if ($messageCount >= 3) {
    echo json_encode(["status" => "error", "message" => "Vous avez atteint la limite de 3 messages par 24 heures."]);
    $conn->close();
    exit;
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO message (prenom, nom, phone, email, sujet, contenu, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Erreur dans la préparation de la requête: " . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param("sssssss", $prenom, $nom, $phone, $email, $sujet, $contenu, $date);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Votre message a été bien envoyé ! Merci pour votre message"]);
} else {
    echo json_encode(["status" => "error", "message" => "Erreur lors de l'envoi du message: " . $stmt->error]);
}

// Close connection
$stmt->close();
$conn->close();
?>

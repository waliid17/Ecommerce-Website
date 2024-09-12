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

// Check if the client already exists in the `client` table
$clientStmt = $conn->prepare("SELECT id_client FROM client WHERE email = ?");
if (!$clientStmt) {
    echo json_encode(["status" => "error", "message" => "Erreur dans la préparation de la requête: " . $conn->error]);
    $conn->close();
    exit;
}
$clientStmt->bind_param("s", $email);
$clientStmt->execute();
$clientStmt->bind_result($id_client);
$clientStmt->fetch();
$clientStmt->close();

// If the client does not exist, insert them into the `client` table
if (empty($id_client)) {
    $insertClientStmt = $conn->prepare("INSERT INTO client (prenom, nom, email, telephone, activation) VALUES (?, ?, ?, ?, 1)");
    if (!$insertClientStmt) {
        echo json_encode(["status" => "error", "message" => "Erreur dans la préparation de la requête: " . $conn->error]);
        $conn->close();
        exit;
    }
    $insertClientStmt->bind_param("ssss", $prenom, $nom, $email, $phone);
    if ($insertClientStmt->execute()) {
        $id_client = $insertClientStmt->insert_id; // Get the newly inserted client ID
    } else {
        echo json_encode(["status" => "error", "message" => "Erreur lors de l'insertion du client: " . $insertClientStmt->error]);
        $insertClientStmt->close();
        $conn->close();
        exit;
    }
    $insertClientStmt->close();
}

// Check how many messages this user has sent in the last 24 hours
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM message WHERE id_client = ? AND Date_Msg >= DATE_SUB(NOW(), INTERVAL 1 DAY)");
if (!$checkStmt) {
    echo json_encode(["status" => "error", "message" => "Erreur dans la préparation de la requête: " . $conn->error]);
    $conn->close();
    exit;
}
$checkStmt->bind_param("i", $id_client);
$checkStmt->execute();
$checkStmt->bind_result($messageCount);
$checkStmt->fetch();
$checkStmt->close();

// Debugging information
error_log("Message count for client $id_client: $messageCount");

// Check if message count exceeds the limit
if ($messageCount >= 3) {
    echo json_encode(["status" => "error", "message" => "Vous avez atteint la limite de 3 messages par 24 heures."]);
    $conn->close();
    exit;
}

// Prepare and bind the message insert
$stmt = $conn->prepare("INSERT INTO message (Sjt_Msg, Ctn_Msg, Date_Msg, id_client) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Erreur dans la préparation de la requête: " . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param("sssi", $sujet, $contenu, $date, $id_client);

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

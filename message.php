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
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$sujet = $_POST['sujet'];
$contenu = $_POST['contenu'];
$date = date('Y-m-d H:i:s'); // Capture current date and time

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO message (prenom, nom, phone, email, sujet, contenu, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $prenom, $nom, $phone, $email, $sujet, $contenu, $date);

// Execute the statement
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
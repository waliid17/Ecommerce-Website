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
$prenom = $_POST['prenom'] ?? '';
$nom = $_POST['nom'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$sujet = $_POST['sujet'] ?? '';
$contenu = $_POST['contenu'] ?? '';
$date = date('Y-m-d H:i:s'); // Capture current date and time

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO message (prenom, nom, phone, email, sujet, contenu, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $prenom, $nom, $phone, $email, $sujet, $contenu, $date);

// Execute the statement
if ($stmt->execute()) {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Success</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            .swal2-popup {
                font-family: Arial, sans-serif;
            }
            .swal2-title {
                font-size: 1.5rem;
                font-weight: bold;
            }
            .swal2-content {
                font-size: 1rem;
                color: #333;
            }
            .swal2-confirm {
                background-color: #007bff;
                border: none;
                color: #fff;
                border-radius: 4px;
                font-size: 1rem;
                padding: 10px 20px;
                transition: background-color 0.3s ease;
            }
            .swal2-confirm:hover {
                background-color: #0056b3;
            }
            .swal2-icon {
                border-color: #007bff;
                color: #007bff;
            }
        </style>
    </head>
    <body>
        <script>
            Swal.fire({
                title: "Votre message a été bien envoyé !",
                text: "Merci pour votre message",
                icon: "success",
                iconColor: "#007bff",
                confirmButtonText: "OK",
                confirmButtonColor: "#007bff",
                customClass: {
                    title: "swal2-title",
                    content: "swal2-content",
                    confirmButton: "swal2-confirm",
                    icon: "swal2-icon"
                },
                didClose: () => {
                    window.location.href = "index.php";
                }
            });
        </script>
    </body>
    </html>';
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>

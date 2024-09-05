<?php
header('Content-Type: application/json'); // Set the response type to JSON

$connection = new mysqli("localhost", "root", "", "base");

if ($connection->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $connection->connect_error]);
    exit();
}

require 'vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if email exists in the database
    $query = "SELECT prenom, mot_de_passe FROM client WHERE email = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($prenom, $mot_de_passe);
        $stmt->fetch();

        // Send email with the password
        $mail = new PHPMailer(true);
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'prooutil00@gmail.com'; 
            $mail->Password = 'qfed ofgs cblp prts'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('your-email@gmail.com', 'PRO-OUTIL');
            $mail->addAddress($email, $prenom);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Votre mot de passe - PRO-OUTIL';
            $mail->Body = "Bonjour $prenom,<br><br>Votre mot de passe est : <strong>$mot_de_passe</strong><br><br>Merci.";

            $mail->send();
            echo json_encode(['status' => 'success', 'message' => 'Votre mot de passe a été envoyé à votre adresse email.']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Le message n\'a pas pu être envoyé. Erreur: ' . $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Adresse email non trouvée.']);
    }

    $stmt->close();
    $connection->close();
}
?>

<?php
header('Content-Type: application/json'); // Set response type to JSON

$connection = new mysqli("localhost", "root", "", "base");

if ($connection->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $connection->connect_error]);
    exit();
}

require '../vendor/autoload.php'; // PHPMailer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email']; // Ensure this matches the form input name

    // Check if email exists in the database
    $query = "SELECT nom_ad, pwd_ad FROM admin WHERE email_ad = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nom_ad, $pwd_ad);
        $stmt->fetch();

        // Initialize PHPMailer and configure SMTP
        $mail = new PHPMailer(true);
        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'prooutil00@gmail.com'; // Update with your Gmail
            $mail->Password = 'qfed ofgs cblp prts';  // Update with your actual app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Email content
            $mail->setFrom('your-email@gmail.com', 'PRO-OUTIL'); // Update 'your-email@gmail.com' as needed
            $mail->addAddress($email, $nom_ad);

            $mail->isHTML(true);
            $mail->Subject = 'Votre mot de passe - PRO-OUTIL';
            $mail->Body = "Bonjour $nom_ad,<br><br>Votre mot de passe est : <strong>$pwd_ad</strong><br><br>Merci.";

            $mail->send();
            echo json_encode(['status' => 'success', 'message' => 'Votre mot de passe a été envoyé à votre adresse e-mail.']);
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

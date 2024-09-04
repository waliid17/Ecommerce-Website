<?php
session_start(); // Ensure session is started

header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed']);
    exit();
}

require 'vendor/autoload.php'; // Load Composer's autoloader for PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function getCurrentPath()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $currentPath = $protocol . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    return rtrim($currentPath, '/');
}

function sendActivationEmail($email, $name, $id_client)
{
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->SMTPDebug = 0; // Disable verbose debug output
        $mail->isSMTP(); // Send using SMTP
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'prooutil00@gmail.com'; // SMTP username
        $mail->Password = 'qfed ofgs cblp prts'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
        $mail->Port = 465; // TCP port to connect to

        $mail->setFrom('prooutil00@gmail.com', 'PRO-OUTIL');
        $mail->addAddress($email, $name);

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Activation de compte - PRO-OUTIL';
        $activationLink = getCurrentPath() . "/activation.php?id=" . $id_client;
        $mail->Body = "Bonjour $name,<br><br>Cliquez sur le lien suivant pour activer votre compte : <a href='$activationLink'>Le lien d'activation</a><br><br>Merci.";

        $mail->send();
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "L'email d'activation n'a pas pu être envoyé. Erreur du mailer : {$mail->ErrorInfo}"]);
        exit();
    }
}

// Debugging: Check session variables
if (!isset($_SESSION['user-id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Vous devez être connecté pour renvoyer le lien d\'activation.']);
    exit();
} else {
    error_log('Session User ID: ' . $_SESSION['user-id']); // Log session user ID for debugging
}

$user_id = $_SESSION['user-id'];

// Fetch user details and activation status
$sql = "SELECT email, prenom, activation FROM client WHERE id_client = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Utilisateur non trouvé.']);
    exit();
}

$stmt->bind_result($email, $prenom, $activation);
$stmt->fetch();
$stmt->close();

if ($activation == 1) {
    echo json_encode(['status' => 'error', 'message' => 'Votre compte est déjà activé.']);
    exit();
}

// Send activation email
sendActivationEmail($email, $prenom, $user_id); // Correct usage of session variable

echo json_encode(['status' => 'success', 'message' => 'Le lien d\'activation a été renvoyé.']);

$connection->close();
?>

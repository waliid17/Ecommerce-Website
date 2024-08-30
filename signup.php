<?php
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
        //Server settings
        $mail->SMTPDebug = 0; // Disable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication


        $mail->Username = 'prooutil00@gmail.com'; //SMTP username
        $mail->Password = 'qfed ofgs cblp prts'; //SMTP password


        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $mail->Port = 465; //TCP port to connect to

        $mail->setFrom('prooutil00@gmail.com', 'PRO-OUTIL');
        $mail->addAddress($email, $name);

        // Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Activation de compte - prooutil';
        $activationLink = getCurrentPath() . "/activation.php?id_client=" . $id_client;
        $mail->Body = "Bonjour $name,<br><br>Cliquez sur le lien suivant pour activer votre compte : <a href='$activationLink'>lien</a><br><br>Merci.";

        $mail->send();
    } catch (Exception $e) {
        echo "L'email d'activation n'a pas pu être envoyé. Erreur du mailer : {$mail->ErrorInfo}";
    }
}

$firstname = $_POST['prenom'] ?? '';
$lastname = $_POST['nom'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['mot_de_passe'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$phone_number = $_POST['telephone'] ?? '';
$address_line = $_POST['adresse'] ?? '';

if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_password) || empty($phone_number) || empty($address_line)) {
    echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs.']);
    exit();
}
// Check if an account with the same email already exists
$sql = "SELECT id_client FROM client WHERE email = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Email already exists
    echo json_encode(['status' => 'error', 'message' => 'Cet email est déjà utilisé. Veuillez utiliser un autre email.']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Format d\'email invalide.']);
    exit();
}

if ($password !== $confirm_password) {
    echo json_encode(['status' => 'error', 'message' => 'Les mots de passe ne correspondent pas.']);
    exit();
}

$query = $connection->prepare("INSERT INTO client (prenom, nom, email, mot_de_passe, telephone, adresse) VALUES (?, ?, ?, ?, ?, ?)");
$query->bind_param("ssssss", $firstname, $lastname, $email, $password, $phone_number, $address_line);

if ($query->execute()) {
    // Check if an account with the same email already exists
$sql = "SELECT id_client FROM client WHERE email = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

$stmt->bind_result($id_client);
    sendActivationEmail($email, $firstname, $id_client);
    echo json_encode(['status' => 'success', 'message' => 'Votre compte a été créé avec succès.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la création du compte.']);
}

$query->close();
$connection->close();
?>

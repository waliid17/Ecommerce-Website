<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root"; // Update with your database username
$password = ""; // Update with your database password
$dbname = "base"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $nom = $conn->real_escape_string(trim($_POST['nom']));
    $description = $conn->real_escape_string(trim($_POST['description']));
    $ancien_prix = filter_var($_POST['ancien_prix'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $prix_actuel = filter_var($_POST['prix_actuel'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $marque = $conn->real_escape_string(trim($_POST['id_marque']));
    $id_cat = intval($_POST['id_cat']);

    // Handle file upload
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_extensions)) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES['image']['name']);

            // Ensure uploads directory exists
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image_path = $conn->real_escape_string(basename($_FILES['image']['name']));
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            exit;
        }
    }

    // Insert into database
    // Check if `id_outil` exists in POST request
    if (isset($_POST['id_outil']) && !empty($_POST['id_outil'])) {
        $id_outil = intval($_POST['id_outil']);
        $sql = "UPDATE outil SET nom='$nom', description='$description', ancien_prix='$ancien_prix', prix_actuel='$prix_actuel', image='$image_path', id_marque='$marque', id_cat='$id_cat' WHERE id_outil='$id_outil'";
    } else {
        $sql = "INSERT INTO outil (nom, description, ancien_prix, prix_actuel, image, id_marque, id_cat) 
                VALUES ('$nom', '$description', '$ancien_prix', '$prix_actuel', '$image_path', '$marque', $id_cat)";
    }
    
    if ($conn->query($sql) === TRUE) {
       header('location: admin.php?targetId=outil-content&message=produitajouter');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    

    $conn->close();
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $id_outil = $_POST['id_outil'];
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $ancien_prix = htmlspecialchars($_POST['ancien_prix']);
    $prix_actuel = htmlspecialchars($_POST['prix_actuel']);
    $marque = htmlspecialchars($_POST['marque']);
    $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : $_POST['current_image'];

    // Handle file upload if a new image is provided
    if ($_FILES['image']['name']) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    // Update the product in the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "base";

    $connection = new mysqli($servername, $username, $password, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "UPDATE outil SET nom=?, description=?, ancien_prix=?, prix_actuel=?, marque=?, image=? WHERE id_outil=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssddssi", $nom, $description, $ancien_prix, $prix_actuel, $marque, $image, $id_outil);

    if ($stmt->execute()) {
        header('Location: admin/admin.php');
    } else {
        echo "Error updating record: " . $connection->error;
    }

    $stmt->close();
    $connection->close();
}
?>
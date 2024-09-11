<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $id_outil = intval($_POST['id_outil']);
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $ancien_prix = floatval($_POST['ancien_prix']);
    $prix_actuel = floatval($_POST['prix_actuel']);
    $marque = htmlspecialchars($_POST['nom_marque']); // This seems to be incorrect
    $id_cat = intval($_POST['id_cat']);
    $id_marque = intval($_POST['id_marque']); // Ensure you have an ID for the marque

    // Handle file upload if a new image is provided
    $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : $_POST['current_image'];

    if ($_FILES['image']['name']) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Validate and move uploaded file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // File uploaded successfully
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors du téléchargement de l\'image']);
            exit;
        }
    }

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "base";

    $connection = new mysqli($servername, $username, $password, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Update query for marque table (only if needed)
    if (!empty($marque) && !empty($id_marque)) {
        $sqlMarque = "UPDATE marque SET nom_marque=? WHERE id_marque=?";
        $stmtMarque = $connection->prepare($sqlMarque);
        $stmtMarque->bind_param("si", $marque, $id_marque);

        if (!$stmtMarque->execute()) {
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la mise à jour de la marque']);
            $stmtMarque->close();
            $connection->close();
            exit;
        }
        $stmtMarque->close();
    }

    // Update query for outil table
    $sqlOutil = "UPDATE outil SET nom=?, description=?, ancien_prix=?, prix_actuel=?, image=?, id_cat=?, id_marque=? WHERE id_outil=?";
    $stmtOutil = $connection->prepare($sqlOutil);
    $stmtOutil->bind_param("ssddsiis", $nom, $description, $ancien_prix, $prix_actuel, $image, $id_cat, $id_marque, $id_outil);

    if ($stmtOutil->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Produit modifié avec succès']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la mise à jour du produit']);
    }

    $stmtOutil->close();
    $connection->close();
}
?>

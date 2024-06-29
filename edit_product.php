<?php
$product = [];

// Example data for demonstration
$product = [
    'id_outil' => 1,
    'nom' => 'Product Name',
    'description' => 'Product Description',
    'ancien_prix' => 100,
    'prix_actuel' => 80,
    'marque' => 'Product Brand',
    'current_image' => 'product-image.jpg'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: user.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h2>Edit Product</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_outil" value="<?php echo htmlspecialchars($product['id_outil']); ?>">
        <table class="product-table">
            <tr>
                <td>Nom:</td>
                <td><input type="text" name="nom" value="<?php echo htmlspecialchars($product['nom']); ?>"></td>
            </tr>
            <tr>
                <td>Description:</td>
                <td><textarea name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Ancien Prix:</td>
                <td><input type="text" name="ancien_prix"
                        value="<?php echo htmlspecialchars($product['ancien_prix']); ?>"></td>
            </tr>
            <tr>
                <td>Prix Actuel:</td>
                <td><input type="text" name="prix_actuel"
                        value="<?php echo htmlspecialchars($product['prix_actuel']); ?>"></td>
            </tr>
            <tr>
                <td>Marque:</td>
                <td><input type="text" name="marque" value="<?php echo htmlspecialchars($product['marque']); ?>"></td>
            </tr>
            <tr>
                <td>Image:</td>
                <td>
                    <img src="images/<?php echo htmlspecialchars($product['current_image']); ?>"
                        alt="<?php echo htmlspecialchars($product['nom']); ?>" width="100">
                    <input type="file" name="image">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit">Update Product</button>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>
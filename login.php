<?php
$connection = new mysqli("localhost", "root", "", "base");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
$password = $_POST['mot_de_passe'];
$email = $_POST['email'];

$query = "SELECT `email`,`mot_de_passe`,`id_client` FROM `client` WHERE email='$email'";
$result = $connection->query($query);
if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($password == $row['mot_de_passe']) {
        session_start();
        $_SESSION['user-id'] = $row['id_client'];

        // panier
        /*
        $id_client = $row['id_client'];
        $query = "SELECT co.id_outil
                FROM conteniroutil co
                JOIN effectuer_com ec ON co.id_com = ec.id_com
                WHERE ec.id_client = 1
                ";
        $result = $connection->query($query);
        while ($row = $result->fetch_assoc()) {
            $id_outils[] = $row['id_outil'];
            echo $row['id_outil'];
        }
        
        if ($result->num_rows > 0) {
            ?>
            <script>
                const product = {
                    id: <?= $id ?>,
                    name: '<?= $name ?>',
                    image: '<?= $image ?>',
                    price: <?= $curr_price ?>,
                    quantity: parseInt(document.getElementById('quantity').textContent)
                };
                function addToWishlist(product) {
                    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                    wishlist.push(product);
                    localStorage.setItem('wishlist', JSON.stringify(wishlist));
                }
            </script>
            <?php
        }
        */
        header("Location: /pro-outil/");
    } else {
        echo "mot de passe incorrect";
    }
} else {
    echo "créer un compte";
}
?>
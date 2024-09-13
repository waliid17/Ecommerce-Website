<?php
require('fpdf/fpdf.php'); // Include FPDF library

if (!isset($_GET['id'])) {
    die('ID de commande non fourni.');
}

$orderId = intval($_GET['id']);
$connection = new mysqli("localhost", "root", "", "base");

if ($connection->connect_error) {
    die("Échec de la connexion : " . $connection->connect_error);
}

// Get order details with delivery price and delivery address
$orderStmt = $connection->prepare("
    SELECT c.id_com, c.date_com, cli.prenom, cli.nom, w.delivery_price, c.adr_Liv
    FROM commande_facture c
    JOIN effectuer_com e ON c.id_com = e.id_com
    JOIN client cli ON e.id_client = cli.id_client
    JOIN wilaya w ON c.id_wilaya = w.id_wilaya
    WHERE c.id_com = ?
");
$orderStmt->bind_param("i", $orderId);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();
$order = $orderResult->fetch_assoc();

if (!$order) {
    die("Commande non trouvée.");
}

// Get products in the order
$productsStmt = $connection->prepare("
    SELECT o.nom, o.prix_actuel, co.Qte_com
    FROM conteniroutil co
    JOIN outil o ON co.id_outil = o.id_outil
    WHERE co.id_com = ?
");
$productsStmt->bind_param("i", $orderId);
$productsStmt->execute();
$productsResult = $productsStmt->get_result();
$products = $productsResult->fetch_all(MYSQLI_ASSOC);

// Calculate total price
$totalPrice = array_reduce($products, function ($carry, $product) {
    return $carry + ($product['prix_actuel'] * $product['Qte_com']);
}, 0);

// Add delivery price
$deliveryPrice = $order['delivery_price'];
$finalTotalPrice = $totalPrice + $deliveryPrice;

$connection->close();

// Generate the PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Facture', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'ID Commande : ' . $order['id_com'], 0, 1);
$pdf->Cell(0, 10, 'Date : ' . $order['date_com'], 0, 1);
$pdf->Cell(0, 10, 'Client : ' . $order['prenom'] . ' ' . $order['nom'], 0, 1);
$pdf->Cell(0, 10, 'Adresse de Livraison : ' . $order['adr_Liv'], 0, 1); // Add delivery address
$pdf->Ln(10);

$pdf->SetFillColor(200, 220, 255); // Set header background color
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 10, 'Produit', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Prix', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Quantite', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Total', 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 12);

foreach ($products as $product) {
    $pdf->Cell(60, 10, $product['nom'], 1);
    $pdf->Cell(30, 10, number_format($product['prix_actuel'], 2), 1);
    $pdf->Cell(30, 10, $product['Qte_com'], 1);
    $pdf->Cell(30, 10, number_format($product['prix_actuel'] * $product['Qte_com'], 2), 1);
    $pdf->Ln();
}

// Add delivery price line
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(120, 10, 'Prix de Livraison', 1);
$pdf->Cell(30, 10, number_format($deliveryPrice, 2), 1);
$pdf->Ln();

// Add final total line
$pdf->Cell(120, 10, 'Total', 1);
$pdf->Cell(30, 10, number_format($finalTotalPrice, 2), 1);

$pdf->Output('I', 'facture_' . $order['id_com'] . '.pdf');
?>

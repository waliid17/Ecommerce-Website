<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// SQL queries to get the counts
$sqlUsers = "SELECT COUNT(*) as count FROM client";
$sqlTools = "SELECT COUNT(*) as count FROM outil";
$sqlMessages = "SELECT COUNT(*) as count FROM message";
$sqlOrders = "SELECT COUNT(*) as count FROM commande_facture";
$sqlWilayas = "SELECT COUNT(*) as count FROM wilaya";
$sqlMarques = "SELECT COUNT(*) as count FROM marque";
$sqlCatégories = "SELECT COUNT(*) as count FROM categorie";
$sqlAdmins = "SELECT COUNT(*) as count FROM admin";
// Execute the queries and fetch the counts
$resultUsers = $conn->query($sqlUsers);
$resultTools = $conn->query($sqlTools);
$resultMessages = $conn->query($sqlMessages);
$resultOrders = $conn->query($sqlOrders);
$resultWilayas = $conn->query($sqlWilayas);
$resultMarques = $conn->query($sqlMarques);
$resultCatégories = $conn->query($sqlCatégories);
$resultAdmins = $conn->query($sqlAdmins);

$countUsers = $resultUsers->fetch_assoc()['count'];
$countTools = $resultTools->fetch_assoc()['count'];
$countMessages = $resultMessages->fetch_assoc()['count'];
$countOrders = $resultOrders->fetch_assoc()['count'];
$countWilayas = $resultWilayas->fetch_assoc()['count'];
$countMarques = $resultMarques->fetch_assoc()['count'];
$countCatégories = $resultCatégories->fetch_assoc()['count'];
$countAdmins = $resultAdmins->fetch_assoc()['count'];

$conn->close();
?>

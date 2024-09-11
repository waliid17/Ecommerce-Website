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
$sqlOrders = "SELECT COUNT(*) as count FROM commande";
$sqlWilayas = "SELECT COUNT(*) as count FROM wilaya";
$sqlMarques = "SELECT COUNT(*) as count FROM marque";

// Execute the queries and fetch the counts
$resultUsers = $conn->query($sqlUsers);
$resultTools = $conn->query($sqlTools);
$resultMessages = $conn->query($sqlMessages);
$resultOrders = $conn->query($sqlOrders);
$resultWilayas = $conn->query($sqlWilayas);
$resultMarques = $conn->query($sqlMarques);

$countUsers = $resultUsers->fetch_assoc()['count'];
$countTools = $resultTools->fetch_assoc()['count'];
$countMessages = $resultMessages->fetch_assoc()['count'];
$countOrders = $resultOrders->fetch_assoc()['count'];
$countWilayas = $resultWilayas->fetch_assoc()['count'];
$countMarques = $resultMarques->fetch_assoc()['count'];

$conn->close();
?>

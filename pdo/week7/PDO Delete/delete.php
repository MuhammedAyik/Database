<?php
// Maak een verbinding met de database
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "winkel";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Ontvang de product_code uit de URL-parameter
$product_code = $_GET['product_code'];

// Verwijder het product met de opgegeven product_code uit de tabel producten
$sql = "DELETE FROM producten WHERE product_code = $product_code";
if ($conn->query($sql) === TRUE) {
    echo "Product met code $product_code is succesvol verwijderd.";
} else {
    echo "Fout bij het verwijderen van het product: " . $conn->error;
}

// Sluit de databaseverbinding
$conn->close();
?>

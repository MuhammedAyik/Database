<?php
$servername = "localhost:3307";
$username = "root";
$password = '';
$dbname = "winkel";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Kan geen verbinding maken met de database: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $productNaam = $_POST["product_naam"];
    $prijsPerStuk = $_POST["prijs_per_stuk"];
    $omschrijving = $_POST["omschrijving"];

    try {
        $sql = "INSERT INTO producten (product_naam, prijs_per_stuk, omschrijving) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$productNaam, $prijsPerStuk, $omschrijving]);
        echo "Nieuw record succesvol toegevoegd.";
    } catch(PDOException $e) {
        echo "Fout bij het toevoegen van het record: " . $e->getMessage();
    }
}

$pdo = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulier</title>
</head>
<body>
    <h2>Voeg een nieuw record toe</h2>
    <form method="POST" action="insert.php">
        <label for="product_naam">Product Naam:</label>
        <input type="text" name="product_naam" required><br><br>
        
        <label for="prijs_per_stuk">Prijs per stuk:</label>
        <input type="number" step="0.01" name="prijs_per_stuk" required><br><br>
        
        <label for="omschrijving">Omschrijving:</label>
        <textarea name="omschrijving" required></textarea><br><br>
        
        <input type="submit" value="Verzenden">
    </form>
</body>
</html>

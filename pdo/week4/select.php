<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "winkel";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM producten WHERE product_code = :code";
    $statement = $pdo->prepare($query);
    $productCode = 2;
    $statement->bindParam(':code', $productCode);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo "Product ID: " . $result['id'] . "<br>";
        echo "Naam: " . $result['naam'] . "<br>";
        echo "Prijs: " . $result['prijs'] . "<br>";
        echo "Categorie: " . $result['categorie'] . "<br>";
    } else {
        echo "Geen resultaat gevonden.";
    }
} catch(PDOException $e) {
    die("Fout bij het uitvoeren van de query: " . $e->getMessage());
}

$pdo = null;
?>

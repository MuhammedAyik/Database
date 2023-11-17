<?php
$host = "localhost:3307";
$dbname = "winkel";
$username = "root";
$password = '';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM producten";
    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Alle gegevens:</h2>";
    foreach ($result as $row) {
        echo "Productnaam: " . $row['product_naam'] . "<br>";
        echo "Prijs: " . $row['prijs_per_stuk'] . "<br>";
        echo "<br>";
    }
    
    $query = "SELECT * FROM producten WHERE product_code = :product_code1";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':product_code1', $product_code1);
    $product_code1 = 1;
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Product met product_code 1:</h2>";
    foreach ($result as $row) {
        echo "Productnaam: " . $row['productnaam'] . "<br>";
        echo "Prijs: " . $row['prijs'] . "<br>";
        echo "<br>";
    }

    $query = "SELECT * FROM producten WHERE product_code = :product_code2";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':product_code2', $product_code2);
    $product_code2 = 2;
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Product met product_code 2:</h2>";
    foreach ($result as $row) {
        echo "Productnaam: " . $row['productnaam'] . "<br>";
        echo "Prijs: " . $row['prijs'] . "<br>";
        echo "<br>";
    }
} catch (PDOException $e) {
    echo "Fout bij het uitvoeren van de query: " . $e->getMessage();
}

// Hoe je alles selecteert in een query zonder variabele
// In dit deel van de code wordt een SELECT-query gebruikt zonder variabele. De query "SELECT * FROM producten" selecteert alle rijen en kolommen uit de tabel "producten".

// Hoe je een single row selecteert met placeholders
// In dit deel van de code wordt een SELECT-query gebruikt met placeholders. De query "SELECT * FROM producten WHERE product_code = :product_code1" selecteert de rij(en) waarvan de product_code overeenkomt met de waarde die aan de placeholder ":product_code1" is gebonden. Hier wordt een enkele rij geselecteerd met behulp van een placeholder.

// Hoe je een single row selecteert met named parameters
// In dit deel van de code wordt een SELECT-query gebruikt met named parameters. De query "SELECT * FROM producten WHERE product_code = :product_code2" selecteert de rij(en) waarvan de product_code overeenkomt met de waarde die aan de named parameter ":product_code2" is gekoppeld. Hier

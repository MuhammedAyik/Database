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

// Selecteer alle gegevens uit de tabel producten
$sql = "SELECT omschrijving, prijs_per_stuk, product_code, product_naam FROM producten ORDER BY product_naam";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Producten</title>
</head>
<body>
    <?php
    if ($result->num_rows > 0) {
        // Output van de gegevens in een mooie volgorde
        echo "<table>
                <tr>
                    <th>Omschrijving</th>
                    <th>Prijs per stuk</th>
                    <th>Product code</th>
                    <th>Product naam</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["omschrijving"]."</td>
                    <td>".$row["prijs_per_stuk"]."</td>
                    <td>".$row["product_code"]."</td>
                    <td>".$row["product_naam"]."</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "Geen producten gevonden.";
    }

    // Sluit de databaseverbinding
    $conn->close();
    ?>

    <a href="delete.php?product_code=2">Verwijder product met code 2</a>
</body>
</html>

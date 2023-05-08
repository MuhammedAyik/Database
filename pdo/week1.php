<!DOCTYPE html>
<html>
<head>
    <title>Gegevensformulier</title>
</head>
<body>
    <h2>Gegevensformulier</h2>
    <form method="GET" action="">
        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" required><br><br>

        <label for="achternaam">Achternaam:</label>
        <input type="text" id="achternaam" name="achternaam" required><br><br>

        <label for="leeftijd">Leeftijd:</label>
        <input type="number" id="leeftijd" name="leeftijd" required><br><br>

        <label for="adres">Adres:</label>
        <input type="text" id="adres" name="adres" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="Verzenden">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["naam"])) {
        $naam = $_GET["naam"];
        $achternaam = $_GET["achternaam"];
        $leeftijd = $_GET["leeftijd"];
        $adres = $_GET["adres"];
        $email = $_GET["email"];

        echo "<h2>Ingevoerde gegevens:</h2>";
        echo "<ul>";
        echo "<li>Naam: " . $naam . "</li>";
        echo "<li>Achternaam: " . $achternaam . "</li>";
        echo "<li>Leeftijd: " . $leeftijd . "</li>";
        echo "<li>Adres: " . $adres . "</li>";
        echo "<li>E-mail: " . $email . "</li>";
        echo "</ul>";
    }
    ?>
</body>
</html>

-----------------------------------------------------------------------------------------------------------------------------------------------

<!DOCTYPE html>
<html>
<head>
    <title>Gegevensformulier</title>
</head>
<body>
    <h2>Gegevensformulier</h2>
    <form method="POST" action="">
        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" required><br><br>

        <label for="achternaam">Achternaam:</label>
        <input type="text" id="achternaam" name="achternaam" required><br><br>

        <label for="leeftijd">Leeftijd:</label>
        <input type="number" id="leeftijd" name="leeftijd" required><br><br>

        <label for="adres">Adres:</label>
        <input type="text" id="adres" name="adres" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="Verzenden">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["naam"])) {
        $naam = $_POST["naam"];
        $achternaam = $_POST["achternaam"];
        $leeftijd = $_POST["leeftijd"];
        $adres = $_POST["adres"];
        $email = $_POST["email"];

        // Weergave van de ingevoerde gegevens op het scherm
        echo "<h2>Ingevoerde gegevens:</h2>";
        echo "<ul>";
        echo "<li>Naam: " . $naam . "</li>";
        echo "<li>Achternaam: " . $achternaam . "</li>";
        echo "<li>Leeftijd: " . $leeftijd . "</li>";
        echo "<li>Adres: " . $adres . "</li>";
        echo "<li>E-mail: " . $email . "</li>";
        echo "</ul>";
    }
    ?>
</body>
</html>

<?php
// GET-methode:
// Gegevens worden toegevoegd aan de URL van het verzoek als queryparameters.
// Gegevens worden zichtbaar in de URL van de pagina.
// Gegevenslimiet: Er is een beperkte lengte aan de gegevens die kunnen worden verzonden (meestal rond de 2048 tekens).

// POST-methode:
// Gegevens worden verzonden als onderdeel van het HTTP-verzoek en zijn niet zichtbaar in de URL van de pagina.
// Gegevenslimiet: Er is geen beperking op de lengte van de gegevens die kunnen worden verzonden.
// Veiligheid: Veiliger dan GET omdat gegevens niet zichtbaar zijn in de URL en niet gecachet worden door de browser.
?>

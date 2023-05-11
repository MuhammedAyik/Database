<!DOCTYPE html>
<html>
<head>
  <title>Gegevensformulier</title>
</head>
<body>
  <form action="verwerk.php" method="GET">
    <label for="naam">Naam:</label>
    <input type="text" id="naam" name="naam" required><br>

    <label for="achternaam">Achternaam:</label>
    <input type="text" id="achternaam" name="achternaam" required><br>

    <label for="leeftijd">Leeftijd:</label>
    <input type="number" id="leeftijd" name="leeftijd" required><br>

    <label for="adres">Adres:</label>
    <input type="text" id="adres" name="adres" required><br>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required><br>

    <input type="submit" value="Verzenden">

    <?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET['naam']) && isset($_GET['achternaam']) && isset($_GET['leeftijd']) && isset($_GET['adres']) && isset($_GET['email'])) {
    $naam = $_GET['naam'];
    $achternaam = $_GET['achternaam'];
    $leeftijd = $_GET['leeftijd'];
    $adres = $_GET['adres'];
    $email = $_GET['email'];

    echo "<h2>Ingevoerde gegevens:</h2>";
    echo "<p><strong>Naam:</strong> " . htmlspecialchars($naam) . "</p>";
    echo "<p><strong>Achternaam:</strong> " . htmlspecialchars($achternaam) . "</p>";
    echo "<p><strong>Leeftijd:</strong> " . htmlspecialchars($leeftijd) . "</p>";
    echo "<p><strong>Adres:</strong> " . htmlspecialchars($adres) . "</p>";
    echo "<p><strong>E-mail:</strong> " . htmlspecialchars($email) . "</p>";
  }
}
?>
  </form>
</body>
</html>


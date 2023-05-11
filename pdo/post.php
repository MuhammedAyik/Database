<!DOCTYPE html>
<html>
<head>
  <title>Gegevensformulier</title>
</head>
<body>
  <h1>Gegevensformulier</h1>
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="naam">Naam:</label>
    <input type="text" name="naam" id="naam" required><br><br>
    
    <label for="achternaam">Achternaam:</label>
    <input type="text" name="achternaam" id="achternaam" required><br><br>
    
    <label for="leeftijd">Leeftijd:</label>
    <input type="number" name="leeftijd" id="leeftijd" required><br><br>
    
    <label for="adres">Adres:</label>
    <input type="text" name="adres" id="adres" required><br><br>
    
    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email" required><br><br>
    
    <input type="submit" value="Verzenden">
</form>
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST["naam"];
    $achternaam = $_POST["achternaam"];
    $leeftijd = $_POST["leeftijd"];
    $adres = $_POST["adres"];
    $email = $_POST["email"];
    
    echo "<h2>Ingevoerde gegevens:</h2>";
    echo "<p><strong>Naam:</strong> $naam</p>";
    echo "<p><strong>Achternaam:</strong> $achternaam</p>";
    echo "<p><strong>Leeftijd:</strong> $leeftijd</p>";
    echo "<p><strong>Adres:</strong> $adres</p>";
    echo "<p><strong>E-mail:</strong> $email</p>";
  }
  ?>
</body>
</html>

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
    $naam = $_GET['naam'];
    $achternaam = $_GET['achternaam'];
    $leeftijd = $_GET['leeftijd'];
    $adres = $_GET['adres'];
    $email = $_GET['email'];
    
    echo $naam;
    echo $achternaam;
    echo $leeftijd;
    echo $adres;
    echo $email;
?>
  </form>
</body>
</html>


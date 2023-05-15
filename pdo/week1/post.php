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
    $naam = $_POST["naam"];
    $achternaam = $_POST["achternaam"];
    $leeftijd = $_POST["leeftijd"];
    $adres = $_POST["adres"];
    $email = $_POST["email"];
    
    echo $naam;
    echo $achternaam;
    echo $leeftijd;
    echo $adres;
    echo $email;
  ?>
</body>
</html>



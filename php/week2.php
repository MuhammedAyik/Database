<!-- $variabele1 = 10;
$variabele2 = 10;

if ($variabele1 == $variabele2) {
    echo "De twee waarden zijn gelijk";
}

$variabele1 = 10;
$variabele2 = 10;

if ($variabele1 !== $variabele2) {
    echo "De twee waarden zijn ongelijk";
}

$variabele1 = 10;
$variabele2 = 10;

if ($variabele1 == $variabele2) {
    echo "De twee waarden zijn gelijk";
} else {
    echo "De twee waarden zijn ongelijk";
} -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="POST" action="week2.php">
  <label for="username">Gebruikersnaam:</label>
  <input type="text" id="username" name="username" required><br>

  <label for="password">Wachtwoord:</label>
  <input type="password" id="password" name="password" required><br>

  <button type="submit" name="submit">Inloggen</button>
</form>

<?php
if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
?>
 <h4>Ingevoerde gegevens:</h4>
 <?php echo $username; ?></p>
 <?php echo $password; ?></p>
<?php
}
?>
</body>
</html>

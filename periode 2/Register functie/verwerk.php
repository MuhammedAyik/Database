<?php
$host = "localhost";
$gebruikersnaam = "root";
$wachtwoord = "";
$database = "test";

try {
    $dbh = new PDO("mysql:host=$host;dbname=$database", $gebruikersnaam, $wachtwoord);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

class Gebruiker {
    private $naam;
    private $email;
    private $wachtwoord;

    public function __construct($naam, $email, $wachtwoord) {
        $this->naam = $naam;
        $this->email = $email;
        $this->wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
    }

    public function opslaan($dbh) {
        try {
            $stmt = $dbh->prepare("INSERT INTO gebruikers (naam, email, wachtwoord) VALUES (:naam, :email, :wachtwoord)");
            $stmt->bindParam(':naam', $this->naam);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':wachtwoord', $this->wachtwoord);
            $stmt->execute();
            
            echo "Registratie succesvol!";

        } catch (PDOException $e) {

            echo "Error: " . $e->getMessage();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = htmlspecialchars(trim($_POST["naam"]));
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $wachtwoord = htmlspecialchars(trim($_POST["wachtwoord"]));

    if (empty($naam) || empty($email) || empty($wachtwoord)) {
        echo "Vul alle verplichte velden in.";
    } elseif (!$email) {
        echo "Voer een geldig e-mailadres in.";
    } else {
        $gebruiker = new Gebruiker($naam, $email, $wachtwoord);
        
        $gebruiker->opslaan($dbh);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verwerking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .button-container {
            margin-top: 20px;
        }

        .button-container a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button-container a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verwerking</h2>
        <?php
        echo "Registratie succesvol!";
        ?>
        <div class="button-container">
            <a href="index.php">Terug naar Registratieformulier</a>
        </div>
    </div>
</body>
</html>
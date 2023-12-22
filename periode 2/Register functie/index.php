<?php
class Database {
    private $dbh;
    public function __construct($host, $gebruikersnaam, $wachtwoord, $database) {
        try {
            $this->dbh = new PDO("mysql:host=$host;dbname=$database", $gebruikersnaam, $wachtwoord);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    public function getGebruikers($zoekNaam = null, $zoekEmail = null) {
        try {
            $query = "SELECT * FROM gebruikers WHERE 1";
    
            if ($zoekNaam !== null) {
                $query .= " AND naam LIKE :zoekNaam";
            }
    
            if ($zoekEmail !== null) {
                $query .= " AND email LIKE :zoekEmail";
            }
    
            $stmt = $this->dbh->prepare($query);
    
            if ($zoekNaam !== null) {
                $stmt->bindValue(':zoekNaam', "%$zoekNaam%", PDO::PARAM_STR);
            }
    
            if ($zoekEmail !== null) {
                $stmt->bindValue(':zoekEmail', "%$zoekEmail%", PDO::PARAM_STR);
            }
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

$database = new Database("localhost", "root", "", "test");
$gebruikersAlle = $database->getGebruikers();
$gebruikersMetZoekcriteria = $database->getGebruikers("mr");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratieformulier</title>
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

    form {
        max-width: 400px;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
    }

    input {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #4caf50;
        color: #fff;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    pre {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
</style>
</head>
<body>
    <h2>Registratieformulier</h2>
    <form action="verwerk.php" method="post">
        <label for="naam">Naam:</label>
        <input type="text" name="naam" required><br>

        <label for="email">E-mail:</label>
        <input type="email" name="email" required><br>

        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" name="wachtwoord" required><br>

        <input type="submit" value="Registreren">
    </form>
    <h2>Gebruikers</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Email</th>
                <th>Wachtwoord</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($gebruikersAlle as $gebruiker) {
                echo "<tr>";
                echo "<td>{$gebruiker['id']}</td>";
                echo "<td>{$gebruiker['naam']}</td>";
                echo "<td>{$gebruiker['email']}</td>";
                echo "<td>{$gebruiker['wachtwoord']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <h2>Gebruikers met zoekcriteria</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Email</th>
                <th>Wachtwoord</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($gebruikersMetZoekcriteria as $gebruiker) {
                echo "<tr>";
                echo "<td>{$gebruiker['id']}</td>";
                echo "<td>{$gebruiker['naam']}</td>";
                echo "<td>{$gebruiker['email']}</td>";
                echo "<td>{$gebruiker['wachtwoord']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
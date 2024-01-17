<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <link rel="stylesheet" href="/css/addcar.css">
    <link rel="stylesheet" href="/css/addcustomer.css">
    <script>
        function showNotification(message, isSuccess) {
            var notification = document.createElement("div");
            notification.className = isSuccess ? "success" : "error";
            notification.innerHTML = message;

            document.body.appendChild(notification);

            setTimeout(function() {
                document.body.removeChild(notification);
            }, 3000);
        }
    </script>
</head>
<body>

<?php

include 'connection.php';

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addUser($fname, $lname, $email, $licNum, $phone, $password, $gender)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("INSERT INTO users (FNAME, LNAME, EMAIL, LIC_NUM, PHONE_NUMBER, PASSWORD, GENDER) VALUES (?, ?, ?, ?, ?, ?, ?)");


        if ($stmt->execute([$fname, $lname, $email, $licNum, $phone, $hashedPassword, $gender])) {
            $this->showNotification('Klant succesvol toegevoegd!', true);
        } else {
            $this->showNotification('Er is een fout opgetreden bij het toevoegen van de klant.', false);
        }
    }

    private function showNotification($message, $success)
    {
        echo "<script>showNotification('" . $message . "', " . ($success ? 'true' : 'false') . ");</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = new User($pdo);

    $user->addUser(
        $_POST["fname"],
        $_POST["lname"],
        $_POST["email"],
        $_POST["lic_num"],
        $_POST["phone"],
        $_POST["password"],
        $_POST["gender"]
    );
}

?>


<div class="hai">
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">CarVerhuur</h2>
            </div>
            <div class="menu">
                <ul>
                <li><a href="adminvehicle.php">VOERTUIGBEHEER</a></li>
                    <li><a href="adminusers.php">GEBRUIKERS</a></li>
                    <li><a href="admindash.php">FEEDBACKS</a></li>
                    <li><a href="adminbook.php">BOEKINGSVERZOEK</a></li>
                    <li><a href="addcustomer.php">KLANT TOEVOEGEN</a></li>
                    <li><a href="adminreserveringtoevoegen.php">RESERVERING TOEVOEGEN</a></li>
                    <li><button class="nn"><a href="index.php">LOGUIT</a></button></li>
                </ul>
            </div>
         </div>

<form method="post" action="">
    <label for="fname">Voornaam:</label>
    <input type="text" name="fname" required>

    <label for="lname">Achternaam:</label>
    <input type="text" name="lname" required>

    <label for="email">E-mail:</label>
    <input type="email" name="email" required>

    <label for="lic_num">Rijbewijsnummer:</label>
    <input type="text" name="lic_num" required>

    <label for="phone">Telefoonnummer:</label>
    <input type="tel" name="phone" required>

    <label for="password">Wachtwoord:</label>
    <input type="password" name="password" required>

    <label for="gender">Geslacht:</label>
    <select name="gender" required>
        <option value="male">Man</option>
        <option value="female">Vrouw</option>
        <option value="other">Anders</option>
    </select>

    <button type="submit">Voeg Klant Toe</button>
</form>

</body>
</html>

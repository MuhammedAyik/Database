<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarVerhuur|AdminUsers</title>
    <link rel="stylesheet" href="adminusers.css">
</head>
<body>
<?php

require_once('connection.php');

class UserManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getUsers()
    {
        $query = "SELECT * FROM users";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($email)
    {
        $sql = "DELETE FROM users WHERE EMAIL = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
    }
}

$database = new Database("localhost", "carproject", "root", "");
$pdo = $database->getPDO();

$userManager = new UserManager($pdo);

$users = $userManager->getUsers();
?>


<div class="hai">
    <div class="navbar">
        <div class="icon">
            <h2 class="logo">CaRs</h2>
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
    <div>
    <h1 class="header">USERS</h1>
            <div>
                <div>
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th>NAAM</th>
                                <th>E-MAIL</th>
                                <th>RIJBEWIJSNUMMER</th>
                                <th>TELEFOONNUMMER</th>
                                <th>GENDER</th>
                                <th>GEBRUIKERS VERWIJDEREN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($users as $user) {
                                echo "<tr class='active-row'>";
                                echo "<td>{$user['FNAME']} {$user['LNAME']}</td>";
                                echo "<td>{$user['EMAIL']}</td>";
                                echo "<td>{$user['LIC_NUM']}</td>";
                                echo "<td>{$user['PHONE_NUMBER']}</td>";
                                echo "<td>{$user['GENDER']}</td>";
                                echo "<td><button type='submit' class='but' name='approve'>";
                                echo "<a href='deleteuser.php?id={$user['EMAIL']}'>DELETE USER</a></button></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
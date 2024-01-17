<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarVerhuur|AdminVehicle</title>
    <link rel="stylesheet" href="adminvehicle.css">
</head>
<body>

<?php

require_once('connection.php');

class CarManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCars()
    {
        $query = "SELECT * FROM cars";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteCar($carId)
    {
        $sql = "DELETE FROM cars WHERE CAR_ID = :carId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);
        $stmt->execute();
    }
}

$pdo = $database->getPDO();

$carManager = new CarManager($pdo);

$cars = $carManager->getCars();
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
</div>
<div>
<h1 class="header">AUTO'S</h1>
            <button class="add"><a href="addcar.php">+ AUTO'S TOEVOEGEN</a></button>
            <div>
                <div>
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th>AUTO-ID</th>
                                <th>AUTONAAM</th>
                                <th>BRANDSTOFTYPE</th>
                                <th>CAPACITEIT</th>
                                <th>PRIJS</th>
                                <th>BESCHIKBAAR</th>
                                <th>VERWIJDEREN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($cars as $car) {
                            ?>
                            <tr  class="active-row">
                                <td><?php echo $car['CAR_ID'];?></td>
                                <td><?php echo $car['CAR_NAME'];?></td>
                                <td><?php echo $car['FUEL_TYPE'];?></td>
                                <td><?php echo $car['CAPACITY'];?></td>
                                <td><?php echo $car['PRICE'];?></td>
                                <td><?php echo $car['AVAILABLE']=='Y' ? 'YES' : 'NO'; ?></td>
                                <td>
                                    <button type="submit" class="but" name="approve">
                                        <a href="deletecar.php?id=<?php echo $car['CAR_ID']?>">AUTO VERWIJDEREN</a>
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
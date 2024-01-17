<?php

require_once('connection.php');

class CarManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function deleteCar($carId)
    {
        try {
            if ($this->pdo !== null) {
                $sql = "DELETE FROM cars WHERE CAR_ID = :carid";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':carid', $carId, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    echo '<script>alert("AUTO SUCCESVOL VERWIJDERD")</script>';
                    echo '<script>window.location.href = "adminvehicle.php";</script>';
                } else {
                    echo '<script>alert("FOUT BIJ VERWIJDEREN VAN AUTO")</script>';
                }
            } else {
                echo "Error: Database connection is not properly established";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

try {
    if (isset($_GET['id'])) {
        $carId = $_GET['id'];

        $carManager = new CarManager($database->getPDO());
        $carManager->deleteCar($carId);
    } else {
        echo "Error: Missing 'id' parameter";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $pdo = null;
}
?>

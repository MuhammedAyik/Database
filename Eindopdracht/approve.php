<?php

require_once('connection.php');

class BookingManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function approveBooking($bookId)
    {
        if (!$this->pdo) {
            echo "Error: Database connection not available.";
            return;
        }

        $sql = "SELECT * FROM booking WHERE BOOK_Id = :bookId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$res) {
            echo "Error: Booking not found.";
            return;
        }

        $carId = $res['CAR_ID'];

        $sql2 = "SELECT * FROM cars WHERE CAR_ID = :carId";
        $stmt2 = $this->pdo->prepare($sql2);
        $stmt2->bindParam(':carId', $carId, PDO::PARAM_INT);
        $stmt2->execute();
        $carResult = $stmt2->fetch(PDO::FETCH_ASSOC);

        if (!$carResult) {
            echo "Error: Car not found.";
            return;
        }

        $email = $res['EMAIL'];
        $carName = $carResult['CAR_NAME'];

        if ($carResult['AVAILABLE'] == 'Y') {
            if ($res['BOOK_STATUS'] == 'APPROVED' || $res['BOOK_STATUS'] == 'RETURNED') {
                echo '<script>alert("AL GOEDGEKEURD")</script>';
                echo '<script>window.location.href = "adminbook.php";</script>';
            } else {
                $query = "UPDATE booking SET BOOK_STATUS='GOEDGEKEURD' WHERE BOOK_ID=:bookId";
                $stmt3 = $this->pdo->prepare($query);
                $stmt3->bindParam(':bookId', $bookId, PDO::PARAM_INT);
                $stmt3->execute();

                $sql4 = "UPDATE cars SET AVAILABLE='N' WHERE CAR_ID=:carId";
                $stmt4 = $this->pdo->prepare($sql4);
                $stmt4->bindParam(':carId', $res['CAR_ID'], PDO::PARAM_INT);
                $stmt4->execute();

                echo '<script>alert("SUCCESVOL GOEDGEKEURD")</script>';
                echo '<script>window.location.href = "adminbook.php";</script>';
            }
        } else {
            echo '<script>alert("AUTO IS NIET BESCHIKBAAR")</script>';
            echo '<script>window.location.href = "adminbook.php";</script>';
        }
    }
}

$pdo = $database->getPDO();

if (isset($_GET['id'])) {
    $bookId = $_GET['id'];

    if ($pdo) {
        $bookingManager = new BookingManager($pdo);

        $bookingManager->approveBooking($bookId);
    } else {
        echo "Error: Database connection not available.";
    }
} else {
    echo "Booking ID not provided.";
}
?>

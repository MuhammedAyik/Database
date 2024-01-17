<?php

require_once('connection.php');

class BookingManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function returnCar($carId, $bookId)
    {
        $car = $this->getCarById($carId);
        $booking = $this->getBookingById($bookId);

        if ($car['AVAILABLE'] == 'Y') {
            echo '<script>alert("AUTO REEDS TERUGGEBRACHT")</script>';
            echo '<script>window.location.href = "adminbook.php";</script>';
        } else {
            $this->updateCarAvailability($carId, 'Y');
            $this->updateBookingStatus($bookId, 'GERETOURNEERD');

            echo '<script>alert("AUTO SUCCESVOL GERETOURNEERD")</script>';
            echo '<script>window.location.href = "adminbook.php";</script>';
        }
    }

    private function getCarById($carId)
    {
        $sql = "SELECT * FROM cars WHERE CAR_ID = :car_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':car_id', $carId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function getBookingById($bookId)
    {
        $sql = "SELECT * FROM booking WHERE BOOK_Id = :book_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function updateCarAvailability($carId, $availability)
    {
        $sql = "UPDATE cars SET AVAILABLE=:availability WHERE CAR_ID = :car_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':car_id', $carId, PDO::PARAM_INT);
        $stmt->bindParam(':availability', $availability, PDO::PARAM_STR);
        $stmt->execute();
    }

    private function updateBookingStatus($bookId, $status)
    {
        $sql = "UPDATE booking SET BOOK_STATUS=:status WHERE BOOK_ID = :book_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
    }
}

$bookingManager = new BookingManager($pdo);

$carId = $_GET['id'];
$bookId = $_GET['bookid'];

$bookingManager->returnCar($carId, $bookId);
?>

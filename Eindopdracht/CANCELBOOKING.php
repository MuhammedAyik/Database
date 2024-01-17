<?php

require_once('connection.php');

class BookingCancellation
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function cancelBooking($bid)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM booking WHERE BOOK_ID = :bid");
            $stmt->bindParam(':bid', $bid, PDO::PARAM_INT);
            $stmt->execute();

            header("Location: cardetails.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

session_start();

$bid = $_SESSION['bid'];

if (isset($_POST['cancelnow'])) {
    $bookingCancellation = new BookingCancellation($pdo);
    $bookingCancellation->cancelBooking($bid);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarVerhuur|CancelBooking</title>
    <link rel="stylesheet" href="cancelbooking.css">
</head>
<body>

<form class="form" method="POST">
    <h1>BENT U ZEKER DAT U UW BOEKING WILT ANNULEREN?</h1>
    <input type="submit" class="hai" value="CANCEL NOW" name="cancelnow">
    <button class="no"><a href="payment.php">GA NAAR BETALING</a></button>
</form>

</body>
</html>
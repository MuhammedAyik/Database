<?php
require_once('connection.php');

$pdo = $database->getPDO();

class BookingManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllBookings()
    {
        $query = "SELECT * FROM booking ORDER BY BOOK_ID DESC";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class BookingRenderer
{
    private $bookings;

    public function __construct($bookings)
    {
        $this->bookings = $bookings;
    }

    public function renderBookings()
    {
        ?>
        <div>
            <h1 class="header">BOEKINGEN</h1>
            <div>
                <div>
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th>AUTO-ID</th>
                                <th>E-MAIL</th>
                                <th>BOEK PLAATS</th>
                                <th>BOEKDATUM</th>
                                <th>DUUR</th>
                                <th>TELEFOONNUMMER</th>
                                <th>BESTEMMING</th>
                                <th>RETOURDATUM</th>
                                <th>BOEKINGSSTATUS</th>
                                <th>GOEDKEUREN</th>
                                <th>AUTO RETOURNEER</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($this->bookings as $booking) : ?>
                            <tr class="active-row">
                                <td><?php echo isset($booking['CAR_ID']) ? $booking['CAR_ID'] : ''; ?></td>
                                <td><?php echo isset($booking['user_id']) ? $booking['user_id'] : ''; ?></td>
                                <td><?php echo isset($booking['BOOK_PLACE']) ? $booking['BOOK_PLACE'] : ''; ?></td>
                                <td><?php echo isset($booking['BOOK_DATE']) ? $booking['BOOK_DATE'] : ''; ?></td>
                                <td><?php echo isset($booking['DURATION']) ? $booking['DURATION'] : ''; ?></td>
                                <td><?php echo isset($booking['PHONE_NUMBER']) ? $booking['PHONE_NUMBER'] : ''; ?></td>
                                <td><?php echo isset($booking['DESTINATION']) ? $booking['DESTINATION'] : ''; ?></td>
                                <td><?php echo isset($booking['RETURN_DATE']) ? $booking['RETURN_DATE'] : ''; ?></td>
                                <td><?php echo isset($booking['BOOK_STATUS']) ? $booking['BOOK_STATUS'] : ''; ?></td>
                                <td><button type="submit" class="but" name="approve"><a href="approve.php?id=<?php echo $booking['BOOK_ID'] ?>">GOEDKEUREN</a></button></td>
                                <td><button type="submit" class="but" name="approve"><a href="adminreturn.php?id=<?php echo $booking['CAR_ID'] ?>&bookid=<?php echo $booking['BOOK_ID'] ?>">RETOURNEREN</a></button></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
}

$bookingManager = new BookingManager($pdo);
$bookings = $bookingManager->getAllBookings();

$bookingRenderer = new BookingRenderer($bookings);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarVerhuur|Adminbook</title>
    <link rel="stylesheet" href="adminbook.css">
</head>
<body>

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

<?php $bookingRenderer->renderBookings(); ?>

</body>
</html>

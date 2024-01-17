<?php
session_start();

if (!isset($_SESSION['pdo'])) {

    require_once('connection.php');

    $_SESSION['pdo'] = $pdo;
}

class User
{
    private $pdo;
    private $user;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;

        if (!isset($_SESSION['user_id'])) {
            die("User ID not set in the session.");
        }

        $user_id = $_SESSION['user_id'];

        try {
            $stmtUser = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
            $stmtUser->bindParam(':user_id', $user_id);
            $stmtUser->execute();

            $this->user = $stmtUser->fetch(PDO::FETCH_ASSOC);

            if (!$this->user) {
                die("User not found.");
            }
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getUser()
    {
        return $this->user;
    }
}

class Booking
{
    private $pdo;
    private $userEmail;

    public function __construct($pdo, $userEmail)
    {
        $this->pdo = $pdo;
        $this->userEmail = $userEmail;

    }

    public function getBookings()
    {
        try {
            $stmtBookings = $this->pdo->prepare("SELECT * FROM booking WHERE EMAIL = :user_email");
            $stmtBookings->bindParam(':user_email', $this->userEmail);
            $stmtBookings->execute();

            $bookings = [];

            while ($booking = $stmtBookings->fetch(PDO::FETCH_ASSOC)) {
                $bookings[] = $booking;
            }

            return $bookings;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}

$user = new User($_SESSION['pdo']);
$booking = new Booking($_SESSION['pdo'], $user->getUser()['EMAIL']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOKING STATUS</title>
    <link rel="stylesheet" href="bookinstatus.css">
</head>
<body>
<div class="cd">
        <div class="main">
            <div class="navbar">
                <div class="icon">
                    <h2 class="logo">CarVerhuur</h2>
                </div>
                <div class="menu">
                    <ul>
                        <li><a href="cardetails.php">HOME</a></li>
                        <li><a href="#">OVER ONS</a></li>
                        <li><a href="#">CONTACT</a></li>
                        <li><a href="#">FEEDBACK</a></li>
                        <li><a id="stat" href="bookinstatus.php">BOEKINGSSTATUS</a></li>
                        <li><button class="nn"><a href="index.php">LOG UIT</a></button></li>
                        <li><img src="images/profile.png" class="circle" alt="Alps"></li>
                        <li><p class="phello">HALLO! &nbsp;<span id="pname" style="font-weight: bold;"><?php echo $user->getUser()['FNAME']." ".$user->getUser()['LNAME']?></span></p></li>
                    </ul>
                </div>
            </div>

            <div class="box">
<h1>Welkom, <strong><?php echo $user->getUser()['FNAME'] . " " . $user->getUser()['LNAME']; ?></strong>!</h1> <br>
                <h2>Uw boekingsgeschiedenis:</h2>
                <table border="1">
                    <tr>
                        <th>Boekings-ID</th>
                        <th>Auto-ID</th>
                        <th>Boekplaats</th>
                        <th>Boekdatum</th>
                        <th>Duur</th>
                        <th>Telefoonnummer</th>
                        <th>Bestemming</th>
                        <th>Retourdatum</th>
                        <th>Prijs</th>
                        <th>Boekingsstatus</th>
                    </tr>
                    <?php
                        foreach ($booking->getBookings() as $booking) {
                            echo "<tr>";
                            echo "<td>{$booking['BOOK_ID']}</td>";
                            echo "<td>{$booking['CAR_ID']}</td>";
                            echo "<td>{$booking['BOOK_PLACE']}</td>";
                            echo "<td>{$booking['BOOK_DATE']}</td>";
                            echo "<td>{$booking['DURATION']}</td>";
                            echo "<td>{$booking['PHONE_NUMBER']}</td>";
                            echo "<td>{$booking['DESTINATION']}</td>";
                            echo "<td>{$booking['RETURN_DATE']}</td>";
                            echo "<td>{$booking['PRICE']}</td>";
                            echo "<td>{$booking['BOOK_STATUS']}</td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
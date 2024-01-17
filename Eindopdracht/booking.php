<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAR BOOKING</title>
    <link rel="stylesheet" href="booking.css">
</head>
<body background="images/book.jpg">

<?php
session_start();

require_once('connection.php');

class User {
    private $email;

    public function __construct($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }
}

class Car {
    private $carId;
    private $carDetails;

    public function __construct($carId, $pdo) {
        $this->carId = $carId;
        $this->loadCarDetails($pdo);
    }

    private function loadCarDetails($pdo) {
        $query = $pdo->prepare("SELECT * FROM cars WHERE CAR_ID = :carId");
        $query->bindParam(':carId', $this->carId, PDO::PARAM_INT);
        $query->execute();

        $this->carDetails = $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getCarDetails() {
        return $this->carDetails;
    }
}

class Booking {
    private $car;
    private $user;
    private $pdo;

    public function __construct($car, $user, $pdo) {
        $this->car = $car;
        $this->user = $user;
        $this->pdo = $pdo;
    }

    public function book($place, $date, $dur, $phno, $des, $rdate) {
        $carDetails = $this->car->getCarDetails();
        $userEmail = $this->user->getEmail();

        $price = $carDetails['PRICE'] * $dur;

        $query = $this->pdo->prepare("INSERT INTO booking (CAR_ID, BOOK_PLACE, BOOK_DATE, DURATION, PHONE_NUMBER, DESTINATION, RETURN_DATE, PRICE, BOOK_STATUS, EMAIL)
        VALUES (:carId, :place, :date, :dur, :phno, :des, :rdate, :price, 'UNDER PROCESSING', :userId)");

        $query->bindParam(':carId', $carDetails['CAR_ID'], PDO::PARAM_INT);
        $query->bindParam(':place', $place, PDO::PARAM_STR);
        $query->bindParam(':date', $date, PDO::PARAM_STR);
        $query->bindParam(':dur', $dur, PDO::PARAM_INT);
        $query->bindParam(':phno', $phno, PDO::PARAM_STR);
        $query->bindParam(':des', $des, PDO::PARAM_STR);
        $query->bindParam(':rdate', $rdate, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_INT);
        $query->bindParam(':userId', $userEmail, PDO::PARAM_STR);

        $query->execute();
    }
}

$user = new User(isset($_SESSION['email']) ? $_SESSION['email'] : null);
$carId = isset($_POST['car_id']) ? $_POST['car_id'] : null;
$car = new Car($carId, $pdo);

if ($carId === null) {
    echo '<script>alert("Invalid car ID");</script>';
} else {
    $booking = new Booking($car, $user, $pdo);

    if (isset($_POST['book'])) {
        $bplace = isset($_POST['place']) ? htmlspecialchars($_POST['place']) : null;
        $bdate = isset($_POST['date']) ? date('Y-m-d', strtotime($_POST['date'])) : null;
        $dur = isset($_POST['dur']) ? htmlspecialchars($_POST['dur']) : null;
        $phno = isset($_POST['ph']) ? htmlspecialchars($_POST['ph']) : null;
        $des = isset($_POST['des']) ? htmlspecialchars($_POST['des']) : null;
        $rdate = isset($_POST['rdate']) ? date('Y-m-d', strtotime($_POST['rdate'])) : null;

        if (!empty($bplace) && !empty($bdate) && !empty($dur) && !empty($phno) && !empty($des) && !empty($rdate)) {
            if ($bdate < $rdate) {
                $booking->book($bplace, $bdate, $dur, $phno, $des, $rdate);
                header("Location: payment.php");
            } else {
                echo '<script>alert("Please enter a valid return date");</script>';
            }
        } else {
        }
    }
}
?>


       <div class="hai">
            <div class="navbar">
                <div class="icon">
                    <h2 class="logo">CarVerhuur</h2>
                </div>
                <div class="menu" >
                    <ul>
                        <li ><a href="cardetails.php">HOME</a></li>
                        <li><a href="#">OVER ONS</a></li>
                        <li><a href="#">CONTACT</a></li>
                        <li><button class="nn"><a href="index.html">LOG UIT</a></button></li>
                        <li><img src="images/profile.png" class="circle" alt="Alps"></li>
                        <li>
                        <p class="phello">
                            HELLO! &nbsp;
                            <a id="pname">
                            <?php
                            if ($user->getEmail() !== null) {
                                echo $user->getEmail();
                            } else {
                                echo 'N/A';
                            }
                            ?>

                            </a>
                        </p>
                                </a>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
       </div>

       <div class="main">
        <div class="register">
            <h2>BOOKING</h2>
            <form id="register" method="POST" onsubmit="return validateForm()">
                <h2>CAR NAME: <?php echo $car->getCarDetails()['CAR_NAME'] ?? 'N/A'; ?></h2>
                <input type="hidden" name="car_id" value="<?php echo $carId; ?>">
                <label>BOEKINGSPLAATS: </label>
                <br>
                <input type="text" name="place" id="place" placeholder="Voer uw bestemming in">
                <br><br>

                <label>BOEKINGSDATUM: </label>
                <br>
                <input type="date" name="date" id="datefield" min='1899-01-01' max='2000-13-13' placeholder="Vul de datum voor reservering in">
                <br><br>

                <label>DUUR: </label>
                <br>
                <input type="number" name="dur" min="1" max="30" id="duration" placeholder="Vul huurperiode in (in dagen)">
                <br><br>

                <label>TELEFOONNUMMER: </label>
                <br>
                <input type="tel" name="ph" maxlength="10" id="ph" placeholder="Enter Your Phone Number">
                <br><br>

                <label>BESTEMMING: </label>
                <br>
                <input type="text" name="des" id="des" placeholder="Voer uw bestemming in">
                <br><br>

                <label>RETOURDATUM: </label>
                <br>
                <input type="date" name="rdate" id="rdate" min='1899-01-01' placeholder="Voer de retourdatum in">
                <br><br>
                <input type="submit" class="btnn" value="BOOK" name="book">
            </form>
        </div>
    </div>

    <script>
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }

        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("datefield").setAttribute("min", today);
        document.getElementById("datefield").setAttribute("max", today);
    </script>
    <script>
        function validateForm() {
            var bplace = document.getElementById("place").value;
            var bdate = document.getElementById("datefield").value;
            var dur = document.getElementById("duration").value;
            var phno = document.getElementById("ph").value;
            var des = document.getElementById("des").value;
            var rdate = document.getElementById("rdate").value;

            if (bplace === "" || bdate === "" || dur === "" || phno === "" || des === "" || rdate === "") {
                alert("Please fill in all the details");
                return false;
            }
        }
    </script>
</body>

</html>
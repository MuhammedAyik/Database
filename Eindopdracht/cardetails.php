<?php
require_once('connection.php');
session_start();

class User {
    private $email;
    private $firstName;
    private $lastName;
    private $userId;

    public function __construct($email, $pdo) {
        $this->email = $email;
        $this->pdo = $pdo;
        $this->getUserInfo();
    }

    public function getUserId() {
        return $this->userId;
    }

    private function getUserInfo() {
        $stmtUser = $this->pdo->prepare("SELECT * FROM users WHERE EMAIL = :email");
        $stmtUser->bindParam(':email', $this->email);
        $stmtUser->execute();
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

        $this->userId = $user['user_id'];

        $this->firstName = $user['FNAME'];
        $this->lastName = $user['LNAME'];
    }

    public function getFullName() {
        return $this->firstName . " " . $this->lastName;
    }
}


class Car {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAvailableCars() {
        $stmtCars = $this->pdo->prepare("SELECT * FROM cars WHERE AVAILABLE = 'Y'");
        $stmtCars->execute();
        return $stmtCars->fetchAll(PDO::FETCH_ASSOC);
    }
}

$user = new User($_SESSION['email'], $pdo);
$car = new Car($pdo);
$availableCars = $car->getAvailableCars();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link rel="stylesheet" href="cardetails.css">

</head>

<body class="body">


</script>
  <div class="cd">
    <div class="main">
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">CaRs</h2>
            </div>
            <div class="menu">
                <ul>
                <li><a href="cardetails.php">HOME</a></li>
                    <li><a href="#">OVER ONS</a></li>
                    <li><a href="#">CONTACT</a></li>
                    <li><a href="feedback/Feedbacks.php">FEEDBACK</a></li>
                    <li><a id="stat" href="bookinstatus.php">BOEKINGSSTATUS</a></li>
                    <li><button class="nn"><a href="index.php">LOG UIT</a></button></li>
                    <li><img src="images/profile.png" class="circle" alt="Alps"></li>
                    <li><p class="phello">HALLO! &nbsp;<a id="pname"><?php echo $user->getFullName(); ?></a></p></li>

                </ul>
            </div>
        </div>

<div><h1 class="overview">ONS AUTO'SOVERZICHT</h1>

    <ul class="de">
        <?php
        $availableCars = $car->getAvailableCars();

        if ($availableCars !== null) {
            foreach ($availableCars as $result) {
                ?>
                <li>
                    <form method="POST" action="booking.php" enctype="multipart/form-data">
                        <div class="box">
                            <div class="imgBx">
                                <img src="images/<?php echo $result['CAR_IMG'] ?>">
                            </div>
                            <div class="content">
                                <?php $res = $result['CAR_ID']; ?>
                                <h1><?php echo $result['CAR_NAME'] ?></h1>
                                <h2>Brandstoftype: <a><?php echo $result['FUEL_TYPE'] ?></a></h2>
                                <h2>Beschikbaarheid: <a><?php echo $result['CAPACITY'] ?></a></h2>
                                <h2>Huur per dag: <a>€<?php echo $result['PRICE'] ?>/-</a></h2>
                                <input type="hidden" name="car_id" value="<?php echo $res; ?>">
                                <button type="submit" name="book" class="button">Boek</button>
                            </div>
                        </div>
                    </form>
                </li>
                <?php
            }
        } else {
            echo "No available cars found.";
        }
        ?>
    </ul>
</div>
 </div>
  </div>
</body>
</html>
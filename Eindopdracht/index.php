<!DOCTYPE html>
<html lang="en">
<head>
    <title>CarVerhuur|Home</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<?php
class_exists('Database') || require_once('connection.php');

class UserAuthenticator {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function loginUser($email, $pass) {
        if (empty($email) || empty($pass)) {
            echo '<script>alert("Vul de lege velden in")</script>';
        } else {
            try {
                $query = "SELECT * FROM users WHERE EMAIL = :email";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    $db_password = $row['PASSWORD'];

                    if (md5($pass) == $db_password) {
                        $this->startSession($email, $row['user_id']);
                        header("location: cardetails.php");
                        exit();
                    } else {
                        echo '<script>alert("Voer een juist wachtwoord in")</script>';
                    }
                } else {
                    echo '<script>alert("Voer een correct e-mailadres in")</script>';
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    private function startSession($email, $userId) {
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $userId;
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $userAuthenticator = new UserAuthenticator($database->getPDO());
    $userAuthenticator->loginUser($email, $pass);
}

?>

<div class="hai">
    <div class="navbar">
        <div class="icon">
            <h2 class="logo">CarVerhuur</h2>
        </div>
        <div class="menu">
            <ul>
                <li><a href="#">HOME</a></li>
                <li><a href="#">OVER ONS</a></li>
                <li><a href="#">DIENSTEN</a></li>
                <li><a href="contactus.html">CONTACT</a></li>
                <li><button class="adminbtn"><a href="adminlogin.php">ADMIN LOGIN</a></button></li>
            </ul>
        </div>
    </div>
    <div class="content">
        <h1>Huur uw <br><span>droomauto</span></h1>
        <p class="par">Leef het leven van luxe.<br>
            Huur gewoon de auto van uw keuze uit onze uitgebreide collectie.<br>Geniet van elk moment met uw gezin<br>
            Sluit je bij ons aan om deze familie groot te maken. </p>
        <button class="cn"><a href="register.php">Word lid van ons</a></button>
        <div class="form">
            <h2>Log hier in</h2>
            <form method="POST">
                <input type="email" name="email" placeholder="Voer E-mail hier in">
                <input type="password" name="pass" placeholder="Voer hier uw wachtwoord in">
                <input class="btnn" type="submit" value="Login" name="login"></input>
            </form>
            <p class="link">Heeft u geen account?<br>
                <a href="register.php">Meld je aan</a> hier</a></p>
            <p class="liw">of<br>Log in met</p>
            <div class="icon">
                &emsp;&emsp;&emsp;&ensp;<a href="https://www.facebook.com/"><ion-icon name="logo-facebook"></ion-icon> </a>&nbsp;&nbsp;
                <a href="https://www.instagram.com/"><ion-icon name="logo-instagram"></ion-icon> </a>&ensp;
                <a href="https://myaccount.google.com/"><ion-icon name="logo-google"></ion-icon> </a>&ensp;
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
</body>
</html>

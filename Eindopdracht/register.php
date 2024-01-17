<!DOCTYPE html>
<html lang="en">
<head>
<title>CarVerhuur|Registratie</title>
<link rel="stylesheet" href="css/regs.css" type="text/css">
<link rel="stylesheet" href="css/register.css">

</head>
<body>
<?php

require_once('connection.php');

class Registration
{
    private $pdo;

    public function __construct($hostname, $dbname, $username, $password)
    {
        $this->pdo = new PDO("mysql:host={$hostname};dbname={$dbname}", $username, $password);
    }

    public function registerUser($fname, $lname, $email, $lic, $ph, $pass, $cpass, $gender)
    {
        $Pass = md5($pass);

        if (empty($fname) || empty($lname) || empty($email) || empty($lic) || empty($ph) || empty($pass) || empty($gender)) {
            echo '<script>alert("Gelieve alle velden in te vullen")</script>';
        } else {
            if ($pass == $cpass) {
                $emailExists = $this->checkEmailExists($email);

                if ($emailExists) {
                    echo '<script>alert("E-mail bestaat al. Druk op OK om in te loggen.")</script>';
                    echo '<script>window.location.href = "index.php";</script>';
                } else {
                    $result = $this->insertUser($fname, $lname, $email, $lic, $ph, $Pass, $gender);

                    if ($result) {
                        echo '<script>alert("Registratie gelukt. Druk op OK om in te loggen.")</script>';
                        echo '<script>window.location.href = "index.php";</script>';
                    } else {
                        echo '<script>alert("Controleer de verbinding")</script>';
                    }
                }
            } else {
                echo '<script>alert("Wachtwoorden komen niet overeen")</script>';
                echo '<script>window.location.href = "register.php";</script>';
            }
        }
    }

    private function checkEmailExists($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE EMAIL = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    private function insertUser($fname, $lname, $email, $lic, $ph, $pass, $gender)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (FNAME, LNAME, EMAIL, LIC_NUM, PHONE_NUMBER, PASSWORD, GENDER) VALUES (:fname, :lname, :email, :lic, :ph, :pass, :gender)");
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':lic', $lic);
        $stmt->bindParam(':ph', $ph);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':gender', $gender);

        return $stmt->execute();
    }
}

if (isset($_POST['regs'])) {
    $registration = new Registration($hostname, $dbname, $username, $password);

    $registration->registerUser(
        $_POST['fname'],
        $_POST['lname'],
        $_POST['email'],
        $_POST['lic'],
        $_POST['ph'],
        $_POST['pass'],
        $_POST['cpass'],
        $_POST['gender']
    );
}

?>



<button id="back"><a href="index.php">HOME</a></button>
<h1 id="fam">WORD LID VAN ONZE FAMILIE VAN AUTO'S!</h1>
<div class="main">
    <div class="register">
        <h2>Registreer hier</h2>
        <form id="register" action="register.php" method="POST">
            <label>Voornaam: </label>
            <br>
            <input type="text" name="fname" id="name" placeholder="Vul uw voornaam in" required>
            <br><br>

            <label>Achternaam: </label>
            <br>
            <input type="text" name="lname" id="name" placeholder="Voer uw achternaam in" required>
            <br><br>

            <label>Email:</label>
            <br>
            <input type="email" name="email" id="name" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="ex: example@ex.com" placeholder="Vul een geldig emailadres in" required>
            <br><br>

            <label>Uw rijbewijsnummer: </label>
            <br>
            <input type="text" name="lic" id="name" placeholder="Voer uw rijbewijsnummer in" required>
            <br><br>

            <label>Telefoonnummer :</label>
            <br>
            <input type="tel" name="ph" maxlength="10" onkeypress="return onlyNumberKey(event)" id="name" placeholder="Vul je telefoonnummer in" required>
            <br><br>

            <label>Wachtwoord: </label>
            <br>
            <input type="password" name="pass" maxlength="12" id="psw" placeholder="Voer wachtwoord in" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Moet minimaal één cijfer, één hoofdletter en kleine letter bevatten, en minimaal acht of meer tekens" required>
            <br><br>
            <label>Bevestig wachtwoord:</label>
            <br>
            <input type="password" name="cpass" id="cpsw" placeholder="voer het wachtwoord in" required>
            <br><br>
            <tr>
                <td><label">Geslacht : </label></td><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td>
                    <label for="one">Man</label>
                    <input type="radio" id="input_enabled" name="gender" value="male" style="width:200px">
                </td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <td>
                    <label for="two">Vrouw</label>
                    <input type="radio" id="input_disabled" name="gender" value="female" style="width:160px" />
                </td>
            </tr>
            <br><br>
            <input type="submit" class="btnn" value="REGISTREER" name="regs" style="background-color: red;color: white">
        </form>
    </div>
</div>
<div id="message">
     <h3>Wachtwoord moet het volgende bevatten:</h3>
     <p id="letter" class="invalid">Een <b>kleine</b> letter</p>
     <p id="capital" class="invalid">Een <b>hoofdletter (hoofdletter)</b> letter</p>
     <p id="nummer" class="invalid">Een <b>nummer</b></p>
     <p id="length" class="invalid">Minimaal <b>8 tekens</b></p>
</div>
<script>
  var myInput = document.getElementById("psw");
  var letter = document.getElementById("letter");
  var capital = document.getElementById("capital");
  var number = document.getElementById("nummer");
  var length = document.getElementById("length");

    myInput.onfocus = function () {
        document.getElementById("message").style.display = "block";
    }

    myInput.onblur = function () {
        document.getElementById("message").style.display = "none";
    }

    myInput.onkeyup = function () {
        var lowerCaseLetters = /[a-z]/g;
        if (myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        var upperCaseLetters = /[A-Z]/g;
        if (myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        var numbers = /[0-9]/g;
        if (myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        if (myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }
</script>
<script>
    function onlyNumberKey(evt) {
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
</script>
</body>
</html>

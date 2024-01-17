<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarVerhuur|AdminLogin</title>
    <link rel="stylesheet" href="adminlogin.css">
</head>
<body>
<?php
include('connection.php');

class AdminLogin
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function attemptLogin($id, $pass)
    {
        if (empty($id) || empty($pass)) {
            echo '<script>alert("Vul alstublieft de lege plekken in")</script>';
        } else {
            $query = "SELECT * FROM admin WHERE ADMIN_ID='$id'";
            $result = $this->pdo->query($query);

            if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $db_password = $row['ADMIN_PASSWORD'];

                if ($pass == $db_password) {
                    echo '<script>alert("Welkom ADMINISTRATOR!");</script>';
                    header("location: admindash.php");
                } else {
                    echo '<script>alert("Voer een juist wachtwoord in")</script>';
                }
            } else {
                echo '<script>alert("Voer een correct e-mailadres in")</script>';
            }
        }
    }
}

$database = new Database('localhost', 'carproject', 'root', '');

$adminLogin = new AdminLogin($database->getPDO());

if (isset($_POST['adlog'])) {
    $id = $_POST['adid'];
    $pass = $_POST['adpass'];
    $adminLogin->attemptLogin($id, $pass);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarVerhuur|AdminLogin</title>
</head>
<body>
<button class="back"><a href="index.php">Ga naar home</a></button>
    <div class="helloadmin">
        <h1>HALLO ADMIN!</h1>
    </div>

    <form class="form" method="POST">
        <h2>Admin Login</h2>
        <input class="h" type="text" name="adid" placeholder="Voer de admin user id in">
        <input class="h" type="password" name="adpass" placeholder="Voer het admin wachtwoord in">
        <input type="submit" class="btnn" value="LOGIN" name="adlog">
    </form>
</body>
</html>
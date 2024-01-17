<?php

class CarManager {
    private $hostname;
    private $dbname;
    private $username;
    private $password;

    public function __construct($hostname, $dbname, $username, $password) {
        $this->hostname = $hostname;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    public function addCar() {
        if (isset($_POST['addcar'])) {
            require_once('connection.php');

            $img_name = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $error = $_FILES['image']['error'];

            if ($error === 0) {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png", "webp", "svg");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = 'images/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    $carname = $_POST['carname'];
                    $ftype = $_POST['ftype'];
                    $capacity = $_POST['capacity'];
                    $price = $_POST['price'];
                    $available = "Y";

                    try {
                        $dbh = new PDO("mysql:host={$this->hostname};dbname={$this->dbname}", $this->username, $this->password);
                        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $stmt = $dbh->prepare("INSERT INTO cars (CAR_NAME, FUEL_TYPE, CAPACITY, PRICE, CAR_IMG, AVAILABLE) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->bindParam(1, $carname);
                        $stmt->bindParam(2, $ftype);
                        $stmt->bindParam(3, $capacity);
                        $stmt->bindParam(4, $price);
                        $stmt->bindParam(5, $new_img_name);
                        $stmt->bindParam(6, $available);

                        $stmt->execute();

                        echo '<script>alert("Nieuwe auto succesvol toegevoegd!!")</script>';
                        echo '<script>window.location.href = "adminvehicle.php";</script>';
                    } catch (PDOException $e) {
                        $error_message = "Database Error: " . $e->getMessage();
                        echo '<script>alert("' . $error_message . '")</script>';
                        echo '<script>window.location.href = "addcar.php";</script>';
                    }
                } else {
                    echo '<script>alert("Kan dit type afbeelding niet uploaden")</script>';
                    echo '<script>window.location.href = "addcar.php";</script>';
                }
            } else {
                $em = "Unknown error occurred";
                header("Location: addcar.php?error=$em");
            }
        } else {
            echo "false";
        }
    }
}

$carManager = new CarManager("localhost", "carproject", "root", "");
$carManager->addCar();

?>

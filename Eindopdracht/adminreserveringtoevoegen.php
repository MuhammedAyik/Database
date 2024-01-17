<?php
include 'connection.php';

// Usage example
$hostname = "localhost";
$dbname = "carproject";
$username = "root";
$password = "";

$database = new Database($hostname, $dbname, $username, $password);
$pdo = $database->getPDO();

class Booking
{
    private $pdo;

    public function __construct($pdo)
    {
        if (isset($pdo)) {
            $this->pdo = $pdo;
        } else {
        }
    }

    public function addReservation($carId, $bookPlace, $bookDate, $duration, $phoneNumber, $destination, $returnDate, $userId)
    {
        $sql = "INSERT INTO `booking` (`CAR_ID`, `BOOK_PLACE`, `BOOK_DATE`, `DURATION`, `PHONE_NUMBER`, `DESTINATION`, `RETURN_DATE`, `BOOK_STATUS`, `user_id`)
                VALUES (:carId, :bookPlace, :bookDate, :duration, :phoneNumber, :destination, :returnDate, 'IN VERWERKING', :userId)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);
        $stmt->bindParam(':bookPlace', $bookPlace, PDO::PARAM_STR);
        $stmt->bindParam(':bookDate', $bookDate, PDO::PARAM_STR);
        $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
        $stmt->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_INT);
        $stmt->bindParam(':destination', $destination, PDO::PARAM_STR);
        $stmt->bindParam(':returnDate', $returnDate, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        try {
            $stmt->execute();
            $response = array("status" => "success", "message" => "Reservering succesvol toegevoegd.");
            echo json_encode($response);
        } catch (PDOException $e) {
            $response = array("status" => "error", "message" => "Databasefout: " . $e->getMessage());
            echo json_encode($response);
        }
    }

    public function handleFormSubmission()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $carId = isset($_POST['car_id']) ? $_POST['car_id'] : null;
            $bookPlace = isset($_POST['book_place']) ? $_POST['book_place'] : null;
            $bookDate = isset($_POST['book_date']) ? $_POST['book_date'] : null;
            $duration = isset($_POST['duration']) ? $_POST['duration'] : null;
            $phoneNumber = isset($_POST['phone_number']) ? $_POST['phone_number'] : null;
            $destination = isset($_POST['destination']) ? $_POST['destination'] : null;
            $returnDate = isset($_POST['return_date']) ? $_POST['return_date'] : null;
            $userId = isset($_POST['user_id']) ? $_POST['user_id'] : null;

            if ($carId && $bookPlace && $bookDate && $duration && $phoneNumber && $destination && $returnDate && $userId) {
                $this->addReservation($carId, $bookPlace, $bookDate, $duration, $phoneNumber, $destination, $returnDate, $userId);
            } else {
                $response = array("status" => "error", "message" => "Vul alle vereiste velden in voordat je het formulier indient.");
                echo json_encode($response);
            }
        }
    }
}

$booking = new Booking($pdo);
$booking->handleFormSubmission();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reservering Toevoegen</title>
    <link rel="stylesheet" href="adminreserveringtoevoegen.css">
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
        <form method="post" action="">
            <label for="user_id">Gebruiker:</label>
            <select name="user_id" id="user_id" required>
                <?php
                $userQuery = "SELECT user_id, CONCAT(FNAME, ' ', LNAME) AS full_name FROM users";
                $userResult = $pdo->query($userQuery);

                while ($user = $userResult->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value=\"{$user['user_id']}\">{$user['full_name']}</option>";
                }
                ?>
            </select><br>

            <label for="car_id">Auto:</label>
            <select name="car_id" required>
                <?php
                $carQuery = "SELECT CAR_ID, CAR_NAME FROM cars WHERE AVAILABLE = 'Y'";
                $carResult = $pdo->query($carQuery);

                while ($car = $carResult->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value=\"{$car['CAR_ID']}\">{$car['CAR_NAME']}</option>";
                }
                ?>
            </select><br>

            <label for="book_place">Boekingsplaats:</label>
            <input type="text" name="book_place" placeholder="Voer uw bestemming in" required><br>

            <label for="book_date">Boekingsdatum:</label>
            <input type="date" name="book_date" placeholder="dd-01-2024" required><br>

            <label for="duration">Duur:</label>
            <input type="text" name="duration" placeholder="Vul huurperiode in (in dagen)" required><br>

            <label for="phone_number">Telefoonnummer:</label>
            <input type="text" name="phone_number" placeholder="Vul je telefoonnummer in" required><br>

            <label for="destination">bestemming:</label>
            <input type="text" name="destination" placeholder="Voer uw bestemming in" required><br>

            <label for="return_date">Retourdatum:</label>
            <input type="date" name="return_date" required><br>

            <input type="submit" value="Add Reservation">
        </form>

        <div id="notification"></div>


        <script>
    function submitForm() {
        var form = document.querySelector('form');

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Het formulier is succesvol verwerkt.', 'error');
            });
        });
    }

    function showNotification(message, type) {
        var notification = document.getElementById('notification');

        var popup = document.createElement('div');
        popup.innerHTML = '<p>' + message + '</p>';

        if (type === 'success') {
            popup.className = 'success';
        } else {
            popup.className = 'error';
        }

        notification.innerHTML = '';
        notification.appendChild(popup);
    }

    document.addEventListener('DOMContentLoaded', function () {
        submitForm();
    });
</script>
</div>
</body>
</html>
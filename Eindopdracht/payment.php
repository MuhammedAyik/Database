<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.1/css/all.min.css" href="main.js" />
  <script src="main.js"></script>
  <link rel="stylesheet" href="css/pay.css" />
  <link rel="stylesheet" href="payment.css">
  <title>CarVerhuur|Payment</title>
  <script type="text/javascript">
    function preventBack() {
      window.history.forward();
    }

    setTimeout("preventBack()", 0);

    window.onunload = function () {
      null
    };
  </script>
</head>
<body>
<?php

require_once('connection.php');

class BookingHandler
{
    private $pdo;
    private $bookingDetails;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        session_start();
    }

    public function getBookingDetails()
    {
        $email = $_SESSION['email'];
        $sql = "SELECT * FROM booking WHERE email = :email ORDER BY BOOK_ID DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $this->bookingDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "SQL Query: $sql<br>";

        echo "Booking Details: ";
        print_r($this->bookingDetails);

        return $this->bookingDetails;
    }

    public function processPayment($cardno, $exp, $cvv)
    {
        $this->getBookingDetails();

        echo "Booking Details: ";
        print_r($this->bookingDetails);

        if (is_array($this->bookingDetails)) {
            $bid = $this->bookingDetails['BOOK_ID'];
            $_SESSION['bid'] = $bid;

            if (empty($cardno) || empty($exp) || empty($cvv)) {
                echo '<script>alert("Vul alstublieft alle velden in")</script>';
            } else {
                $carId = $this->bookingDetails['CAR_ID'];

                $this->updateCarCapacity($carId);

                $price = isset($this->bookingDetails['PRICE']) ? $this->bookingDetails['PRICE'] : 0;
                $this->insertPaymentDetails($bid, $cardno, $exp, $cvv, $price);
            }
        } else {
            echo "Error: No data found for the given email.";
        }
    }

    private function updateCarCapacity($carId)
    {
        $sql = "UPDATE cars SET CAPACITY = CAPACITY - 1 WHERE CAR_ID = :carId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);
        $stmt->execute();
    }

    private function insertPaymentDetails($bid, $cardno, $exp, $cvv, $price)
    {
        $sql = "INSERT INTO payment (BOOK_ID, CARD_NO, EXP_DATE, CVV, PRICE) VALUES (:bid, :cardno, :exp, :cvv, :price)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':bid', $bid, PDO::PARAM_INT);
        $stmt->bindParam(':cardno', $cardno, PDO::PARAM_STR);
        $stmt->bindParam(':exp', $exp, PDO::PARAM_STR);
        $stmt->bindParam(':cvv', $cvv, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: psucess.php");
        }
    }
}

$bookingHandler = new BookingHandler($pdo);

if (isset($_POST['pay'])) {
    $cardno = htmlspecialchars($_POST['cardno']);
    $exp = htmlspecialchars($_POST['exp']);
    $cvv = htmlspecialchars($_POST['cvv']);
    $bookingHandler->processPayment($cardno, $exp, $cvv);
}
?>

<h2 class="payment">BETALING:</h2>


  <div class="card">
    <form method="POST">
      <h1 class="card__title">Voer betalingsgegevens in</h1>
      <div class="card__row">
        <div class="card__col">
          <label for="cardNumber" class="card__label">Kaartnummer</label><input type="text" class="card__input card__input--large" id="cardNumber" placeholder="xxxx-xxxx-xxxx-xxxx" required="required" name="cardno" maxlength="16" />
        </div>
        <div class="card__col card__chip">
          <img src="images/chip.svg" alt="chip" />
        </div>
      </div>
      <div class="card__row">
        <div class="card__col">
          <label for="cardExpiry" class="card__label">Vervaldatum</label><input type="text" class="card__input" id="cardExpiry" placeholder="xx/xx" required="required" name="exp" maxlength="5" />
        </div>
        <div class="card__col">
          <label for="cardCcv" class="card__label">CCV</label><input type="password" class="card__input" id="cardCcv" placeholder="xxx" required="required" name="cvv" maxlength="3" />
        </div>
        <div class="card__col card__brand"><i id="cardBrand"></i></div>
      </div>
      <input type="submit" VALUE="PAY NOW" class="pay" name="pay">
      <button class="btn"><a href="cancelbooking.php">ANNULEREN</a></button>
      <script>
        function myFunction() {
          let text = "ARE YOU SURE?\nYOU WANT TO CANCEL THE PAYMENT?"
          if (confirm(text) == true) {
            window.location.href = "cancelbooking.php";
          }
        }
      </script>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
  <script src="main.js"></script>
</body>

</html>
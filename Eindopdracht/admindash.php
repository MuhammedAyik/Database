<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarVerhuur|AdminDash</title>
    <link rel="stylesheet" href="admindash.css">
</head>
<body>
<?php
require_once('connection.php');

require_once('connection.php');

$pdo = $database->getPDO();

class FeedbackManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllFeedbacks()
    {
        try {
            $sql = "SELECT * FROM feedback";
            $result = $this->pdo->query($sql);

            if ($result->rowCount() > 0) {
                return $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return [];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}

class FeedbackRenderer
{
    private $feedbacks;

    public function __construct($feedbacks)
    {
        $this->feedbacks = $feedbacks;
    }

    public function renderFeedbacks()
    {
        ?>
        <div>
            <h1 class="header">FEEDBACKS</h1>
            <div>
                <div>
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th>FEEDBACK_ID</th>
                                <th>E-MAIL</th>
                                <th>COMMENTAAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($this->feedbacks as $feedback) : ?>
                                <tr>
                                    <td><?php echo isset($feedback['FED_ID']) ? $feedback['FED_ID'] : ''; ?></td>
                                    <td><?php echo isset($feedback['EMAIL']) ? $feedback['EMAIL'] : ''; ?></td>
                                    <td><?php echo isset($feedback['COMMENT']) ? $feedback['COMMENT'] : ''; ?></td>
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

$feedbackManager = new FeedbackManager($pdo);
$feedbacks = $feedbackManager->getAllFeedbacks();

$feedbackRenderer = new FeedbackRenderer($feedbacks);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarVerhuur|AdminDash</title>
    <link rel="stylesheet" href="/css/admindash.css">
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

<?php $feedbackRenderer->renderFeedbacks(); ?>

</body>
</html>
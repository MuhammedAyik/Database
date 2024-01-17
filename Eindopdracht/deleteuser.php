<?php
// Include your connection details
require_once('connection.php');

class UserDeletion
{
    private $pdo;

    public function __construct($hostname, $dbname, $username, $password)
    {
        $this->pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function deleteUser($email)
    {
        try {
            $sql = "DELETE FROM users WHERE EMAIL = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo '<script>alert("GEBRUIKER SUCCESVOL VERWIJDERD")</script>';
                echo '<script>window.location.href = "adminusers.php";</script>';
            } else {
                echo '<script>alert("FOUT BIJ HET VERWIJDEREN VAN GEBRUIKER")</script>';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function closeConnection()
    {
        $this->pdo = null;
    }
}

try {
    // Check if 'id' is set in the URL
    if (isset($_GET['id'])) {
        $email = $_GET['id'];

        // Create an instance of UserDeletion with connection details
        $userDeletion = new UserDeletion($hostname, $dbname, $username, $password);
        $userDeletion->deleteUser($email);
        $userDeletion->closeConnection();
    } else {
        echo "Error: 'id' is not set.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

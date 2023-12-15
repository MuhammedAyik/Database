<?php
class Database {
    public $pdo;

    public function __construct($db = "test", $user = "root", $pwd = "", $host = "localhost:3306") {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function insert($name, $email) {
        $sql = "INSERT INTO klant (Naam, email) VALUES (?, ?)";
        $statement = $this->pdo->prepare($sql);

        $statement->execute([$name, $email]);
    }


    public function select($id = null) {
        try {
            if ($id != null) {
                $stmt = $this->pdo->prepare("SELECT * FROM klant WHERE id = ?");
                $stmt->execute([$id]);
                $result = $stmt->fetchAll(); // Change from fetch to fetchAll to include the id column
            } else {
                $stmt = $this->pdo->query("SELECT * FROM klant");
                $result = $stmt->fetchAll();
            }
            return $result ? $result : [];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function update($id, $name, $email) {
        try {
            $sql = "UPDATE klant SET Naam = ?, email = ? WHERE id = ?";
            $statement = $this->pdo->prepare($sql);

            $statement->execute([$name, $email, $id]);
        } catch (PDOException $e) {
            echo "Error updating record: " . $e->getMessage();
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM klant WHERE id = ?";
            $statement = $this->pdo->prepare($sql);

            $statement->execute([$id]);
        } catch (PDOException $e) {
            echo "Error deleting record: " . $e->getMessage();
        }
    }
}
?>

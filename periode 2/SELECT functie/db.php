<?php 

class Database {
    public $pdo;

    public function __construct($db="test", $user="root", $pwd="", $host="localhost:3306") {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected to $db succesfully";
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function insert($name, $email) {
        $sql = "INSERT INTO persons (name, email)
        VALUES (?, ?)";
        $statement = $this->pdo->prepare($sql);
        
        $statement->execute([$name, $email]);
    }

    public function select($id = null) {
        if ($id != null) {
            $stmt = $this->pdo->prepare("SELECT * FROM persons WHERE id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch();
        } else {
            $stmt = $this->pdo->query("SELECT * FROM persons");
            $result = $stmt->fetchAll();
        }
        return ($result);
    }
}
?>
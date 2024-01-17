<?php

class Database {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $pdo;

    public function __construct($hostname, $dbname, $username, $password) {
        $this->host = $hostname;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }

    private function connect() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getPdo() {
        return $this->pdo;
    }
}

$database = new Database('localhost', 'carproject', 'root', '');
$pdo = $database->getPdo();
?>

<?php
$hostname = 'localhost';
$dbname = 'carproject';
$username = 'root';
$password = '';
?>
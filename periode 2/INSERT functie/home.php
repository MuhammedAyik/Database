<?php
require_once 'db.php';

class Home {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addData($column1, $column2, $column3) {
        $sql = "INSERT INTO tabel (Naam) VALUES (:value1, :value2, :value3)";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bindParam(':value1', $column1);
        $stmt->bindParam(':value2', $column2);
        $stmt->bindParam(':value3', $column3);
        $stmt->execute();
    }
}
?>
<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;

    public function __construct($db){
        $this->conn = $db;
    }

    function login($identifier){
        $query = "SELECT id, username, password FROM " . $this->table_name . " WHERE username = :identifier OR email = :identifier";
        $stmt = $this->conn->prepare($query);

        $identifier = htmlspecialchars(strip_tags($identifier));
        $stmt->bindParam(":identifier", $identifier);

        $stmt->execute();

        return $stmt;
    }
}
?>

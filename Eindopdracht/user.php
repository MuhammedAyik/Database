<?php
class User
{
    private $email;
    private $pdo;

    public function __construct($email, $pdo)
    {
        $this->email = $email;
        $this->pdo = $pdo;
    }

    public function getFullName()
    {
        $sql = "SELECT fNAME FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $userData['fname'];
        }

        return null;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUserId()
    {
        $sql = "SELECT user_id FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $userData['user_id'];
        }

        return null;
    }
}
?>
<?php
require_once('connection.php');
require_once('register.php');
session_start();

if (isset($_POST['regs'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['email']);
    $lic = htmlspecialchars($_POST['lic']);
    $ph = htmlspecialchars($_POST['ph']);
    $id = htmlspecialchars($_POST['id']);
    $pass = htmlspecialchars($_POST['pass']);

    if (empty($fname) || empty($lname) || empty($email) || empty($lic) || empty($ph) || empty($id) || empty($pass)) {
        echo 'Gelieve alle velden in te vullen';
    } else {
        try {
            $database = new Database('your_database_host', 'your_database_name', 'your_database_username', 'your_database_password');
            $pdo = $database->getPdo();

            $userRegistration = new UserRegistration($pdo);
            $userRegistration->registerUser($fname, $lname, $email, $lic, $ph, $id, $pass);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

if (isset($_SESSION['rdate'])) {
    $value = $_SESSION['rdate'];
    echo $value;
}
?>

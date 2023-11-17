<?php
session_start(); 

if (isset($_SESSION['naam']) && isset($_SESSION['email'])) {
    
    $naam = $_SESSION['naam'];
    $email = $_SESSION['email'];

    echo "Naam: " . $naam . "<br>";
    echo "Email: " . $email . "<br>";
} else {
    echo "sessievariabelen zijn niet leesbaar";
}
?>

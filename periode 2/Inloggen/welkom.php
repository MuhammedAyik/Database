<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welkom</title>
</head>
<body>
    <h2>Welkom, <?php echo $_SESSION['username']; ?>!</h2>

    <form action="uitloggen.php" method="post">
        <input type="submit" name="logout" value="Uitloggen">
    </form>
</body>
</html>

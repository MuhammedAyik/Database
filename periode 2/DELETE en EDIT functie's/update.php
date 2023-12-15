<?php
include "db.php";

$db = new Database();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $data = $db->select($id);

    if (!is_array($data) || empty($data)) {
        header("Location: 404.php");
        exit();
    }
} else {
    header("Location: 404.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    $db->update($id, $name, $email);

    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <style>
        a {
            margin: 3px;
        }
    </style>
</head>
<body>
    <h2>Update Data</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo isset($data[0]['id']) ? $data[0]['id'] : ''; ?>">
        <input type="text" name="name" value="<?php echo isset($data[0]['Naam']) ? $data[0]['Naam'] : ''; ?>">
        <input type="email" name="email" value="<?php echo isset($data[0]['email']) ? $data[0]['email'] : ''; ?>">
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

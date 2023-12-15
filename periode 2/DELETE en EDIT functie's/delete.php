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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    $db->delete($id);

    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
    <style>
        a {
            margin: 3px;
        }
    </style>
</head>
<body>
    <h2>Delete Data</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo isset($data[0]['id']) ? $data[0]['id'] : ''; ?>">
        <p>Are you sure you want to delete the following record?</p>
        <p>Name: <?php echo isset($data[0]['Naam']) ? $data[0]['Naam'] : ''; ?></p>
        <p>Email: <?php echo isset($data[0]['email']) ? $data[0]['email'] : ''; ?></p>
        <input type="submit" name="delete" value="Delete">
    </form>
</body>
</html>

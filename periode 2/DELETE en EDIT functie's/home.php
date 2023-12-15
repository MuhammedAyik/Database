<?php
include "db.php";

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['knopje'])) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    $db->insert($name, $email);
}

$data = $db->select();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <style>
        a {
            margin: 3px;
        }
    </style>
</head>
<body>
    <form method="POST">
        <input type="text" name="name">
        <input type="email" name="email">
        <input type="submit" name="knopje">
    </form>
    <table>
        <tr>
            <th>name</th>
            <th>email</th>
            <th>actie</th>
        </tr>

        <?php foreach($data as $user) { ?>
            <tr>
                <td><?php echo isset($user['Naam']) ? $user['Naam'] : ''; ?></td>
                <td><?php echo isset($user['email']) ? $user['email'] : ''; ?></td>
                <td>
                    <a href="update.php?id=<?php echo isset($user['id']) ? $user['id'] : ''; ?>">edit</a>
                    <a href="delete.php?id=<?php echo isset($user['id']) ? $user['id'] : ''; ?>">delete</a>
                </td>

            </tr>
        <?php } ?>    
    </table>
</body>
</html>

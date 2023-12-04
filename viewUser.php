<?php
require "dbConfig.php";

// php processing
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "admin") {
    header("Location: /info2180-finalproject/dashboard.php");
}

if ($_SESSION["user_role"] == "admin") {
    $sql = "SELECT * FROM users";
}

$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($users);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</head>
    <div>
        <div>
            <h1>Users</h1>
            <button id="addUserBtn">+ Add User</button>
        </div>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created</th>
            </tr>

            <!-- For loop to display data in a table -->
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user["firstname"] . " " . $user["lastname"]; ?></td>
                    <td><?php echo $user["email"]; ?></td>
                    <td><?php echo $user["role"]; ?></td>
                    <td><?php echo $user["created_at"]; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>



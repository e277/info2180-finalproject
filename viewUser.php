<?php
require "dbConfig.php";
require "header.php";
require "sidebar.php";


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

<section>
    <div>
        <h1>Users</h1>
        <a href="addUser.php">+ Add User</a>
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
    
</section>


<?php
require "dbConfig.php";

// php processing
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "admin") {
    header("Location: /info2180-finalproject/dashboard.php");
}

if ($_SESSION["user_role"] == "admin") {
    $sql = "SELECT u1.email, u1.id, u1.firstname, u1.lastname, u1.role, u1.created_at 
            FROM users u1
            JOIN (
                SELECT email, MIN(id) as id
                FROM users
                WHERE email != ''
                GROUP BY email
            ) u2 ON u1.email = u2.email AND u1.id = u2.id;";
}

$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($users);

?>
    <div class="contentContainer">
        <div class="contentHeader">
            <h1>Users</h1>
            <button id="addUserBtn">+ Add User</button>
        </div>
        <div class="tableContainer">
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
    </div>



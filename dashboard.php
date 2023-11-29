<?php
require "dbConfig.php";
require "header.php";
require "sidebar.php";

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: /info2180-finalproject/index.php");
}

$sql = "SELECT * FROM contacts";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($contacts);

?>

<section>
    <div>
        <h1>Dashboard</h1>
        <a href="addContact.php">+ Add Contact</a>
    </div>
    <div>
        <div>
            <img src="./filter.svg" alt="filter">
            <span>Filter By: </span>
            <ul>
                <li class="active">All</li>
                <li>Sales Leads</li>
                <li>Support</li>
                <li>Assigned to me</li>
            </ul>
        </div>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Type</th>
            </tr>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?php echo $contact["firstname"] . " " . $contact["lastname"]; ?></td>
                    <td><?php echo $contact["email"]; ?></td>
                    <td><?php echo $contact["company"]; ?></td>
                    <td class="type"><?php echo $contact["type"]; ?></td>
                    <td><a href="viewContact.php">View</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</section>
</body>
</html>

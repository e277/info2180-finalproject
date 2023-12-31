<?php
require "dbConfig.php";

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: /info2180-finalproject/index.php");
}

$sql = "SELECT c1.email, c1.id, c1.firstname, c1.lastname, c1.company, c1.type, c1.assigned_to
        FROM contacts c1
        JOIN (
            SELECT email, MIN(id) as id
            FROM contacts
            WHERE email != ''
            GROUP BY email
        ) c2 ON c1.email = c2.email AND c1.id = c2.id;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$filterBy = ["All", "Sales Lead", "Support", "Assigned to me"];

function filterContacts($contacts, $filterBy) {
    if ($filterBy === "All") {
        // No filtering needed for "All" case
        return $contacts;
    }

    $filteredContacts = [];

    foreach ($contacts as $contact) {
        if (
            ($filterBy === "Sales Lead" && $contact["type"] === "Sales Lead") ||
            ($filterBy === "Support" && $contact["type"] === "Support") ||
            ($filterBy === "Assigned to me" && $contact["assigned_to"] === $_SESSION["user_id"])
        ) {
            array_push($filteredContacts, $contact);
        }
    }

    return $filteredContacts;
}

if (isset($_GET["filterBy"])) {
    $filterBy = $_GET["filterBy"];
    $contacts = filterContacts($contacts, $filterBy);
}

?>
    <div id="filteredDataContainer">
        <div class="contentContainer" >
            <div class="contentHeader">
                <h1>Dashboard</h1>
                <button id="addContactBtn">+ Add Contact</button>
            </div>
            <div>
                <div>
                    <div class="filterType">
                        <img src="./filter.svg" alt="filter">
                        <span>Filter By: </span>
                        <button class="filterBtn" data-filter="All">All</button>
                        <button class="filterBtn" data-filter="Sales Lead">Sales Leads</button>
                        <button class="filterBtn" data-filter="Support">Support</button>
                        <button class="filterBtn" data-filter="Assigned to me">Assigned to me</button>
                    </div>
                </div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th colspan="2">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contacts as $contact) { ?>
                                <tr>
                                    <td><?php echo $contact["firstname"] . " " . $contact["lastname"] ?></td>
                                    <td><?php echo $contact["email"] ?></td>
                                    <td><?php echo $contact["company"] ?></td>
                                    <td><?php echo $contact["type"] ?></td>
                                    <td>
                                        <button class="viewContactBtn" data-id="<?php echo $contact["id"] ?>">View</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


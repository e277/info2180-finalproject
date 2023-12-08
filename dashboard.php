<?php
require "dbConfig.php";

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: /info2180-finalproject/index.php");
}

$sql = "SELECT * FROM contacts";
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
    <div>
        <div>
            <h1>Dashboard</h1>
            <button id="addContactBtn">+ Add Contact</button>
        </div>
        <div>
            <div>
                <img src="./filter.svg" alt="filter">
                <span>Filter By: </span>
                <div class="filterType">
                    <button class="filterBtn" data-filter="All">All</button>
                    <button class="filterBtn" data-filter="Sales Lead">Sales Leads</button>
                    <button class="filterBtn" data-filter="Support">Support</button>
                    <button class="filterBtn" data-filter="Assigned to me">Assigned to me</button>
                </div>
            </div>
            <div id="filteredDataContainer">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th>Type</th>
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
                                    <button class="viewBtn" data-id="<?php echo $contact["id"] ?>">View</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


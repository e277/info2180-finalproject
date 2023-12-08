<?php
require "dbConfig.php";

session_start();

if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION["csrf_token"];
// print_r($csrf_token);

if (!isset($_SESSION["user_id"])) {
    header("Location: /info2180-finalproject/");
}

$_SESSION["contact_id"] = isset($_GET['id']) ? intval($_GET['id']) : 0;
// print_r($contact_id);

if (isset($_SESSION["contact_id"] )) {
    // echo "<p style='left: 0; bottom: 50px'>Session contact id: </p> " . $_SESSION["contact_id"];
    echo "<p>Session contact id: </p> " . $_SESSION["contact_id"];
}

$sql = "SELECT * FROM contacts WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $_SESSION["contact_id"]);
$stmt->execute();
if ($stmt->execute()) {
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
}
// print_r($contact);

// format date
$created_at = $contact['created_at'];
$created_at = new DateTime($created_at);
$created_at = $created_at->format("M, j, Y");

$updated_at = $contact['updated_at'];
$updated_at = new DateTime($updated_at);
$updated_at = $updated_at->format("M, j, Y");

// get user who created contact
$sql2 = "SELECT u.firstname, u.lastname FROM users u JOIN contacts c ON u.id = c.created_by WHERE u.id = :created_by AND c.created_by IS NOT NULL";
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindParam(":created_by", $contact['created_by']);
$stmt2->execute();
$created_by = $stmt2->fetch(PDO::FETCH_ASSOC);

// get contact who has been assigned to
$sql3 = "SELECT c.firstname, c.lastname FROM users u JOIN contacts c ON u.id = c.assigned_to WHERE u.id = :assigned_to AND c.assigned_to IS NOT NULL";
$stmt3 = $pdo->prepare($sql3);
$stmt3->bindParam(":assigned_to", $contact['assigned_to']);
$stmt3->execute();
$assigned_to = $stmt3->fetch(PDO::FETCH_ASSOC);

// get notes for contact
$sql4 = "SELECT u.id, u.firstname, u.lastname, n.comment, n.created_at FROM notes n JOIN users u ON u.id = n.created_by WHERE u.id = :created_by AND n.created_by IS NOT NULL";
$stmt4 = $pdo->prepare($sql4);
$stmt4->bindParam(":created_by", $contact['created_by']);
$stmt4->execute();
$notes = $stmt4->fetchAll(PDO::FETCH_ASSOC);
// print_r($notes);
foreach ($notes as $note) {
    $created_by_note = new DateTime($note['created_at']);
    $created_by_note = $created_by_note->format("M, j, Y") . " at " . $created_by_note->format("g:i A");
}

// Check if the request is an AJAX request
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (
            !isset($_POST["csrf_token"])
            || !isset($_POST["user_id"])
            || !isset($_POST["contact_id"])
            || !isset($_POST["comment"])
        ) {
            // Return a JSON response instead of redirecting
            echo json_encode(['error' => 'All fields are required']);
            exit;
        }

        if (!hash_equals($csrf_token, $_POST["csrf_token"])) {
            // Return a JSON response instead of redirecting
            echo json_encode(['error' => 'Invalid CSRF token']);
            exit;
        }

        $comment = $_POST["comment"];
        $user_id = $_POST["user_id"];
        $contact_id = $_POST["contact_id"];

        $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
        $user_id = htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8');
        $contact_id = htmlspecialchars($contact_id, ENT_QUOTES, 'UTF-8');

        $sql2 = "INSERT INTO notes (contact_id, comment, created_by) VALUES (:contact_id, :comment, :user_id)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(":contact_id", $contact_id);
        $stmt2->bindParam(":comment", $comment);
        $stmt2->bindParam(":user_id", $user_id);
        $stmt2->execute();

        // Return a JSON response instead of redirecting
        echo json_encode(['success' => 'Note added successfully']);
        exit;
    }
}


?>
    <div class="contentContainer">
        <div>
            <div>
                <img src="profile.svg" alt="profile">
                <div>
                    <h2><?php echo $contact["title"] . " " . $contact["firstname"] . " " . $contact["lastname"]; ?></h2>
                    <h4>Created on <?php echo $created_at ?> by <?php echo $created_by["firstname"] . " " . $created_by["lastname"] ?></h4>
                    <h4>Updated on <?php echo $updated_at ?></h4>
                </div>
            </div>
            <div>
                <button>
                    <img src="hand.svg" alt="hand">Assign to me
                </button>
                <button>
                    <img src="switch.svg" alt="switch">
                    Switch to Sales Lead
                </button>
            </div>
        </div>

        <div>
            <div>
                <h4>Email</h4>
                <h4><?php echo $contact["email"] ?></h4>
            </div>
            <div>
                <h4>Telephone</h4>
                <h4><?php echo $contact["telephone"] ?></h4>
            </div>
            <div>
                <h4>Company</h4>
                <h4><?php echo $contact["company"] ?></h4>
            </div>
            <div>
                <h4>Assigned To</h4>
                <h4><?php echo $contact["firstname"] . " " . $contact["lastname"] ?></h4>
            </div>
        </div>

        <div>
            <?php foreach ($notes as $note) : ?>
                <div>
                    <h3><?php echo $note["firstname"] . " " . $note["lastname"] ?></h3>
                    <p><?php echo $note["comment"] ?></p>
                    <p><?php echo $created_by_note ?> </p>
                </div>
            <?php endforeach; ?>

            <!-- Add the Note Form -->
            <div>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <h3>Add a note about <?php echo $contact["firstname"] ?></h3>
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION["user_id"]; ?>">
                    <input type="hidden" name="contact_id" value="<?php echo $_SESSION["contact_id"]; ?>">
                    <textarea name="comment" id="comment" cols="30" rows="10" placeholder="Enter details here"></textarea>
                    <button type="submit" name="save" id="addNoteBtn">Add Note</button>
                </form>
            </div>
        </div>
    </div>


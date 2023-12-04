<?php
require "dbConfig.php";

session_start();

if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION["csrf_token"];
// print_r($csrf_token);

if (!isset($_SESSION["user_id"])) {
    header("Location: /info2180-finalproject/dashboard.php");
}

$contact_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// print_r($contact_id);

$sql = "SELECT * FROM contacts WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $contact_id);
$stmt->execute();
if ($stmt->execute()) {
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
}
// print_r($contact);

// format date
$created_at = new DateTime($contact['created_at']);
$updated_at = new DateTime($contact['updated_at']);
$created_at = $created_at->format("M, j, Y");
$updated_at = $updated_at->format("M, j, Y");

// get user who created contact
$sql2 = "SELECT u.firstname, u.lastname FROM users u JOIN contacts c ON u.id = c.created_by WHERE u.id = :created_by AND c.created_by IS NOT NULL";
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindParam(":created_by", $contact['created_by']);
$stmt2->execute();
$created_by = $stmt2->fetch(PDO::FETCH_ASSOC);

// get user who has been assigned to
$sql3 = "SELECT u.firstname, u.lastname FROM users u JOIN contacts c ON u.id  = c.assigned_to WHERE u.id = :assigned_to AND c.assigned_to IS NOT NULL";
$stmt3 = $pdo->prepare($sql3);
$stmt3->bindParam(":assigned_to", $contact['assigned_to']);
$stmt3->execute();
$assigned_to = $stmt3->fetch(PDO::FETCH_ASSOC);

$sql4 = "SELECT * FROM notes WHERE contact_id = :id";
$stmt4 = $pdo->prepare($sql4);
$stmt4->bindParam(":id", $user_id);
$stmt4->execute();
$notes = $stmt4->fetchAll(PDO::FETCH_ASSOC);
// print_r($notes);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        !isset($_POST["csrf_token"])
        || !isset($_POST["user_id"])
        || !isset($_POST["contact_id"])
        || !isset($_POST["comment"])
    ) {
        echo "<script>alert('All fields are required')</script>";
        header("Location: /info2180-finalproject/viewContact.php");
    }

    if (!hash_equals($csrf_token, $_POST["csrf_token"])) {
        // echo "<script>alert('Invalid CSRF token')</script>";
        header("Location: /info2180-finalproject/");
    }

    $comment = $_POST["comment"];
    $user_id = $_POST["user_id"];
    $contact_id = $_POST["contact_id"];

    $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
    $user_id = htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8');
    $contact_id = htmlspecialchars($contact_id, ENT_QUOTES, 'UTF-8');

    $sql = "INSERT INTO notes (contact_id, comment, created_by) VALUES (:contact_id, :comment, :user_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":contact_id", $contact_id);
    $stmt->bindParam(":comment", $comment);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
}

?>

    <div>
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
            <input type="checkbox" name="notes" id="notes">
            <label for="notes">Notes</label>
            <div>
                <h3>John Doe</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. 
                    Iusto modi beatae sed ut necessitatibus, aliquam maiores 
                    ipsum numquam, laboriosam sapiente nam saepe, et voluptates 
                    quod magnam sint temporibus mollitia consequuntur!
                </p>
                <p>November 30, 2022 at 6pm</p>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <h3>Add a note about Michael</h3>
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION["user_id"]; ?>">
                <input type="hidden" name="contact_id" value="<?php echo $contact_id; ?>">
                <textarea name="comment" id="comment" cols="30" rows="10" placeholder="Enter details here"></textarea>
                <button type="submit" name="save">Add Note</button>
            </form>
        </div>
    </div>


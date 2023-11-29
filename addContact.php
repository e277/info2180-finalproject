<?php
require "dbConfig.php";
require "header.php";
require "sidebar.php";

session_start();

if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION["csrf_token"];
// print_r($csrf_token);

if (!isset($_SESSION["user_id"])) {
    header("Location: /info2180-finalproject/dashboard.php");
}

$sql = "SELECT * FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$contact_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($contact_users);

?>


<section>
    <h1>New Contact</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="hidden" name="csrf_token" value="<?=$csrf_token; ?>">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION["user_id"]; ?>">
        <div>
            <label for="title">Title</label>
            <select name="title" id="title">
                <option value="mr">Mr.</option>
                <option value="ms">Ms.</option>
            </select>
        </div>
        <div>
            <div>
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" placeholder="First Name">
            </div>
            <div>
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" placeholder="Last Name">
            </div>
        </div>
        <div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email address">
            </div>
            <div>
                <label for="telephone">Telephone</label>
                <input type="tel" name="telephone" id="telephone" placeholder="Telephone">
            </div>
        </div>
        <div>
            <div>
                <label for="company">Company</label>
                <input type="text" name="company" id="company" placeholder="Company name">
            </div>
            <div>
                <label for="type">Type</label>
                <select name="type" id="type">
                    <option value="sales">Sales Lead</option>
                    <option value="support">Support</option>
                </select>
            </div>
        </div>
        <div>
            <label for="assigned_to">Assigned To</label>
            <select name="assigned_to" id="assigned_to">
                <?php foreach ($contact_users as $user): ?>
                    <option value="<?php echo $user["id"]; ?>"><?php echo $user["firstname"] . ' '. $user['lastname']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <button type="submit" name="save">Save</button>
        </div>
    </form>
</section>
</body>
</html>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        !isset($_POST["csrf_token"])
        || !isset($_POST["user_id"])
        || !isset($_POST["title"]) 
        || !isset($_POST["firstname"]) 
        || !isset($_POST["lastname"]) 
        || !isset($_POST["email"]) 
        || !isset($_POST["telephone"]) 
        || !isset($_POST["company"]) 
        || !isset($_POST["type"]) 
        || !isset($_POST["assigned_to"]) 
    ) {
        echo "<script>alert('All fields are required')</script>";
        header("Location: /info2180-finalproject/addContact.php");
    }
    
    $title     = $_POST["title"];
    $firstname = $_POST["firstname"];
    $lastname  = $_POST["lastname"];
    $email     = $_POST["email"];
    $telephone = $_POST["telephone"];
    $company   = $_POST["company"];
    $type      = $_POST["type"];
    $assigned_to = $_POST["assigned_to"];
    $created_by   = $_POST["user_id"];

    if (!hash_equals($csrf_token, $_POST["csrf_token"])) {
        // echo "<script>alert('Invalid CSRF token')</script>";
        header("Location: /info2180-finalproject/");
    }

    $title = htmlspecialchars($title, ENT_QUOTES, "UTF-8");
    $firstname = htmlspecialchars($firstname, ENT_QUOTES, "UTF-8");
    $lastname = htmlspecialchars($lastname, ENT_QUOTES, "UTF-8");
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $telephone = filter_var($telephone, FILTER_SANITIZE_NUMBER_INT);
    $company = htmlspecialchars($company, ENT_QUOTES, "UTF-8");
    $type = htmlspecialchars($type, ENT_QUOTES, "UTF-8");
    $assigned_to = htmlspecialchars($assigned_to, ENT_QUOTES, "UTF-8");

    $sql = "INSERT INTO contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by) VALUES (:title, :firstname, :lastname, :email, :telephone, :company, :type, :assigned_to, :created_by)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":telephone", $telephone);
    $stmt->bindParam(":company", $company);
    $stmt->bindParam(":type", $type);
    $stmt->bindParam(":assigned_to", $assigned_to);
    $stmt->bindParam(":created_by", $created_by);

    $stmt->execute();

    header("Location: /info2180-finalproject/dashboard.php");
}

?>
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

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "admin") {
    header("Location: /info2180-finalproject/dashboard.php");
}

?>

<section>
    <div>
        <h3>New User</h3>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div>
            <input type="hidden" name="csrf_token" value="<?=$csrf_token; ?>">
            <div>
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname">
            </div>
            <div>
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname">
            </div>
        </div>
        <div>
            <div>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>
        </div>
    
        <div>
            <label for="role">Role</label>
            <select name="role" id="role">
                <option value="member">Member</option>
                <option value="admin">Admin</option>
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
    if (!isset($_POST["csrf_token"]) || !isset($_POST["firstname"]) || !isset($_POST["lastname"]) || !isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["role"])) {
        echo "<script>alert('All fields are required')</script>";
        header("Location: /info2180-finalproject/addUser.php");
    }
    
    
    $firstname = $_POST["firstname"];
    $lastname  = $_POST["lastname"];
    $email     = $_POST["email"];
    $password  = $_POST["password"];
    $role      = $_POST["role"];

    if (!hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])) {
        // echo "<script>alert('Invalid CSRF token')</script>";
        header("Location: /info2180-finalproject/addUser.php");
    }

    $firstname = htmlspecialchars($firstname, ENT_QUOTES, "UTF-8");
    $lastname = htmlspecialchars($lastname, ENT_QUOTES, "UTF-8");
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($password, ENT_QUOTES, "UTF-8");
    $role = htmlspecialchars($role, ENT_QUOTES, "UTF-8");

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('User already exists')</script>";
        header("Location: /info2180-finalproject/addUser.php");
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (firstname, lastname, email, password, role) VALUES (:firstname, :lastname, :email, :password, :role)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":role", $role);
    $stmt->execute();

    header("Location: /info2180-finalproject/viewUser.php");
}

?>
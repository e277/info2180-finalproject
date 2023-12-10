<?php
require "dbConfig.php";

session_start();

if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION["csrf_token"];
// print_r($csrf_token);

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "admin") {
    header("Location: /info2180-finalproject/");
}


function checkPassword($password) {
    $pattern = '/^(?=.*\d)(?=.*[A-Za-z])(?=.*[A-Z])[A-Za-z\d]{8,}$/';
    return preg_match($pattern, $password);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (
            !isset($_POST["csrf_token"]) 
            || !isset($_POST["firstname"]) 
            || !isset($_POST["lastname"]) 
            || !isset($_POST["email"]) 
            || !isset($_POST["password"]) 
            || !isset($_POST["role"])
        ) {
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

        if (!checkPassword($password)) {
            echo "<script>alert('Password must be at least 8 characters long and contain at least one number and uppercase letter')</script>";
            header("Location: /info2180-finalproject/addUser.php");
        }

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

        header("Location: /info2180-finalproject/home.php");
    }
}

?>

    <div class="formContainer">
        <h1>New User</h1>
        <form class="form" id="saveUser" method="POST">
            <div>
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <div>
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>
                <div>
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" required>
                </div>
            </div>
            <div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
        
            <div>
                <label for="role">Role
                    <select name="role" id="role" required>
                        <option value="" selected>Select Role</option>
                        <option value="member">Member</option>
                        <option value="admin">Admin</option>
                    </select>
                </label>
            </div>
            <div>
                <button type="submit" name="save">Save</button>
            </div>
        </form>
    </div>


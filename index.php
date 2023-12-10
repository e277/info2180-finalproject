<?php
require "dbConfig.php";

session_start();

if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION["csrf_token"];

function checkPassword($password) {
    $pattern = '/^(?=.*\d)(?=.*[A-Za-z])(?=.*[A-Z])[A-Za-z\d]{8,}$/';
    return preg_match($pattern, $password);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (!isset($_POST["csrf_token"]) || !isset($_POST["email"]) || !isset($_POST["password"])) {
        echo "<script>alert('Email, password, and CSRF token are required')</script>";
        header("Location: /info2180-finalproject/");
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!hash_equals($csrf_token, $_POST["csrf_token"])) {
        // echo "<script>alert('Invalid CSRF token')</script>";
        header("Location: /info2180-finalproject/");
    }

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (!checkPassword($password)) {
        echo "<script>alert('Password must be at least 8 characters long and contain at least one number and uppercase letter')</script>";
        header("Location: /info2180-finalproject/addUser.php");
    }
    $password = htmlspecialchars($password, ENT_QUOTES, "UTF-8");

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetchALL(PDO::FETCH_ASSOC)[0];

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        $_SESSION["user_role"] = $user["role"];
        header("Location: /info2180-finalproject/home.php");
    } else {
        echo "<script>alert('Invalid email or password')</script>";
        header("Location: /info2180-finalproject/");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="dolphin.png" alt="Dolphin Logo">
        <span>Dolphin CRM</span>
    </header>
    <section class="login-container">
        <div class="login">
            <h1>Login</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="login-form">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" required>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email address" required>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </div>
                <div>
                    <button type="submit" id="login-btn">Login</button>
                </div>
            </form>
            <p>
                Copyright &copy; 2023 Dolphin CRM
            </p>
        </div>
    </section>
</body>
</html>

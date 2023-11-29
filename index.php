<?php
require "dbConfig.php";
require "header.php";
?>


    <section>
        <div class="login">
            <h1>Login</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="login-form">
                <input type="hidden" name="csrf_token">
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email address">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password">
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


<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["csrf_token"]) || !isset($_POST["email"]) || !isset($_POST["password"])) {
        echo "<script>alert('Email, password, and CSRF token are required')</script>";
        header("Location: /info2180-finalproject/");
    }

    $csrf_token = $_POST["csrf_token"];
    $key = hash("sha512", $csrf_token);
    $_SESSION["csrf_token"] = $key;
    
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])) {
        // echo "<script>alert('Invalid CSRF token')</script>";
        header("Location: /info2180-finalproject/");
    }

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($password, ENT_QUOTES, "UTF-8");

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetchALL(PDO::FETCH_ASSOC)[0];

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        $_SESSION["user_role"] = $user["role"];
        header("Location: /info2180-finalproject/dashboard.php");
    } else {
        echo "<script>alert('Invalid email or password')</script>";
        header("Location: /info2180-finalproject/");
    }
}

?>
<?php
// require "dbConfig.php";
require "header.php";
?>


<body>
    <section>
        <h1>Login</h1>
        <form action="" method="post">
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
                <button type="submit">Login</button>
            </div>
        </form>
    </section>
</body>
</html>


<?php

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $email = $_POST["email"];
//     $password = $_POST["password"];

//     $sql = "SELECT * FROM users WHERE email = :email";
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute(["email" => $email]);
//     $user = $stmt->fetchALL(PDO::FETCH_ASSOC)[0];

//     if ($user && password_verify($password, $user["password"])) {
//         $_SESSION["user_id"] = $user["id"];
//         $_SESSION["user_name"] = $user["name"];
//         $_SESSION["user_role"] = $user["role"];
//         header("Location: /dashboard.php");
//     } else {
//         echo "<script>alert('Invalid email or password')</script>";
//         header("Location: /");
//     }
// }

require "footer.php";
?>
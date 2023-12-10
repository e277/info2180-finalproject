<?php

$host  = "localhost";
$dbname = "dolphin_crm";
$username = "project2_user";
$password = "password123";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "[CONNECTION FAILED]: " . $e->getMessage();
    die();
}


try {
    // Test if default users exists already
    $sql = "SELECT firstname, lastname, password, email, role FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);

    $users = [
        ["Admin", "Test", "password123", "admin@project2.com", "admin"],
        ["User", "One", "user123", "user1@email.com", "member"],
        ["User", "Three", "user123", "user3@email.com", "member"]
    ];

    // Loop
    foreach ($users as $user) {
        $stmt->bindParam(":email", $user[3]);
        $stmt->execute();

        // if email not in db
        if ($stmt->rowCount() == 0) {
            $sql = "INSERT INTO users (firstname, lastname, password, email, role) VALUES (:firstname, :lastname, :password, :email, :role)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "firstname" => $user[0],
                "lastname"  => $user[1],
                "password"  => password_hash($user[2], PASSWORD_DEFAULT),
                "email"     => $user[3],
                "role"      => $user[4]
            ]);
        }
    }

} catch (PDOException $e) {
    echo "[INSERT FAILED]: " . $e->getMessage();
}

?>
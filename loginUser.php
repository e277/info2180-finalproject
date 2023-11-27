

<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli("localhost","id","password","database");
    if ($conn->connect_error) {
        die("Failed". $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id,CONCAT(firstname, ' ', lastname) AS full_name,role,created_at FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id,$name,$pword);
    $stmt->fetch();
    $stmt->close();
    
    if ($id && password_verify($password, $pword)){
        return ['id' =>$id,'name'=>$name,'email'=>$email,];
        exit();
    }else{
        $error = "Invalid Login";
    }

    $conn ->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dolphin CRM</title>
    <link rel="stylesheet" href="loginstyle.css" />
</head>
<body>
    <?php include 'header.php'; ?>
    <h2>Login</h2>

    <?php if (isset($error)):
        echo $error; 
    endif; ?>

    <form>
        Email: <input type="text" name="email" required><br>
        Password: <input type="text" name="password" required><br>
        <button type = "click" id="login">Login</button>
    </form>
</body>
<footer>
    <?php include 'footer.php'; ?>
</footer>

<?php
// require "dbConfig.php";
require "header.php";
require "sidebar.php";
?>


<body>
    <section>
        <h1>New Contact</h1>
        <form action="" method="post">
            <input type="hidden" name="csrf_token">
            <div>
                <label for="title">Title</label>
                <select name="title" id="title">
                    <option value="mr">Mr.</option>
                    <option value="ms">Ms.</option>
                </select>
            </div>
            <div>
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" placeholder="First Name">
            </div>
            <div>
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" placeholder="Last Name">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email address">
            </div>
            <div>
                <label for="telephone">Telephone</label>
                <input type="tel" name="telephone" id="telephone" placeholder="Telephone">
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </section>
</body>
</html>


<?php

// session_start();
// $token = hash("sha256", microtime());
// $_SESSION["csrf_token"] = $token;

?>
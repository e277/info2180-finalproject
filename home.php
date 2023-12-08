<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</head>
<body>
    <header>
        <img src="dolphin.png" alt="Dolphin Logo">
        <span>Dolphin CRM</span>
    </header>
    <aside class="sidebar">
        <nav>
            <ul>
                <li>
                    <img src="home.svg" alt="home">
                    <button id="homeBtn">Home</button>
                </li>
                <li>
                    <img src="contact.svg" alt="add contact">
                    <button id="addContactBtn">New Contact</button>
                </li>
                <li>
                    <img src="user.svg" alt="users">
                    <button id="userBtn">Users</button>
                </li>
                <hr />
                <li>
                    <img src="logout.svg" alt="logout">
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>
    </aside>
    <section id="content"></section>
</body>
</html>

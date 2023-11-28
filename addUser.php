<?php
require "header.php";
require "sidebar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <div style="text-align: left;">
        <img src="C:\Users\18765\Downloads\info2180-finalproject\dolphin.png" style="width: 50px; height: 50px; vertical-align: middle;">
        <h1 style="display: inline-block; vertical-align: middle; margin-left: 5px;">Dolphin CRM</h1>
    </div>
    <div style="text-align: center;">
        <div style="display: flex; justify-content: center;">
            <h2 style="margin-top: 0;">New User</h2>
        </div>
        <form>
            <div style="display: flex; justify-content: center;">
                <div style="text-align: left; margin-right: 20px;">
                    <label for="firstName">First Name:</label><br>
                    <input type="text" id="firstName" name="firstName">
                </div>
                <div style="text-align: left;">
                    <label for="lastName">Last Name:</label><br>
                    <input type="text" id="lastName" name="lastName">
                </div>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 20px;">
                <div style="text-align: left; margin-right: 20px;">
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email">
                </div>
                <div style="text-align: left;">
                    <label for="password">Password:</label><br>
                    <input type="password" id="password" name="password">
                </div>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 20px;">
                <div style="text-align: left;">
                    <label for="role">Role:</label><br>
                    <input type="text" id="role" name="role">
                </div>
                <div style="text-align: left; margin-left: 20px; margin-top: 25px;">
                    <input type="submit" value="Save">
                </div>
            </div>
        </form>
    </div>
</body>
</html>

$(document).ready(function () {
    // jquery code here
    $("#homeBtn").click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "dashboard.php",
            success: (response) => {
                $("#content").html(response);                
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#contactBtn").click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "addContact.php",
            type: "POST",
            success: function (response) {
                $("#content").html(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#userBtn").click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "viewUser.php",
            type: "GET",
            success: function (response) {
                $("#content").html(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });


    $("#addContactBtn").click(function () {
        console.log("add contact");
        $.ajax({
            url: "addContact.php",
            type: "POST",
            success: function (response) {
                $("#content").html(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#addUserBtn").click(function () {
        console.log("add user");
        $.ajax({
            url: "addUser.php",
            type: "POST",
            success: function (response) {
                $("#content").html(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
});


$(document).ready(function () {
    // console.log("Document is ready");
    // jquery code here
    $("#homeBtn").click(function (e) {
        e.preventDefault();
        // console.log("Home button clicked");
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
        // console.log("Contact button clicked");
        $.ajax({
            url: "addContact.php",
            type: "POST",
            success: function (data) {
                $("#content").html(data);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#userBtn").click(function (e) {
        e.preventDefault();
        // console.log("User button clicked");
        $.ajax({
            url: "viewUser.php",
            type: "GET",
            success: function (data) {
                $("#content").html(data);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
});


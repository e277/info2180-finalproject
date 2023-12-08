$(document).ready(function () {
    // jquery code here
    let throttleTimer;
    const throttleDelay = 500;

    // Filter Contacts
    $(document).on('click', '.filterBtn', function(e) {
        e.preventDefault();
        const filterValue = $(this).data("filter");
        console.log(filterValue);
        if (!throttleTimer) {
            $.ajax({
                url: "dashboard.php",
                type: "GET",
                data: { filterBy: filterValue },
                success: function (response) {
                    $("#filteredDataContainer").html(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
    
            throttleTimer = setTimeout(function () {
                throttleTimer = null;
            }, throttleDelay);
        }
    });

    $(document).on('click', '#homeBtn', function (e) {
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

    $(document).on('click', '#addContactBtn', function (e) {
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

    // View Contact
    $(document).on('click', '.viewBtn', function (e) {
        e.preventDefault();
        const contactId = $(this).data("id");
        console.log(contactId);
        $.ajax({
            url: "viewContact.php",
            type: "GET",
            data: { id: contactId },
            success: function (response) {
                $("#content").html(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $(document).on('click', '#userBtn', function (e) {
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

    $(document).on('click', '#addUserBtn', function (e) {
        e.preventDefault();
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


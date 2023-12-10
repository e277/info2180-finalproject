$(document).ready(function () {
    // jquery code here
    let throttleTimer;
    const throttleDelay = 500;
    viewAllContacts();

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


    // Home / View All Contacts
    function viewAllContacts() {
        $.ajax({
            url: "dashboard.php",
            type: "GET",
            success: function (response) {
                $("#content").html(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
    $(document).on('click', '#homeBtn', function (e) {
        e.preventDefault();
        viewAllContacts();
    });


    // Add Contact
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

    $(document).on('submit', '#addContact', function (e) {
        e.preventDefault();
        let formData = {
            csrf_token: $("#csrf_token").val(),
            user_id: $("#user_id").val(),
            title: $("#title").val(),
            firstname: $("#firstname").val(),
            lastname: $("#lastname").val(),
            email: $("#email").val(),
            telephone: $("#telephone").val(),
            company: $("#company").val(),
            type: $("#type").val(),
            assigned_to: $("#assigned_to").val()
        };
        console.log(formData);
        $.ajax({
            url: "addContact.php",
            type: "POST",
            data: formData,
            success: function (response) {
                $("#content").html(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // View Contact
    function viewContact(contactId) {
        console.log("Contact id: ", contactId);
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
    }
    $(document).on('click', '.viewContactBtn', function (e) {
        e.preventDefault();
        const contactId = $(this).data("id");
        viewContact(contactId);
    });

    // Handle Assign to me and Switch Contact Type
    $(document).on("click", ".btns button:first-child", function (e) {
        e.preventDefault();
        console.log("Clicked");
        const assignedTo = $(this).data("userid");
        console.log("Assign to me: ", assignedTo);
        // if (assignedTo) {
        //     $.ajax({
        //         url: "viewContact.php",
        //         type: "POST",
        //         data: { assigned_to: assignedTo },
        //         success: function (response) {
        //             $("#content").html(response);
        //         },
        //         error: function (error) {
        //             console.log(error);
        //         }
        //     });
        // }
    });
    $(document).on("click", ".btns button:nth-child(2)", function (e) {
        e.preventDefault();
        console.log("Clicked");
        const type = $(this).data("type");
        console.log("Type: ", type);
    //     // if type is like 'sales' change to 'support' else change to 'sales'
    //     if (type == '/sales/i') {
    //         $.ajax({
    //             url: "viewContact.php",
    //             type: "POST",
    //             data: { type: 'Support' },
    //             success: function (response) {
    //                 $("#content").html(response);
    //             },
    //             error: function (error) {
    //                 console.log(error);
    //             }
    //         });
    //     } else {
    //         $.ajax({
    //             url: "viewContact.php",
    //             type: "POST",
    //             data: { type: 'Sales Lead' },
    //             success: function (response) {
    //                 $("#content").html(response);
    //             },
    //             error: function (error) {
    //                 console.log(error);
    //             }
    //         });
    //     }
    });
        




    // View User
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


    // Add User
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

    $(document).on('submit', '#saveUser', function (e) {
        e.preventDefault();
        let formData = {
            csrf_token: $("#csrf_token").val(),
            firstname: $("#firstname").val(),
            lastname: $("#lastname").val(),
            email: $("#email").val(),
            password: $("#password").val(),
            role: $("#role").val()
        };
        console.log(formData);
        $.ajax({
            url: "addUser.php",
            type: "POST",
            data: formData,
            success: function (response) {
                $("#content").html(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });


    // Add Note
    $(document).on('submit', '#saveNote', function (e) {
        e.preventDefault();
        let formData = {
            csrf_token: $("#csrf_token").val(),
            user_id: $("#user_id").val(),
            contact_id: $("#contact_id").val(),
            comment: $("#comment").val()
        };
        console.log(formData);
        $.ajax({
            url: "viewContact.php",
            type: "POST",
            data: formData,
            success: function (response) {
                viewContact(formData.contact_id);
                $("#content").html(response);
                console.log(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

});


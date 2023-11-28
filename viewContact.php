<?php
// require "dbConfig.php";
require "header.php";
require "sidebar.php";
?>


<body>
    <section>
        <div>
            <div>
                <img src="./profile.svg" alt="profile">
                <div>
                    <h2>Mr. Michael Scott</h2>
                    <h4>Created on November 9, 2022 by David Wallace</h4>
                    <h4>Updated on november 13, 2022</h4>
                </div>
            </div>
            <div>
                <button>
                    <img src="./hand.svg" alt="hand">Assign to me
                </button>
                <button>
                    <img src="./switch.svg" alt="switch">
                    Switch to Sales Lead
                </button>
            </div>
        </div>

        <div>
            <div>
                <h4>Email</h4>
                <h4>michael.scott@paper.com</h4>
            </div>
            <div>
                <h4>Telephone</h4>
                <h4>876-999-9999</h4>
            </div>
            <div>
                <h4>Company</h4>
                <h4>The Paper company</h4>
            </div>
            <div>
                <h4>Assigned To</h4>
                <h4>Jen Levinson</h4>
            </div>
        </div>

        <div>
            <input type="checkbox" name="notes" id="notes">
            <label for="notes">Notes</label>
            <div>
                <h3>John Doe</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. 
                    Iusto modi beatae sed ut necessitatibus, aliquam maiores 
                    ipsum numquam, laboriosam sapiente nam saepe, et voluptates 
                    quod magnam sint temporibus mollitia consequuntur!
                </p>
            </div>
            <div>
                <h3>John Doe</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. 
                    Iusto modi beatae sed ut necessitatibus, aliquam maiores 
                    ipsum numquam, laboriosam sapiente nam saepe, et voluptates 
                    quod magnam sint temporibus mollitia consequuntur!
                </p>
            </div>
            <div>
                <h3>John Doe</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. 
                    Iusto modi beatae sed ut necessitatibus, aliquam maiores 
                    ipsum numquam, laboriosam sapiente nam saepe, et voluptates 
                    quod magnam sint temporibus mollitia consequuntur!
                </p>
            </div>
            <div>
                <h3>Add a note about Michael</h3>
                <textarea name="note" id="note" cols="30" rows="10" placeholder="Enter details here"></textarea>
                <button>Add Note</button>
            </div>
        </div>
    </section>
</body>


<?php

// session_start();
// $token = hash("sha256", microtime());
// $_SESSION["csrf_token"] = $token;

?>
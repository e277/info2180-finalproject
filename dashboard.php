<?php
// require "dbConfig.php";
require "header.php";
require "sidebar.php";
?>

<section>
    <div>
        <h1>Dashboard</h1>
        <button>+ Add Contact</button>
    </div>
    <div>
        <div>
            <img src="./filter.svg" alt="filter">
            <span>Filter By: </span>
            <ul>
                <li class="active">All</li>
                <li>Sales Leads</li>
                <li>Support</li>
                <li>Assigned to me</li>
            </ul>
        </div>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Type</th>
            </tr>
            <tr>
                <td>Mr. Michael Scott</td>
                <td>michael.scott@paper.com</td>
                <td>Dunder Mifflin</td>
                <td class="type">Sales Lead</td>
                <td><a href="viewContact.php"></a></td>
        </table>
    </div>
    
</section>


<?php
// php processing

?>

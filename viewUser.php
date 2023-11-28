<?php
// require "dbConfig.php";
require "header.php";
require "sidebar.php";
?>

<section>
    <div>
        <h1>Users</h1>
        <button>+ Add User</button>
    </div>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created</th>
        </tr>
        <tr>
            <td>John Doe</td>
            <td>johndoe@gmail.com</td>
            <td>Member</td>
            <td>2020-01-01</td>
        </tr>
        
        <?php //foreach ($users as $user): ?>
        <tr>
            <td><?php // $user["firstname"] . " " . $user["lastname"] ?></td>
            <td><?php // $user["email"] ?></td>
            <td><?php // $user["role"] ?></td>
            <td><?php // $user["created"] ?></td>
        </tr>
        <?php //endforeach; ?>
    </table>
    
</section>


<?php
// php processing

?>

<?php
    include '_dbconn.php';

    $query = "SELECT * FROM users ORDER BY uid";
    $result= pg_query($conn, $query) or die (preg_last_error());
    $total_users = pg_num_rows($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store Admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/table.css">

</head>
<body>

    <div class="topnav" id="myTopnav">
        <a href="admin.php"><span>BookStoreAdmin</span></a>
    </div>

    <!-- The sidebar -->
    <div class="sidebar">
        <a href="admin.php">Dashboard</a>
        <a class="active" href="users.php">Users</a>
        <a href="books.php">Books</a>
        <a href="buybooks.php">Buy Books</a>
        <a href="boughtbooks.php">Bought Books</a>
        <a href="orders.php">Orders</a>
        <a href="transactions.php">Transactions</a>
    </div>

    <div class="content">
        <h3 class="heading"> Users Information: </h3>
        <table id="table">
            <thead>
                <th>#</th>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Bought</th>
                <th>Sold</th>
                <th>View Profile</th>
                <th>Delete Profile</th>
            </thead>
            <tbody>
                <?php
                    $srno = 1;
                    while($row = pg_fetch_assoc($result)) {
                        echo "<tr>";
                        echo  "<td>".$srno."</td>";
                        echo  "<td>#".$row['uid']."</td>";
                        echo  "<td>".$row['uname']."</td>";
                        echo  "<td>".$row['umob']."</td>";
                        echo  "<td>".$row['bought']."</td>";
                        echo  "<td>".$row['sold']."</td>";
                        echo  "<td><a href=\"profile.php?id=".$row['uid']."\"  name=\"user_id\" class=\"btn btn-primary\">Details</a></td>";
                        echo  "<td><a href=\"delete.php?id=".$row['uid']."\"  name=\"user_id\" class=\"btn btn-danger\">Delete</a></td>";
                        echo "</tr>";
                        $srno += 1;
                    }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>

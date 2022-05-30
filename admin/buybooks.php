<?php
    include '_dbconn.php';

    $query = "SELECT * FROM user_book_table WHERE bought = 'false'";
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
        <a href="users.php">Users</a>
        <a href="books.php">Books</a>
        <a class="active" href="buybooks.php">Buy Books</a>
        <a href="boughtbooks.php">Bought Books</a>
        <a href="orders.php">Orders</a>
        <a href="transactions.php">Transactions</a>
    </div>

    <div class="content">
        <h3 class="heading"> Books Sold by Users: </h3>
        <table id="table">
            <thead>
                <th>#</th>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Selling Price</th>
                <th>Publisher</th>
                <!-- <th>Publish Year</th> -->
                <!-- <th>Category</th> -->
                <th>Course</th>
                <!-- <th>Semester</th> -->
                <th>Condition</th>
                <th>Sold By</th>
                <th>Details</th>
                <th>Buy</th>
            </thead>
            <tbody>
                <?php
                    $srno = 1;
                    $query = "Select * from users where uid = $1";
                    $r = pg_prepare($conn, "user_query", $query) or die ("Cannot prepare statement1\n");
                    while($row = pg_fetch_assoc($result)) {
                        echo "<tr>";
                        echo  "<td>".$srno."</td>";
                        echo  "<td>#".$row['book_id']."</td>";
                        echo  "<td>".$row['book_name']."</td>";
                        echo  "<td>".$row['p_mrp']."</td>";
                        echo  "<td>".$row['selling_price']."</td>";
                        echo  "<td>".$row['pub_name']."</td>";
                        // echo  "<td>".$row['pub_year']."</td>";
                        // echo  "<td>".$row['book_cat']."</td>";
                        echo  "<td>".$row['c_name']."</td>";
                        // echo  "<td>".$row['c_year']."</td>";
                        echo  "<td>".$row['book_condition']."</td>";
                        $r = pg_execute($conn, "user_query", array($row['user_id'])) or die ("Cannot execute statement1\n");
                        $name = pg_fetch_assoc($r);
                        echo  "<td>".$name['uname']."</td>";
                        echo  "<td><a href=\"bookInfoBuy.php?id=".$row['book_id']."&name=".$name['uname']."\"  name=\"book_id\" class=\"btn btn-primary\">Details</a></td>";
                        echo  "<td><a href=\"buy.php?id=".$row['book_id']."\"  name=\"book_id\" class=\"btn btn-success\">Buy</a></td>";
                        echo "</tr>";
                        $srno += 1;
                    }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>

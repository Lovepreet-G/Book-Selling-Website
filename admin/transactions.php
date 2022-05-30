<?php
    include '_dbconn.php';

    $query = "SELECT * FROM transaction";
    $result= pg_query($conn, $query) or die (preg_last_error());

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
        <a href="buybooks.php">Buy Books</a>
        <a href="boughtbooks.php">Bought Books</a>
        <a href="orders.php">Orders</a>
        <a class="active" href="transactions.php">Transactions</a>
    </div>

    <div class="content">
        <h3 class="heading"> Transaction Details: </h3>
        <table id="table">
            <thead>
                <th>#</th>
                <th>ID</th>
                <th>User Name</th>
                <th>Amount</th>
                <th>Date Time</th>
                <th>Status</th>
            </thead>
            <tbody>
                <?php
                    $srno = 1;
                    $query = "Select * from users where uid = $1";
                    $r = pg_prepare($conn, "user_query", $query) or die ("Cannot prepare statement1\n");
                    while($row = pg_fetch_assoc($result)) {
                        echo "<tr>";
                        echo  "<td>".$srno."</td>";
                        echo  "<td>#".$row['transaction_id']."</td>";
                        $r = pg_execute($conn, "user_query", array($row['user_id'])) or die ("Cannot execute statement1\n");
                        $name = pg_fetch_assoc($r);
                        echo  "<td>".$name['uname']."</td>";
                        echo  "<td>".$row['amount']."</td>";
                        echo  "<td>".$row['date_time']."</td>";
                        if(str_replace(' ','',$row['transaction_status']) == "SUCCESSFULL") {
                            echo  "<td class='btn btn-success'>".$row['transaction_status']."</td>";
                        } else {
                            echo  "<td class='btn btn-danger'>".$row['transaction_status']."</td>";
                        }
                        echo "</tr>";
                        $srno += 1;
                    }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
    include '_dbconn.php';

    $query = "SELECT * FROM users";
    $result= pg_query($conn, $query) or die (preg_last_error());
    $total_users = pg_num_rows($result);

    $query = "SELECT * FROM admin_book_table";
    $result= pg_query($conn, $query) or die (preg_last_error());
    $total_books = 0;
    while ($row = pg_fetch_assoc($result)) {
        $total_books += $row['quantity'];
    }

    $query = "SELECT * FROM book_order";
    $result= pg_query($conn, $query) or die (preg_last_error());
    $total_orders = pg_num_rows($result);

    $query = "SELECT * FROM admin_book_table WHERE selling_price = 0";
    $result= pg_query($conn, $query) or die (preg_last_error());
    $total_donated = pg_num_rows($result);

    $query = "SELECT amount FROM transaction";
    $result= pg_query($conn, $query) or die (preg_last_error());
    $total_earnings = 0;
    while ($row = pg_fetch_row($result)) {
        $total_earnings += $row[0];
    }
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
    <link rel="stylesheet" href="css/cards.css">

</head>
<body>

    <div class="topnav" id="myTopnav">
        <a href="admin.php"><span>BookStoreAdmin</span></a>
    </div>

    <!-- The sidebar -->
    <div class="sidebar">
        <a class="active" href="admin.php">Dashboard</a>
        <a href="users.php">Users</a>
        <a href="books.php">Books</a>
        <a href="buybooks.php">Buy Books</a>
        <a href="boughtbooks.php">Bought Books</a>
        <a href="orders.php">Orders</a>
        <a href="transactions.php">Transactions</a>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6 coll">
                <div class="card-box bg-red">
                    <div class="inner">
                        <h3> <?php echo $total_users ?> </h3>
                        <p> Total Users </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 colr">
                <div class="card-box bg-blue">
                    <div class="inner">
                        <h3> <?php echo $total_books ?> </h3>
                        <p> Total Books </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-book" aria-hidden="true"></i>
                    </div>
                </div>
            </div>

            
        </div>
        <div class="row">

            <div class="col-lg-3 col-sm-6 coll">
                <div class="card-box bg-orange">
                    <div class="inner">
                        <h3> <?php echo $total_donated ?> </h3>
                        <p> Total Books Donated </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-heart" aria-hidden="true"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 coll colr">
                <div class="card-box bg-bluish">
                    <div class="inner">
                        <h3> <?php echo $total_orders ?> </h3>
                        <p> Total Books Ordered </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 colr">
                <div class="card-box bg-green">
                    <div class="inner">
                        <h3> <?php echo "₹".$total_earnings ?> </h3>
                        <p> Total Earnings </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

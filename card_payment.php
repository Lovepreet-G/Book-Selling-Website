<?php

    error_reporting(0);

    include '_dbconn.php';

    session_start();

    $query = "SELECT * FROM dummy_account WHERE user_id = $1";
    $result = pg_prepare($conn, "my_query", $query) or die ("Cannot prepare statement1\n");
    $result = pg_execute($conn, "my_query", array($_SESSION['user_id'])) or die ("Cannot execute statement1\n");

    $row = pg_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <style>
        #button{
            height: 70px;
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            border: none;
            border-radius: 30px;
            background: #f7971e;
            color: #fff;
            font-size: 15px;
            font-weight: bold;
        }
        #button:hover{
            cursor: pointer;
            background: #f1b56c;
        }
    </style>

</head>
<body>
    <div class="container">
    <form action="card_payment.php" method="POST">
        <h1>Card Details</h1>
        <div class="first-row">
            <div class="owner">
                
                <h3>Account holder's name: </h3>
                <div class="input-field">
                    <input type="text" value="<?php echo $_SESSION['username'];?>" required>
                </div>
            </div>
            <div class="cvv">
                <h3>CVV</h3>
                <div class="input-field">
                    <input type="password" name="cvv" required>
                </div>
            </div>
        </div>
        <div class="second-row">
            <div class="card-number">
                <h3>Card Number</h3>
                <div class="input-field"> 
                    <input type="text" value="<?php echo $row['card_number'];?>" required>
                </div>
            </div>
        </div>
        <div class="third-row">
            <h3>Card Number</h3>
            <div class="selection">
                <div class="date">
                    <input type="text" name="month" id="month" placeholder="mm" maxlength="2" style="width: 35px; height: 35px;" value="<?php echo $row['exp_month'];?>">
                    /<input type="text" name="year" id="year" placeholder="yyyy" maxlength="4" style="width: 55px; height: 35px;" value="<?php echo $row['exp_year'];?>">
                </div>
                <div class="cards">
                    <img src="resources/mc.png" alt="">
                    <img src="resources/vi.png" alt="">
                    
                </div>
            </div>    
        </div>
        <input type="submit" value="Pay <?php echo $_SESSION['total_price']+50;?>" id="button">
    </form>
    </div>

    <?php
    
        $cvv = $_POST['cvv'];

        if($cvv == $row['cvv']) {

            $query = "SELECT * FROM dummy_account WHERE user_id = 1";
            $res = pg_query($conn, $query);
            $r = pg_fetch_assoc($res);

            $sender = $row['balance'] - ($_SESSION['total_price']+50);
            $receiver = $r['balance'] + ($_SESSION['total_price']+50);
            $total = $_SESSION['total_price']+50;

            $query = "UPDATE dummy_account SET balance = $1 WHERE user_id = $2;";
            $r1 = pg_prepare($conn, "query_send", $query) or die ("Cannot prepare statement1\n");
            $r1 = pg_execute($conn, "query_send", array($sender, $_SESSION['user_id'])) or die ("Cannot execute statement1\n");

            $query = "UPDATE dummy_account SET balance = $1 WHERE user_id = 1;";
            $r2 = pg_prepare($conn, "query_receiver", $query) or die ("Cannot prepare statement2\n");
            $r2 = pg_execute($conn, "query_receiver", array($receiver)) or die ("Cannot execute statement2\n");

            $query = "INSERT INTO transaction(user_id, amount, transaction_status) VALUES($1, $2, $3)";
            $r3 = pg_prepare($conn, "query_transaction", $query) or die ("Cannot prepare statement3\n");
            $r3 = pg_execute($conn, "query_transaction", array($_SESSION['user_id'], $total, 'SUCCESSFULL')) or die ("Cannot execute statement3\n");
            
            $query = "UPDATE book_order SET order_status = 'SUCCESSFULLY PLACED' WHERE user_id = $1 and dte = CURRENT_DATE";
            $r4 = pg_prepare($conn, "query_order", $query) or die ("Cannot prepare statement4\n");
            $r4 = pg_execute($conn, "query_order", array($_SESSION['user_id'])) or die ("Cannot execute statement4\n");

            $query = "Select * from users where uid = $1";
            $r5 = pg_prepare($conn, "user_query", $query) or die ("Cannot prepare statement1\n");
            $r5 = pg_execute($conn, "user_query", array($_SESSION['user_id'])) or die ("Cannot execute statement1\n");

            $bought_res = pg_fetch_assoc($r5);
            $bought = $bought_res['bought'] + count($_SESSION['books_in_cart']);

            $query = "UPDATE users SET bought = $1 WHERE uid = $2;";
            $r5= pg_prepare($conn, "my_query_bought", $query) or die ("Cannot prepare statement2\n");
            $r5 = pg_execute($conn, "my_query_bought", array($bought, $_SESSION['user_id'])) or die ("Cannot execute statement2\n");

            foreach($_SESSION['books_in_cart'] as $book) {
                $_SESSION['remove_books'] = $book;
                include 'removefromcart.php';
            }

            header("location: order.php");
        } else if($cvv != $row['cvv']){
            echo "TRANSACTION FAILED!!!";
        }

    ?>
    
</body>
</html>
<?php

    error_reporting(0);

    include '_dbconn.php';
    session_start();

    $query = "Select * from users where uid = $1";
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
    <link rel="stylesheet" href="css/buy.css">
    <title>Place your order</title>
</head>
<body>
<div class="container">
  <div class="title">
      <h2>Place your order</h2>
  </div>
<div class="d-flex">
  <form action="buy.php" method="post">
    <label>
      <span class="fname">Full Name <span class="required">*</span></span>
      <input type="text" name="fname" value="<?php echo $row['uname']; ?>" required>
    </label>
    <label>
      <span>Address <span class="required">*</span></span>
      <input type="text" name="address" placeholder="Enter delivery address" required value="<?php if($row['address'] != 'NA') {echo $row['address'];}?>">
    </label>
    <label>
      <span>City <span class="required">*</span></span>
      <input type="text" name="city" required> 
    </label>
    <label>
      <span>State <span class="required">*</span></span>
      <input type="text" name="state" required> 
    </label>
    <label>
      <span>Pincode <span class="required">*</span></span>
      <input type="text" name="pincode" maxlength = "6" required value="<?php if($row['pincode'] != 0) {echo $row['pincode'];}?>"> 
    </label>
    <label>
      <span>Phone <span class="required">*</span></span>
      <input type="tel" name="phone" value="<?php echo $row['umob']; ?>" required> 
    </label>
    <label>
      <span>Email Address <span class="required">*</span></span>
      <input type="email" name="email" value="<?php echo $row['uemail']; ?>" required> 
    </label>
    <div class="Yorder">
        <table>
            <tr>
                <th colspan="2">Amount to be paid</th>
            </tr>
            <tr>
        <td>Total</td>
        <td><?php echo $_SESSION['total_price'];?></td>
      </tr>
      <tr>
        <td>Shipping Charges</td>
        <td>50</td>
      </tr>
      <tr>
        <td>Subtotal</td>
        <td><?php echo $_SESSION['total_price']+50;?></td>
      </tr>
    </table><br>
    <div>
      <input type="radio" name="payment_method" value="upi"> UPI
    </div>
    <div>
      <input type="radio" name="payment_method" value="Card"> Credit/Debit Card
    </div>
    <input type="submit" value="Place Order" id="button">
  </div>
    </form>
 </div>
</div>

<?php

    $state = $_POST['state'];
    $pincode = $_POST['pincode'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $payment_method = $_POST['payment_method'];

    if($row['address'] == 'NA') {
        $query = "UPDATE users SET address = $1 WHERE uid = $2;";
        $result = pg_prepare($conn, "query_add", $query) or die ("Cannot prepare statement1\n");
        $result = pg_execute($conn, "query_add", array($address, $_SESSION['user_id'])) or die ("Cannot execute statement1\n");
    }

    if($row['pincode'] == 0) {
        $query = "UPDATE users SET pincode = $1 WHERE uid = $2;";
        $result = pg_prepare($conn, "my_query_pin", $query) or die ("Cannot prepare statement2\n");
        $result = pg_execute($conn, "my_query_pin", array($pincode, $_SESSION['user_id'])) or die ("Cannot execute statement2\n");
    }

    $query = "INSERT INTO book_order(book_id, user_id, address, city, state, pincode, phone) VALUES ($1, $2, $3, $4, $5, $6, $7)";
    $result = pg_prepare($conn, "query_order", $query) or die ("Cannot prepare statement3\n");
    foreach($_SESSION['books_in_cart'] as $book) {
        $result = pg_execute($conn, "query_order", array($book, $_SESSION['user_id'], $address, $city, $state, $pincode, $phone)); 
        //or die ("Cannot execute statement3\n");
    }

    if($payment_method == "Card") {
        header("location: card_payment.php");
    } else if($payment_method == "UPI"){
        header("location: upi_payment.php");
    }
?>

</body>
</html>
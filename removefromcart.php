<?php

    error_reporting(0);

    session_start();

    $user_id=$_SESSION["user_id"];

    $conn=pg_connect("host = localhost dbname= book user= postgres password= bookwebsite ") or die (preg_last_error());

    if(isset($_SESSION['remove_books'])) {
        $book_id = $_SESSION['remove_books'];
    } else {
        $book_id=$_GET["id"];
        echo $book_id;
    }

    if (($key = array_search($book_id, $_SESSION['books_in_cart'])) !== false) {
        unset($_SESSION['books_in_cart'][$key]);
    }

    $temp = array_values($_SESSION['books_in_cart']);
    $_SESSION['books_in_cart'] = array_values($temp);

    $query1 = "Delete FROM cart WHERE book_id = $book_id AND user_id =$user_id ";
    $result1= pg_query($conn,$query1) or die (preg_last_error());

    header("Location: cart.php");
    pg_close($conn);
?>

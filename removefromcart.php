<?php

    session_start();

    $user_id=$_SESSION["user_id"];

    $conn=pg_connect("host = localhost dbname= postgres user= postgres password= bookwebsite ") or die (preg_last_error());

    $book_id=$_GET["id"];
    echo $book_id;

   
    $query1 = "Delete FROM cart WHERE book_id = $book_id AND user_id =$user_id ";
    $result1= pg_query($conn,$query1) or die (preg_last_error());

    header("Location: cart.php");
    pg_close($conn);
?>
<?php

    error_reporting(0);

    session_start();

    $user_id=$_SESSION["user_id"];

    include '_dbconn.php';
    $book_id=$_GET["id"];

    $query1 = "Delete FROM user_book_table WHERE book_id = $book_id AND user_id =$user_id ";
    $result1= pg_query($conn,$query1) or die (preg_last_error());

    header("Location: yourbook.php");
    pg_close($conn);
?>

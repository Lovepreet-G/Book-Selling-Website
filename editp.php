<?php

    session_start();

    $user_id=$_SESSION["user_id"];

    $conn=pg_connect("host = localhost dbname= postgres user= postgres password= bookwebsite ") or die (preg_last_error());

    $user_name=$_POST["uname"];
    $user_email=$_POST["email"];
    $mob_no=$_POST["mn"];
    $pin=$_POST["pin"];
    $add=$_POST["add"];

   
    $query1 ="update user_table SET user_name = '$user_name' , user_email = '$user_email' , mobile_no = '$mob_no' , pincode = $pin , address ='$add' WHERE user_id =$user_id";
    $result1= pg_query($conn,$query1) or die (preg_last_error());

    header("Location: profile.php");
    pg_close($conn);
?>
<?php

    error_reporting(0);
    session_start();

    $user_id=$_SESSION["user_id"];

    include '_dbconn.php';

    $user_name=$_POST["uname"];
    $user_email=$_POST["email"];
    $mob_no=$_POST["mn"];
    $pin=$_POST["pin"];
    $add=$_POST["add"];

   
    $query1 ="update users SET uname = '$user_name' , uemail = '$user_email' , umob = '$mob_no' , pincode = $pin , address ='$add' WHERE uid =$user_id";
    $result1= pg_query($conn,$query1) or die (preg_last_error());

    header("Location: profile.php");
    pg_close($conn);
?>

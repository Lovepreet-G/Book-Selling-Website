<?php

    error_reporting(0);

    session_start();

    // ini_set('SMTP','Pepipost');
    // ini_set('smtp_port',456);

    // $user_id=$_SESSION["user_id"];

    $uname=$_POST["uname"];
    $uemail =$_POST["uemail"];
    $msg=$_POST["input-message"];

    $to = "singh.lovepreet@moderncollegegk.org";
    $subject = "Mail from Book Store Customer";
    
    $message = $msg."<br> From :- ".$uname;
    
    
    $header = "From:".$uemail." \r\n";
    // $header .= "Cc:afgh@somedomain.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text\r\n";
    
    $retval = mail ($to,$subject,$message,$header);
    
    if( $retval == true ) {
       echo "Message sent successfully...";
    }else {
       echo "Message could not be sent...";
    }
  
    header("Location: homepage.php");
    pg_close($conn);    


?>    
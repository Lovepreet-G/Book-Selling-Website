<?php

    // error_reporting(0);

    session_start();

    $user_id=$_SESSION["user_id"];
    

    include '_dbconn.php';

    $bname=$_POST["bname"];
    $pub =$_POST["pub"];
    $cat=$_POST["cat"];
    $course=$_POST["course"];
    $year=$_POST["year"];
    $pub_year=$_POST["pub_year"];
    $condition=$_POST["condition"];
    $donation=$_POST["donation"];
    if(isset($_POST["mrp"]))
    {
        $mrp=$_POST["mrp"];
    }
    else
    {
        $mrp=0;
    }
    if(isset($_POST["selling_price"]))
    {
        $selling_price=$_POST["selling_price"];        
    }
    else
    {
        $selling_price=0;
    }
    // $book_image=$_POST["book_image"];

    $query ="insert into user_book_table(book_name,p_mrp,selling_price,pub_name,pub_year,book_cat,c_year,c_name,book_condition,user_id) values('$bname',$mrp,$selling_price,'$pub',$pub_year,'$cat','$year','$course','$condition',$user_id)";
    $result= pg_query($conn,$query) or die (preg_last_error());
   
    header("Location: yourbook.php");
    pg_close($conn);    
?>
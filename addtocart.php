<?php

    session_start();

    $user_id=$_SESSION["user_id"];

    $conn=pg_connect("host = localhost dbname= postgres user= postgres password= bookwebsite ") or die (preg_last_error());

    $id=$_GET["id"];

    $query2 = "select * from cart";
    $result2= pg_query($conn,$query2) or die (preg_last_error());    
    
    $flag=0;
    if (pg_num_rows($result2)==0)
    {
        $query1 ="insert into cart(book_id,user_id,dte) values($id,$user_id, CURRENT_DATE )" ;
        $result1= pg_query($conn,$query1) or die (preg_last_error());
        echo "Added To Cart";
      
    }
    else
    {
        while($row =pg_fetch_row($result2) )
        {
            if($row[1]==$id && $row[2]==$user_id)
            {
                
                $flag=1;    
                break;                        
            }
            else
            {
                
                $flag=0;
            }
        } 
        if($flag==1)
        {
            echo " Already Added To Cart";
        }
        else
        {
            $query1 ="insert into cart(book_id,user_id,dte) values($id,$user_id, CURRENT_DATE )" ;
            $result1= pg_query($conn,$query1) or die (preg_last_error());
            echo "Added To Cart";
        }  
    }

    
    pg_close($conn);
?>
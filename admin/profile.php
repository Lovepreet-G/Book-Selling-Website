<?php

    session_start();
    error_reporting(0);


    $user_id=$_GET["id"];

    $_SESSION["uid"] = $user_id;

    include '_dbconn.php';


    if(isset($user_id))
    {
        $query ="select * from users";

        $result= pg_query($conn,$query) or die (preg_last_error());
        while ($row =pg_fetch_row($result) )
        {
            if($row[0]==$user_id)
            {
                $user_name=$row[1];
            }
        }
    }
    $query1 ="select * from users";
    $result1= pg_query($conn,$query1) or die (preg_last_error());

    while ($row =pg_fetch_row($result1) )
    {
        if($row[0]==$user_id)
        {
            $user_email=$row[2];
            $mob_no=$row[3];
            $pin=$row[8];
            $sold=$row[6];
            $add=$row[7];
        }
    }
    $query1 = "select * from book_order";

    $result1= pg_query($conn,$query1) or die (preg_last_error());

    $bought=0;
    while ($row =pg_fetch_row($result1) )
    {
        if($row[2]==$user_id)
        {            
            $bought++;
        }
    }  




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bookpage.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="https://kit.fontawesome.com/624437a27c.js" crossorigin="anonymous"></script>
    <title>Profile</title>
</head>
<body>
    
    <!-- Display -->
    <section id="display" class="container my-5 pt-5">
        <div class="row " style=" border:.5px solid gray ; box-shadow=1px 1px 1px 1px inset; ">
           
                   
            <div id="book-details" class="col-lg-12 col-md-12 col-12">
                    <h1 class="mt-3 ">Profile</h1>
                    <br>
                    <h4><label for="uname">Name  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</label>
                    <input type="text" id="uname" name="uname" value="<?php echo $user_name; ?>" style="border:none; font-size:1.3rem;" size="40" disabled><br></h4>

                    <h4><label for="mn">Mobile No &nbsp;:&nbsp;</label>
                    <input type="text" id="mn" name="mn" value="<?php echo $mob_no; ?>" style="border:none; font-size:1.3rem;" size="40" disabled><br></h4>
                    
                    <h4><label for="email">Email &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</label>
                    <input type="text" id="email" name="email" value="<?php echo $user_email; ?>" style="border:none; font-size:1.3rem; " size="40" size="40" disabled><br></h4>
                    
                    <h4><label for="add">Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</label>
                    <input type="text" id="add" name="add" value="<?php echo $add; ?>" style="border:none; font-size:1.3rem;" size="40" disabled><br></h4>
                    
                    <h4><label for="pin">Pincode &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</label>
                    <input type="text" id="pin" name="pin" value="<?php echo $pin; ?>" style="border:none; font-size:1.3rem;" size="40" disabled><br></h4>
                    
                    <h4><label for="baught">No. of Books Baught &nbsp;&nbsp;:&nbsp;</label>
                    <input type="text" id="baught" name="baught" value="<?php echo $bought; ?>" style="border:none; font-size:1.3rem;" size="40" disabled><br></h4>
                    
                    <h4><label for="baught">No. of Books Sold &nbsp;&nbsp;:&nbsp;</label>
                    <input type="text" id="baught" name="baught" value="<?php echo $sold; ?>" style="border:none; font-size:1.3rem;" size="40" disabled><br></h4>
                    
                    <br>
                    <!-- <button id="cart-btn" class="btn btn-primary">Edit</button> -->
                    <form action="editprof.php" method="get">
                        <button id="buy-btn" class="btn btn-primary mb-3">Edit</button>
                    </form>
                    <a href="delete.php?id=<?php echo $user_id?>"  name="user_id" class="btn btn-danger mb-3">Delete</a>
                    <a href="users.php" class="btn btn-primary mb-3">Back</a>
            </div>
        </div>
    </section>
    <script src="js/bootstrap.js"></script>
    <script>
        var mainimg=document.getElementById("main-img");
        var smallimg =document.getElementsByClassName("small-img");
        smallimg[0].onclick =function(){
            mainimg.src = smallimg[0].src;        
        }
        smallimg[1].onclick =function(){
            mainimg.src = smallimg[1].src;        
        }
        smallimg[2].onclick =function(){
            mainimg.src = smallimg[2].src;        
        }
        smallimg[3].onclick =function(){
            mainimg.src = smallimg[3].src;        
        }
        smallimg[4].onclick =function(){
            mainimg.src = smallimg[4].src;        
        }

    </script>
     <script>
        var dd_main = document.querySelector(".dd_main");

        dd_main.addEventListener("click", function(){
            this.classList.toggle("active");
            })
    </script>
</body>
</html>
<?php
pg_close($conn);
?>

<?php

    session_start();
    error_reporting(0);


    $user_id=$_SESSION["user_id"];

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
    <title>Home</title>
</head>
<body>
    <header id="body-header">
        <!-- Logo -->
        <div id="logo">
            <img src="resources/logo.png" alt="logo" >
        </div>
          <!-- search bar -->
          <div id="search-bar">
            <form class="example" action="searchpage.php" method ="get">
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <!-- Sign in buttons -->
        <?php
        
        if($user_id==null)
        {  
            echo '<div id ="button">';
            echo '<form action="signup.php" method="get" style="display:inline;">';
            echo '<button id="signup" type="submit" >  ';
            echo  '   Sign up';
            echo '</button> </form>';
            echo '<form action="login.php" method="get" style="display:inline;">';
            echo '<button id ="signin">';
            echo  '   Sign in';
            echo '</button> </form>';
            echo '</div>';
        }
        else        
       {
        
        echo '<div class="wrapper">';
        echo  '  <div class="navbar">';
    
        echo  '   <div class="nav_right">';
        echo   '         <ul>';
        echo    '            <li class="nr_li dd_main">';
        echo     '               <!-- <img src="profile_pic.png" alt="profile_img"> -->';
        echo     $user_name;
        echo      '              <div class="dd_menu">';
        echo       '                 <div class="dd_left">';
        echo        '                    <ul>';
        echo         '                       <li><i class="fas fa-map-marker-alt"></i></li>';
        echo          '                      <li><i class="far fa-star"></i></li>';
        echo           '                     <li><i class="fas fa-download"></i></li>';								
        echo            '                    <li><i class="fas fa-sign-out-alt"></i></li>';
        echo            '                    <li><i class="fas fa-sign-out-alt"></i></li>';
        echo             '               </ul>';
        echo              '          </div>';
        echo               '         <div class="dd_right">';
        echo                '            <ul>';
        echo                 '               <li><a href="profile.php" style="color: rgb(86 86 86); text-decoration: none; transition: color 1s, border-bottom 3s ;">Your Profile</a></li>';
        echo                  '              <li><a href="yourbook.php" style="color: rgb(86 86 86); text-decoration: none; transition: color 1s, border-bottom 3s ;">Your Book</a></li>';
        echo                   '             <li><a href="order.php" style="color: rgb(86 86 86); text-decoration: none; transition: color 1s, border-bottom 3s ;">Your Order</a></li>';
        echo                    '            <li><a href="cart.php" style="color: rgb(86 86 86); text-decoration: none; transition: color 1s, border-bottom 3s ;" >Cart</a></li>';
        echo                    '            <li><a href="logout.php" style="color: rgb(86 86 86); text-decoration: none; transition: color 1s, border-bottom 3s ;" >logout</a></li>';
        echo                     '       </ul>';
        echo                      '  </div>';
        echo   '                 </div>';
        echo    '            </li>';
    
        echo      '      </ul>';
        echo       ' </div>';
        echo '   </div>';
        echo '</div>	';
       }
    ?>
      
    </header>
    
    <!--navigation menu  -->
    <div id="nav">  
        <nav>
            <ul class="horizontal-list nav-menu">
                <li>
                    <a href="homepage.php"  >Home</a>
                </li>
                <li>
                    <a href="category.php?cat=Science">Science</a>
                </li>
                <li>
                    <a href="category.php?cat=Commerce">Commerce</a>
                </li>
                <li>
                    <a href="category.php?cat=Arts">Arts</a>
                </li>
                <li>
                    <a href="category.php?cat=Fiction">Fiction</a>
                </li>
                <li>
                    <a href="category.php?cat=Non-Fiction">Non-Fiction</a>
                </li>
                <li>
                    <a href="#contact">Contact</a>
                </li>
                <li>
                    <a href="sell.php">Sell</a>
                </li>
            </ul>
        </nav>
    </div>
    
    <!-- Display -->
    <section id="display" class="container my-5 pt-5">
        <div class="row " style=" border:.5px solid gray ; box-shadow=1px 1px 1px 1px inset; ">
           
                   
            <div id="book-details" class="col-lg-6 col-md-12 col-12">
                    <h1 class="mt-3 ">Profile</h1>
                    <br>
                    
                    <form action="editp.php" method="post">

                        <h4><label for="uname">Name  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</label>
                        <input type="text" id="uname" name="uname" value="<?php echo $user_name; ?>" style="border:none;" ><br></h4>

                        <h4><label for="mn">Mobile No &nbsp;:&nbsp;</label>
                        <input type="text" id="mn" name="mn" value="<?php echo $mob_no; ?>" style="border:none;" ><br></h4>
                        
                        <h4><label for="email">Email &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</label>
                        <input type="text" id="email" name="email" value="<?php echo $user_email; ?>" style="border:none;" ><br></h4>
                        
                        <h4><label for="add">Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</label>
                        <input type="text" id="add" name="add" value="<?php echo $add; ?>" style="border:none;" ><br></h4>
                        
                        <h4><label for="pin">Pincode &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</label>
                        <input type="text" id="pin" name="pin" value="<?php echo $pin; ?>" style="border:none;" ><br></h4>
                        
                        <h4><label for="baught">No. of Books Baught &nbsp;&nbsp;:&nbsp;</label>
                        <input type="text" id="baught" name="baught" value="<?php echo $bought; ?>" style="border:none;" disabled ><br></h4>
                        
                        <h4><label for="sold">No. of Books Sold &nbsp;&nbsp;:&nbsp;</label>
                        <input type="text" id="baught" name="sold" value="<?php echo $sold; ?>" style="border:none;" disabled ><br></h4>
                        
                        <br>
                        <!-- <button id="cart-btn" class="btn btn-primary">Edit</button> -->
                        <button id="buy-btn" type="submit"  class="btn btn-primary mb-3">Update</button>
                    </form>

            </div>
        </div>
    </section>
    <!-- contact                       -->
    <section id="contact">
        <!-- contact heading -->
        <H1 class="section-heading mb75px">
            <span>
                <i class="far fa-address-card"></i>
            </span>
            <span>
                Contact
            </span>
        </H1>
        <div id="contact-container" >
            <!-- contact form -->
            <div id="contact-form">
                <form action="">
                    <input type="text" id="input-name" placeholder="Your Name"><br>
                    <input type="text" id="input-email" placeholder="Email" ><br>
                    <textarea name="input-message" id="input-message" cols="40" rows="2" placeholder="Meassage"></textarea><br>
                    <button type="submit" id="sub-button">Send Meassage </button>
                </form>
            </div>
            <!-- contact details -->
            <div id="contact-details">
                <h3>Get In touch</h3>
                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                <h3>My Address</h3>
                <div class="my-address-info">
                    <span>
                        <i class="fas fa-map-marker-alt"></i>
                    </span>
                    <span>
                        Punjab,India
                    </span>
                </div>

                <div class="my-address-info">
                    <span>
                        <i class="fas fa-mobile-alt"></i>
                    </span>
                    <span>
                        9130269066
                    </span>
                </div>

                <div class="my-address-info">
                    <span>
                        <i class="far fa-envelope"></i>
                    </span>
                    <span>
                        gillpreetsingh35@gmail.com
                    </span>
                </div>

            </div>
        </div>     
            <!-- contact icons -->
            <div id="contact-icons">
                <ul class="horizontal-list social-icon">
                    <li>
                        <a href="https://www.youtube.com/channel/UCA_1xtOdv66q0pdbRFDfsBA" target="_blank"><i class="fab fa-youtube"></i></a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/lovepreet_singh35/" target="_blank"><i class="fab fa-instagram"></i></a>
                    </li>
                    <li>
                        <a href="https://discord.gg/g7fwhwT4" target="_blank"><i class="fab fa-discord"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </li>
                    
                </ul> 
            </div>
            
    </section>
    <script src="js/bootstrap.js"></script>
    
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

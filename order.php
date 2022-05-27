<?php

    session_start();
    error_reporting(0);

    include '_dbconn.php';


    $user_id=$_SESSION["user_id"];

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

   
 
    $query1 = "select * from book_order ORDER BY dte DESC";

    $result1= pg_query($conn,$query1) or die (preg_last_error());

    $status = array();

    $i=0;
    while ($row =pg_fetch_row($result1) )
    {
        if($row[2]==$user_id)
        {
            $book_id[$i]=$row[1];
            $date[$i]=$row[3];
            $i++;
        }
        array_push($status, $row[9]);
    }
    
    
    $query2 = "select * from admin_book_table";

    $result2= pg_query($conn,$query2) or die (preg_last_error());
    
  




?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="https://kit.fontawesome.com/624437a27c.js" crossorigin="anonymous"></script>
    <title>Your Order</title>
</head>
<body>
    <header id="body-header">
        <!-- Logo -->
        <div id="logo">
            <img src="resources/logo.png" alt="logo" >
        </div>
          <!-- search bar -->
          <div id="search-bar">
            <form class="example" action="searchpage.php">
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
                <?php
                    if(isset($user_id))
                    {
                        echo '<a href="sell.php">Sell</a>';
                    }
                    else
                    {
                        echo '<a href="login.php">Sell </a>';
                    }
                ?>      
                </li>
            </ul>
        </nav>
    </div>
    
    <!-- Display -->
    <section id="display" class="container my-5 pt-5">
        <h2>Your Order</h2>
        <br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Book Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Link</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    $j=0;
                    while ($row =pg_fetch_row($result2) )
                    {
                        foreach ($book_id as $temp)
                        if($row[0]==$temp)
                        {
                            echo '<tr>';
                            echo  '<th scope="row">'.$i.'</th>';
                            echo ' <td> '.$date[$j].' </td>';
                            echo '<td>'.$row[1].'</td>';
                            echo ' <td>'.$row[4].'</td>';
                            echo ' <td><a href="bookpage.php?id='.$row[0].'"  name="book_id" class="btn btn-primary" style="background-color: #f7971e ;border: none;">Details</a></td>';
                            echo '<td>'.$status[$j].'</td>';
                            echo'</tr>';
                            $i++;
                            $j++;
                        }
                    }            
                       
                ?>
            </tbody>
        </table>

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

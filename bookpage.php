<?php
    $conn=pg_connect("host = localhost dbname= postgres user= postgres password= bookwebsite ") or die (preg_last_error());

    $query = "select * from user_book_table";

    $result= pg_query($conn,$query) or die (preg_last_error());

    if(isset($_GET['id'])){
        $book_id = $_GET['id']; 
        
    }
    while ($row =pg_fetch_row($result) )
    {
        if($row[0]==$book_id)
        {
            $book_name=$row[1];
            $book_price=$row[4];
            $course=$row[9];
            $pub_year=$row[6];
            $seller_id=$row[11];
        }
    }




?>











<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bookpage.css">
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
        <!-- Sign in buttons -->
        <div id ="button">
            <button id="signup">
                Sign up
            </button>
            <button id ="signin">
                Sign in
            </button>
        </div>
        <!-- search bar -->
        <div id="search-bar">
            <form class="example" action="action_page.php">
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </header>
    
    <!--navigation menu  -->
    <div id="nav">  
        <nav>
            <ul class="horizontal-list nav-menu">
                <li>
                    <a href="#"  >Home</a>
                </li>
                <li>
                    <a href="#">Science</a>
                </li>
                <li>
                    <a href="#">Commerce</a>
                </li>
                <li>
                    <a href="#">Arts</a>
                </li>
                <li>
                    <a href="#">Fiction</a>
                </li>
                <li>
                    <a href="#">Non-Fiction</a>
                </li>
                <li>
                    <a href="#contact">Contact</a>
                </li>
            </ul>
        </nav>
    </div>
    
    <!-- Display -->
    <section id="display" class="container my-5 pt-5">
        <div class="row ">
            <div id="book-img" class="col-lg-5 col-md-12 col-12">
                <img class="img-fluid w-100 pd-1" src="resources/cc.jpg" id="main-img" alt="image">

                <div class="small-img-group">
                    <div class="small-img-col">
                        <img class="small-img" src="resources/web.jpg" width="100%" alt="image">
                    </div>
                    <div class="small-img-col">
                        <img class="small-img" src="resources/cc.jpg" width="100%" alt="image">
                    </div>
                    <div class="small-img-col">
                        <img class="small-img" src="resources/cc.jpg" width="100%" alt="image">
                    </div>
                    <!-- <div class="small-img-col">
                        <img class="small-img" src="resources/c.jpg" width="100%" alt="image">
                    </div> -->
                </div>
            </div>        
            <div id="book-details" class="col-lg-6 col-md-12 col-12">
                    <h6>book</h6>
                    <h3 class="py-3"><?php echo $book_name; ?></h3>
                    <h3 class="mb-3"><?php echo $book_price; ?></h3>
                    <button id="cart-btn" class="btn btn-primary">Add to cart</button>
                    <button id="buy-btn" class="btn btn-primary">Buy Now</button>
                    <h4 class="mt-4 mb-3">Book Details </h4>
                    <span>
                    <?php echo $course; ?> <br> Publishing Year :- <?php echo $pub_year; ?>
                    </span>
                    <h4 class="mt-4 mb-3">Seller Information </h4>
                    <span>
                    <?php echo $seller_id; ?>
                    </span>


            </div>
        </div>
        
            <!-- <div id="display-card">
                <Div class="card " style="width: 18rem;">
                    <img src="resources/cc.jpg" alt="image">
                    <div class="card-body">
                        <h5 class="card-title"> Compiler Construction </h5>
                        <p class="card-text"> TY Bcs <br> Publishing Year :- 2022</p>
                        <a href="" class="btn btn-primary">Buy</a>
                    </div>
                </Div>
            </div>
        </div> -->
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
</body>
</html>
<?php

    session_start();
    error_reporting(E_ALL ^ E_WARNING);

    $conn=pg_connect("host = localhost dbname= postgres user= postgres password= bookwebsite ") or die (preg_last_error());

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

   
 
    $query1 = "select * from cart ORDER BY dte DESC";

    $result1= pg_query($conn,$query1) or die (preg_last_error());

    $i=0;
    while ($row =pg_fetch_row($result1) )
    {
        if($row[2]==$user_id)
        {
            $book_id[$i]=$row[1];
            $date[$i]=$row[3];
            $i++;
        }
    }
    
    
    $query2 = "select * from user_book_table";

    $result2= pg_query($conn,$query2) or die (preg_last_error());
    
  


    $rows=pg_num_rows($result1);

?>





<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/fontawesome.min.css" integrity="sha512-RUDCXG3qlIoMxuNYXWvgh3WT6t+dBpm4yzBHkLmqw3itMjBPKFtOz1/tyHrcJqtCD3lkDLH72wzbRB1/iEhEpw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="https://kit.fontawesome.com/624437a27c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="css/main.css">

    <title>Shopping cart</title>
  </head>
  <body class="bg-light">

  <header id="body-header">
        <!-- Logo -->
        <div id="logo">
            <img src="resources/logo.png" alt="logo" >
        </div>
        
        <!-- search bar -->
        <div id="search-bar">
            <form class="example" action="searchpage.php" method="get">
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
        echo                  '              <li>Your Books</li>';
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
            </ul>
        </nav>
    </div>

    <!-- Shopping cart -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-11 mx-auto">
                <div class="row mt-5 gx-3">
                    <!-- left side div -->
                    <?php
                        $total_price=0;
                        if($rows==0)
                        {
                            echo '<h2 style="margin:auto;" > No Books Added Yet <h2>';
                        }
                        else
                        {
                        while($row =pg_fetch_row($result2) )
                        {
                            foreach ($book_id as $temp)
                            if($row[0]==$temp)
                            {
                            echo '<div class="col-md-12 col-lg-8 col-11 mx-auto main_cart mb-lg-0 mb-5 shadow">';
                            echo  '   <div class="card p-4">';
                            echo   '    <!-- <h2 class="py-4 font-weight-bold">Cart (2 items)</h2> -->';
                            echo    '    <div class="row">';
                            echo     '      <!-- cart images div -->';
                            echo      '      <div class="col-md-5 col-11 mx-auto bg-light d-flex justify-content-center align-items-center shadow product_img">';
                            echo       '         <img src="resources/cc.jpg" class="img-fluid" alt="cart img">';
                
                            echo        '    </div>';
                            echo         '   <!-- cart product details -->';
                            echo          '  <div class="col-md-7 col-11 mx-auto px-4 mt-2 ">';
                            echo           '     <div class="row d-flex card-details">';
                            echo            '        <!-- product name -->';
                            echo             '       <div class="col-10 col-xs-10 card-title">';
                            echo              '          <h1 class="mb-4 product-name">'.$row[1].'</h1>';
                            echo               '         <p class="mb-2">publication name :- '.$row[5].'</p>';
                            echo                '        <p class="mb-2">'.$row[9].'</p>';
                            echo                 '       <p class="mb-3">condition :- '.$row[10].'</p>';
                            echo                  '  </div>';
                            echo                   ' <!-- Quantity inc dec -->';
                            echo                    '<div class="col-6 " id = "set">';
                            echo   '                     <ul class="pagination justify-content-end set_quantity">';
                            echo    '                        <li class="page-item">';
                            echo     '                           <button class="page-link" > <i class="fa-regular fa-minus"></i></button>';
                            echo      '                      </li>';
                            echo       '                     <li class="page-item"><input type="text" name="" class="page-link" value="1" id="textbox"></li>';
                            echo        '                    <li class="page-item">';
                            echo         '                       <button class="page-link" > <i class="fa-solid fa-plus"></i></button>';
                            echo          '                 </li> ';                           
                            echo           '             </ul>';
                            echo            '        </div>';
                            echo             '   </div>';
                            echo              '  <!-- remove move and price -->';
                            echo               ' <div class="row">';
                            echo    '                <div class="col-8 d-flex justify-content-between remove">';
                            echo     '                   <p><a href="removefromcart.php?id='.$row[0].'"  name="book_id" class="btn btn-primary" style="background-color: #f7971e ;border: none;">Remove</a></p>';
                            echo      '              </div>';
                            echo       '             <div class="col-4 d-flex justify-content-end price_money">';
                            echo        '                <h3>$<span id="itemval">'.$row[4].'</span></h3>';
                            echo         '           </div>';
                            echo '<a  href="bookpage.php?id='.$row[0].'"  name="book_id" class="btn btn-primary" style="background-color: #f7971e ; border: none;">Details</a>';
                            echo          '      </div>';
                            echo           ' </div>';
                            echo    '    </div>';
                            echo    '</div>';
                            echo    '<hr/>';
                            echo '</div>';
                            $total_price +=$row[4];
                            }
                        }
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- right side div -->
            <div class="col-md-12 col-lg-8 col-11 mx-auto  mb-lg-0 mb-10 mt-5">
                        <div class="right_side p-3 shadow bg-white">
                            <h2 class="product_name mb-5">Total Amount</h2>
                            <div class="price_indiv d-flex justify-content-between">
                                <p>Product amount</p>
                                <p>$<span id="product_total_amt"><?php echo $total_price; ?></span></p>
                            </div>
                            <div class="price_indiv d-flex justify-content-between">
                                <p>Shipping Charge</p>
                                <p>$<span id="shipping_charge">50.0</span></p>
                            </div>
                            <hr />
                            <div class="total-amt d-flex justify-content-between font-weight-bold">
                                <p>The total amount of (including VAT)</p>
                                <p>$<span id="total_cart_amt"><?php echo ($total_price+50); ?></span></p>
                            </div>
                            <a href=""  name="book_id" class="btn btn-primary" style="background-color: #f7971e ;border: none;">Checkout</a>
                        </div>
                    </div>     
        </div>
    </div>
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



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->


    <script type="text/javascript">

        var product_total_amt = document.getElementById('product_total_amt');
        var shipping_charge = document.getElementById('shipping_charge');
        var total_cart_amt = document.getElementById('total_cart_amt');
        const decreaseNumber = (incdec, itemprice) => {
                var itemval = document.getElementById(incdec);
                var itemprice = document.getElementById(itemprice);
                console.log( itemprice.innerHTML);

        // console.log(itemval.value);

                if(itemval.value <= 0){
                itemval.value = 0;
                alert('Negative quantity not allowed');
                } else {
                            itemval.value = parseInt(itemval.value) - 1;
                            itemval.style.background = '#fff';
                            itemval.style.color = '#000';
                            itemprice.innerHTML  = parseInt(itemprice.innerHTML) - 15;
                            product_total_amt.innerHTML  = parseInt(product_total_amt.innerHTML) - 15;
                            total_cart_amt.innerHTML  = parseInt(product_total_amt.innerHTML) + parseInt(shipping_charge.innerHTML);
                        }
        }
        const increaseNumber = (incdec, itemprice) => {
                        var itemval = document.getElementById(incdec);
                        var itemprice = document.getElementById(itemprice);
                // console.log(itemval.value);
                if(itemval.value >= 5){
                        itemval.value = 5;
                        alert('max 5 allowed');
                        itemval.style.background = 'red';
                        itemval.style.color = '#fff';
                } else {
                            itemval.value = parseInt(itemval.value) + 1;
                            itemprice.innerHTML  = parseInt(itemprice.innerHTML ) + 15;
                            product_total_amt.innerHTML  = parseInt(product_total_amt.innerHTML) + 15;
                            total_cart_amt.innerHTML  = parseInt(product_total_amt.innerHTML) + parseInt(shipping_charge.innerHTML);
                        }
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
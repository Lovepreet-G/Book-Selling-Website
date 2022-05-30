<?php

    session_start();
    error_reporting(0);

    include '_dbconn.php';

    $query1 = "select * from user_book_table";

    $result1= pg_query($conn,$query1) or die (preg_last_error());

    if(isset($_GET['id'])){
        $_SESSION['bbuyid'] = $_GET['id']; 
        
    }
    while ($row =pg_fetch_assoc($result1) )
    {
        if($row['book_id']==$_SESSION['bbuyid'])
        {
            $book_name=$row['book_name'];
            $original_book_price = $row['p_mrp'];
            $book_price=$row['selling_price'];
            $category = $row['book_cat'];
            $course=$row['c_name'];
            $course_year = $row['c_year'];
            $pub_name = $row['pub_name'];
            $pub_year=$row['pub_year'];
            $book_condition = $row['book_condition'];
            $user = $row['user_id'];
            $bought = $row['bought'];
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
    <script type="text/javascript">
    </script>
    <title>Home</title>
</head>
<body>
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
                    <h6>Book Information:</h6>
                    <h3 class="py-3"><?php echo "Book Name: ".$book_name; ?></h3>

                    <h4 class="mt-4 mb-3">Book Details </h4>
                    <h4 class="mb-3"><?php echo "Original Price: ".$original_book_price; ?></h4>
                    <h4 class="mb-3"><?php echo "Selling Price: ".$book_price; ?></h4>
                    <h4 class="mb-3"><?php echo "Category: ".$category; ?></h4>
                    <?php
                        if(isset($course)) {
                            echo '<h4 class="mb-3">Course: '.$course.'</h4>';
                        }
                        if(isset($course_year)) {
                            echo '<h4 class="mb-3">Semester: '.$course_year.'</h4>';
                        }
                    ?>
                    <h4 class="mb-3"><?php echo "Publisher: ".$pub_name; ?></h4>
                    <h4 class="mb-3"><?php echo "Published Year: ".$pub_year; ?></h4>
                    <h4 class="mb-3"><?php echo "Condition: ".$book_condition; ?></h4>
                    <h4 class="mb-3"><?php echo "Sold By: ".$_GET['name']; ?></h4>
                    
                    <?php echo  "<a href=\"buy.php?id=".$_SESSION['bbuyid']."\"  name=\"book_id\" class=\"btn btn-success mb-3\">Buy</a>";?>
                    <a href="buybooks.php" class="btn btn-primary mb-3">Back</a>
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
<?php
    $conn=pg_connect("host = localhost dbname= postgres user= postgres password= bookwebsite ") or die (preg_last_error());

    $search =ucwords($_GET["search"]);

    $probableTerms  = buildProbableSearchTerms($search);

    $query = "select * from user_book_table  WHERE book_name LIKE '{$probableTerms}' ";

    $result= pg_query($conn,$query) or die (preg_last_error());

    function buildProbableSearchTerms($searchTerm){
        $searchTerms    = "";
        if(strlen($searchTerm)<1){
            return "";
        }
        $arrVowels  = array("a", "e", "i", "o", "u");
        $arrSString = str_split($searchTerm);
        if(in_array(strtolower($arrSString[0]), $arrVowels)){
            array_splice($arrSString, 0, 1);
            foreach($arrVowels as $vowel){
                $searchTerms .= "%{$vowel}" . implode("", $arrSString) . "% OR ";
            }
            $searchTerms = rtrim($searchTerms, " OR ");
        }else{
            $searchTerms .= "%{$searchTerm}%";
        }
        return $searchTerms;

    }
    $rows=pg_num_rows($result);
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="searchpage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="https://kit.fontawesome.com/624437a27c.js" crossorigin="anonymous"></script>
    <title>Search</title>
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
            <form class="example" action="searchpage.php" method="get">
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
    <section id="display">
        <div id="display-area">
            <!-- Book display card -->
            <?php
                $i=0;
                
                if($rows==0)
                {
                    echo "<div id='display-card'>";
                    echo '<div class="card" style="width: 40rem;">';
                    echo '<div class="card-body " id="error">';
                    echo  $search." not Found :( ";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                
                while ($row =pg_fetch_row($result) )
                {
                    echo "<div id='display-card'>";
                        echo '<Div class="card " style="width: 18rem;">';
                            echo '<img src="resources/cc.jpg" alt="image">';
                            echo '<div class="card-body">';
                                echo '<h5 class="card-title"> '.$row[1].' </h5>';
                                echo '<p class="card-text">'.$row[9].'<br> Publishing Year :- '.$row[6].'</p>';
                                echo '<a href="bookpage.php?id='.$row[0].'"  name="book_id" class="btn btn-primary">Details</a>';
                                echo "</form>";
                            echo '</div>';
                        echo '</Div>';
                    echo '</div>';
                    $i++;
                }
            ?>
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
</body>
</html>
<?php
    pg_close($conn);
    
?>
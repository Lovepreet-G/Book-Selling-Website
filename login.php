<?php

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $login = false;
        $showError = false;
        include '_dbconn.php';

        $mobile = $_POST['mobile'];
        $pass = $_POST['password'];

        $query = "Select * from users where umob = $1";
        $result = pg_prepare($conn, "my_query", $query) or die ("Cannot prepare statement1\n");
        $result = pg_execute($conn, "my_query", array($mobile)) or die ("Cannot execute statement1\n");

        $row = pg_fetch_assoc($result);

        $num = pg_num_rows($result);
        if($num == 1) {
            if(password_verify($pass, $row['upass'])) {
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $row['uid'];
                $_SESSION['username'] = $row['uname'];
                if($_SESSION['bookPageRequest'] == true) {
                    $_SESSION['bookPageRequest'] = false;
                    header("location: bookpage.php");
                } else {
                    header("location: homepage.php");
                }
            }
            else {
                $showError = true;
            }
        } else {
            $showError = true;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login_page.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/bootstrap.css">

    <style>
         #sign_up_form
        {
            margin-top: 15px;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        #divPass {
            display: inline-block;
            margin-top: 10px;
            margin-left: 205px;
        }
    </style>

</head>
<body>
    <header id="body-header">
        <!-- Logo -->
        <div id="logo">
            <img src="resources/logo.png" alt="logo" >
        </div>
        
        
    </header>
    <div class = "center">
        <h1>Sign in</h1>
        <form method="post" action="login.php">
            <?php
                error_reporting(0);
                if($login) {
                    echo '
                    <div id="error">
                        <p>Successfully Signed IN!!!</p>
                    </div> ';
                } else if ($showError) {
                    echo '
                    <div id="error">
                        <p style="color:tomato;">Invalid Credentials.</p>
                    </div> ';
                }
            ?>
            <div class="row">
                <div class="txt_field">
                    <input type="number" id="mobile" name="mobile" required>
                    <span></span>
                    <label>Mobile Number</label>
                </div>

            </div>
            <div class="row">
                <div class="txt_field">
                    <input type="password" id="password" name="password" required>
                    <span></span>
                    <label>Password</label>
                </div>
                <div id="divPass">
                    <input type="checkbox" onclick="myFunction()" id="showPass">
                    <label for="showPass">Show Password</label>
                </div>
            </div>
            <div class="row">
                <div class="pass">Forget Password?</div>
                <input type="submit" value = "Sign in">
                <div class="signup_link">
                    Don't have an account? <a href="signup.php">Signup</a>
                </div>

            </div>
            
           
        </form>

    </div>
    <!-- script for show/hide password -->
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
    
</body>
</html>
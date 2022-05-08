<?php
    error_reporting(E_ALL ^ E_WARNING);


    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $eExists = false;
        $mExists = false;
        $showAlert = false;
        $showError = false;
        include '_dbconn.php';

        $username = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile_number'];
        $pass = $_POST['password'];
        $cpass = $_POST['cpassword'];

        $existEmailQuery = 'select * from users where uemail = $1';
        $existEmail = pg_prepare($conn, "equery", $existEmailQuery) or die ("Cannot prepare statement1\n");
        $existEmail = pg_execute($conn, "equery", array($email)) or die ("Cannot execute statement1\n");

        $existMobileQuery = 'select * from users where umob = $1';
        $existMobile = pg_prepare($conn, "mquery", $existMobileQuery) or die ("Cannot prepare statement1\n");
        $existMobile = pg_execute($conn, "mquery", array($mobile)) or die ("Cannot execute statement1\n");

        $email_num = pg_num_rows($existEmail);
        $mob_num = pg_num_rows($existMobile);

        if($email_num > 0) {
            $eExists = true;
        }

        if($mob_num > 0) {
            $mExists = true;
        }

        if($eExists == true || $mExists == true) {
            $showError = true;
        } else {

            $hash = password_hash($pass, PASSWORD_DEFAULT);

            $query = "insert into users (uname, uemail, umob, upass) values($1, $2, $3, $4)";
    
            $rs = pg_prepare($conn, "my_query", $query) or die ("Cannot prepare statement1\n");
            $rs = pg_execute($conn, "my_query", array($username, $email, $mobile, $hash)) or die ("Cannot execute statement1\n");
    
            if($rs) {
                $showAlert = true;
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/login_page.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/bootstrap.css">

    <script defer src="js/signup.js"></script>

    <style>
        #sign_up_form
        {
            margin-top: 15px;
        }

        html { overflow-y: scroll;}

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

        .center {
            margin-top: 100px;
        }

        .error {
            color: tomato;
            margin-top: -35px;
            font-size: small;
        }

        .passwordError {
            color: white;
            margin-bottom: -16px;
            display: inline-block;
        }

        #divPass {
            display: inline-block;
            margin-top: 10px;
            margin-left: 205px;
        }

    </style>
</head> 
<body>
    <header id="body-header" >
        <!-- Logo -->
        <div id="logo">
            <img src="resources/logo.png" alt="logo" >
        </div>
    </header>

    <div id="sign_up_form" class="center">
        <h1>Sign Up</h1>
        <form id="form" action="signup.php" method="post">
            <?php
                error_reporting(0);
                if($showAlert) {
                    echo '
                    <div id="error">
                        <p>Successfully Signed UP!!!</p>
                    </div> ';
                }
                if($showError) {
                    if($eExists) {
                        echo '
                        <span>
                            <p>Please try using different email id.</p>
                        </span> ';
                    }
                    if($mExists) {
                        echo '
                        <span>
                            <p>Please try using different Mobile number.</p>
                        </span> ';
                    }
                }
            ?>
            
            <div class="row">
                <div class="txt_field">
                    <input type="text" name="name" id="name" class="info" required>
                    <span></span>
                    <label>Enter your Name</label>
                </div>
                <span id="nameError" class="error"></span>
            </div>
            <div class="row">
                <div class="txt_field">
                    <input type="email" name="email" id="email" class="info" required>
                    <span></span>
                    <label>Enter your E-mail</label>
                </div>
                <!-- <span id="emailError" class="error"></span> -->
            </div>
            <div class="row">
                <div class="txt_field">
                        <input type="number" name="mobile_number" id="mobile_number" class="info" onKeyPress="if(this.value.length==10) return false;"  required>
                        <span></span>
                        <label>Enter Mobile Number</label>
                </div>
                <span id="numberError" class="error"></span>
            </div>
            <div class="row">
                <div class="txt_field">
                        <input type="password" name="password" id="password" class="info" required>
                        <span></span>
                        <label>Enter Password</label>
                </div>
                <span id="passError" class="error">
                    <p class="passwordError" id="upper"></p>
                    <p class="passwordError" id="lower"></p>
                    <p class="passwordError" id="digit"></p>
                    <p class="passwordError" id="special"></p>
                    <p class="passwordError" id="length"></p>
                </span>
                <span id="flag"></span>
            </div>
            <div class="row">
                <div class="txt_field">
                        <input type="password" name="cpassword" id="c_password" class="info" required>
                        <span></span>
                        <label>Confirm Password</label>
                </div>
                <span id="cpassError" class="error"></span>
                <div id="divPass">
                    <input type="checkbox" onclick="myFunction()" id="showPass">
                    <label for="showPass">Show Password</label>
                </div>
            </div>
            <div class="row">
                    <input type="submit" value="Sign Up" class="btn">
                    <input type="reset" value="Reset" class="btn" onclick="document.location.reload()">
                <div class="signin_link">
                    Already have an account? <a href="login.php">Sign in</a>
                </div>
            </div>
        </form>
    </div>

    <!-- script for show/hide password -->
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            var y = document.getElementById("c_password");
            if (x.type === "password" && y.type ==="password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
    </script>

</body>
</html>
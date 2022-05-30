<?php

    error_reporting(0);

    include '_dbconn.php';
    session_start();

    $query = "Select * from users where uid = $1";
    $result = pg_prepare($conn, "my_query", $query) or die ("Cannot prepare statement1\n");
    $result = pg_execute($conn, "my_query", array($_SESSION['user_id'])) or die ("Cannot execute statement1\n");

    $row = pg_fetch_assoc($result);

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
            $category = str_replace(' ','',$category);
            $course=$row['c_name'];
            $course_year = $row['c_year'];
            $course_year = str_replace(' ','',$course_year);
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
    <link rel="stylesheet" href="css/buy.css">
    <title>Buy Books Admin</title>
</head>
<body>
<div class="container">
  <div class="title">
      <h2>Buy Book Admin</h2>
  </div>
<div class="d-flex">
  <form action="buy.php" method="post">
    <label>
      <span class="bname">Book Name <span class="required">*</span></span>
      <input type="text" name="bname" id="bname" value="<?php echo $book_name?>" required>
    </label>
    <label>
      <span>Publisher <span class="required">*</span></span>
      <input type="text" name="pub" placeholder="" required value="<?php echo $pub_name?>">
    </label>
    <label>
      <span>Book Category <span class="required">*</span></span>
      <select name="cat">
            <option>CHOOSE BOOK CATEGORY</option>
            <option <?php if($category == 'Arts') {echo 'selected="selected"';}?>>Arts</option>
            <option <?php if($category == 'Commerce') {echo 'selected="selected"';}?>>Commerce</option>
            <option <?php if($category == 'Science') {echo 'selected="selected"';}?> value="Science">Science</option>
            <option <?php if($category == 'Fiction') {echo 'selected="selected"';}?>>Fiction</option>
            <option <?php if($category == 'Non-Fiction') {echo 'selected="selected"';}?>>Non-Fiction</option>
			</select>
    </label>
    
    <label>
      <span>Course <span class="required">*</span></span>
      <input type="text" name="course" value="<?php echo $course?>"> 
    </label>
    <label>
      <span>Course Year/Sem <span class="required">*</span></span>
      <select name="year" >
							<option>Choose year/sem..</option>
							<option <?php if($course_year == 'sem1') {echo 'selected="selected"';}?>>sem1</option>
							<option <?php if($course_year == 'sem2') {echo 'selected="selected"';}?>>sem2</option>
							<option <?php if($course_year == 'sem3') {echo 'selected="selected"';}?>>sem3</option>
							<option <?php if($course_year == 'sem4') {echo 'selected="selected"';}?>>sem4</option>
							<option <?php if($course_year == 'sem5') {echo 'selected="selected"';}?>>sem5</option>
							<option <?php if($course_year == 'sem6') {echo 'selected="selected"';}?>>sem6</option>
						</select>
    </label>
    <label>
      <span>Publishing Year <span class="required">*</span></span>
      <input type="text" name="pub_year" placeholder="" required value="<?php echo $pub_year?>">
    </label>
    <label>
      <span>Condition <span class="required">*</span></span>
      <input type="text" id="condition" name="condition" placeholder="" required value="<?php echo $book_condition?>" readonly>
    </label>
    <label>
      <span>Actual MRP <span class="required">*</span></span>
      <input type="text" id="mrp" name="mrp" placeholder="" required value="<?php echo $original_book_price?>" readonly>
    </label>
    <label>
      <span>Selling Price <span class="required">*</span></span>
      <input type="text" id="selling_price" name="selling_price" placeholder="" required value="<?php echo $book_price?>" readonly>
    </label>
    <label>
      <span>Book Image <span class="required">*</span></span>
      <input type="file" name="book_img" id="book_image" multiple accept="image/*">
    </label>
    <div class="Yorder" style="height:auto;">
      <input type="submit" value="Buy" id="button">
    </div>
    </form>

    <?php

      $bname=$_POST["bname"];
      $pub =$_POST["pub"];
      $cat=$_POST["cat"];
      $course=$_POST["course"];
      $year=$_POST["year"];
      $pub_year=$_POST["pub_year"];
      $condition=$_POST["condition"];
      $donation=$_POST["donation"];

      if(isset($_POST["mrp"]))
      {
        $mrp=$_POST["mrp"];
      }
      else
      {
        $mrp=0;
      }
      if(isset($_POST["selling_price"]))
      {
        $selling_price=$_POST["selling_price"];        
      }
      else
      {
        $selling_price=0;
      }

      if($mrp==0 && $selling_price==0) {
        $query ="insert into admin_book_table(book_name,p_mrp,selling_price,pub_name,pub_year,book_cat,c_year,c_name,posted) values('$bname',$mrp,$selling_price,'$pub',$pub_year,'$cat','$year','$course', 'false')";
        $result= pg_query($conn,$query) or die (preg_last_error());

        $query = "UPDATE user_book_table SET bought = 'true' WHERE book_id = $1;";
        $r1 = pg_prepare($conn, "update_bought", $query) or die ("Cannot prepare statement2\n");
        $r1 = pg_execute($conn, "update_bought", array($_SESSION['bbuyid'])) or die ("Cannot execute statement2\n");
   
        header("Location: books.php");
      } else {
        $query = "SELECT * FROM admin_book_table WHERE book_name = $1 AND pub_name = $2";
        $result = pg_prepare($conn, "book_query", $query) or die ("Cannot prepare statement1\n");
        $result = pg_execute($conn, "book_query", array($bname, $pub)) or die ("Cannot execute statement1\n");

        if(pg_num_rows($result) > 0) {
          $row = pg_fetch_assoc($result);
          $quantity = $row['quantity'] + 1;

          $query = "UPDATE admin_book_table SET quantity = $1 WHERE book_id = $2;";
          $r1 = pg_prepare($conn, "my_query_quantity", $query) or die ("Cannot prepare statement2\n");
          $r1 = pg_execute($conn, "my_query_quantity", array($quantity, $row['book_id'])) or die ("Cannot execute statement2\n");

          $query = "Select * from users where uid = $1";
          $r2 = pg_prepare($conn, "user_query", $query) or die ("Cannot prepare statement1\n");
          $r2 = pg_execute($conn, "user_query", array($user)) or die ("Cannot execute statement1\n");

          $sold_res = pg_fetch_assoc($r5);
          $sold = $sold_res['sold'] + 1;

          $query = "UPDATE users SET sold = $1 WHERE uid = $2;";
          $r3 = pg_prepare($conn, "my_query_sold", $query) or die ("Cannot prepare statement2\n");
          $r3 = pg_execute($conn, "my_query_sold", array($sold, $user)) or die ("Cannot execute statement2\n");

          $query = "UPDATE user_book_table SET bought = 'true' WHERE book_id = $1;";
          $r1 = pg_prepare($conn, "update_bought", $query) or die ("Cannot prepare statement2\n");
          $r1 = pg_execute($conn, "update_bought", array($_SESSION['bbuyid'])) or die ("Cannot execute statement2\n");

          header("Location: books.php");
          
        } else {
          $query ="insert into admin_book_table(book_name,p_mrp,selling_price,pub_name,pub_year,book_cat,c_year,c_name,posted) values('$bname',$mrp,$selling_price,'$pub',$pub_year,'$cat','$year','$course', 'true')";
          $result= pg_query($conn,$query) or die (preg_last_error());

          header("Location: books.php");
        }
      }

    ?>

 </div>
</div>
<script type="text/javascript">
  document.getElementById("book_image").onchange = function () {
    var reader = new FileReader();
    if(this.files[0].size>528385){
        alert("Image Size should not be greater than 500Kb");
        $("#book_image").attr("src","blank");
        $("#book_image").hide();  
        $('#book_image').wrap('<form>').closest('form').get(0).reset();
        $('#book_image').unwrap();     
        return false;
    }
    if(this.files[0].type.indexOf("image")==-1){
        alert("Invalid Type");
        $("#book_image").attr("src","blank");
        $("#book_image").hide();  
        $('#book_image').wrap('<form>').closest('form').get(0).reset();
        $('#book_image').unwrap();         
        return false;
    }   
    reader.onload = function (e) {
        // get loaded data and render thumbnail.
        document.getElementById("book_image").src = e.target.result;
        $("#book_image").show(); 
    };

    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
};

</script>

    <script type="text/javascript">
      function change()
      {
        
        const mrp=document.getElementById("mrp");
        const price=document.getElementById("selling_price");        
        if(document.getElementById("yes_").checked)
          {
            
            price.value =0;
            mrp.value =0;
            mrp.disabled = true;
            price.disabled = true;
          }
        else if(document.getElementById("no_").checked)
          {
            
            price.value ="";
            mrp.value ="";
            mrp.disabled = false;
            price.disabled = false;
          }      
      }

    </script>

</body>
</html>
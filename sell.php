<?php

    error_reporting(0);

    include '_dbconn.php';
    session_start();

    $query = "Select * from users where uid = $1";
    $result = pg_prepare($conn, "my_query", $query) or die ("Cannot prepare statement1\n");
    $result = pg_execute($conn, "my_query", array($_SESSION['user_id'])) or die ("Cannot execute statement1\n");

    $row = pg_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/buy.css">
    <title>Place your order</title>
   
</script>
</head>
<body>
<div class="container">
  <div class="title">
      <h2>Sell your Book</h2>
  </div>
<div class="d-flex">
  <form action="sell_process.php" method="post" enctype='multipart/form-data'>
    <label>
      <span class="bname">Book Name <span class="required">*</span></span>
      <input type="text" name="bname" value="" required>
    </label>
    <label>
      <span>Publisher <span class="required">*</span></span>
      <input type="text" name="pub" placeholder="" required value="">
    </label>
    <label>
      <span>Book Category <span class="required">*</span></span>
      <select name="cat" >
							<option >CHOOOSE BOOK CATEGORY</option>
							<option>SCIENCE</option>
							<option>ARTS</option>
							<option>COMMERCE</option>
							<option>FICTION</option>
							<option>NON FICTION</option>
							
			</select>
    </label>
    
    <label>
      <span>Course <span class="required">*</span></span>
      <input type="text" name="course" required> 
    </label>
    <label>
      <span>Course Year/Sem <span class="required">*</span></span>
      <select name="year" >
							<option>Choose year/sem..</option>
							<option>sem1</option>
							<option>sem2</option>
							<option>sem3</option>
							<option>sem4</option>
							<option>sem5</option>
							<option>sem6</option>
						</select>
    </label>
    <label>
      <span>Publishing Year <span class="required">*</span></span>
      <input type="text" name="pub_year" placeholder="" required value="">
    </label>
    <label>
      <span>Book Condition <span class="required">*</span></span>
            Good
						<input type="radio" value="Good" name="condition" >
						Very Good
						<input type="radio" value="Good" name="condition" >
						Excellent
						<input type="radio"value="Good"  name="condition" >
    </label>
    <label>
      <span>Donate Book <span class="required">*</span></span>
            Yes
						<input type="radio" id="yes_" value="1" onchange="change()" name="donation" >
						No
						<input type="radio" id = "no_" value="0" onchange="change()" name="donation" >
    </label>
    <label>
      <span>Actual MRP <span class="required">*</span></span>
      <input type="text" id="mrp" name="mrp" placeholder="" required value="">
    </label>
    <label>
      <span>Selling Price <span class="required">*</span></span>
      <input type="text" id="selling_price" name="selling_price" placeholder="" required value="">
    </label>
    <label>
      <span>Book Image <span class="required">*</span></span>
      <input type="file" name="book_img" id="book_image" multiple accept="image/*">
    </label>
    <div class="Yorder" style="height:auto;">
      <input type="submit" value="Sell" id="button">
    </div>
    
    
    </form>
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
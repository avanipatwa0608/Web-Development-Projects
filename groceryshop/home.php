<?php 
session_start();

if (!isset($_SESSION["session_id"]))
    ($_SESSION["session_id"] = 0);
   
?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>ABC Super Market</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script>
$('document').ready(function () {
    
        $("#header").load("header.php");
 });

function saveData(a){
    
    document.getElementById("prod_cat_id").value=a;
    
    document.getElementById("frm1").submit();

}


function setSession(){
    var loggedin=0;
    loggedin = "<?php echo $_SESSION['session_id']; ?>";
    
    if (loggedin != 0) 
        sessionStorage.setItem("loggedin", 1);

    //alert(sessionStorage.getItem("sess_id"));
    if (sessionStorage.getItem("sess_id") == null) {
        var arrCart = [["Dummy", "Dummy", "0"]];
    sessionStorage.setItem("cart", JSON.stringify(arrCart));
    
  }
  //alert ("the cart has " + sessionStorage.getItem("cart"));
}
</script>



</head>
<body class="bdy" onload="setSession()">
<div id="header"></div>
<form action="products.php" method="POST" id="frm1">
    <input type=hidden id="prod_cat_id" name="prod_cat_id" value="">
     <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname="grocery_shop";
    $err_msg =" ";

    $conn = new mysqli($servername,  $username, $password, $dbname);
    // Check connection
        if ($conn->connect_error) {
        $err_msg = "Connection failed: " . $conn->connect_error;
    }

    $sql = "SELECT prod_cat_id, prod_cat_name, image_name, prod_desc FROM product_catalog";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
?>
 <div class="row m-2">
       
   <?php     
   while($row = $result->fetch_assoc()) {  
   ?>
   
      
     <div  class="card  text-black bg-white" style="width:25%" >
             <a href="#" onclick =saveData("<?php echo $row['prod_cat_id']; ?>")>
            
            <img class="mt-5 img_size" src="images/<?php echo $row['image_name'];?>" alt="No image">
            <div class="card-body" >
               
                <h5 class="card-title text-center"><?php echo $row['prod_cat_name'];?></h5>
                <p class="card-text text-center"><?php echo $row['prod_desc'];?></p>
              
            </div>
        </a>
    </div>
<?php 
} 
?>
    </div>
<?php
    } else {
  echo "0 results";
}

$conn->close();
?>
   
        



    </div>

    </form>
</body>
</html>
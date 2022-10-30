<?php
session_start();
if (!isset($_SESSION["session_id"])) 
    ($_SESSION["session_id"] = 0);
if (!isset($_SESSION["item_count"])) 
    ($_SESSION["item_count"] = 0);
$prod_cat_id="";
$prod_cat_id = $_POST['prod_cat_id'];
?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>ABC Super Market</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   
<script>
$('document').ready(function () {
    
        $("#header").load("header.php");
 });

 let abc=0;
function checkSessionData(){
    
     let count=0;
     //alert(sessionStorage.getItem("cart"));
      arrCart = JSON.parse(sessionStorage.getItem("cart"));

      if (sessionStorage.getItem("item_count") != null) {
         abc = parseInt(sessionStorage.getItem("item_count"));
         
      }
      
      for (i=1; i< arrCart.length; i++) {

          if (arrCart[i][0] == "<?php echo $prod_cat_id; ?>") {
                
                document.getElementById('count_' +arrCart[i][1]).innerHTML = arrCart[i][2];
              
          }
     }
}

function incrCount(a){
    var temp = document.getElementById('count_' + a).innerHTML;
    if (temp != 0 )
    {
        //alert("in here" + document.getElementById('btn_' + a).innerHTML);
        document.getElementById('count_' + a).innerHTML=++temp;
         document.getElementById('btn_' + a).innerHTML="Modify Cart";

    }
    else {
    document.getElementById('count_' + a).innerHTML=++temp;
    }

}
function decrCount(a){
    var temp = document.getElementById('count_' + a).innerHTML;
    if (temp > 1) {
        document.getElementById('count_' + a).innerHTML=--temp;
        document.getElementById('btn_' + a).innerHTML="Modify Cart";
    }
}

function addToCart(prod_id){
    let abc=0;
   var flag=0; var temp=0;
    var count = document.getElementById('count_' + prod_id).innerHTML;
    
    arrCart = JSON.parse(sessionStorage.getItem("cart"));
   
   
    for (x=0; x<arrCart.length; x++) {
           
        if (arrCart[x][1] == prod_id) {
           
       
            temp =  parseInt(arrCart[x][2]);
            //alert ("temp is " + temp);
            arrCart[x][2] = count;
            //alert("arrCaart is " + arrCart[x][2]);
            flag=1;
             
            }
           abc = abc  +  parseInt(arrCart[x][2]);  
               
    }
    if (flag==0) {
       // alert("abc in flag " + abc);
       abc = abc + parseInt(count);
    var temp2 = ["<?php echo $prod_cat_id; ?>", prod_id, count];
    arrCart.push(temp2);
    }
    sessionStorage.setItem("cart", JSON.stringify(arrCart)); 
    sessionStorage.setItem("sess_id", "1");
   
    sessionStorage.setItem("item_count", abc);
    
    document.getElementById("cart").innerHTML = "<h5>"+abc +"<i class='fa fa-shopping-cart' aria-hidden='true'></i></h5>";
}
</script>
</head>
<body class="bdy" onload="checkSessionData()">
    <div   id="header"></div>
        
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

    $sql = "SELECT prod_id, prod_name, image_name, prod_desc, price, qty_measure, qty_count FROM product_details where prod_cat_id ='" . $prod_cat_id . "'";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
?>
 <div class="row m-2">
       
   <?php  
   $i=1;
   while($row = $result->fetch_assoc()) {  
   ?>
   
      
     <div  class="card  text-black bg-white" style="width:25%" >
             <a href="#">
            
            <img class="mt-5 img_size" src="images/<?php echo $row['image_name'];?>" alt="No image">
            <div class="card-body" >
               
                <h5 class="card-title text-center"><?php echo $row['prod_name'];?></h5>
                <p class="card-text text-center"><?php echo $row['prod_desc'];?></p>
                 <p class="card-text text-center"><?php echo $row['qty_measure'];?></p>
                <p class="card-text text-center">Rs. <?php echo $row['price'];?></p>
                <?php if ($row["qty_count"] == 0){ ?>
                       <p class="card-text text-center">Out of Stock</p>
                <?php }
                else {
                   
                ?>
                     <div class="counter px-5">
                            <div class="btn1" onclick="incrCount('<?php echo $row["prod_id"] ; ?>')">+</div>
                            <div id="count_<?php echo $row["prod_id"] ; ?>" class="count">0</div>
                            <div class="btn1" onclick="decrCount('<?php echo $row["prod_id"] ; ?>')">-</div>
                    </div>
                    <div class="text-center">
                    <button class="btn m-3"  id="btn_<?php echo $row["prod_id"] ; ?>"  onclick="addToCart('<?php echo $row["prod_id"] ?>')">Add to Cart</button>
                    </div>
               <?php } ?>
              
              
            </div>
        </a>
    </div>
<?php 
$i++;
}  ?>
   </div>
<?php
    } else { ?>

  <div  class="card  text-black bg-white" style="width:100%" >
           
            
            <img class="mt-5 img_size" src="images/noproducts.jpg" alt="No image">
            
       
    </div>
<?php }
$conn->close();
?>
   
        



    </div>

    


</body>
</html>
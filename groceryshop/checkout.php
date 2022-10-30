<?php
Session_start();
if (!isset($_SESSION["session_id"])) 
    ($_SESSION["session_id"] = 0);
   
  if (isset($_POST['cart'])) {
      
        $flag = $_POST['flag'];
        $cart = $_POST['cart'];
        $test_array = [[]];
        $final="'";
        $counter = count($cart);
        if ($flag == 1) 
        {
            for ( $a= 1; $a < $counter; $a++) 
            {
	            $product_code = $cart[$a][1];
                $final = $final. $product_code . "' , '";  
            }
            $final = rtrim($final, ", '");
        
            $sql = "select prod_name, image_name, price, qty_count, qty_measure, prod_id from product_details where prod_id in (" . $final . "')";
             $conn = mysqli_connect('localhost', 'root', '', 'grocery_shop');
      
            // Check connection
            if ($conn->connect_error) 
            {
                $err_msg ="Connection failed: " . $conn->connect_error;
            }
    
            $result = $conn->query($sql);
            if ($result->num_rows > 0)
            {

                $a=1;
                while($rows = $result->fetch_assoc())
                {
                    $test_array[$a][0] = $rows["prod_name"];
                    $test_array[$a][1] = $rows["image_name"];
                    $test_array[$a][2] = $rows["price"];
                    $test_array[$a][3] = $rows["qty_count"];
                    $test_array[$a][4] = $rows["qty_measure"];
                    $test_array[$a][5] = $rows["prod_id"];
              
                    $a++;
                }

            }
            $conn->close();
            echo JSON_encode($test_array);  
            exit();
        }
        else if ($flag == 0)
        {
            if ($_SESSION["session_id"] == 0){
                echo 2;
                exit();
            }
            else {
            echo "1";
            exit();
            }
        }
       
   }
  

?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>ABC Super Market</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="javascript/validate.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script>

$('document').ready(function () {
        if (sessionStorage.getItem("item_count") == null)
            cartItemCount = 0; 
        else 
            cartItemCount = parseInt(sessionStorage.getItem("item_count"));
        
        if (cartItemCount == 0){
            $("#checkoutcart").html("<div class='col-6 ml-5 mt-5'><h4>Your cart is empty</h4></div>");
            $("#checkout").hide();
        }
        else {
            //alert(sessionStorage.getItem("cart"));
            arrCart = JSON.parse(sessionStorage.getItem("cart"));
               
            $.ajax({
            url: 'checkout.php',
            type: 'post',
            data: {
                'cart': arrCart,
                'flag': '1',
                
            },
            success: function (response) {
              
               new_array = JSON.parse(response);
               total =0;
               
               for (i=1; i< arrCart.length; i++) {
                   for (j=1; j<new_array.length; j++) {
                       if (arrCart[i][1] == new_array[j][5]){
                            tmp = j;
                            break;
                       }
                   }

                            if (arrCart[i][2] != 0) {

                                   $('#parent').append('<div class="col-1" id="img_'+ arrCart[i][1] +'"><img class="ml-3 mt-3 img_size1" src="images/' + new_array[tmp][1] + '" alt="No image"></div>');
                  
                            $('#parent').append('<div class="col-2 mt-5 " id="pr_'+ arrCart[i][1] + '" >' + new_array[tmp][0] + '<br><span class="bld">' +  new_array[tmp][4] + '</span></div>');
                            $('#parent').append(' <div class="col-2" id="ab_'+ arrCart[i][1] + '"><p class=" ml-5 mt-3 ">'  + '<br>Rs. ' + new_array[tmp][2] + '</p>');
                   
                            $('#parent').append('<div class="col-2 text-center" id="abc_'+ arrCart[i][1] + '"><p class=" ml-5 mt-5">Rs.' + arrCart[i][2]* new_array[tmp][2]+ '</p></div>');
                             $('#parent').append('<div class="col-2 counter px-5" id="abcd_'+ arrCart[i][1] + '"><button class="btn1" id="btn_' + arrCart[i][1] + '">+</button><div id="count_' + arrCart[i][1] + '" class="count">'+ arrCart[i][2] + '</div><button id="btn_minus_' + arrCart[i][1] + '" class="btn1" >-</button></div>');
                            $('#parent').append('<div class="col-3" id="abcde_'+ arrCart[i][1] + '"><button id="delete_' + arrCart[i][1] +'" class="mt-5 ml-5" >Delete</button></div>');
                            }            
                           total = total + (arrCart[i][2]* new_array[tmp][2]);
                         
                        
               }
               $('#parent').append('<div class="col-5"></div>');
               $('#parent').append('<div class="col-3  mt-2 ml-3 font-weight-bold" id="total">Total Due : Rs.'+ total + '</div>');
              
            }
            
            });
         
        }

        $("#checkout").on('click', function() {

          $.ajax({
            url: 'checkout.php',
            type: 'post',
            data: {
                'cart': arrCart,
                'flag': '0',
                
            },
            success: function(response) {
               // alert("response is " + response);
                if (response == "1") {
                    
                    sessionStorage.clear();
                    $("#cart").empty().append("<h5><i class='fa fa-shopping-cart' aria-hidden='true'></i></h5>");
                    $("#parent").empty().append("<div class='col-6 ml-5 mt-5'><h5> Checkout successful. </h5></div>");
                    $("#checkout").hide();

                }
                else if (response == "2") {
                     $("#parent").empty().append("<div class='col-6 ml-5 mt-5'><h5> You need to login before checking out the items. </h5></div>");
                     $("#checkout").hide();
                }
                else {
                    alert("Could not complete checkout. try again");
                }
            }
           });
        });
        $("#header").load("header.php");
        $("#parent").on('click', 'button', function() {
             temp = this.id;
             temp1 = temp.slice(-4);
                       
            cnt = $("#count_" + temp1).text();
             
            if (this.innerHTML=="+"){
               
                cnt++;
              $("#count_" + temp1).text(cnt);
              for (i = 1; i < arrCart.length; i++)
                 {
                    for (j=1; j<new_array.length; j++)
                    {
                       if (arrCart[i][1] == new_array[j][5]){
                            tmp = j;
                            break;
                       }
                   }
                    if (temp1 == arrCart[i][1]) 
                    {
                        arrCart[i][2] = cnt; 
                        //alert(arrCart[i][2]);
                    }
                    count = count + parseInt(arrCart[i][2]);
                    ttl = ttl + (arrCart[i][2]* new_array[tmp][2]);
                  
                    
                 }
            
              
                    
            }
            else if (this.innerHTML=="-"){
                if (cnt >1)
                cnt--;
                 $("#count_" + temp1).text(cnt);
                 for (i = 1; i < arrCart.length; i++)
                 {
                    for (j=1; j<new_array.length; j++)
                    {
                       if (arrCart[i][1] == new_array[j][5]){
                            tmp = j;
                            break;
                       }
                   }
                    if (temp1 == arrCart[i][1]) 
                    {
                        arrCart[i][2] = cnt; 
                    }
                    count = count + parseInt(arrCart[i][2]);
                    ttl = ttl + (arrCart[i][2]* new_array[tmp][2]);
                  
                     arrCart[i][2] = cnt;
                     $("#total").html("Total Due : Rs."+ ttl);
                 }
            
            }
            else {
             
            
            var flag=0;
            var count = 0;
            var ttl =0;
            for (i = 1; i < arrCart.length; i++){
                for (j=1; j<new_array.length; j++) {
                       if (arrCart[i][1] == new_array[j][5]){
                            tmp = j;
                            break;
                       }
                   }
                if (temp1 == arrCart[i][1]) {
                    arrCart[i][2] = 0; }
                count = count + parseInt(arrCart[i][2]);
                  ttl = ttl + (arrCart[i][2]* new_array[tmp][2]);
                  
                
                if (arrCart[i][2] != 0) {
                    flag=1;}

            }
           
            if (flag==0) {
                
                 $("#parent").empty().append("<div class='col-6 ml-5 mt-5'><h5> Your cart is now empty </h5></div>");
                 $("#checkout").hide();
                 $("#cart").html("<h5>"+count +"<i class='fa fa-shopping-cart' aria-hidden='true'></i></h5>");

            }
            else{
                 
                $("#img_" + temp1).hide();
                $("#pr_" + temp1).hide();
                $("#ab_" + temp1).hide();
                $("#abc_" + temp1).hide();
                $("#abcd_" + temp1).hide();
                $("#abcde_" + temp1).hide();
                $("#total").html("Total Due : Rs."+ ttl);
                $("#cart").html("<h5>"+count +"<i class='fa fa-shopping-cart' aria-hidden='true'></i></h5>");
            }
           
        sessionStorage.setItem("cart", JSON.stringify(arrCart)); 
             sessionStorage.setItem("item_count", count);
        
           }
           
        }        );
 });

</script>
</head>
<body>
<div id="header"></div>
<div id="checkoutcart"></div>
 <div id="parent" class="row"></div>
 

 <div class="row">
    <div class="col-5"></div>
    <div class="mt-5 ml-3 col-3">
    <button class="btn" id="checkout">Checkout</button>
    </div>
</div>

 
</body>
</html>
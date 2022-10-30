<?php
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$gender = $_POST["gender"];
$telno = $_POST["telno"];
$uname = $_POST["username"];
$pwd = $_POST["password1"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname="grocery_shop";
$msg = "";
$flag=0;

if ($gender=='Female')
    $gender='f';
else 
       $gender='m';

$conn = new mysqli($servername,  $username, $password, $dbname);
    // Check connection
  if ($conn->connect_error) {
        $msg = "Connection failed: " . $conn->connect_error;
   }
   try {
       $sql= "INSERT into login_details(username, password) values ('$uname', '$pwd')";
        $conn->query($sql);
             
   }
   catch (Exception $e){
           $msg = "Error description: " . $conn -> error;
           $flag=1;
            
   }
       
    if ($flag==0) { 
        $sel_sql = "select user_id from login_details where username = '$uname'";
        $result = $conn->query($sel_sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {  
                $uid = $row["user_id"];
            }
        }
        try {
       $sql2 = "INSERT into user_details(fname, lname, email, tel_no, gender, user_id) values ('$fname', '$lname', '$email', $telno, '$gender', $uid)";
      
        if ($conn->query($sql2) === FALSE) {
            $msg = "Could not create user. Try Again!!";
        }
        else {
            $msg= "New User created successfully";
            }
       }
       catch (Exception $e){
           echo ("Error description11: " . $e->getMessage());
       }
    }  
        $conn->close();
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
    
        $("#header").load("header.html");
 });
 </script>
    </head>
 <body>
    
    <div id="header"></div>
    <div class="row">
        <div id="msg" class="m-2  pl-5 errormsg"><h1><?php echo $msg; ?></h1></div>
    </div>

    <div class="row">
        <button class=" ml-5 btn_class form-control col-sm-1" onclick="location.href='newuserreg.html'" >Go Back</button>
          </div>


</body>
</html>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

</head>
<body>

<?php 

$nameErr =$msg = $name= "";
$pwdErr=$pwd="";


   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
        if (empty($_POST["uname"])) {
             $nameErr = "Name is required";
            
        }else if (empty($_POST["pwd"])) {
           $name=($_POST["uname"]);
           
            $pwdErr = "Password is required";
        }
        else {
             $name = test_input($_POST["uname"]);
             $pwd = test_input($_POST["pwd"]);
             if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
              $nameErr = "Only letters and white space allowed";
            }
            else { 
               
                   $conn = new mysqli('localhost','root','','college_website');
	                if($conn->connect_error){
		                echo "$conn->connect_error";
		            die("Connection Failed : ". $conn->connect_error);
	                } else {
                         
                         $sql = "SELECT * from login_details where username = '" . $name ."'";
                         
                         $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                 if ($pwd == $row["pswd"]) {
                                        $msg="Welcome Admin";
                                        $conn->close();
                                         header("Location:admin_login.php");
                                         exit();
                                    }
                                else {
                                    $msg= "Invalid password";
                                }
                                }
                          } else {
                            $msg= "Invalid Username!!";
                    }

                    $conn->close();
             }
        }
        }}



   function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
    <div class="container border border-dark rounded  my-5 " style="width:40%">
        <h1 class="my-5">Admin Portal</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

            <div class="row">
                <label for="uname" class="col-sm-5 mb-3 pl-5" >Username:</label>
                <input type="text" name="uname" class="col-sm-5 mb-3" value="<?php echo $name;?>"/>
                <span>* <?php echo $nameErr;?></span>

            </div>
            <div class="row">
                <label for="pwd" class="col-sm-5 mt-3 pl-5">Password:</label>
                <input type="password" name="pwd" class="col-sm-5 mt-3" />
                <span>* <?php echo $pwdErr;?></span>
            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <input type="submit" value="Submit" class="col-sm-3 border border-primary rounded my-5 mx-5" />
            </div>
            
        </form>

    </div>
    <div class="container-fluid row ">
            <h3 class="text-xl-center"> <?php echo $msg; ?></h3>
            </div>
</body>
</html>
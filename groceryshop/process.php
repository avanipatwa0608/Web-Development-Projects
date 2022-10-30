<?php 
  $db = mysqli_connect('localhost', 'root', '', 'grocery_shop');
  if (isset($_POST['username_check'])) {
  	$username = $_POST['username'];
      $sql = "select * from login_details where username = '$username'";
  	//$sql = "SELECT * FROM users WHERE username='$username'";
  	$results = mysqli_query($db, $sql);
  	if (mysqli_num_rows($results) > 0) {
  	  echo "taken";	
  	}else{
  	  echo 'not_taken';
  	}
  	exit();
  }
  

?>



<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>To Do List</title>


</head>
<body class="bdy">

<?php

$to_do_list = $_POST["hiddenF"];
$date_select = $_POST["date_select"];
$final_date = $date_select;
$test_array = array();
$test_array= json_decode($to_do_list,true);
 $counter = count($test_array);
 $flag=0;
 for ( $a= 0; $a < $counter; $a++) 
 {
	  $temp = $test_array[$a]["mode"];
	  if ($temp != "Deleted") {
		  break;
	  }
	//if ($test_array)[$a]["mode"] =="Deleted")
	 	$flag=1;
	
	 
 }


	$sql ="";
	$msg="";
	$conn = mysqli_connect('localhost','root','','to_do_list');
	if(!$conn){
		     echo "Connection error: " . mysqli_connect_error;
		    
	}
	else {
			for ( $row = 0; $row < $counter; $row++){
		
					$taskdata = $test_array[$row]["task_data"];
					$taskmode = $test_array[$row]["mode"];
					$taskid = $test_array[$row]["task_num"];
		
					if ($taskid==0) {

						$sql = "insert into list_items(mode, task_data, date_created ) values ('$taskmode', '$taskdata', '$date_select')";
						if (!(mysqli_query($conn,$sql))){
								$msg = "Could not insert data";
						}

					
				
					}
					else {
						$sql = "Update list_items set mode = '" . $taskmode . "' where task_num = " . $taskid;
						if (!(mysqli_query($conn,$sql))) {
							$msg = "Could not update data";
						}		
						
					}
					
				
			}
	}
	mysqli_close($conn);

 if ($flag == 1) {
?>
<h4 class="h4 m-5">You do not have any To Do List items for <?php echo $final_date?>!!</h4>
<?php 
 }
 else {
  
 if ($msg=="") { ?>

	<h4 class="h4 m-5">The following To Do tasks have been created for <?php echo $final_date?>: </h4>
	<ul>
	<?php 
	for ( $row = 0; $row < $counter; $row++){
		
					$taskdata = $test_array[$row]["task_data"];
					$taskmode = $test_array[$row]["mode"];
					$taskid = $test_array[$row]["task_num"];
					if ($taskmode != "Deleted") { 
						echo   "<li> " . $taskdata;
						if ($taskmode == "Checked")
							echo "  --> Marked Done";
						echo "</li>";
				}
	} ?>
</ul>
<?php } 
 } 
?>
	
<form action="home_1.php" method="POST">

<input type="hidden" name="date_select" value="<?php echo $final_date; ?>"/> 
 <div class="col-sm-3">
            
            <input type="submit" value="Add more TO DO items" class="btn_sub" onclick="submitTask();">
        </div>

</body>
</html>
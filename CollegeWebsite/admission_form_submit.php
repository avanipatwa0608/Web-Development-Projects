<?php
//getting all the values to be entered in the database
$name = $_POST["fname"];
$gender = $_POST["gender"];
$email= $_POST["email"];
$tel_no = $_POST["telno"];
$address = $_POST["address"];
$percent10 = $_POST["percent10"];
$percent12 = $_POST["percent12"];
$coursename =$_POST["coursename"];

$p10= rtrim($percent10, "%");
$p12 = rtrim($percent12, "%");
if ($gender == "Male") {
	$gender="m";
}
else {
	$gender = "f";
}
$dt_created = date("Y-m-d",time());
$conn = new mysqli('localhost','root','','college_website');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into admission_form(name, gender, email, mobile_num, address, class10_percent, class12_percent, course_name, dt_created) values(?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssisddss", $name, $gender, $email, $tel_no, $address, $p10, $p12, $coursename, $dt_created);
		$execval = $stmt->execute();
		//echo $execval;
		$msg =  "<br>Admission Form successfully submitted for " . $name . " for the course " .$coursename;

		
		$stmt->close();
		$conn->close();
	}
	
	
	$target_dir = "uploads/";
	$uploadOk = 1;
	$allowed = array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf');
	$file_name = basename($_FILES["fileToUpload"]["name"]);
	//$ext = basename($_FILES["fileToUpload"]["type"]);
	
	$target_file = $target_dir . $file_name;
	$ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime = finfo_file($finfo, $_FILES["fileToUpload"]['tmp_name']);
	finfo_close($finfo);
	if (!in_array($mime, $allowed)) {
        $uploadOk = 0;
        $errMsg = 'Not an accepted file type. Please upload only .pdf/.doc/.docx files!';
    }
    echo "<br>the extension is " .$ext . "<br>";
    if (($ext == "doc" || $ext=="docx" || $ext == "pdf")  && ($uploadOk == 0)){
        $errMsg = "The file is corrupt!";
    }

	if (file_exists($target_file)) {
	$errMsg = "Sorry, file already exists.";
	$uploadOk = 0;
	}

	if ($_FILES["fileToUpload"]["size"] > 500000) {
	$errMsg= "Sorry, your file is too large.";
	$uploadOk = 0;
	}


  

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 1) {
  
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $errMsg = "The file ". htmlspecialchars( $file_name). " has been uploaded.";
    } else {
        $errMsg ="Sorry, there was an error uploading your file.";
    }
}
?>
<div class="row">
<?php echo $msg ."<br>" . $errMsg?>
</div>
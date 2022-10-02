<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Admin Login</title>

    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <title>Admin Portal</title>
    <script>
        $(document).ready(function () {
            $("#header").load("header.html");
            $("#footer").load("footer.html")


        });
    </script>
</head>
<body class="bdy">
<div class="container-fluid">
    <div id="header"></div>
<?php


function getCourseName($course_id){
            $course="";
            switch  ($course_id) {
                    case "UGCS" :
                          $course = "Under Graduate Course in Computer Science";
                          break;
                    case "UGIT" :
                          $course = "Under Graduate Course in Information Technology";
                          break;
                    case "PGCS":
                          $course = "Post Graduate Course in Computer Science";
                          break;
                    case "PGIT" :
                          $course = "Post Graduate Course in Information Technology";
                          break;
                    default:
                          $course = "Bachelors of Business Administration";
                              
            }
            return $course;
}
$coursename=$frm_dt=$to_dt=$dt_err_msg="";
$flag=0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $coursename = $_POST["cname"];
    $frm_dt = $_POST["from_dt"];
    $to_dt = $_POST["to_dt"];
              
    if ($frm_dt > $to_dt) {
        $dt_err_msg = "From Date cannot be greater than To date";
    }
    else {
        $flag=1;    
    }
}
?>
<div class="container-fluid">
<div class="row">
    <h1 class="my-3 pl-5">Welcome to Admin Portal</h1>

</div>
<div class="row">
<h3>View Submitted Admission Form details for:</h3>
</div>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

<div class="row ">
    
    <div class="col-sm-1 pl-5">
        <label for="cname">Course</label>
    </div>
    <div class="col-sm-6">
         <select class="form-control col-sm-4" name="cname" id="coursename">
         <option value="ALL">All Courses</option>
            <option value="UGCS">B. Tech Computer Science</option>
            <option value="UGIT">B. Tech Information Technology</option>
            <option value="PGCS" >M. Tech Computer Science</option>
            <option value="PGIT">M. Tech Information Technology</option>
            <option value="UGMBA">Bachelors of Business Administration</option>
            </select>
    </div>
    
</div>
<div class="row">
    <div class="col-sm-1 ">
        <label>Date Range </label>
    </div>
    <div class="col-sm-2">
        <input type="date" name="from_dt" value="<?php echo $frm_dt; ?>">
    </div>
    <div class="col-sm-1">
        <label> To </label>
    </div>
    <div class="col-sm-4">
        <input type="date" name="to_dt" value="<?php echo $to_dt; ?>">
         <span><?php echo $dt_err_msg; ?></span>
    </div>
</div>
<div class="row col-sm-5">
    <input type="submit" value="Submit">
   
</div>
 </form>


<?php
if ($flag ==1) {
    $conn = new mysqli('localhost','root','','college_website');
	if($conn->connect_error){
		 echo "$conn->connect_error";
		 die("Connection Failed : ". $conn->connect_error);
	} else {
            
            if ($coursename=="ALL") {

                if ($frm_dt == "" and $to_dt == "") {  
                    $sql = "SELECT * from admission_form";
                   }
                   else {
                     $sql = "SELECT * from admission_form where dt_created >= '" . $frm_dt ."' and dt_created <= '" . $to_dt ."'";
                    }
            }
           else {
               if ($frm_dt == "" and $to_dt == "") {  
                    $sql = "SELECT * from admission_form where course_name = '" . $coursename . "'";
                   }
                   else {
                     $sql = "SELECT * from admission_form where course_name = '" . $coursename . "' and dt_created >= '" . $frm_dt ."' and dt_created <= '" . $to_dt ."'";
                    }
            }

           

          $result = $conn->query($sql);

             if ($result->num_rows > 0) {
                    
                    
                    if ($coursename != "ALL") {
                        $course_name = getCourseName($coursename);
                        echo "<br><h3>Application details for the " . $course_name . "</h3><br>";
                    }
                    echo "<table>";
                    echo "<thead><th class='px-3'>Name</th><th class='px-3'>Gender</th><th class='px-3'>Email</th>";
                    echo "<th class='px-3'>Mobile Number</th><th class='px-3'>Address</th>";
                       echo "<th class='px-3'>Percent in Class 10</th><th class='px-3'>Percent in Class 12</th>";
                    if ($coursename=="ALL") {
                        echo "<th class='px-3'>Course Name</th>";
                    }
                    echo "</thead>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td class='px-3'>" .$row["name"] . "</td>";
                        if ($row["gender"] == "m") {
                            echo "<td class='px-3'>Male</td>";
                        }
                        else {
                             echo "<td class='px-3'>Female</td>";
                        }
                         echo "<td class='px-3'>" .$row["email"] . "</td>";
                        echo "<td class='px-3'>" .$row["mobile_num"] . "</td>";
                         echo "<td class='px-3'>" .$row["address"] . "</td>";
                        echo "<td class='px-3'>" .$row["class10_percent"] . "</td>";
                        echo "<td class='px-3'>" .$row["class12_percent"] . "</td>";
                        if ($coursename=="ALL") {
                             $course_name = getCourseName($row["course_name"]);   
                            
                            echo "<td class='px-3'>" .$course_name . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
             }
             else {
                 echo "No records found";
             }
    }
             $conn->close();
    }

?>

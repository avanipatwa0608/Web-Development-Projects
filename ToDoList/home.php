<?php 

$final_date = date('Y-m-d');
//$final_date = date_format($sel_date);

?>
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sel_date = $_POST["date_select"];
    $time = strtotime($sel_date);

$final_date = date('Y-m-d',$time);
    
   
}

    $todolist = [];
    $conn = mysqli_connect('localhost','root','','to_do_list');
	if(!$conn){
		     echo "Connection error: " . mysqli_connect_error;
		    
	}
	else {
    //$today = date("Y/m/d");
    $sql = "select * from list_items where  mode != 'Deleted' and date_created <= '" . $final_date . "'";          
    $result = mysqli_query($conn,$sql);
    $rows= mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    mysqli_close($conn);
    $i=0;
    foreach($rows as $row){
        $i++;
        if (($row["mode"] == "Checked" and $row["date_created"] === $final_date ) ||($row["mode"] == "Add")) {
             $list_item = array("task_num"=> $row["task_num"], "mode"=> $row["mode"], "task_data" => $row["task_data"], "count" => $i);
             $list_item_new = json_decode(json_encode($list_item), true);
             array_push($todolist, $list_item);
        }
        else {
            $i--;
        }
    }
              
    }           
                     
     ?>
    <h3 class="mt-3 h1">To Do Task Creator</h3>
    <hr class="border border-dark">
    <div class="row m-3">
        <p>To add tasks for Today, simply write the task and click on Add button.<br>
        To add/modify/delete tasks for any other date, select the specific date and click on 'Change the Date' button</p>
    </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" >
       
        <div class="row px-4">
            <p class="dthead col-2 my-3 py-3">Add TO DO items for:</p>
            <input type="date" class="dtpicker col-2 my-3" name="date_select"  value="<?php echo $final_date ?>"></input>
        <input type="submit" class="btn_sub col-2" value="Change the Date" title="click here to change the date"></input>
        </div>
    </form>
    <form action="savetodo.php" method="POST">
        <div class="container-fluid header">
            <h2>
                My To Do List
            </h2>
            <div class="row m-3">
                <input type="text" name="myInput" id="myInput" class="col-sm-8" placeholder="Add a TO DO item.." />
                <button type="button" value="Add" class=" button_pos col-sm-2" onclick="addNewTask()">Add</button>
            </div>

        </div>
        <ul id="myList" class="list_type" name="myList1">
        </ul>
        <div class="col-sm-3">
            <input type="hidden" id="date_select" name ="date_select" value="<?php echo $final_date ?>">
        <input type="hidden" id="hiddenF" name="hiddenF" value="">
            <input type="submit" value="Done for the day" class="btn_sub" onclick="submitTask();">
        </div>
    </form>
    
    <script>
           
            n =  new Date();
            
            y = n.getFullYear();
            m = n.getMonth();
            monthArr = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            month = monthArr[m];
            d = n.getDate();
            
           
            
            const todolist = <?php echo json_encode($todolist); ?>
        
        
        let counter = todolist.length;
        console.log("the counter value is " + counter + todolist);
        if (counter != 0) {

            for (i = 1; i <= counter; i++) {
                var li = document.createElement("li");
                console.log ("the value of todolist.count is " + todolist.count );
                var ptr = todolist.find(todolist => todolist.count == i);
                            
                //console.log(ptr);
                var inputValue = ptr.task_data;
                var mode = ptr.mode;
                console.log ("the mode is " +mode);

                var t = document.createTextNode(inputValue);
                li.appendChild(t);
                document.getElementById("myList").appendChild(li);
                var span = document.createElement("SPAN");
                var txt = document.createTextNode("\u00D7");
                span.appendChild(txt);
                span.className = "close";
                li.appendChild(span);
                li.setAttribute("id", "list_" + i);
                if (ptr.mode == "Checked") {
                    li.classList.toggle('checked');
                }
            }


        }


        // Add a "checked" symbol when clicking on a list item or delete an item
        var list = document.querySelector('ul');
        
        list.addEventListener('click', function (ev) {
            
            if (ev.target.tagName === 'LI') {
                
                var cc = ev.target.id;
                var dd = cc.substr(5);
                //console.log("in checked value of cc is " + cc);
                //console.log("in checked value of dd is " + dd);
               // dd++;
              var ptr = todolist.find(todolist => todolist.count == dd);
                //console.log(ptr.mode);
                if (ptr.mode === "Add") { 
                    ptr.mode = "Checked";
                
                }
                else if (ptr.mode == "Checked"){
                    ptr.mode = "Add";
                    
                }
                ev.target.classList.toggle('checked');
               
            }
            if (ev.target.tagName === 'SPAN') {

                var aa = ev.target.parentElement.id;
                var bb = aa.substr(5);
                //console.log("in delete aa is " + aa);
                //console.log("in delete bb is " + bb);
                var ptr = todolist.find(todolist => todolist.count == bb);
                ptr.mode = "Deleted";
                
                
                var cc = ev.target.parentElement;
                cc.style.display = "none";
                
            }

        }, false);


        function addNewTask() {

            
            
            var li = document.createElement("li");

            var inputValue = document.getElementById("myInput").value;
            var t = document.createTextNode(inputValue);
            li.appendChild(t);
            counter = counter + 1;
            li.setAttribute("id", "list_" + counter);
            if (inputValue === '') {
                alert("You must write something!");
            } else {

                
             
                document.getElementById("myList").appendChild(li);
                let newVal = {
                    "task_num": 0,
                    "mode": "Add",
                    "task_data": inputValue,
                }
                todolist.push(newVal);
                
                
                
            }
           
            document.getElementById("myInput").value = "";
            var span = document.createElement("SPAN");
            var txt = document.createTextNode("\u00D7");
            span.className = "close";
            span.appendChild(txt);
           
            li.appendChild(span);
            
            
        }
        

        function submitTask() {
            console.log(todolist);
            const myJSON = JSON.stringify(todolist);
            document.getElementById("hiddenF").value = myJSON;
            //sessionStorage.setItem("flag", "1");
            console.log(document.getElementById("hiddenF").value);
        };
    </script>
    </body>
</html>
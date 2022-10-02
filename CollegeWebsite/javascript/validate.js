function checkValid(z) {
  console.log("value is " + z.value);

  if (z.value == "") {

    alert("its a required field!!");

    return;
  }
  else {
    z = ToUpper(z);
  }

}


function ToUpper(a){
a.value = a.value.toUpperCase();
}

function validateemail(b){
  var x = b.value;
  if ((x.indexOf("@") == -1)||(x.indexOf(".")==-1)) {
    alert("Enter valid email id!!");
    b.focus();
  }

}

function checkNumber(d){

  if (isNaN(d.value)){
    alert("enter valid number");
    d.focus();
    return ;
  }
}
function validatenumber(c){

  if (isNaN(c.value)){
    alert("enter valid number");
    c.focus();
    return false;
  }
  if (c.value == "" || c.value == null) {
    alert("Please enter your Mobile No.");
    c.focus();
    return;
  }
  if (c.value.length < 10 || c.value.length > 10) {
    alert("Mobile No. is not valid, Please Enter 10 Digit Mobile No.");
    c.focus();
    return;
}
}


function calculatePercent10(){
    var total = document.getElementById('total10').value;
    console.log(total);
    checkNumber(document.getElementById('total10'));
    var marks = document.getElementById('marks10').value;

  if (marks > total) {
    alert ("Marks obtained cannot be more than total marks possible!!");;
    return
  }
  var percent = (marks * 100)/total;
  console.log(percent);
  document.getElementById('percent10').value= percent.toFixed(2) + "%";


}

function calculatePercent12(){
    var total = document.getElementById('total12').value;

    checkNumber(document.getElementById('total12'));
    var marks = document.getElementById('marks12').value;

  if (marks > total) {
    alert ("Marks obtained cannot be more than total marks possible!!");;
    return
  }
  var percent = (marks * 100)/total;
  console.log(percent);
  document.getElementById('percent12').value= percent.toFixed(2) + "%";


}

function savedetails(){

  var a;
   if (document.getElementById('gndr1').checked){
      a= document.getElementById('gndr1').value;
    }
    else {
    a=  document.getElementById('gndr2').value;
    }
const saved_details= {
  name: document.getElementById('fn').value,
  email:document.getElementById('email1').value,
  mobile: document.getElementById('mob').value,
  gender:a,
  addr: document.getElementById('addrss').value,

  percent10: document.getElementById('percent10').value,
    percent12: document.getElementById('percent12').value,
};

var  course= document.getElementById("coursename");
var result = coursename.options[coursename.selectedIndex].text;

console.log(result);
    document.getElementById("percent10").disabled = false;
    document.getElementById("percent12").disabled = false;
alert("You have saved the following details for course: " + result + " \n Name: " + saved_details.name + "\n Email: " + saved_details.email + "\n Gender: " + saved_details.gender + "\n Mobile Number: " + saved_details.mobile + "\n Address: " + saved_details.addr + "\nClass 10 Percentage: " + saved_details.percent10 + "\n Class 12 Percentage: " + saved_details.percent12);
//document.getElementById('prnt').innerHTML="Name: " + saved_details.name + "<br> Email: " + saved_details.email + "<br> Gender: " + saved_details.gender + "<br> Mobile Number: " + saved_details.mobile + "<br> Address: " + saved_details.addr;
   
}



function check() { // Define a function that we can call our event listeners with
    // Get our inputs and textareas
    var inputs = document.getElementsByTagName("input");
    var textareas = document.getElementsByTagName("textarea");
    var filled = true; // We'll assume that all of the fields are full unless proven otherwise
    var oneChecked = false; // We can use this to keep track of the radio buttons (by assuming at first that none are checked)

    for (var i = 0; i < inputs.length; i++) { // Loop through all of the inputs first
        if (inputs[i].type === "text" && !inputs[i].value) { // If the input is a text field, check whether it is empty; if so, set filled to false

            filled = false;
        }

        if (inputs[i].type === "radio" && inputs[i].checked) { // If the input is a radio button, see if it is filled in; because we only need one radio button to be filled in, that's all we need to know
            oneChecked = true;
        }

    }

    if (!oneChecked) { // Check outside of the loop if any of our radio buttons were selected and, if not, set filled to false
        filled = false;
    }

    for (var j = 0; j < textareas.length; j++) { // Now loop through all of the text areas; if any aren't filled in, set filled to false
        if (!textareas[j].value) {
            filled = false;
        }
    }

    if (filled) { // Check whether any of the fields are empty (or, in the radio button's case, if one is selected, and enable/disable the button accordingly
        document.getElementById("save1").disabled = false;
    } else {
        document.getElementById("save1").disabled = true;
    }
}

// Add event listeners to check for keypresses and clicks
window.addEventListener("keyup", check);
window.addEventListener("click", check);

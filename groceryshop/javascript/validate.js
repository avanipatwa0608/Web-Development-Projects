function incrCount(a) {
    alert("in here");
    var temp = document.getElementById('count_' + a).innerHTML;
    if (temp != 0) {
        //alert("in here" + document.getElementById('btn_' + a).innerHTML);
        document.getElementById('count_' + a).innerHTML = ++temp;
        //document.getElementById('btn_' + a).innerHTML="Modify Cart";

    }
    else {
        document.getElementById('count_' + a).innerHTML = ++temp;
    }

}
function decrCount(a) {
    var temp = document.getElementById('count_' + a).innerHTML;
    if (temp > 1) {
        document.getElementById('count_' + a).innerHTML = --temp;
        //document.getElementById('btn_' + a).innerHTML="Modify Cart";
    }
}





function checkValid(z, a) {
  console.log("value is " + z.value);

  if (z.value == "") {

      document.getElementById(a).innerHTML="this is a required field!!"
      return false;
  }
  

}


function ToUpper(a){
a.value = a.value.toUpperCase();
}

function validateemail(b){
  var x = b.value;
  if ((x.indexOf("@") == -1)||(x.indexOf(".")==-1)) {
      document.getElementById("msg4").innerHTML = "Enter valid email";
    b.focus();
  }

}

function checkNumber(d){

  if (isNaN(d.value)){
      document.getElementById("msg5").innerHTML = "Enter valid number";
    d.focus();
    return ;
  }
}
function validatenumber(c){

  if (isNaN(c.value)){
      document.getElementById("msg5").innerHTML = "Enter valid number";
    
    return false;
  }
    if (c.value == "" || c.value == null) {
        document.getElementById("msg5").innerHTML = "Please enter your Mobile No.";
   
    
    return false;
  }
    if (c.value.length < 10 || c.value.length > 10) {
        document.getElementById("msg5").innerHTML = "Mobile No. is not valid, Please Enter 10 Digit Mobile No.";
  
    return false;
}
}

function verifyPassword() {
    var pw = document.getElementById("pwd1").value;
    //check empty password field  
    if (pw == "") {
        document.getElementById("message").innerHTML = "**Fill the password please!";
        return false;
    }

    //minimum password length validation  
    if (pw.length < 8) {
        document.getElementById("message").innerHTML = "**Password length must be atleast 8 characters";
        return false;
    }

    //maximum length of password validation  
    if (pw.length > 15) {
        document.getElementById("message").innerHTML = "**Password length must not exceed 15 characters";
        return false;
    }
    else {

        //check if first letter is capital
        var firstChar = pw.substring(0, 1);
        if (firstChar.toUpperCase() != firstChar) {
            document.getElementById("message").innerHTML = "**First letter of Password must be a Capital letter";
            return false;

        }
    //check if special character is included
        const specialChars = `\`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~`;
        var count = 0;
        for (var i = 0; i < pw.length; i++) {
            
            if (specialChars.indexOf(pw.charAt(i)) == -1) {
                count++;
            }
            if (count == 0) {
                document.getElementById("message").innerHTML = "**Password must have a special character";
                return false;
            }
            
        }
        
       
    }
}  

function checkPwd() {
   
    var pwd1 = document.getElementById("pwd1").value;
    var pwd2 = document.getElementById("pwd2").value;
    
    if (pwd1 != pwd2) {
        document.getElementById("message").innerHTML= "Passwords entered do not match";
        document.getElementById("save1").disabled = false;
        
        return false;
    }
  

}






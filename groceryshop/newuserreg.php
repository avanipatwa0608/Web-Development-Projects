﻿
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>New User Registration</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    
    <script src="javascript/val.js"></script>

    <script src="javascript/validate.js"></script>
    

</head>
<body>
    <div id="header"></div>
    <div class="container-fluid m-5">

        <form action="createuser.php" method="POST">

            <div class="row form-group">

                <label class="col-sm-2" for="fname">First Name</label>
                <input type="text" name="fname" class="col-sm-2 form-control" id="fn" onblur="checkValid(this, 'msg1'), ToUpper(this)" required>
                <div class="col-sm-3 " id="msg1"></div>

            </div>
            <div class="row form-group">

                <label class="col-sm-2" for="lname">Last Name</label>
                <input type="text" name="lname" class="col-sm-2 form-control" id="ln" onblur="checkValid(this, 'msg2'), ToUpper(this)" required>
                <div class="col-sm-3 " id="msg2"></div>

            </div>
            <div class="row form-group">
                <label class="col-sm-2" for="gender">Gender</label>
                <input type="radio" name="gender" value="Male" class="mx-2" id="gndr1"> Male
                <input type="radio" name="gender" value="Female" class="mx-2" id="gndr2">Female
                <div class="col-sm-3" id="msg3"></div>
            </div>
            <div class="row form-group">
                <label class="col-sm-2" for="email">Email</label>
                <input type="email" name="email" class="col-sm-2 form-control" onchange="validateemail(this)" required id="email1">
                <div class="col-sm-3" id="msg4"></div>
            </div>
            <div class="row form-group">
                <label for="telno" class="col-sm-2">Mobile Number</label>
                <input type="tel" name="telno" class="col-sm-2 form-control" maxlength="10" required onchange="validatenumber(this)" id="mob">
                <div class="col-sm-3" id="msg5"></div>
            </div>

            <div class="row form-group">

                <label class="col-sm-2" for="username">Username</label>
                <input type="text" name="username" maxlength="10" size="15" class="col-sm-2 form-control" id="username" required>
                <div class="col-sm-3" id="msg6"></div>

            </div>

            <div class="row form-group">

                <label class="col-sm-2" for="password1">Password</label>
                <input type="password" name="password1" maxlength="15" size="20" class="col-sm-2 form-control" required id="pwd1" onblur="checkValid(this,'message')">
                <div class="col-sm-3" id="message"></div>

            </div>

            <div class="row form-group">

                <label class="col-sm-2" for="password2">Re-enter Password</label>
                <input type="password" name="password2" maxlength="15" size="20" class="col-sm-2 form-control" required id="pwd2" onblur="checkValid(this, 'msg7'), checkPwd()">
                <div class="col-sm-3" id="msg7"></div>

            </div>
            <div class="row errormsg">All fields are mandatory</div>

            <div class="row pt-3 ml-2 form-group">


                <input type="submit" class="btn_class  col-sm-1" id="save1">

            </div>
        </form>

    </div>




</body>
</html>

$('document').ready(function () {
    
        $("#header").load("header.html");
   
    var username_state = false;

    $('#username').on('blur', function () {
        var username = $('#username').val();

        if (username == '') {
            username_state = false;
            document.getElementById("msg6").innerHTML = 'Username cannot be empty';
            return;
        }
        if (username.length < 5) {
            username_state = false;
            document.getElementById("msg6").innerHTML = 'Username should be atleast 5 characters';
            return;
        }
        $.ajax({
            url: 'process.php',
            type: 'post',
            data: {
                'username_check': 1,
                'username': username,
            },
            success: function (response) {
               
                if (response == 'taken') {
                    username_state = false;
                    document.getElementById("msg6").innerHTML='Sorry... Username already taken';
                } else if (response == 'not_taken') {
                    username_state = true;
                    document.getElementById("msg6").innerHTML ='Username available';
                }
            }
        });
    });
});
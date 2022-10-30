<?php 
session_start();
?>
<script>
$('document').ready(function () {
    
        if(sessionStorage.getItem("item_count")!=null) {
            
            $("#cart").html(function (i, origText){
                return "<h5>" + sessionStorage.getItem("item_count")  + origText + "</h5>";
            });
              
           
        }
            
    });
</script>
<div class="container-fluid border border-bottom border-dark">
    <div class="row mt-3 mr-5 text-right">
        <?php 
        
        if($_SESSION["session_id"]== 1) { ?>
            <span class="col-12"> Welcome <?php echo $_SESSION["name_of_user"]; ?> | <a href="logout.php" class="anchor">Logout</a>  | <a class="anchor" href="checkout.php">My Cart<span id="cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span></a>
</span>
        <?php } else { ?>
            <span class="col-12"><a class="anchor" href="login.php"> Login </a> | <a class="anchor" href="checkout.php">My Cart<span id="cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span></a></span>
        <?php } ?>
        <div id="cart1"></div>
    </div>
        <div class="row text-center mt-4">
            <h1 class="col-12 head text-uppercase">ABC Super Market</h1>
        </div>
        <div class="row">
            <h6 class=" col-9   subhead">Guaranteed delivery in 20 mins</h6>
        </div>

    </div>
    <div class="navbar navbar-light bg-secondary">
        <div class="nav-action">

            <a class="navbar-brand" href="home.php"> Home</a>
        </div>
        <div class="nav-action">
            <input type="text" />
            <a class="navbar-brand" href="#"><i class="fa-solid fa-magnifying-glass"></i> Search </a>
        </div>
    </div>
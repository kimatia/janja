<script>
function getcity(id) {
      xhr = new XMLHttpRequest();
      xhr.open('GET' , 'test.php?idd='+id, true);
      xhr.send();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status==200){
          document.getElementById("city_display").innerHTML = xhr.responseText;
          }
      
        }


}

function getEmail(emailid){

      email  = new XMLHttpRequest();
      email.open('GET' , 'test2.php?email='+emailid, true);
      email.send();
      email.onreadystatechange = function(){
        if (email.readyState == 4 && email.status == 200)
        {
          
          document.getElementById('emailDiv').innerHTML = email.responseText;
          }
        
        }
  
  
  }
  
  
  function password (pass){
  var a = document.getElementById('txtpass1').value;
  //  document.write(a);
    var b = document.getElementById('txtpass2').value;
    if (a == b ){
      document.getElementById('cnfrmpass').innerHTML = "<font color='#00CC00'>Matched</font>";
      }
      else {
        
        document.getElementById('cnfrmpass').innerHTML = "<font color='red'>Miss matched</font>";
        }
    }

</script>

<?php
include_once('config.php');
$result = mysqli_query($conn , 'select * from country');
if(!$result){
  echo 'query failed';}
?>
<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
  $stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if($row['loginType']=="admin"){
    $reg_user->redirect('adhome.php');
  }else if($row['loginType']=="company"){
    $reg_user->redirect('home.php');
  }
}


if(isset($_POST['btn-signup']))
{
 $uname = trim($_POST['txtuname']);
 $email = trim($_POST['txtemail']);
 $upass = trim($_POST['txtpass']);
 $uphone = trim($_POST['txtphone']);
 $uNatId = trim($_POST['txtNatId']);
 $ucount = trim($_POST['txtcount']);
 $urole = trim($_POST['txtrole']);

 $stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
 $stmt->execute(array(":email_id"=>$email));
 $row = $stmt->fetch(PDO::FETCH_ASSOC);

 if($stmt->rowCount() > 0)
 {
  $msg = "
        <div class='alert alert-danger'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong>  User with that email already exists , Please Try another one
     </div>
     ";
 } else {
  if($reg_user->register($uname,$email,$upass,$uphone,$uNatId,$ucount,$urole)){
    $msg = "
          <div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
       <strong>Success !</strong>  You can now login.
       </div>
       ";
       //after successful login, lets take the user to the login page
       header("refresh:3;login.php");
        
 }else  {
   echo "sorry , Query could no execute...";
  }
}
}

if(isset($_POST['btn-call']))
    {
        $username = $_POST['user_name'];// name
        $userphone = $_POST['user_phone'];// phone
        
       
        if(empty($username)){
            $errMSG = "Please Enter Name.";
        }
        else if(empty($userphone)){
            $errMSG = "Please Enter phone number.";
        }
       
       


        // if no error occured, continue ....
        if(!isset($errMSG))
        {
            $stmt = $DB_con->prepare('INSERT INTO tbl_call(userName,userPhone,sendtime) VALUES(:uname,:uphone,now())');
            $stmt->bindParam(':uname',$username);
            $stmt->bindParam(':uphone',$userphone);
            

            if($stmt->execute())
            {
                $successMSG = "successfully created a call request...";
               
            }
            else
            {
                $errMSG = "error while creating a call request....";
            }
        }
    }
?>
<!DOCTYPE HTML>
<html>
<div class="row">
    <div class="col-md">
</div>
<head>
<title>Ideas | Signup</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Learn Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--bootstrap corousel omitted->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="dist/css/sb-admin-2.css" rel="stylesheet">
<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script src="vendor/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
<script src="bootstrap/js/bootstrap.min.js"></script>

<!--for the sake of corousel-->
<link rel="stylesheet" href="css/theme.css" />
<link rel="stylesheet" href="css/MoneAdmin.css" />
<link rel="stylesheet" href="plugins/Font-Awesome/css/font-awesome.css" />
<link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
<link href="dist/css/sb-admin-2.css" rel="stylesheet">
<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="lib/animate-css/animate.min.css" rel="stylesheet">
<link href="css/bootstrap-3.1.1.min.css" rel='stylesheet' type='text/css' />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/jquery.countdown.css" />
<link href="css/font-awesome.css" rel="stylesheet">
<script src="js/notifications.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<link href="css/animate.min.css" rel="stylesheet">
<script src="js/wow.min.js"></script>
<script>
 new WOW().init();
</script>
<!-- Template Specisifc Custom Javascript File -->
<script src="js/custom.js"></script>
</head>

        <script>
      $(function () { Notifications(); });
        </script>
<script>
$(document).ready(function(){
    $(".dropdown").hover(
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
            $(this).toggleClass('open');
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
            $(this).toggleClass('open');
        }
    );
});
</script>
</head>
<body style="background-image: url(images/bg10.jpg); " >
<div id="particles-js" class="gradient"></div>
 <div class="count-particles">
              <span class="js-count-particles"></span>
            </div>
<header>
<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
<a href="index.php" class="navbar-brand"><h2><strong>Janja</strong></h2></a>
        </div>
        <!--/.navbar-header-->
        <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1" style="height: 1px;">
            <ul class="nav navbar-nav">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list"></i><span>Courses</span></a>
                      <ul class="dropdown-menu">
                        <li><a href="#">Courses Categories</a></li>
                        <li><a href="#">Courses list</a></li>
                        <li><a href="#">Courses detail</a></li>
                      </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-calendar"></i><span>Events</span></a>
                     <ul class="dropdown-menu">
                        <li><a href="#">Event1</a></li>
                        <li><a href="#">Event2</a></li>
                        <li><a href="#">Event3</a></li>
                     </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-globe"></i><span>English</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><span><i class="flags us"></i><span>English</span></span></a></li>
                        <li><a href="#"><span><i class="flags newzland"></i><span>Newzland</span></span></a></li>
                        
                    </ul>
                </li>
                <li class="dropdown">
                   
                    
                      <li><a href="login.php"><span class="glyphicon glyphicon-user"></span><strong>login</strong></a></li>
                   
                </li>
                
            </ul>
        </div>
        <div class="clearfix"> </div>
      </div>
        <!--/.navbar-collapse-->
</nav>
<nav class="navbar nav_bottom" role="navigation">
 <div class="container">
 <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header nav_2">
      <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"></a>
   </div>
   <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
      <ul class="nav navbar-nav nav_1">
          <li><a href="index.php"><strong>Home</strong></a></li>
          <li><a href="about.php"><strong>About</strong></a></li>


          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><strong>Services</strong><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="research&development.php"><strong>research & development</strong></a></li>
              <li><a href="strategy&advisory.php"><strong>strategy advisory</strong></a></li>
              <li><a href="project&management.php"><strong>project management</strong></a></li>
              <li><a href="advisory&risk.php"><strong>Risk advisory</strong></a></li>
              <li><a href="financial&advisory.php"><strong>financial advisory</strong></a></li>
              <li><a href="legal&advisory.php"><strong>legal advisory</strong></a></li>
            </ul>
          </li>

          <li><a href="services.php"><strong>Services</strong></a></li>
           <li><a href="gallery.php"><strong>Gallery</strong></a></li>
 <li><a href="team.php"><strong>Meet Us</strong></a></li>
          <li class="last"><a href="contact.php"><strong>Contacts</strong></a></li>
      </ul>
     </div><!-- /.navbar-collapse -->
    </div>
</nav>
</header>
    <div class="row" style="padding-top: 120px">
<div class="col-md-5 col-md-offset-3">
<div id="slider">
    <div id="slide-wrapper" class="rounded clear">
    <div class="panel panel-default">

            <div class="panel-heading">
                <center><strong>SIGNUP</strong></center>
               
                <?php
    if(isset($errMSG1)){
            ?>
            <div class="alert alert-danger">
                <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG1; ?></strong>
            </div>
            <?php
    }
    else if(isset($successMSG1)){
        ?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG1; ?></strong>
        </div>
        <?php
    }
    ?>
            </div>
            <div class="panel-body" style="background-color: purple;">

       <form class="form-signin" method="post" id="register-form" >



             <fieldset>
  <?php if(isset($msg)) echo $msg;  ?>
  <div class="form-group input-group">
  <span class="input-group-addon">Username&nbsp&nbsp&nbsp</span>
      <input class="form-control" placeholder="Username" name="txtuname"  autofocus required>
  </div>
  <div class="form-group input-group">
  <span class="input-group-addon">Email&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
    <input class="form-control" placeholder="E-mail" name="txtemail" type="email" required>
</div>
  <div class="form-group input-group">
  <span class="input-group-addon">Telephone&nbsp&nbsp</span>
      <input class="form-control" placeholder="Phone number" name="txtphone" required>
  </div>
  <div class="form-group input-group">
  <span class="input-group-addon">National ID</span>
    <input class="form-control" placeholder="National Number" name="txtNatId" required>
</div>
<div class="form-group input-group">
  <span class="input-group-addon">Nationality</span>
    <select class="form-control" name="txtcount">
<?php while($row = mysqli_fetch_assoc($result)){?>
<option value="<?php echo $row['country_id']; ?>"> <?php echo $row['country_name']; ?>
</option>

<?php } ?>
</select>
<div id="city_display"></div>
</div>
<div class="form-group input-group">
<span class="input-group-addon">Password&nbsp&nbsp&nbsp</span>
    <input class="form-control" placeholder="Password" name="txtpass" id="txtpass1" type="password" value="" required>
</div>
<div class="form-group input-group">
<span class="input-group-addon">C.Password&nbsp&nbsp&nbsp</span>
    <input class="form-control" placeholder="Password" name="txtpass2" id="txtpass2" onblur="password()" type="password" value="" required>
    
</div>
                                
  <input name="txtrole" type="hidden" value="worker" required>
                                 
<button class="btn btn-lg btn-success btn-block" type="submit" name="btn-signup">Signup</button></br>
          </fieldset>
             </form>
              </div>
            <div class="panel-footer">
             <div id="cnfrmpass"></div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

</body>
     <div class="row" style="padding-top: 1.1em;">
       <div class="col-md-10 col-md-offset-1">
        <div id="slider">
      <div id="slide-wrapper" class="rounded clear">
        <div class="footer">
       <div class="col-md-4 grid_4">
               <h3>About Us</h3>
               <p>iDEAS Ltd offers the expertise that a proactive-oriented and market-opportunity seeking company needs to develop and enter new product distribution and new market segments. We provide a number of indispensable services to the business community and the public. These can be summed up in two main divisions - Business and Training Services. </p>

            </div>
            <div class="col-md-4 grid_4">
               <h3>Quick Links</h3>
              <ul class="footer_list">

                    <li><a href="research&development.php"><strong>research & development</strong></a></li>
                    <li><a href="strategy&advisory.php"><strong>strategy advisory</strong></a></li>
                    <li><a href="project&management.php"><strong>project management</strong></a></li>
                    <li><a href="advisory&risk.php"><strong>Risk advisory</strong></a></li>
                    <li><a href="financial&advisory.php"><strong>financial advisory</strong></a></li>
                    <li><a href="legal&advisory.php"><strong>legal advisory</strong></a></li>

              </ul>
            </div>
            <div class="col-md-4 grid_4">
               <h3>Contact Us</h3>
              <address>
                        <div class="clearfix"></div>
                                <div class="login-form-1">

                                        <div class="login-form-main-message"></div>
                                        <div class="main-login-form">
                                         <div class="login-group">
                                         <form id="login-form" class="text-left" method="post">
                                            <div class="form-group">
                                                <label for="ad" class="sr-only" style="color: black;">Name</label>
                                                <input type="text" class="form-control" id="ad" name="user_name" placeholder="Name">
                                            </div>
                                            <div class="form-group">
                                                <label for="tel" class="sr-only" style="color: black;">Phone Number</label>
                                                <input type="text" class="form-control" id="tel" name="user_phone" placeholder="Phone Number">
                                            </div>
                                        
                                        <button type="submit" class="login-button" name="btn-call" id="btn-call"><i class="fa fa-chevron-right"></i></button>
                                        </form>
                                        </div>
                                </div>
                        <br>
                         <br>

                        <div class="row">
                <?php
      if(isset($errMSG)){
              ?>

              <div class="alert alert-danger alert-dismissable">
                  <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
              </div>
              <?php
      }
      else if(isset($successMSG)){
          ?>
          <div class="alert alert-success alert-dismissable">
                <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
          </div>
          <?php
      }
      ?>
             </div>
                        <abbr>Email : </abbr> <a href="mailto@ideaslimited@gmail.com">info(at)ideaslimited.com</a>
                   </address>
                   <ul class="social-nav icons_2 clearfix">
                        <li><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" class="facebook"> <i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a></li>
                     </ul>
            </div>

            <div class="clearfix"> </div>
            <div class="copy">
               <p>Copyright &copy 2017. All Rights Reserved  | Design by <a href="#" target="_blank">Kimatia Joshua.</a> </p>
              </div>
          </div>
            </div>
            </div>
            </div>
    </div>
<script src="js/script.js"></script>
    <script type="text/javascript">
        $('.carousel[data-type="multi"] .item').each(function(){
          var next = $(this).next();
          if (!next.length) {
            next = $(this).siblings(':first');
          }
          next.children(':first-child').clone().appendTo($(this));

          for (var i=0;i<4;i++) {
            next=next.next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }

            next.children(':first-child').clone().appendTo($(this));
          }
        });
    </script>
    <script src="dist/spin.min.js"></script>
    <script src="dist/ladda.min.js"></script>
 <script src="js/bootstrap.min.js"></script>
      <script src="js/animsition.min.js"></script>
      <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
      <script src="js/jquery.magnific-popup.min.js"></script>
      <script src="js/jquery.countdown.min.js"></script>
      <script src="js/twitterFetcher_min.js"></script>
      <script src="js/masonry.pkgd.min.js"></script>
      <script src="js/imagesloaded.pkgd.min.js"></script>
      <script src="js/jquery.flexslider-min.js"></script>
      <script src="js/photoswipe.min.js"></script>
      <script src="js/photoswipe-ui-default.min.js"></script>
      <script src="js/jqinstapics.min.js"></script>
      <script src="js/particles.min.js"></script>
      <script type="text/javascript">
        particlesJS("particles-js", {"particles":{"number":{"value":67,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"triangle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":12,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":false,"mode":"repulse"},"onclick":{"enable":false,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true});var count_particles, stats, update; stats = new Stats; stats.setMode(0); stats.domElement.style.position = 'absolute'; stats.domElement.style.left = '0px'; stats.domElement.style.top = '0px'; document.body.appendChild(stats.domElement); count_particles = document.querySelector('.js-count-particles'); update = function() { stats.begin(); stats.end(); if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) { count_particles.innerText = window.pJSDom[0].pJS.particles.array.length; } requestAnimationFrame(update); }; requestAnimationFrame(update);;
      </script>
      <script src="js/script.js"></script>
    <script>

      // Bind normal buttons
      Ladda.bind( '.button-demo h4', { timeout: 5000 } );

      // Bind progress h4s and simulate loading progress
      Ladda.bind( '.progress-demo h4', {
        callback: function( instance ) {
          var progress = 0;
          var interval = setInterval( function() {
            progress = Math.min( progress + Math.random() * 0.1, 1 );
            instance.setProgress( progress );

            if( progress === 1 ) {
              instance.stop();
              clearInterval( interval );
            }
          }, 200 );
        }
      } );

      // To control loading explicitly using the JavaScript API
      // var l = Ladda.create( document.querySelector( 'h4' ) );
      // l.start();
      // l.stop();
      // l.toggle();
      // l.isLoading();
      // l.setProgress( 0-1 );

    </script>


</html>


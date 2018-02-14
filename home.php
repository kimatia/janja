<?php
session_start();
require_once 'dbconfig.php';

//get the logged in user credentials and validate
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('login.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//we can now access the users details from $row['appropriatedbfield']

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
<!--new-->

<!DOCTYPE HTML>
<html>
<head>
<title>Ideas | User</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Learn Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
<link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- jQuery -->
<script src="vendor/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<!-- Optional theme -->
<!-- custom stylesheet -->
<link rel="stylesheet" href="style.css">
<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="css/theme.css" />
    <link rel="stylesheet" href="css/MoneAdmin.css" />
    <link rel="stylesheet" href="plugins/Font-Awesome/css/font-awesome.css" />
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<link href="css/bootstrap-3.1.1.min.css" rel='stylesheet' type='text/css' />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/jquery.countdown.css" />
<link href="css/font-awesome.css" rel="stylesheet">

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
<body>
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
<a href="index.php" class="navbar-brand"><strong>Janja</strong></a>
        </div>
        <!--/.navbar-header-->
        <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1" style="height: 1px;">
            <ul class="nav navbar-nav">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list"></i><span><strong>Courses</strong></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="#"><strong>Courses Categories</strong></a></li>
                        <li><a href="#"><strong>Courses list</strong></a></li>
                        <li><a href="#"><strong>Courses detail</strong></a></li>
                      </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-calendar"></i><span><strong>Events</strong></span></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-globe"></i><span><strong>English</strong></span></a>
                </li>
                <li class="dropdown">
                    <a href="#"><i class="fa fa-user"></i><span>&nbsp; <strong><?php echo "Hello User ".$row['userName']; ?></strong></span>
                    </a>
                    </li>
            <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></br> <strong>Logout</strong></span></a>
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




</body>

      <div class="row">
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
                <p>Copyright © 2017 ideasLTD . All Rights Reserved  | Design by <a href="#" target="_blank">K.D Joshua.</a> </p>
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
   <div class="container">

 <div class="sticky-container">
      <ul class="sticky">
        <li>
          <img src="images/facebook-circle.png" width="32" height="32">
          <p><a href="https://www.facebook.com/" target="_blank">Like Us on<br>Facebook</a></p>
        </li>
        <li>
          <img src="images/twitter-circle.png" width="32" height="32">
          <p><a href="https://twitter.com/" target="_blank">Follow Us on<br>Twitter</a></p>
        </li>
       
       
        <li>
          <img src="images/youtube-circle.png" width="32" height="32">
          <p><a href="http://www.youtube.com/" target="_blank">Subscribe on<br>YouYube</a></p>
        </li>
       
      </ul>
    </div>
</div>
</body>
</html>


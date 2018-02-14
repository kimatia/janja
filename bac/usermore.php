
<script>
function startTime() {
    var today = new Date();
    var hr = today.getHours();
    var min = today.getMinutes();
    var sec = today.getSeconds();
    ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
    hr = (hr == 0) ? 12 : hr;
    hr = (hr > 12) ? hr - 12 : hr;
    //Add a zero in front of numbers<10
    hr = checkTime(hr);
    min = checkTime(min);
    sec = checkTime(sec);
    document.getElementById("clock").innerHTML = hr + ":" + min + ":" + sec + " " + ap;
    
    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    var curWeekDay = days[today.getDay()];
    var curDay = today.getDate();
    var curMonth = months[today.getMonth()];
    var curYear = today.getFullYear();
    var date = curWeekDay+", "+curDay+" "+curMonth+" "+curYear;
    document.getElementById("date").innerHTML = date;
    
    var time = setTimeout(function(){ startTime() }, 500);
}
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function getText() {
    
  var $a =  document.getElementById('text').value;
  
    xhr = new XMLHttpRequest();
    xhr.open('POST' , 'chatdb.php',true);
    xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
    xhr.send('chat='+$a);
    xhr.onreadystatechange=function(){
      if (xhr.responseText){
      //  document.getElementById('chatarea').innerHTML=xhr.responseText;
                  }
        }
          }
          function getText() {
    
  var $a =  document.getElementById('text').value;
  
    xhr = new XMLHttpRequest();
    xhr.open('POST' , 'comment.php',true);
    xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
    xhr.send('comment='+$a);
    xhr.onreadystatechange=function(){
      if (xhr.responseText){
      //  document.getElementById('chatarea').innerHTML=xhr.responseText;
                  }
        }
          }
    

function setText(){
  
  xhr = new XMLHttpRequest();
  xhr.open('POST' , 'chatFetch.php' , true);
  xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
  xhr.send();
  xhr.onreadystatechange = function(){
  //  alert(xhr.responseText);
      document.getElementById('chatarea').innerHTML = xhr.responseText;
      }
    
  }
  setInterval("setText()",2000);
  
  
setInterval("users()",3000);

  
  function users(){
  xhr1 = new XMLHttpRequest();
  xhr1.open('POST' , 'userFetch.php' , true);
  xhr1.setRequestHeader('content-type','application/x-www-form-urlencoded');
  xhr1.send();
  xhr1.onreadystatechange = function(){
  //  alert(xhr.responseText);
      document.getElementById('loginperson').innerHTML = xhr1.responseText;
      }
    
    
    }
    
    
</script>

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
if (isset($_GET['logout'])){
  $email = $row['userEmail'];
$_SESSION['email'] = $email;
  $result = mysqli_query($conn, "UPDATE tbl_users SET user_status = '0' WHERE userEmail = '$_SESSION[email]'");
session_destroy();
header('location: login.php?logout_successfully=<span style="color:green">You have successfully Logged Out.</span>');
  
  }

if(isset($_POST['btnsave']))
    {

      $name = $row['userName'];
$_SESSION['name'] = $name;
        $username = $_SESSION['name'];// user email
        $usercontent = $_POST['user_content'];// user content
        
        

        $imgFile = $_FILES['user_image']['name'];
        $tmp_dir = $_FILES['user_image']['tmp_name'];
        $imgSize = $_FILES['user_image']['size'];

       if(empty($usercontent)){
            $errMSG = "Please Enter Your content.";
        }
       
       
        else if(empty($imgFile)){
            $errMSG = "Please Select Image File.";
        }
        else
        {
            $upload_dir = 'upload/'; // upload directory

            $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

            // valid image extensions
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

            // rename uploading image
            $userpic = rand(1000,1000000).".".$imgExt;

            // allow valid image file formats
            if(in_array($imgExt, $valid_extensions)){
                // Check file size '20MB'
                if($imgSize < 20000000)             {
                    move_uploaded_file($tmp_dir,$upload_dir.$userpic);
                }
                else{
                    $errMSG = "Sorry, your file is too large.";
                }
            }
            else{
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        }


        // if no error occured, continue ....
        if(!isset($errMSG))
        {
            $stmt = $DB_con->prepare('INSERT INTO chat(chat_person_name,chat_value,chat_pic,chat_time) VALUES(:uname, :ucontent, :upic,now())');
            $stmt->bindParam(':uname',$username);
            $stmt->bindParam(':ucontent',$usercontent);
          
            $stmt->bindParam(':upic',$userpic);

            if($stmt->execute())
            {
                $successMSG = "chat successfully send ...";
               
            }
            else
            {
                $errMSG = "error while sending chat....";
            }
        }
    }
     if(isset($_GET['admin_id'])&& !empty($_GET['admin_id']))
  {
   $id = $_GET['admin_id'];
        $stmt_admin = $DB_con->prepare('SELECT loginType FROM tbl_users WHERE userID =:uid');
        $stmt_admin->execute(array(':uid'=>$id));
        $admin_row = $stmt_admin->fetch(PDO::FETCH_ASSOC);
        extract($admin_row);
$userLogin = "admin";// user login type
            if(!isset($errMSG))
            {
            $stmt = $DB_con->prepare('UPDATE tbl_users SET loginType=:ulogtype WHERE userID=:uid');
            $stmt->bindParam(':ulogtype',$userLogin);
            $stmt->bindParam(':uid',$id);

            if($stmt->execute()){
                ?>
                <script>
                alert('Successfully made admin ...');
                window.location.href='adhome.php';
                </script>
                <?php
            }
            else{
                $errMSG = "Sorry, could not provide admin priviledges!";
            }

        }
    
  }
  
  if(isset($_GET['removeadmin_id'])&& !empty($_GET['removeadmin_id']))
  {
   $id = $_GET['removeadmin_id'];
        $stmt_admin = $DB_con->prepare('SELECT loginType FROM tbl_users WHERE userID =:uid');
        $stmt_admin->execute(array(':uid'=>$id));
        $admin_row = $stmt_admin->fetch(PDO::FETCH_ASSOC);
        extract($admin_row);
$userLogin = "worker";// user login type
            if(!isset($errMSG))
            {
            $stmt = $DB_con->prepare('UPDATE tbl_users SET loginType=:ulogtype WHERE userID=:uid');
            $stmt->bindParam(':ulogtype',$userLogin);
            $stmt->bindParam(':uid',$id);

            if($stmt->execute()){
                ?>
                <script>
                alert('Successfully made user ...');
                window.location.href='adhome.php';
                </script>
                <?php
            }
            else{
                $errMSG = "Sorry, could demote admin priviledges!";
            }

        }
    
  }
  if(isset($_GET['delete_id']))
  {
   
 // it will delete an actual record from db
    $stmt_delete = $DB_con->prepare('DELETE FROM tbl_users WHERE userID =:uid');
    $stmt_delete->bindParam(':uid',$_GET['delete_id']);
    $stmt_delete->execute();

    header("Location: adhome.php");
  }
  //number of users
$users=0;
$sql="SELECT * FROM tbl_users";
$resultusers=mysqli_query($mysqli, $sql);
$users=mysqli_num_rows($resultusers);
?>
<!--new-->
<style type="text/css">

#clock{
    background-color:#333;
    font-family: sans-serif;
    font-size:50px;
    text-shadow:0px 0px 1px #fff;
    color:#fff;
}

</style>

<!DOCTYPE HTML>
<html>
<head>
<title>Janja | Admin</title>
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


<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />

<!--chat-->
<link rel="stylesheet" type="text/css" href="js/jScrollPane/jScrollPane.css" />
<link rel="stylesheet" type="text/css" href="css/page.css" />
<link rel="stylesheet" type="text/css" href="css/chat.css" />

<script src="js/jScrollPane/jquery.mousewheel.js"></script>
<script src="js/jScrollPane/jScrollPane.min.js"></script>
<!--chat-->
<script>
 new WOW().init();
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
<body onload="startTime()">
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
                    <a href="adhome.php"><i class="fa fa-user"></i><span>&nbsp; <strong><?php echo "Back to Admin ".$row['userName']; ?></strong></span>
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

   <div class="row" style="padding-top: 100px">
       <div class="panel-body" style="margin-right: 10px;">
        <div class="col-md-3" id="leftCol">
           <div class="row" style="margin-left: -9px;">     
        <div class="well" style="position: fixed; width:24%"> 
             <?php
$date_array = getdate();
$formated_date;
$formated_date .= $date_array[mday] . "/";
$formated_date .= $date_array[mon] . "/";
$formated_date .= $date_array[year];


//$d=date("D");
switch ($d)
{
case "Mon":
echo " Monday ". $formated_date;
break;
case "Tue":
echo " Tuesday ". $formated_date;
break;
case "Wed":
echo " Wednesday ". $formated_date;
break;
case "Thu":
echo " Thursday ".$formated_date;
break;
case "Fri":
echo " Friday ".$formated_date;
break;
case "Sat":
echo " Saturday ".$formated_date;
break;
case "Sun":
echo " Sunday ".$formated_date;
break;
default:
//echo "Wonder which day is this ?";
}
?>     
 <div id="clockdate">
  <div class="clockdate-wrapper">
    <div id="clock"></div>
    <div id="date"></div>
  </div>
</div>
               
          </div>
          </div>
          <div class="row" style="margin-top: 225px;margin-left: -9px;">     
        <div class="well" style="position: fixed; width:24%"> 
              <ul class="nav nav-stacked" id="sidebar">
                  <li><a href="#sec1">Chat xxxxxx xxxxxx xxxxxx </a></li>
                  <li><a href="#sec2">Section 2 Section 2 </a></li>
                  <li><a href="#sec3">Section 3  Section 3 </a></li>
                  <li><a href="#sec4">Section 4  Section 4 </a></li>
                </ul>  
          </div>
          </div>
          </div>  
          <div class="col-md-6">
          <div class="row">
          <div class="well" style="position: relative;"> 
           



<div id="chatContainer">

    <div id="chatTopBar" class="rounded"></div>
    <div id="chatLineHolder"></div>
    
    <div id="chatUsers" class="rounded"></div>
    <div id="chatBottomBar" class="rounded">
      <div class="tip"></div>
        
        <form id="loginForm" method="post" action="">
            <input id="name" name="name" class="rounded" maxlength="16" />
            <input id="email" name="email" class="rounded" />
            <input type="submit" class="blueButton" value="Login" />
        </form>
        
        <form id="submitForm" method="post" action="">
            <input id="chatText" name="chatText" class="rounded" maxlength="255" />
            <input type="submit" class="blueButton" value="Submit" />
        </form>
        
    </div>
    
</div>



                <h2 id="sec2">Section 2</h2>
        
                <h2 id="sec3">Section 3</h2>
      

                <h2 id="sec4">Section 4</h2>
             

          </div> 
          </div>
          </div>
          <div class="col-md-3" id="rightCol">
             <div class="row" style="margin-left: -10px;">   
        <div class="well" style="position: fixed;width: 25%;"> 
 <?php
 $_SESSION['onlineSession']=$_GET['more_id'];
   
    $stmt = $DB_con->prepare("SELECT * FROM tbl_users WHERE userID=:uid");
    $stmt->execute(array(":uid"=>$_SESSION['onlineSession']));

    
    if($stmt->rowCount() > 0)
    {
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            ?>
            <?php
             $_SESSION['loginSession']=$row['user_login'];
    $stmt1 = $DB_con->prepare("SELECT * FROM tbl_login WHERE id=:uidd");
    $stmt1->execute(array(":uidd"=>$_SESSION['loginSession']));
    $roww = $stmt1->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="row">
              <?php
              echo $row['userName'];
              ?>
            </div>
              <div class="row">
                      <div class="desc">
                      <div class="details">
       <p><a href="mail.php">
    
      </a><br/> </p>
      <div class="row">
      <div class="col-md-6">
      <con style="color: green;">Login Time</con>
      <span class="message"><?php echo $roww['loginTime']?></span>
        </div>
       <div class="col-md-6">
      <con style="color: green;">Logout Time</con>
      <span class="message"><?php echo $roww['logoutTime']?></span>
        </div>
       </div>
       </div>
      </div>
      </div><hr/>
            <?php
        }
    }
 ?>
          </div>

               </div>
              
          </div>  
    </div>
   </div>
 
   




     
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


</div>
</body>
</html>


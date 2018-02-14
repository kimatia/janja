
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


</script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="postscriptt.js"></script>
  <script>
  var timer=10;
  var view="";
  $(function (){
    function onTime(){
      setTimeout(onTime, 1000);
 
      if(timer==10){
       //alert("at 8")
  
       $.post("chat.php",{viewing:view},function(data){
        $(".realTimeChat h5").html(data);
       })
       timer=11;
       clearTimeout(onTime); 
      }
      timer--;
    }

    onTime(); 
  });
</script>

<script>
  var timeruser=10;
  var user="";
  $(function (){
    function inTime(){
      setTimeout(inTime, 1000);
 
      if(timeruser==10){
  
       $.post("userFetch.php",{userload:user},function(data){
        $(".userfetch h5").html(data);
       })
       timeruser=11;
       clearTimeout(inTime); 
      }
      timeruser--;
    }

    inTime(); 
  });

</script>
<script>
  var timerpic=10;
  var pic="";
  $(function (){
    function picTime(){
      setTimeout(picTime, 1000);
 
      if(timerpic==10){
  
       $.post("picFetch.php",{picload:pic},function(data){
        $(".picFetch h5").html(data);
       })
       timerpic=11;
       clearTimeout(picTime); 
      }
      timerpic--;
    }

    picTime(); 
  });

</script>
<script>
  var timerpic=10;
  var pic="";
  $(function (){
    function picTime(){
      setTimeout(picTime, 1000);
 
      if(timerpic==10){
  
       $.post("picFetch.php",{picload:pic},function(data){
        $(".picFetch h5").html(data);
       })
       timerpic=11;
       clearTimeout(picTime); 
      }
      timerpic--;
    }

    picTime(); 
  });

</script>
<!-- Script -->
     
<?php
date_default_timezone_set("Africa/Nairobi");
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
 if (isset($_GET['likechat_id'])){
    //like

$idd = $_GET['likechat_id'];
$like_id = $DB_con->prepare('SELECT * FROM tbl_chat WHERE id =:uid');
        $like_id->execute(array(':uid'=>$idd));
        $like_row = $like_id->fetch(PDO::FETCH_ASSOC);
        extract($like_row);

$likeID=$like_row['id'];
  $userID = $row['userID'];
  $_SESSION['userID']=$userID;
  $type=0;

$stmt = $DB_con->prepare('INSERT INTO tbl_like(likeID,userID,likeType,likeTime) VALUES(:likeID,:userID,:likeType,now())');
            $stmt->bindParam(':likeID',$likeID);
            $stmt->bindParam(':userID',$_SESSION['userID']);
            $stmt->bindParam(':likeType',$type);
            $stmt->execute();
  

  

  }
  //like

  

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
            $stmt = $DB_con->prepare('INSERT INTO tbl_chat(chatUser,chatValue,chatPic,chatTime) VALUES(:uname, :ucontent, :upic,now())');
            $stmt->bindParam(':uname',$username);
            $stmt->bindParam(':ucontent',$usercontent);
          
            $stmt->bindParam(':upic',$userpic);

         
          $stmt->execute();
            
      
        $chat = $mysqli->query("SELECT * FROM tbl_chat ORDER BY id DESC limit 1");
            $roww = $chat->fetch_assoc();
            $chatid=$roww['id'];
            $_SESSION['chatid']=$chatid;
            $stmt1 = $DB_con->prepare('INSERT INTO tbl_like(likeID,likeUser,likeTime) VALUES(:uid, :ulike, now())');
            $stmt1->bindParam(':uid',$_SESSION['chatid']);
            $stmt1->bindParam(':ulike',$_SESSION['name']);
            $stmt1->execute();
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
                
            }
            else{
                $errMSG = "Sorry, could demote admin priviledges!";
            }

        }
    
  }
  //delete users
  if(isset($_GET['delete_id']))
  {
   
 // it will delete an actual record from db
    $stmt_delete = $DB_con->prepare('DELETE FROM tbl_users WHERE userID =:uid');
    $stmt_delete->bindParam(':uid',$_GET['delete_id']);
    $stmt_delete->execute();

    header("Location: adhome.php");
  }
  //delete chat
    if(isset($_GET['deletee_id']))
  {
   
 // it will delete an actual record from db
    $stmt_delete = $DB_con->prepare('DELETE FROM tbl_chat WHERE id =:uid');
    $stmt_delete->bindParam(':uid',$_GET['deletee_id']);
    $stmt_delete->execute();

    header("Location: adhome.php");
  }

   if(isset($_GET['deletechat_id']))
  {
   
 // it will delete an actual record from db
    $stmt_delete = $DB_con->prepare('DELETE FROM tbl_chat WHERE id =:uid');
    $stmt_delete->bindParam(':uid',$_GET['deletechat_id']);
    $stmt_delete->execute();

    header("Location: adhome.php");
  }
  //number of users
$users=0;
$sql="SELECT * FROM tbl_users";
$resultusers=mysqli_query($mysqli, $sql);
$users=mysqli_num_rows($resultusers);

if(isset($_POST['btncomment']))
    {
 $name = $row['userName'];
        $_SESSION['name'] = $name;
        $username = $_SESSION['name'];// user email
        $usercomment = $_POST['user_comment'];// user content
        
        $commentid=$row['chat_id'];
         $_SESSION['cid'] = $commentid;
        $cid = $_SESSION['cid'];

            $stmt = $DB_con->prepare('INSERT INTO comment(comment_id,comment_person_name,comment_value,comment_time) VALUES(:cid,:uname, :ucomment,now())');
            $stmt->bindParam(':uname',$username);
            $stmt->bindParam(':cid',$cid);
            $stmt->bindParam(':ucomment',$usercomment);
          
           
            if($stmt->execute())
            {
                $successMSG = "comment successfully send ...";
               
            }
            else
            {
                $errMSG = "error while sending comment....";
            }
        
    }
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Janja | Admin</title>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

     <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Begin emoji-picker Stylesheets -->
    <link href="lib/css/emoji.css" rel="stylesheet">
    <!-- End emoji-picker Stylesheets -->
    <!-- Custom Fonts -->
<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="css/style3.css" />
    <script src="bower_components/modernizr/modernizr.js"></script>
     <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/foundation/js/foundation.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/reveal.js"></script>
<script src="js/angular.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!--chat-->
<link rel="stylesheet" type="text/css" href="js/jScrollPane/jScrollPane.css" />
<link rel="stylesheet" type="text/css" href="css/page.css" />
<link rel="stylesheet" type="text/css" href="css/chat.css" />

<script src="js/jScrollPane/jquery.mousewheel.js"></script>
<script src="js/jScrollPane/jScrollPane.min.js"></script>


</head>
<body onload="startTime()" ng-app='myapp'>

<header>
 <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Janja</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
             
                <li class="dropdown get_tooltip" data-toggle="tooltip" data-placement="bottom" title="logout">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?php echo "Admin ". $row['userName'];?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"> Logout</i></a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
            </ul>
            <!-- /.navbar-top-links -->
        </nav>
</header>

   <div class="row" style="padding-top: 40px">
       <div class="panel-body" style="margin-right: 10px;">
        <div class="col-md-3" id="leftCol">
           <div class="row" style="margin-left: -9px;">     
        <div class="well" style="position: fixed; width:24%"> 
    
 
<div class="row">
<div class="col-md-3">
<div class="picFetch"><h5>Loading Your Image...</h5></div>

<br/>
<br/>
<dl class="accordion text-center">
 <dd>
    <a href="dashboard.php?page=pic" style="background:#3EB05B;"  title="Profile Picture">
  <i class="fa fa-user sancolor-white"></i></a>
  </dd>
  <dd>
    <a href="dashboard.php?page=info" style="background:#F7990D"  title="info"><i class="fa fa-info-circle sancolor-white"></i></a>
  </dd>
  
  <dd>
    <a href="dashboard.php?page=password" style="background:#E94B3B"  title="Change Password"><i class="fa fa-lock sancolor-white"></i></a>
  </dd>
  
  <dd>
    <a href="dashboard.php?page=profile"  style="background:#0099D3;"  title="profile"><i class="fa icon-cog sancolor-white"></i></a>
  </dd>
  <dd>
    <a href="usermore.php?page=records"  style="background:#800080;"  title="country"><i class="fa icon-flag sancolor-white"></i></a>
  </dd>
</dl>
<br/>
</div>
<div class="col-md-9">
<ul class="nav nav-stacked" id="sidebar">
    <li><a href="adhome.php?page=chat">Chat logs</a></li>    
    <li><a href="clearing/adhome.php">Clearing </a></li>
      <li><a href="booking/booking.php">Booking</a></li>
      <li><a href="#sec4">Reservation </a></li>
       <li><a href="#sec4">Transportation </a></li>
        <li><a href="#sec4">Agriculture </a></li>
         <li><a href="#sec4">Hospitality </a></li>
         <li><a href="ajaxget.php">Point of Sales </a></li> 
         <li><a href="ajaxget.php">Sports</a></li> 
                </ul>
</div>
</div>
             
          </div>
          </div>
          </div>  
          <div class="col-md-6">
          <div class="row">

          
          <div class="well" style="position: relative;"> 
             
         <span id="message"></span> 
<form method="post" id="uploadimage"  enctype="multipart/form-data" class="form-horizontal">
      
         <p class="lead emoji-picker-container">
           <textarea class="form-control" type="text" name="user_content" id="user_content" data-emojiable="true" placeholder="Enter chat action" value="<?php echo $usercontent; ?>"></textarea>
         </p>

        
        <div class="row">
<div class="col-md-6">
        <input  type="file" name="file" class="btn btn-default" accept="image/*" />
        </div>
        <div class="col-md-2">
        <button type="submit" name="btnsave" value="send" class="btn btn-default" onclick="javascript:PlaySound('sounds/sound_3.mp3');">
        <span class="glyphicon glyphicon-save"></span>save chat
        </button>


       


        </div>
</div>       
</form>    
    
<div class="row">
 
    <?php
    $page=@$_REQUEST['page'];
    
    switch($page){
    
    case($page=='chat'):
    include('chat.php');
    break; 
     case($page=='clearing'):
     echo "<script>window.location.assign('clearing/adhome.php')</script>";
    break;
    case($page=='country'):
    include('janja/country.php');
    break;
    case($page=='records'):
    include('records.php');
    break;
    case($page=='booking'):
    include('booking/booking.php');
    break;
    
    case($page=='info'):
    include('janja/info.php');
    break;
    
    case($page=='profile'):
    include('janja/profile.php');
    break;
    
    default:
    include('janja/main.php');
    break;  
      
      
    }
    
    ?>



</div>


               
             

          </div> 
          </div>
          </div>
          <div class="col-md-3" id="rightCol">
             <div class="row" style="margin-left: -10px;">   
        <div class="well" style="position: fixed;width: 25%;"> 
    <div class="panel panel-default">
    <div class="panel-body" style="overflow-y: scroll;max-height: 470px;">
                                         
<div class="userfetch"><h5>Loading users...</h5></div>
</div>
 </div>
                       </div>
          </div>  

               </div>
              
          </div>  
    </div>
   </div>
 
   

<!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>



    <script src="js/jquery.js"></script>

    <!-- Begin emoji-picker JavaScript -->
    <script src="js/config.js"></script>
    <script src="js/util.js"></script>
    <script src="js/jquery.emojiarea.js"></script>
    <script src="js/emoji-picker.js"></script>
    <!-- End emoji-picker JavaScript -->

    <script>
      $(function() {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: 'lib/img/',
          popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
      });
    </script>
    <script>
      // Google Analytics
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-49610253-3', 'auto');
      ga('send', 'pageview');
    </script>

<script type="text/javascript">

function PlaySound(path) {
  var audioElement = document.createElement('audio');
  audioElement.setAttribute('src', path);
  audioElement.play();
}

</script>
    
</body>
</html>


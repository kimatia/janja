<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="postscripttt.js"></script>


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
$sid=$row['userID'];
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

if(isset($_POST['btnsavee']))
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

$idd=$_GET['more_id'];



          $_SESSION['sendTo']=$_GET['more_id'];
   
    $stmtto = $DB_con->prepare("SELECT * FROM tbl_users WHERE userID=:uid");
    $stmtto->execute(array(":uid"=>$_SESSION['sendTo']));
    if($stmtto->rowCount() > 0)
    {
        while($rowto=$stmtto->fetch(PDO::FETCH_ASSOC))
        {
            extract($rowto);
            $sendTo=$rowto['userName'];
            $_SESSION['sendTo']=$sendTo;
          }

          }
           
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
<title>Janja | About</title>
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

<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!--chat-->
<link rel="stylesheet" type="text/css" href="js/jScrollPane/jScrollPane.css" />
<link rel="stylesheet" type="text/css" href="css/page.css" />
<link rel="stylesheet" type="text/css" href="css/chat.css" />

<script src="js/jScrollPane/jquery.mousewheel.js"></script>
<script src="js/jScrollPane/jScrollPane.min.js"></script>

</head>
<body onload="startTime()" style="background-color: black;">

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



    <div class="row">
<div class="col-md-3">
<img src="upload/<?php echo $row['userPic']; ?>" width="64" height="84" class="round-img" alt="User Image"/>
<br/>
<br/>
<dl class="accordion text-center">
 <dd>
    <a href="dashboard.php?page=pic" style="background:#3EB05B;"  title="Dashboard Home">
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
    <li><a href="#sec4">Point of Sales </a></li>
      <li><a href="#sec4">Booking </a></li>
      <li><a href="#sec4">Reservation </a></li>
       <li><a href="#sec4">Transportation </a></li>
                </ul>
</div>
</div>
             
          </div>
          </div>
          </div>  
          <div class="col-md-6">
          <div class="row">
          <div class="well" style="position: relative;"> 
           

 <h2 id="sec1"></h2>
            </br></br>

             <?php
    if(isset($errMSG)){
            ?>
            <div class="alert alert-danger">
                <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
    }
    else if(isset($successMSG)){
        ?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
    }
    ?>
    <?php
    $page=@$_REQUEST['page'];
    
    switch($page){
    
    case($page=='chat'):
    include('janja/chat.php');
    break; 
    
    case($page=='country'):
    include('janja/country.php');
    break;
    case($page=='records'):
    include('records.php');
    break;
    case($page=='logout'):
    include('janja/logout.php');
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
            <div class="col-md-3" id="rightCol">
             <div class="row" style="margin-left: -10px;">   
        <div class="well" style="position: fixed;width: 25%;"> 
    <div class="panel panel-default">
   <div class="panel-body" style="overflow-y: scroll;max-height: 500px;">
      
        <?php

          $_SESSION['userSessionMore']=$_GET['more_id'];
   
    $stmt = $DB_con->prepare("SELECT * FROM tbl_users WHERE userID=:uid");
    $stmt->execute(array(":uid"=>$_SESSION['userSessionMore']));
    if($stmt->rowCount() > 0)
    {
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            ?>
            <?php
            $dee= $row['userName']; 
             $_SESSION['moreLogin']=$dee;
   
    $stmtLogin = $DB_con->prepare("SELECT * FROM tbl_login WHERE userName=:uid ORDER BY id DESC LIMIT 1");
    $stmtLogin->execute(array(":uid"=>$_SESSION['moreLogin']));
     $login_row = $stmtLogin->fetch(PDO::FETCH_ASSOC);
        extract($login_row);
      
            ?>
            <div class="row">
                  <div class="panel-body">
                      <div class="desc">
                  <?php  
if($row['user_status'] == 1 ){

    echo "<h3><center><strong><font color='#009900'>".$row['userName']." (Online)"."</font><strong></center></h3><br>";
 
 }else 
  echo "<h3><center><strong><font color='#FF0000'>".$row['userName']." (Offline)"."</font><strong></center></h3><br>";
 ?>
    <img src="upload/<?php echo $row['userPic']; ?>" width="150" height="120" class="round-img" alt="User Image"/>

            </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6">
              
                  <div class="panel-body">
<h6 style="color: purple;"><center><strong>Login Time</strong></center></h6></br>
<p><?php echo $login_row['loginTime']; ?></p></br><hr>
<h6 style="color: purple;"><center><strong>Logout Time</strong></center></h6></br>
<p><?php echo $login_row['logoutTime']; ?></p>
                  </div>
                  </div>
             
              <div class="col-md-6">
              
                  <div class="panel-body">
<h6 style="color: purple;"><center><strong>Login IP</strong></center></h6></br>
<p><?php echo $login_row['loginUserIp']; ?></p></br><hr>
<h6 style="color: purple;"><center><strong>Logout IP</strong></center></h6></br>
<p><?php echo $login_row['logoutUserIP']; ?></p>
                  </div>
                 
              </div>
            </div>
             </div>
            <?php
        }
    }
 
       ?>                                 
</div>
 </div>
                       </div>
          </div>

               </div>
              
          </div> 
           
    </div>
   </div>
 
   




     
    
</body>
</html>


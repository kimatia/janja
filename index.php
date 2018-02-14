<?php

require_once 'dbconfig.php';
require_once 'class.user.php';
session_start();
ini_set('display_errors', 1);
$user_login = new USER();
if($user_login->is_logged_in()!="")
{
  $stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if($row['loginType']=="admin"){
   
    $user_login->redirect('adhome.php');
  }else if($row['loginType']=="worker"){
    $user_login->redirect('home.php');
  }
}

if(isset($_POST['btn-login']))
{
 $email = trim($_POST['txtemail']);
 $upass = trim($_POST['txtupass']);

 if($user_login->login($email,$upass))
 {
  #$user_login->redirect('home.php');
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

<head>
<title>Janja | Login</title>
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

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!--for the sake of corousel-->
<link rel="stylesheet" href="plugins/Font-Awesome/css/font-awesome.css" />
<link href="dist/css/sb-admin-2.css" rel="stylesheet">
<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="lib/animate-css/animate.min.css" rel="stylesheet">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />

</head>
<body style="background-image: url(images/legal.png); " >

<header>
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
              <li>
                <a href="signup.php"><span class="fa icon-pencil"></span>&nbsp;Signup</a>
              </li>
                
                
            </ul>
            <!-- /.navbar-top-links -->
        </nav>
</header>


<div class="row" style="padding-top: 130px">
<div class="col-md-5 col-md-offset-3">
<div id="slider">
    <div id="slide-wrapper" class="rounded clear">
    <div class="panel panel-default">

            <div class="panel-heading">
                <center><strong>LOGIN</strong></center>
               <?php
                                    if(isset($_GET['error']))
                              {
                               ?>
                                <div class='alert alert-danger'>
                                <button class='close' data-dismiss='alert'>&times;</button>
                                <strong>Incorect Email or Password.</strong>
                               </div>
                              <?php
                              }
                              if(isset($_SESSION['offline'])){
                                echo $_SESSION['offline'];
                              }
                              ?>
            </div>
            <div class="panel-body" style="background-color: purple;">
        <form class="form-signin" method="post" id="register-form" >
        <div class="form-group input-group">
        <span class="input-group-addon">Email Add</span>
        <input type="email" class="form-control" placeholder="Email address" name="txtemail" />

        </div>

        <div class="form-group input-group">
        <span class="input-group-addon">Password.</span>
        <input type="password" class="form-control" placeholder="Password" name="txtupass" />
        </div>

        <hr />

        <div class="form-group">
            <button type="submit" class="btn btn-lg btn-success btn-block" name="btn-login" id="btn-login">
            <span class="glyphicon glyphicon-log-in"></span> &nbsp;Login
            </button>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>



      </form>
 </div>
            <div class="panel-footer">

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
            </div>
        </div>
    </div>
</div>
</div>
</div>

     
</body>
</html>


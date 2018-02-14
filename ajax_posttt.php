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

   $chattime=date("h:i A.",time());
  $name = $row['userName'];
  $_SESSION['name'] = $name;//name
  $usernamefrom = $_SESSION['name'];// user name
  $usernameto = $_POST['sendTo'];// user content;
  $message = $_POST['user_content'];// user content
  $idd = $_POST['mid'];// user content
   $sid = $_POST['sid'];// user con
 

   


         // if no error occured, continue ....
        if(!isset($errMSG))
        {
            $stmtttt = $DB_con->prepare('INSERT INTO tbl_messages(mid,sid,chatFrom,chatTo,message, chatTime) VALUES(:mid,:sid,:cfrom,:cto,:mess,:timee)');
            
            $stmtttt->bindParam(':mid',$idd);
             $stmtttt->bindParam(':sid',$sid);
             $stmtttt->bindParam(':cfrom',$usernamefrom);
             $stmtttt->bindParam(':cto',$usernameto);
             $stmtttt->bindParam(':mess',$message);
             $stmtttt->bindParam(':timee',$chattime);
           

            if($stmtttt->execute()){
                echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.send</div>";
            }
            else{
              echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Profile could not be updated
           </div>";
            }

       }



?>

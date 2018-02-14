<?php
date_default_timezone_set("Africa/Nairobi");
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../dbconfig.php'; 
//get the logged in user credentials and validate
require_once '../class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('login.php');
}
$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//we can now access the users details from $row['appropriatedbfield']
  $chattime=date("h:i A.",time());
  $name = $row['userName'];
  $_SESSION['name'] = $name;//name
  $usernamefrom = $_SESSION['name'];// user name
  $usernameto = "to";
  $message = $_POST['user_content'];// user content
  $idd = $_POST['mid'];// user conten
 

   


          $id = $row['userID'];
            $stmt = $DB_con->prepare('INSERT INTO tbl_messages(mid,chatFrom,chatTo,message, chatTime) VALUES(:mid,:cfrom,:cto,:mess,:timee)');
            
            $stmt->bindParam(':mid',$idd);
             $stmt->bindParam(':cfrom',$usernamefrom);
             $stmt->bindParam(':cto',$usernameto);
             $stmt->bindParam(':mess',$message);
              $stmt->bindParam(':timee',$chattime);
           

            if($stmt->execute()){
                echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.Profile updated</div>";
            }
            else{
              echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Profile could not be updated
           </div>";
            }

       



?>

<?php
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

     if($stmt->execute()){
                echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.Liked</div>";
            }
            else{
              echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Could not like
           </div>";
            }
  }
 



?>

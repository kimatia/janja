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
$stmtt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmtt->execute(array(":uid"=>$_SESSION['userSession']));
$roww = $stmtt->fetch(PDO::FETCH_ASSOC);
//we can now access the users details from $row['appropriatedbfield']

$stmttre = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmttre->execute(array(":uid"=>$_SESSION['userSessionMore']));
$rowwre = $stmttre->fetch(PDO::FETCH_ASSOC);
//we can now access the users details from $row['appropriatedbfield']



//under Get
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

          //select user messages based on GET


           $postid=$_SESSION['userSessionMore'];
          $userid=$roww['userID'];

    $stmt = $DB_con->prepare( "SELECT * FROM tbl_messages  WHERE sid=".$userid." and mid=".$postid."");
    $stmt->execute();


    //select based on reply
    $useridd=$_SESSION['userSessionMore'];
    $postidd=$roww['userID'];

    $stmttt = $DB_con->prepare( "SELECT * FROM tbl_messages WHERE sid= ".$useridd." and mid=".$postidd."" );
    $stmttt->execute();


    if($stmt->rowCount() > 0)
    {
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
        
            ?>

 <div class="chat chat-rounded">
<span class="author"><?php echo $row['chatFrom'];?>:</span>
<span class="text"><?php echo $row['message'];?></span>
<span class="time"><?php echo $row['chatTime'];?></span>
</div>
<!--reply-->
            <?php
        }
    }

     if($stmttt->rowCount() > 0)
    {
        while($rowtt=$stmttt->fetch(PDO::FETCH_ASSOC))
        {
            extract($rowtt);
        
            ?>



 <div class="chat chat-rounded">
<span class="author"><?php echo $rowtt['chatFrom'];?>:</span>
<span class="text"><?php echo $rowtt['message'];?></span>
<span class="time"><?php echo $rowtt['chatTime'];?></span>
</div>

            <?php
        }
    }

?>
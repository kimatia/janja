



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

   extract($_POST);
   if($old_password!="" && $password!="" && $confirm_pwd!="") :
    $user_id = $row['userID'];
    $old_pwd=md5(mysqli_real_escape_string($mysqli,$_POST['old_password']));
    $pwd=md5(mysqli_real_escape_string($mysqli,$_POST['password']));
    $c_pwd=md5(mysqli_real_escape_string($mysqli,$_POST['confirm_pwd']));
    if($pwd == $c_pwd) :
       if($pwd!=$old_pwd) :
         $db_check=$mysqli->query("SELECT * FROM `tbl_users` WHERE `userID`='$user_id' AND `userPass` ='$old_pwd'");
         $count=mysqli_num_rows($db_check);
         if($count==1) :
             $fetch=$mysqli->query("UPDATE `tbl_users` SET `userPass` = '$pwd' WHERE `userID`='$user_id'");
             $old_password=''; $password =''; $confirm_pwd = '';
             echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.Password updated</div>";
          else:
             echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>The password you gave is incorrect.
           </div>";
           
          endif;
        else :
           echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Old password new password same Please try again.
           </div>";
         
        endif;
    else:
       echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>New password and confirm password do not matched
           </div>";
     
    endif;
   else :
     echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Please fill all the fields
           </div>";
    
   endif;   

?>
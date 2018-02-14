<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./postscript4.js"></script>
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

 
 if(isset($_POST['submit'])):
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
             $successMSG = "Your new password update successfully.";
          else:
            $errMSG = "The password you gave is incorrect.";
          endif;
        else :
          $errMSG = "Old password new password same Please try again.";
        endif;
    else:
      $errMSG = "New password and confirm password do not matched";
    endif;
   else :
     $errMSG = "Please fill all the fields";
   endif;   
 endif;
?>
	<div class="row">
       <span id="message4"></span>    
    <div id="slider">
    <div id="slide-wrapper" class="rounded clear">
                          <!--research -->
                        
                            <div class="panel-body" style="background-color: purple;"">
     
     
         <form method="post" autocomplete="off" id="uploadimage">
          <div class="modal-body with-padding">
         
           
             <div class="form-group ">
            
                 <span class="form-control"><strong>Name:&nbsp&nbsp&nbsp&nbsp<?php echo $row['userName']; ?></strong></span>
                 
             </div>  
              <div class="form-group ">

                 <span class="form-control"><strong>Email:&nbsp&nbsp&nbsp&nbsp<?php echo $row['userEmail']; ?></strong></span>
                
             </div>  
           <div class="form-group input-group">

                 <span class="input-group-addon"><strong>Old Password.</strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
                 <input class="form-control" type="password" name="old_password" placeholder="Password">
             </div>                            
           <div class="form-group input-group">

                 <span class="input-group-addon"><strong>New Password.</strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
                 <input class="form-control" type="password" name="password" placeholder="Password">
             </div>
           <div class="form-group input-group">

                 <span class="input-group-addon"><strong>Confirm Password.</strong></span>
                 <input class="form-control" type="password" name="confirm_pwd" placeholder="Password">
             </div>      
          </div>
          
          <!-- end Add popup  -->  
          <div class="modal-footer">          
            <input type="submit" id="btn-pwd" name="btnsave" value="Submit" class="btn btn-primary">            
          </div>
        </form> 
                            </div>
                       
                        <!--to be reserched-->

        </div>
     </div>
     </div>
    
<!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

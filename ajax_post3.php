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


    
        
        $username = $_POST['user_name'];// user name
         $usercity = $_POST['user_city'];// user city
         $usercountry = $_POST['user_country'];// user country
         $useremail = $_POST['user_email'];// user email
         

        // if no error occured, continue ....
        if(!isset($errMSG))
        {

        	$id = $row['userID'];
            $stmt = $DB_con->prepare('UPDATE tbl_users SET  userName=:uname,userCity=:ucity, userCountry=:ucountry, userEmail=:uemail WHERE userID=:uid');
            
            $stmt->bindParam(':uname',$username);
             $stmt->bindParam(':ucity',$usercity);
             $stmt->bindParam(':ucountry',$usercountry);
             $stmt->bindParam(':uemail',$useremail);
           
            $stmt->bindParam(':uid',$id);

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

        }


    
?>
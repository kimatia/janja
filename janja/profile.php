<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./postscript3.js"></script>

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


    if(isset($_POST['btn_save_updates']))
    {
        
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
                ?>
                <script>
                alert('Profile successfully Updated ...');
                window.location.href='dashboard.php?page=profile';
                </script>
                <?php
            }
            else{
                $errMSG = "Sorry, profile Could Not Updated !";
            }

        }


    }
?>

<div class="row" style="background-color: cream">
  <h3 style="color: purple;">Profile Update</h3>
  
 <table class="table table-bordered table-responsive">

 <span id="message2"></span> 
  <form method="post" id="uploadimage" enctype="multipart/form-data" class="form-horizontal">

    <div class="row">
         <div class="col-md-12">
          <label class="control-label">Name.</label>
        <input class="form-control" type="text" name="user_name" id="name" placeholder="Enter name" value="<?php echo $row['userName']; ?>"/>
			
		 </div>
	</div>	
	<div class="row"> 
		 <div class="col-md-6">
			<label class="control-label">City.</label>
        <input class="form-control" type="text" name="user_city" id="city" placeholder="Enter your city" value="<?php echo $row['userCity']; ?>"/>
		 </div>
		 <div class="col-md-6">
			<label class="control-label">Country.</label>
        <input class="form-control" type="text" name="user_country" id="country" placeholder="Enter your country" value="<?php echo $row['userCountry']; ?>"/>
		 </div>
    </div>
    <div class="row">
		<div class="col-md-12">
		<label class="control-label">Email.</label>
        <input class="form-control" type="text" name="user_email" id="email" placeholder="Enter new email" value="<?php echo $row['userEmail']; ?>"/>
		
        </div>
    </div>
    </br>
    <div class="row">

		<label class="control-label">Update profile.</label>
         <button type="submit" name="btnsave" class="btn btn-success">
        <span class="glyphicon glyphicon-save"></span> &nbsp; Update profile
        </button>
    </div>
    
  </form>      
 </table>
 
</div>
 
<!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

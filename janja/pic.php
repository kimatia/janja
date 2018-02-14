

 <script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./postscript2.js"></script>
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


        $id = $row['userID'];
		$stmt_edit = $DB_con->prepare('SELECT userPic FROM tbl_users WHERE userID =:uidd');
		$stmt_edit->execute(array(':uidd'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);

	if(isset($_POST['btn_save_updates']))
	{
	
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];

		if($imgFile)
		{
			$upload_dir = 'upload/'; // upload directory
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			$userpic = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{
				if($imgSize < 5000000)
				{
				
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else
				{
					$errMSG = "Sorry, your file is too large it should be less then 5MB";
				}
			}
			else
			{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			}
		}
		else
		{
			// if no image selected the old image remain as it is.
			$userpic = $edit_row['userPic']; // old image from database
		}


		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('UPDATE tbl_users SET  userPic=:upic  WHERE userID=:uid');
			
			$stmt->bindParam(':upic',$userpic);
			$stmt->bindParam(':uid',$id);

			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='dashboard.php?page=pic';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}

		}


	} 
	   
	         ?>
	           


<div class="row" style="background-color: cream">

<span id="message1"></span> 
<form method="post" id="uploadimage" enctype="multipart/form-data" class="form-horizontal">


	<table class="table table-bordered table-responsive">

    
    <tr>
    	<td><label class="control-label">Profile Img.</label></td>
        <td>
        	<p>
        	
        	<div class="userFetchEdit"><h5>Loading image to be edited...</h5></div>
        	</p>
        	<input class="input-group" type="file" name="user_image"  accept="image/*" />
        </td>
    </tr>

    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>

        <a class="btn btn-default" href="dashboard.php?page=pic"> <span class="glyphicon glyphicon-backward"></span> cancel </a>

        </td>
    </tr>

    </table>

</form>
</div>
<!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

 

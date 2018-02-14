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


        $name = $row['userName'];
        $_SESSION['name'] = $name;//name
        $username = $_SESSION['name'];// user email


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
         echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Edited</div>";
      }
      else{
      echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
      }

    }

  
 



?>

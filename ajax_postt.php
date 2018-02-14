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
//we can now access the users details from $row['appropriatedbfield']

        $name = $row['userName'];
        $_SESSION['name'] = $name;//name
        $username = $_SESSION['name'];// user email


  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG" );
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES["file"]['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES["file"]['name']; // Target path where file is to be stored

  $_SESSION['name'] = $name;//name
  $username = $_SESSION['name'];// user email
  $usercontent = $_POST['user_content'];// user content
  $chatFile=$_FILES["file"]["name"];
  $chattime=date("h:i A.",time());
  $SQL = $DBcon->prepare("INSERT INTO tbl_chat(chatUser,chatValue,chatPic, chatTime) VALUES(?,?,?,?)");

    if($SQL){
      $SQL->bind_param('ssss',$username,$usercontent, $chatFile,$chattime);
      $SQL->execute();

      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.Chat made.</div>";
sleep(1);
?>
<script type="text/javascript">
  function load(){
    $.ajax({
      success:function(){
         location.href="adhome.php";
        load();
      }
    });
  }
load();
</script>
<?php
//echo "<script>window.location.assign('adhome.php')</script>";

    }else{
      echo $con->error;
    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
 



?>

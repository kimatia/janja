<?php


session_start();
date_default_timezone_set("Africa/Nairobi");
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbconfig.php'; 


  
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


  

 
  $posttime=date("h:i A.",time());
  $roomprice = $_POST['room_price'];// room name
  $roomID = $_POST['room_code'];// room name
  $room_id = $_POST['room_id'];// room name
  $roomname = $_POST['room_name'];// room name
  $roomcapacity=$_POST['room_capacity'];//room capacity
  $imagefile=$_FILES["file"]["name"];

  $SQL = $DBcon->prepare("INSERT INTO tbl_hostelmore(IDD,roomID,roomName,roomCapacity,roomImages,roomPrice,postDate) VALUES(?,?,?,?,?,?,?)");

    if($SQL){
      $SQL->bind_param('iisssss',$room_id, $roomID,$roomname, $roomcapacity,  $imagefile,$roomprice,$posttime);
      $SQL->execute();

      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
             <strong>Success!</strong>.Image inserted......</div>";


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
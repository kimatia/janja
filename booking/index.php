
<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbconfig.php'; 
 
?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="postscript.js"></script>
<script>
  var timer=10;
  var view="";
  $(function (){
    function onTime(){
      setTimeout(onTime, 1000);
 
      if(timer==10){
       //alert("at 8")
  
       $.post("recordFetch.php",{viewing:view},function(data){
        $(".recordFetchh h5").html(data);
       })
       timer=11;
       clearTimeout(onTime); 
      }
      timer--;
    }

    onTime(); 
  });
</script>
<?php 

//delete
   if(isset($_GET['delete_id']))
  {


    // it will delete an actual record from db
    $stmt_delete = $DB_con->prepare('DELETE FROM tbl_hadullo WHERE id =:uid');
    $stmt_delete->bindParam(':uid',$_GET['delete_id']);
    $stmt_delete->execute();

   
  }
 
  

    //save record
if(isset($_POST['btnsavee'])){


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


  

  
  $usercontent = $_POST['user_content'];// user content
  $imageFile=$_FILES["file"]["name"];

  $SQL = $DBcon->prepare("INSERT INTO tbl_hadullo(textRecord,imageRecord,timeRecord) VALUES(?,?,now())");

    if($SQL){
      $SQL->bind_param('ss',$usercontent, $imageFile);
      $SQL->execute();

      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      //echo "<div class='alert alert-success'>
              //<button class='close' data-dismiss='alert'>&times;</button>
             // <strong>Success!</strong>.Record made.</div>";


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
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">



</head>

<body>

    

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Hadullo</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
              <li>
                      
                      
            </ul>
            <!-- /.navbar-top-links -->
        </nav>

    <br>
   

<div class="row">
<div class="col-md-4">
<div class="panel panel-default">
  <div class="panel-body" style="position: fixed;">
    <span id="message"></span> 
    <form method="post" id="uploadimage"  enctype="multipart/form-data" class="form-horizontal">
       
        <input class="form-control" type="text" name="user_content" id="user_content" placeholder="Enter record" />
       </br>
        <input  type="file" name="file" class="btn btn-default" accept="image/*" />
        </br>
        <button type="submit" name="btnsave" value="send" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span>save record
        </button>
           
</form> 
  </div>
</div>
</div>
<div class="col-md-8">
<div class="panel-body" style="position: relative;">
<div class="row">
  <div class="panel-body">
     <?php 
if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
    {
        $id = $_GET['edit_id'];
        $stmt_edit = $DB_con->prepare('SELECT * FROM tbl_hadullo WHERE id =:uid');
        $stmt_edit->execute(array(':uid'=>$id));
        $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
        extract($edit_row);
   
      //edit
  if(isset($_POST['btnupdate']))
    {   
     
 
  $text=$_POST['user_content'];
  $uid=$_GET['edit_id'];

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
                    unlink($upload_dir.$edit_row['imageRecord']);
                    move_uploaded_file($tmp_dir,$upload_dir.$userpic);
                }
                else
                {
                    $errMSG = "Sorry, your file is too large.Select file with less than 5MB";
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
            $userpic = $edit_row['imageRecord']; // old image from database
        }


        // if no error occured, continue ....
        if(!isset($errMSG))
        {

         
            $stmt = $DB_con->prepare('UPDATE tbl_hadullo SET textRecord=:trecord, imageRecord=:uimage WHERE id=:uid');
           
             $stmt->bindParam(':trecord',$text);
            $stmt->bindParam(':uimage',$userpic);
            $stmt->bindParam(':uid',$uid);

            if($stmt->execute()){
                ?>
                <script>
                alert('Successfully Updated ...');
               
                </script>
                <?php
            }
            else{
                $errMSG = "Sorry, Record Could Not Update !";
            }

        }

  
}
    

            ?>
           <form method="post" enctype="multipart/form-data" class="form-horizontal">
              <div class="col-md-2">
              
               <?php echo "ID ". $edit_row['id']; ?>
              </div>
               <div class="col-md-3">
         <input class="form-control" type="text" name="user_content" id="user_content" value="<?php echo $edit_row['textRecord']; ?>" placeholder="Enter record" />
              
              </div>
              <div class="col-md-4">
        <img src="upload/<?php echo  $edit_row['imageRecord']; ?>"  width="50px" height="50px" class="img-rounded"  />
        
        <input class="input-group" type="file" value="<?php echo  $edit_row['imageRecord']; ?>"  name="user_image"  accept="image/*" />
              </div>
              <div class="col-md-2">
                <button type="submit" name="btnupdate" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>
              </div>
               </form>
              <?php 
 }
              ?>
  </div>
</div>
<div class="row">
<div class="panel panel-default">
<div class="recordFetchh"><h5>Loading records...</h5></div>
</div>
</div>
</div>
</div>
</div>

</div>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

   
</body>

</html>

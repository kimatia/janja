
<?php

session_start();
 $_SESSION['add'] = $_GET['add_id'];
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbconfig.php'; 

?>
<link rel="stylesheet" href="normalize.css" media="all">
<link rel="stylesheet" href="demoo.css" media="all">
<link rel="stylesheet" href="tingle/tingle.css" media="all">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="postscript.js"></script>
<script type="text/javascript" src="postscriptt.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">
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
<script>
  var timernew=10;
  var vieww="";
  $(function (){
    function onTimeNew(){
      setTimeout(onTimeNew, 1000);
 
      if(timernew==10){
       //alert("at 8")
  
       $.post("imagefetch.php",{viewwing:vieww},function(data){
        $(".ImageFetch h5").html(data);
       })
       timernew=11;
       clearTimeout(onTimeNew); 
      }
      timernew--;
    }

    onTimeNew(); 
  });
</script>
<?php 

//delete
   if(isset($_GET['delete_id']))
  {


    // it will delete an actual record from tbl_hostelbook
    $stmt_delete = $DB_con->prepare('DELETE FROM tbl_hostelbook WHERE id =:uid');
    $stmt_delete->bindParam(':uid',$_GET['delete_id']);
    $stmt_delete->execute();

 // it will delete an subsequent record from tbl_hostelmore reasonating with tbl_hostelbook
    $stmt_delete1 = $DB_con->prepare('DELETE FROM tbl_hostelmore WHERE IDD =:uid');
      $stmt_delete1->bindParam(':uid',$_GET['delete_id']);
    $stmt_delete1->execute();
   
  }
   if(isset($_GET['delete_image']))
  {


    // it will delete an actual record from db
    $stmt_delete = $DB_con->prepare('DELETE FROM tbl_hostelmore WHERE id =:uid');
    $stmt_delete->bindParam(':uid',$_GET['delete_image']);
    $stmt_delete->execute();

   
  }
  //image
 
   if(isset($_GET['image_id']))
  {


    // it will delete an actual record from db
    $stmt_image = $DB_con->prepare('SELECT FROM tbl_hostelbook WHERE id =:uid');
    $stmt_image->bindParam(':uid',$_GET['image_id']);
    $stmt_image->execute();

   
  }
 //User profile picture
$userPicture = !empty($stmt_image['imageRecord'])?$stmt_image['imageRecord']:'no-image.png';
$userPictureURL = 'uploads/'.$userPicture;
  


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
                <a class="navbar-brand" href="../adhome.php">Janja</a>
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

        <!-- room name -->
        <input class="form-control" type="text" name="room_name" id="user_content" placeholder="Enter room name" />
         <!-- room ID -->
         
       <input class="form-control" type="hidden" name="room_code" id="user_content" placeholder="Enter room code" />
        <!-- room description -->
         </br>
        <input class="form-control" id="charInput" type="text" name="room_description"  placeholder="Enter room description" />
         <!-- room capacity -->
          </br>
        <input class="form-control" type="text" name="room_capacity" id="user_content" placeholder="Enter room capacity" />
        <!-- room Image -->
       </br>
       <!-- room price -->
       <input class="form-control " type="text" name="room_price" id="room_price"  placeholder="Enter room room_price" >
       </br>
        <input  type="file" name="file" class="btn btn-success" accept="image/*" />
        </br>
        <div class="text-center">

<input id="yazdir" value="1" type="checkbox">Checkout&nbsp;&nbsp;&nbsp;
<input id="email" value="2" type="checkbox">Need Button? 
 
<br><br>
<div id="div1" style="display:none;">
<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>No need!</strong>Just Hit enter
           </div></div>
<div id="div2" style="display:none;">
<button type="submit" name="btnsave" value="send" class="btn btn-success">
        <span class="glyphicon glyphicon-save"></span>save record
        </button>
</div>
</div>
        
        
</form> 
  


<script type="text/javascript">
  
$(document).ready(function(){
  $("#yazdir").click(function(){
    $("#div1").fadeIn(0);
 $("#div2").fadeOut(0);
 $("#div3").fadeOut(0);
  });
});

$(document).ready(function(){
  $("#email").click(function(){
    $("#div2").fadeIn(0);
 $("#div3").fadeOut(0);
 $("#div1").fadeOut(0);
  });
});



</script>

  </div>
</div>
</div>
<div class="col-md-8">
<div class="panel panel-default">
  <div class="panel-body" style="margin-right: 5px;">
    <div class="row">
 <div class="panel-body" style="max-height: 60px;">
    <?php

            if(isset($_GET['add_id']) && !empty($_GET['add_id']))
    {    

      
        $_SESSION['add'] = $_GET['add_id'];
        $id = $_GET['add_id'];
        $stmt_image = $DB_con->prepare('SELECT * FROM tbl_hostelmore WHERE IDD =:uid');
        $stmt_image->execute(array(':uid'=>$id));
        $edit_roww = $stmt_image->fetch(PDO::FETCH_ASSOC);
        
        $id = $_GET['add_id'];
        $stmt_edit = $DB_con->prepare('SELECT * FROM tbl_hostelbook WHERE id =:uid');
        $stmt_edit->execute(array(':uid'=>$id));
        $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
     //save record
if(isset($_POST['btnsav'])){
   
?>
<!--  -->
<script type="text/javascript" src="postscriptt.js"></script>
<?php
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



}
    

            ?>
            <?php
        $idd = $_GET['add_id'];
        $stmt_edit = $DB_con->prepare('SELECT * FROM tbl_hostelmore WHERE IDD =:uid');
        $stmt_edit->execute(array(':uid'=>$idd));
        $edit_rowww = $stmt_edit->fetch(PDO::FETCH_ASSOC);

        $stmt_edittt = $DB_con->prepare('SELECT * FROM tbl_hostelbook WHERE id =:uid');
        $stmt_edittt->execute(array(':uid'=>$idd));
        $edit_rowwww = $stmt_edittt->fetch(PDO::FETCH_ASSOC);
            ?>
            <h4 style="color: purple"><center>Add images of same type with reference room&nbsp;<strong><?php echo $edit_rowwww['roomName'];?></strong></center></h4></br>
            <div  class="row" style="margin-left: 5px;">
               <div class="row">
              <div class="col-md-12">
              <span id="message1"></span> 
                 <form method="post" id="uploadimagee"  enctype="multipart/form-data" class="form-horizontal">
<!-- ALTER DATABASE my_database CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci -->
      <!-- ALTER TABLE table_name CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci -->
         
           
            <input class="form-control " type="hidden" name="room_id" id="room_id"  placeholder="id" value="<?php echo $edit_row['id'];?>">
            <input class="form-control " type="hidden" name="room_code" id="  " value="<?php echo $edit_row['roomID'];?>" placeholder="code" >
            <input class="form-control " type="hidden" name="room_price" id="room_price" value="<?php echo $edit_row['roomPrice'];?>" placeholder="code" >
            <input class="form-control " type="hidden" name="room_capacity" id="room_capacity" value="<?php echo $edit_row['roomCapacity'];?>" placeholder="code" >
            <input class="form-control " type="hidden" name="room_name" id="room_name" value="<?php echo $edit_row['roomName'];?>" placeholder="code" >
         
       <div class="row">
         <div class="col-md-5">
            <input class="form-control " type="text" name="image_description" id="image_description"  placeholder="Description" >
         </div>
         <div class="col-md-3">
            <input  type="file" name="file" class="btn btn-success" accept="image/*" />
         </div>
         <div class="col-md-3 col-md-offset-1">
           <button type="submit" name="btnsavee" value="send" class="btn btn-success">
        <span class="glyphicon glyphicon-save"></span>save
        </button>
         </div>
       </div>
     
        
       
</form>    
              </div>
              </div>
              <div class="row">
               <div class="col-md-12">
               <div class="ImageFetch"><h5>Loading images...</h5></div>
                </div>
              </div>
            </div>
         
              <?php 
 }
              

else if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
    {
        $id = $_GET['edit_id'];
        $stmt_edit = $DB_con->prepare('SELECT * FROM tbl_hostelbook WHERE id =:uid');
        $stmt_edit->execute(array(':uid'=>$id));
        $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
        extract($edit_row);
   
      //edit
  if(isset($_POST['btnupdate']))
    {   
     
  $post_Update=1;
  $roomid=$_POST['room_code'];//room ID
  $roomname = $_POST['room_name'];// room name
  $roomdescription=$_POST['room_description'];//room description
  $roomcapacity=$_POST['room_capacity'];//room capacity
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
                    unlink($upload_dir.$edit_row['roomImage']);
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
            $userpic = $edit_row['roomImage']; // old image from database
        }


        // if no error occured, continue ....
        if(!isset($errMSG))
        {

         
            $stmt = $DB_con->prepare('UPDATE tbl_hostelbook SET roomID=:rid,roomName=:rname,roomDescription=:rdesc,roomCapacity=:rcap,roomUpdate=:post_Update, roomImage=:rimage WHERE id=:uid');
            $stmt->bindParam(':rid',$roomid);
           $stmt->bindParam(':rname',$roomname);
             $stmt->bindParam(':rdesc',$roomdescription);
             $stmt->bindParam('rcap',$roomcapacity);
             $stmt->bindParam(':post_Update',$post_Update);
            $stmt->bindParam(':rimage',$userpic);
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

           <form method="post" id="uploadimage" enctype="multipart/form-data" class="form-horizontal">
              <div class="col-md-1">
              
               <?php echo "<h6><strong>ID</strong></h6> ". $edit_row['id']; ?>
              </div>
               <div class="col-md-2">
               <h6><strong>Room ID</strong></h6>
         <input class="form-control" type="text" name="room_code" id="user_content" value="<?php echo $edit_row['roomID']; ?>" placeholder="Enter record" />
              
              </div>
              <div class="col-md-2">
              <h6><strong>Room Name</strong></h6>
         <input class="form-control" type="text" name="room_name" id="user_content" value="<?php echo $edit_row['roomName']; ?>" placeholder="Enter record" />
              
              </div>
              <div class="col-md-2">
              <h6><strong>Description</strong></h6>
         <input class="form-control" type="text" name="room_description" id="user_content" value="<?php echo $edit_row['roomDescription']; ?>" placeholder="Enter record" />
              
              </div>
              <div class="col-md-2">
              <h6><strong>Capacity</strong></h6>
         <input class="form-control" type="text" name="room_capacity" id="user_content" value="<?php echo $edit_row['roomCapacity']; ?>" placeholder="Enter record" />
              
              </div>
              <div class="col-md-2">
        <img src="upload/<?php echo  $edit_row['roomImage']; ?>"  width="50px" height="50px" class="img-rounded"  />
        
        <input class="input-group" type="file" value="<?php echo  $edit_row['roomImage']; ?>"  name="user_image"  accept="image/*" />
              </div>
              <div class="col-md-1">
                <button class="btn btn-success" type="submit" name="btnupdate" title="click to update">
        <span class="glyphicon glyphicon-save"></span>
        </button>
              </div>
               </form>
              <?php 
 }
              
 ?>
 </div>
            </div>
           <div class="row">
            <h3 style="color: purple"><center><strong>Room Booking System</strong></center></h3>
            <div class="panel-body" style="margin-left: 5px;">
<div class="recordFetchh"><h5>Loading records...</h5></div>
</div>
</div>
  </div>
</div>
</div>
</div>

</div>
 

        <!-- Tingle big content -->
        <div class="tingle-demo tingle-demo-big">
            
        </div>

       
        <!-- Tingle tiny content -->
        <div class="tingle-demo tingle-demo-force-close">
           
        </div>
        <!-- /Tingle tiny content -->

    </div>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
     <!-- /Tingle big content -->

    <script src="tingle/tingle.js"></script>
    <script type="text/javascript">

    /**
    * Modal Tiny no footer
    */

    var modalTinyNoFooter = new tingle.modal({
        onClose: function() {
            console.log('close');
        },
        onOpen: function() {
            console.log('open');
        },
        beforeOpen: function() {
            console.log('before open');
        },
        beforeClose: function() {
            console.log('before close');
            return true;
        },
        cssClass: ['class1', 'class2']
    });
    var btn = document.querySelector('.js-tingle-modal-1');
    btn.addEventListener('click', function(){
        modalTinyNoFooter.open();
    });
    modalTinyNoFooter.setContent(document.querySelector('.tingle-demo-tiny').innerHTML);

    /**
    * Modal tiny with btn
    */

    var modalTinyBtn = new tingle.modal({
        footer: true
    });
    var btn2 = document.querySelector('.js-tingle-modal-2');

    btn2.addEventListener('click', function(){
        modalTinyBtn.open();
    });

    modalTinyBtn.setContent(document.querySelector('.tingle-demo-tiny').innerHTML);

    modalTinyBtn.addFooterBtn('Primary action', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() {
        alert('click on primary button!');
    });

    modalTinyBtn.addFooterBtn('Cancel', 'tingle-btn tingle-btn--default tingle-btn--pull-right', function(){
        modalTinyBtn.close();
    });

    modalTinyBtn.addFooterBtn('Danger!', 'tingle-btn tingle-btn--danger', function(){
        alert('click on danger button!');
    });

    /**
    * Modal big
    */

    var modalBigContent = new tingle.modal();
    var btn3 = document.querySelector('.js-tingle-modal-3');
    btn3.addEventListener('click', function(){
        modalBigContent.open();
    });
    modalBigContent.setContent(document.querySelector('.tingle-demo-big').innerHTML);

    /**
    * Modal big with sticky footer
    */
    var modalStickyFooter = new tingle.modal({
        footer: true,
        stickyFooter: true
    });
    var btn4 = document.querySelector('.js-tingle-modal-4');
    btn4.addEventListener('click', function(){
        modalStickyFooter.open();
    });


    modalStickyFooter.addFooterBtn('I agree', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function(){
        modalStickyFooter.close();
    });

    modalStickyFooter.addFooterBtn('Cancel', 'tingle-btn tingle-btn--default tingle-btn--pull-right', function(){
        modalStickyFooter.close();
    });

    modalStickyFooter.setContent(document.querySelector('.tingle-demo-sticky').innerHTML);

    /**
    *   Force close button
    */

    var modalButtonOnly = new tingle.modal({
        closeMethods: [],
        footer: true,
        stickyFooter: true
    });
    var btn5 = document.querySelector('.js-tingle-modal-5');
    btn5.addEventListener('click', function(){
        modalButtonOnly.open();
    });
    modalButtonOnly.setContent(document.querySelector('.tingle-demo-force-close').innerHTML);

    modalButtonOnly.addFooterBtn('I agree', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function(){
        modalButtonOnly.close();
    });

    modalButtonOnly.addFooterBtn('Cancel', 'tingle-btn tingle-btn--default tingle-btn--pull-right', function(){
        modalButtonOnly.close();
    });

    /**
    *   Modal suprise
    */
    var btn6 = document.querySelector('.js-tingle-modal-6');
    btn6.addEventListener('click', function(){
        var modalSurprise = new tingle.modal({
            onClose: function(){
                modalSurprise.destroy();
            }
        });
        modalSurprise.setContent('<iframe width="100%" height="400" src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1" frameborder="0" allowfullscreen></iframe>');
        modalSurprise.open();
    });

    </script>
    <script type="text/javascript" src="vendor/highlight/highlight.pack.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>

   
</body>

</html>

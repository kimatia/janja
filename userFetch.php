<?php
include_once('dbconfig.php');
 if(isset($_GET['admin_id'])&& !empty($_GET['admin_id']))
  {
   $id = $_GET['admin_id'];
        $stmt_admin = $DB_con->prepare('SELECT loginType FROM tbl_users WHERE userID =:uid');
        $stmt_admin->execute(array(':uid'=>$id));
        $admin_row = $stmt_admin->fetch(PDO::FETCH_ASSOC);
        extract($admin_row);
$userLogin = "admin";// user login type
            if(!isset($errMSG))
            {
            $stmt = $DB_con->prepare('UPDATE tbl_users SET loginType=:ulogtype WHERE userID=:uid');
            $stmt->bindParam(':ulogtype',$userLogin);
            $stmt->bindParam(':uid',$id);

            if($stmt->execute()){
                ?>
                <script>
                alert('Successfully made admin ...');
                window.location.href='adhome.php';
                </script>
                <?php
            }
            else{
                $errMSG = "Sorry, could not provide admin priviledges!";
            }

        }
    
  }
  //number of users
$users=0;
$sql="SELECT * FROM tbl_users";
$resultusers=mysqli_query($mysqli, $sql);
$users=mysqli_num_rows($resultusers);
  if(isset($_GET['removeadmin_id'])&& !empty($_GET['removeadmin_id']))
  {
   $id = $_GET['removeadmin_id'];
        $stmt_admin = $DB_con->prepare('SELECT loginType FROM tbl_users WHERE userID =:uid');
        $stmt_admin->execute(array(':uid'=>$id));
        $admin_row = $stmt_admin->fetch(PDO::FETCH_ASSOC);
        extract($admin_row);
$userLogin = "worker";// user login type
            if(!isset($errMSG))
            {
            $stmt = $DB_con->prepare('UPDATE tbl_users SET loginType=:ulogtype WHERE userID=:uid');
            $stmt->bindParam(':ulogtype',$userLogin);
            $stmt->bindParam(':uid',$id);

            if($stmt->execute()){
                ?>
                <script>
                alert('Successfully made user ...');
                window.location.href='adhome.php';
                </script>
                <?php
            }
            else{
                $errMSG = "Sorry, could demote admin priviledges!";
            }

        }
    
  }
?>
 <center><h4 style="color: purple;"><strong><?php if($users>0) { echo $users; } ?>&nbsp;&nbsp;Users</strong></h4></center>
<?php
 $stmt = $DB_con->prepare('SELECT * FROM tbl_users');
    $stmt->execute();

    if($stmt->rowCount() > 0)
    {
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            ?>

 
     <?php


                                     $ad = "admin";
                                      $wk = "worker";
                                       $sp="superadmin";
                                        $ua="useradmin";
             
                        if(($row['loginType']==$ad) && ($row['superType']==$sp)){
                        	if($row['user_status'] == 1 ){
                        		?>
                        		<div class="row">
                        		<div class="col-md-6">

                        		<?php
		echo "<font color='#009900'>".$row['userName']." (Online)"."</font><br>";
		?>
		</div>
		<div class="col-md-6">
		 <a  href="usermore.php?more_id=<?php echo $row['userID']; ?>" title="click for More" ><span class="glyphicon glyphicon-user"></span>About</a>
		 </div>
		 </div>
		<?php
                     echo '<div class="row">
                      <div class="desc">
                      <div class="details">
       <p><a href="mail.php">
      </a><br/> </p>
      <con>Phone:</con>
      <span class="message">'.$row["userPhone"].'</span>
      <a class="btn btn-success"  > &nbsp;Super Admin</a>  
     
       </div>
       </div>
      </div><hr/>';
      }
      else {
		?>
                        		<div class="row">
                        		<div class="col-md-6">
                        		<?php
		echo "<font color='#FF0000'>".$row['userName']." (Offline)"."</font><br>";
		?>
		</div>
		<div class="col-md-6">
		 <a  href="usermore.php?more_id=<?php echo $row['userID']; ?>" title="click for More" ><span class="glyphicon glyphicon-user"></span>About</a>
		 </div>
		 </div>
		<?php
		
                     echo '<div class="row">
                      <div class="desc">
                      <div class="details">
       <p><a href="mail.php">
      </a><br/> </p>
      <con>Phone:</con>
      <span class="message">'.$row["userPhone"].'</span>
      <a class="btn btn-success"  > &nbsp;Super Admin</a>  
     
       </div>
       </div>
      </div><hr/>';
      }
                       }
                        
                       
                        ?>
                                    <?php
                                     $ad = "admin";
                                      $wk = "worker";
                                     $sp="superadmin";
                                        $ua="useradmin";
             
                        if(($row['loginType']==$ad) && ($row['superType']==$ua)){
                        	if($row['user_status'] == 1 ){
		?>
                        		<div class="row">
                        		<div class="col-md-6">
                        		<?php
		echo "<font color='#009900'>".$row['userName']." (Online)"."</font><br>";
		?>
		</div>
		<div class="col-md-6">
		 <a  href="usermore.php?more_id=<?php echo $row['userID']; ?>" title="click for More" ><span class="glyphicon glyphicon-user"></span>About</a>
		 </div>
		 </div>
		<?php
                     echo '<div class="row">
                      <div class="desc">
                      <div class="details">
       <p><a href="mail.php">
    
      </a><br/> </p>
      <con>Phone:</con>
      <span class="message">'.$row["userPhone"].'</span>
      <a class="btn btn-success"  > &nbsp;Admin</a>  
      <a class="btn btn-danger" href="?removeadmin_id='.$row['userID'].'" title="click to remove admin" ><span class="glyphicon glyphicon-user"></span></a>
       </div>
       </div>
      </div><hr/>';
  }
  else {
		?>
                        		<div class="row">
                        		<div class="col-md-6">
                        		<?php
		echo "<font color='#FF0000'>".$row['userName']." (Offline)"."</font><br>";
		?>
		</div>
		<div class="col-md-6">
		 <a  href="usermore.php?more_id=<?php echo $row['userID']; ?>" title="click for More" ><span class="glyphicon glyphicon-user"></span>About</a>
		 </div>
		 </div>
		<?php
                     echo '<div class="row">
                      <div class="desc">
                      <div class="details">
       <p><a href="mail.php">
    
      </a><br/> </p>
      <con>Phone:</con>
      <span class="message">'.$row["userPhone"].'</span>
      <a class="btn btn-success"  > &nbsp;Admin</a>  
      <a class="btn btn-danger" href="?removeadmin_id='.$row['userID'].'" title="click to remove admin" ><span class="glyphicon glyphicon-user"></span></a>
       </div>
       </div>
      </div><hr/>';
  }
                       }
                         
                       
                        ?>
                      <?php
                      
                       if ($row['loginType']==$wk){
                       	if($row['user_status'] == 1 ){
		?>
                        		<div class="row">
                        		<div class="col-md-6">
                        		<?php
		echo "<font color='#009900'>".$row['userName']." (Online)"."</font><br>";
		?>
		</div>
		<div class="col-md-6">
		 <a  href="usermore.php?more_id=<?php echo $row['userID']; ?>" title="click for More" ><span class="glyphicon glyphicon-user"></span>About</a>
		 </div>
		 </div>
		<?php
                     echo '<div class="row">
                      <div class="desc">
                      <div class="details">
       <p><a href="mail.php">
    
      </a><br/> </p>
      <con>Phone:</con>
      <span class="message">'.$row["userPhone"].'</span>
      <a class="btn btn-danger" href="?delete_id='.$row['userID'].'" title="click to delete user" onclick="javascript:PlaySound(sounds/sound_2.mp3);"><span class="glyphicon glyphicon-remove-circle" ></span> &nbsp;Delete</a>
       <a class="btn btn-success" href="?admin_id='.$row['userID'].'" title="click to make admin" ><span class="glyphicon glyphicon-user"></span></a>
       </div>
       </div>
      </div><hr/>';
  }else {
		?>
                        		<div class="row">
                        		<div class="col-md-6">
                        		<?php
		echo "<font color='#FF0000'>".$row['userName']." (Offline)"."</font><br>";
		?>
		</div>
		<div class="col-md-6">
		 <a  href="usermore.php?more_id=<?php echo $row['userID']; ?>" title="click for More" ><span class="glyphicon glyphicon-user"></span>About</a>
		 </div>
		 </div>
		<?php
                     echo '<div class="row">
                      <div class="desc">
                      <div class="details">
       <p><a href="mail.php">
    
      </a><br/> </p>
      <con>Phone:</con>
      <span class="message">'.$row["userPhone"].'</span>
      <a class="btn btn-danger" href="?delete_id='.$row['userID'].'" title="click to delete user" onclick="javascript:PlaySound(sounds/sound_2.mp3);"><span class="glyphicon glyphicon-remove-circle"></span> &nbsp;Delete</a>
       <a class="btn btn-success" href="?admin_id='.$row['userID'].'" title="click to make admin" ><span class="glyphicon glyphicon-user"></span></a>
       </div>
       </div>
      </div><hr/>';
  }
                       }
                     
                       ?>
                <?php
        }
    }

?>  
<script type="text/javascript">

function PlaySound(path) {
  var audioElement = document.createElement('audio');
  audioElement.setAttribute('src', path);
  audioElement.play();
}

</script>                
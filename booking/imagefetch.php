


             <?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbconfig.php'; 
//get the logged in user credentials and validate
 ?>

  <div class="row">
  <?php
    $id=$_SESSION['add'];

    $stmttt = $DB_con->prepare( "SELECT * FROM tbl_hostelmore WHERE IDD= ".$id."  " );
    $stmttt->execute();

    if($stmttt->rowCount() > 0)
    {
        while($imagerow=$stmttt->fetch(PDO::FETCH_ASSOC))
        {
            extract($imagerow);
           
       
            ?>

    <div class="col-md-2">
      <a  href="?delete_image=<?php echo $imagerow['id']; ?>" title="click to delete this image" > <img src="upload/<?php echo  $imagerow['roomImages']; ?>"  width="60px" height="60px" class="img-rounded"  /></a>
    </div>
 
              


            <?php
        }
    }else{
    ?>
        <div class="col-xs-12">
          <div class="alert alert-warning">
              <span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Data Found conserning this room.Please add images if its kind...
            </div>
        </div>
        <!--  -->
        <?php
  }

?>

</div>
</br></br></br></br>

   <!-- /Tingle big content -->

   
    
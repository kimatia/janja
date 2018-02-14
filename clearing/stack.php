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
//we can now access the users details from $row['appropriatedbfield']

//check user type
$admin = "admin";
if($row['loginType']==$admin){
  $type = "admin";
}else{
  $type = "worker";
}

//check out a particular file stack
if (isset($_GET['view'])){
  $_SESSION['view'] = $_GET['view'];
  header("location: stack.php");
}

$view = $_SESSION['view'];

$verified = 'Yes';
if($row['status']!==$verified){
  $notVerifiedMessage = "<div class='alert alert-danger'>
<button class='close' data-dismiss='alert'>&times;</button>
<strong>Allert!</strong>  You have no jurisdiction to manipulate forms. Kindly wait to get that priviledge or contact the admin.
</div>";
}

if(isset($_POST['btn-add-stack'])){

 $sNumber = $_POST['stackNumber'];

 $SQL = $con->prepare("INSERT INTO tbl_stacks(stackNumber, postDate) VALUES(?,now())");
 if(!$SQL){
  echo $con->error;
  $msgCreateStack = "<div class='alert alert-danger'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry!</strong>  Create failed.
     </div>
     ";
  header("refresh:5;adhome.php");
}else{

  $SQL->bind_param('s',$sNumber);
  $SQL->execute();
  header("location: adhome.php");
  $msgCreateStack = "<div class='alert alert-success'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Success !</strong>  Create success.
     </div>
     ";
 }

}

//edit file  in that stack
if (isset($_GET['editbol'])){
  $_SESSION['editbol'] = $_GET['editbol'];
  $_SESSION['editfile'] = "bol";
  header("location: editFile.php");
}

if (isset($_GET['editidf'])){
  $_SESSION['editidf'] = $_GET['editidf'];
  $_SESSION['editfile'] = "idf";
  header("location: editFile.php");
}

if (isset($_GET['editkbs'])){
  $_SESSION['editkbs'] = $_GET['editkbs'];
  $_SESSION['editfile'] = "kbs";
  header("location: editFile.php");
}

if (isset($_GET['editecert'])){
  $_SESSION['editecert'] = $_GET['editecert'];
  $_SESSION['editfile'] = "ecert";
  header("location: editFile.php");
}

if (isset($_GET['editinvoice'])){
  $_SESSION['editinvoice'] = $_GET['editinvoice'];
  $_SESSION['editfile'] = "invoice";
  header("location: editFile.php");
}

if (isset($_GET['edittreciept'])){
  $_SESSION['edittreciept'] = $_GET['edittreciept'];
  $_SESSION['editfile'] = "treciept";
  header("location: editFile.php");
}

if (isset($_GET['editquadruplicate'])){
  $_SESSION['editquadruplicate'] = $_GET['editquadruplicate'];
  $_SESSION['editfile'] = "quadruplicate";
  header("location: editFile.php");
}

if (isset($_GET['editlbook'])){
  $_SESSION['editlbook'] = $_GET['editlbook'];
  $_SESSION['editfile'] = "lbook";
  header("location: editFile.php");
}


//check stack number to direct input of files in that stack
if (isset($_GET['addBOL'])){
  $_SESSION['stackNumber'] = $_GET['addBOL'];
  $_SESSION['file'] = "BOL";
  header("location: addFile.php");
}

if (isset($_GET['addIDF'])){
  $_SESSION['stackNumber'] = $_GET['addIDF'];
  $_SESSION['file'] = "IDF";
  header("location: addFile.php");
}

if (isset($_GET['addKBS'])){
  $_SESSION['stackNumber'] = $_GET['addKBS'];
  $_SESSION['file'] = "KBS";
  header("location: addFile.php");
}

if (isset($_GET['addECert'])){
  $_SESSION['stackNumber'] = $_GET['addECert'];
  $_SESSION['file'] = "ECert";
  header("location: addFile.php");
}

if (isset($_GET['addInvoice'])){
  $_SESSION['stackNumber'] = $_GET['addInvoice'];
  $_SESSION['file'] = "Invoice";
  header("location: addFile.php");
}

if (isset($_GET['addTReciept'])){
  $_SESSION['stackNumber'] = $_GET['addTReciept'];
  $_SESSION['file'] = "TReciept";
  header("location: addFile.php");
}

if (isset($_GET['addQuadruplicate'])){
  $_SESSION['stackNumber'] = $_GET['addQuadruplicate'];
  $_SESSION['file'] = "Quadruplicate";
  header("location: addFile.php");
}

if (isset($_GET['addLBook'])){
  $_SESSION['stackNumber'] = $_GET['addLBook'];
  $_SESSION['file'] = "LBook";
  header("location: addFile.php");
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

    <title>Palm | Files</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>
  

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Palm</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
              <?php if($type==$admin){
                ?>
                <li>
                   <a href="adhome.php"><span class="fa fa-home"></span> home</a>
                </li>
                <li>
                   <a href="users.php"><span class="fa fa-group"></span> users</a>
                </li>
                <li>
                <a href="#" data-toggle="modal" data-target="#newStack"><span class="fa fa-folder-open"></span> New Stack</a>
                </li>
                <?php
              } else{
                ?>
                <li>
                   <a href="home.php"><span class="fa fa-home"></span> home</a>
                </li>
                <?php
              }?>
              <li>
                 <a href="#" data-toggle="modal" data-target="#find"><span class="fa fa-search"></span> Search</a>
              </li>
              <li class="dropdown get_tooltip" data-toggle="tooltip" data-placement="bottom" title="logout">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      <i class="fa fa-user fa-fw"></i> Hello <?php echo $row['userName'];?> <i class="fa fa-caret-down"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-user">
                      <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"> Logout</i></a>
                      </li>
                  </ul>
                  <!-- /.dropdown-user -->
              </li>
            </ul>
            <!-- /.navbar-top-links -->
        </nav>

    <br><br>
    <div class="row" style="background-color: cream">
      <div class="col-md-8">

        <div class="panel panel-default">
          <div class="panel panel-body">

            <?php
            if(isset($msgCreateStack)){
              echo $msgCreateStack;
            }

            if(isset($notVerifiedMessage)){
              echo $notVerifiedMessage;
              $x = 0;
              $respstack = $con->query("SELECT * FROM tbl_stacks WHERE stackNumber='$view' ORDER BY id DESC");
              while($rowStack=$respstack->fetch_array()){
                $x++;
                $num = $rowStack['stackNumber'];?>
              <div class="panel panel-default" style="background-color:whitesmoke">
              <h4>
                &nbsp&nbsp&nbsp<?php echo $num;?>
                &nbsp&nbsp&nbsp
                <?php
                 $pending = "pending";
                 if($rowStack['finalDate']==$pending){ ?>
                   <span class="pull-right text-muted" style="background-color:blue">&nbsp&nbsp
                   <span class="fa fa-unlock" style="color:white"> Open</span>&nbsp&nbsp
                   </span>
                  <?php
                 } else{
                   ?>
                <span class="pull-right text-muted" style="background-color:red">&nbsp&nbsp
                   <span class="fa fa-lock"style="color:white"> Closed</span>&nbsp&nbsp
                </span>
                   <?php
                 }?>
                </h4>
              <hr>
              <div class="row">
                <div class="col-md-3">
                  <h5>&nbsp&nbsp&nbsp&nbspBill of Lading</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_billoflading WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['bol']=="Yes"){
                    ?>
                    <a href="#"  data-toggle="modal" data-target="#displaybol<?php echo $x; ?>">
                      <img src="upload/<?php echo $rowFileImage['billofLading_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                    </a>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>

                    <!-- search by atribute functionality-->
                    <div class="modal fade" id="displaybol<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Bill of Lading</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['billofLading_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                    <?php
                  }else{
                    ?>
                    &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>
                    <?php
                  }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Import Declaration Form</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_idf WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                  if($rowStack['idf']=="Yes"){
                   ?>
                   <a href="#" data-toggle="modal" data-target="#displayidf<?php echo $x; ?>">
                   <img src="upload/<?php echo $rowFileImage['idf_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                 </a>
                 &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                   <br>
                   &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>

                   <div class="modal fade" id="displayidf<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" style="width: 800px" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <h4><span class="fa  fw"> Import Declaration Form</span></h4>
                                    </div>
                                    <div class="modal-body section">
                                      <img src="upload/<?php echo $rowFileImage['idf_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                    </div>
                                    <div class="modal-footer">
                                      <div class="form-group" >
                                        <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                      </div>
                                      </form>
                                    </div>
                               </div>
                           </div>
                           </div>
                           <?php
                 }else{
                   ?>
                  &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Kenya Bureau Standards</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_kbs WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                  if($rowStack['kbs']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displaykbs<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['kbs_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>

                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
                    <div class="modal fade" id="displaykbs<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Kenya Bureau of Standards</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['kbs_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>
                   &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Export Certificate</h5>
                  <?php //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_ecert WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();


                  if($rowStack['ecert']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displayecert<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['ecert_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>
                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
                    <div class="modal fade" id="displayecert<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Export Certificate</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['ecert_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>

                  &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>

                  <?php }?>
                  <br>
                  <br>
                  <br>
                </div>

                <div class="col-md-3">
                  <h5>&nbsp&nbsp&nbsp&nbspInvoice</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_invoice WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }


                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();


                  if($rowStack['invoice']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displayinvoice<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['invoice_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>
                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
                    <div class="modal fade" id="displayinvoice<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Invoice Form</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['invoice_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                      <?php
                  }else{
                    ?>
                    &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>KRA Bank Slip</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_treciept WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['treciept']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displaytreciept<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['treciept_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>
                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
                    <div class="modal fade" id="displaytreciept<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> KRA Bank Slip</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['treciept_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>
                    &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Quadruplicate</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_quadruplicate WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['quadruplicate']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displayquadruplicate<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['quadruplicate_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>
                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
                    <div class="modal fade" id="displayquadruplicate<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Quadruplicate Form</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['quadruplicate_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>
                    &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Log Book</h5>
                  <?php

                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_lbook WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['lbook']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displaylbook<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['lbook_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                    </a>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
                    <div class="modal fade" id="displaylbook<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Log Book Form</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['lbook_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>
                    &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <br>
                <hr>
              </div>
            </div>
            <?php
          }
            }else{
            $x = 0;
            $respstack = $con->query("SELECT * FROM tbl_stacks WHERE stackNumber='$view'");
            while($rowStack=$respstack->fetch_array()){
              $x++;
              $num = $rowStack['stackNumber'];
              $No = "No";
              $Yes = "Yes";
              if($rowStack['status']==$No){
              ?>
              <div class="panel panel-default" style="background-color:whitesmoke">
              <h4>
                &nbsp&nbsp&nbsp<?php echo $num;?>
                &nbsp&nbsp&nbsp
                <?php
                 $pending = "pending";
                 if($rowStack['finalDate']==$pending){ ?>
                   <span class="pull-right text-muted" style="background-color:blue">&nbsp&nbsp
                   <span class="fa fa-unlock" style="color:white"> Open</span>&nbsp&nbsp
                   </span>
                  <?php
                 } else{
                   ?>
                <span class="pull-right text-muted" style="background-color:red">&nbsp&nbsp
                   <span class="fa fa-lock"style="color:white"> Closed</span>&nbsp&nbsp
                </span>
                   <?php
                 }?>
              </h4>
              <hr>
              <div class="row">
                <div class="col-md-3">
                  <h5>&nbsp&nbsp&nbsp&nbspBill of Lading</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_billoflading WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['bol']=="Yes"){
                    ?>
                    <a href="#"  data-toggle="modal" data-target="#displaybol<?php echo $x; ?>">
                      <img src="upload/<?php echo $rowFileImage['billofLading_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                    </a>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
                    <span class="pull-right"><a href="?editbol=<?php echo $rowFileImage['id'];?>" class="fa fa-pencil"> Edit</a></span>
                    <!-- search by atribute functionality-->
                    <div class="modal fade" id="displaybol<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Bill of Lading</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['billofLading_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                    <?php
                  }else{
                    ?>
                    &nbsp&nbsp&nbsp&nbsp<a href="?addBOL=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:200px"></a>
                    <?php
                  }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Import Declaration Form</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_idf WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                  if($rowStack['idf']=="Yes"){
                   ?>
                   <a href="#" data-toggle="modal" data-target="#displayidf<?php echo $x; ?>">
                   <img src="upload/<?php echo $rowFileImage['idf_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                 </a>
                 &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                   <br>
                   &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="?editidf=<?php echo $rowFileImage['id'];?>" class="fa fa-pencil"> Edit</a></span>
                   <div class="modal fade" id="displayidf<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" style="width: 800px" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <h4><span class="fa  fw"> Import Declaration Form</span></h4>
                                    </div>
                                    <div class="modal-body section">
                                      <img src="upload/<?php echo $rowFileImage['idf_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                    </div>
                                    <div class="modal-footer">
                                      <div class="form-group" >
                                        <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                      </div>
                                      </form>
                                    </div>
                               </div>
                           </div>
                           </div>
                           <?php
                 }else{
                   ?>
                  <a href="?addIDF=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:200px"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Kenya Bureau Standards</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_kbs WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                  if($rowStack['kbs']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displaykbs<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['kbs_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>

                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="?editkbs=<?php echo $rowFileImage['id'];?>" class="fa fa-pencil"> Edit</a></span>
                    <div class="modal fade" id="displaykbs<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Kenya Bureau of Standards</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['kbs_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>
                  <a href="?addKBS=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:200px"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Export Certificate</h5>
                  <?php //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_ecert WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();


                  if($rowStack['ecert']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displayecert<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['ecert_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>
                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="?editecert=<?php echo $rowFileImage['id'];?>" class="fa fa-pencil"> Edit</a></span>
                    <div class="modal fade" id="displayecert<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Export Certificate</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['ecert_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>
                  <a href="?addECert=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:200px"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>
                </div>

                <div class="col-md-3">
                  <h5>&nbsp&nbsp&nbsp&nbspInvoice</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_invoice WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }


                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();


                  if($rowStack['invoice']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displayinvoice<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['invoice_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>
                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="?editinvoice=<?php echo $rowFileImage['id'];?>" class="fa fa-pencil"> Edit</a></span>
                    <div class="modal fade" id="displayinvoice<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Invoice Form</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['invoice_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                      <?php
                  }else{
                    ?>
                  &nbsp&nbsp&nbsp&nbsp<a href="?addInvoice=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:200px"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>KRA Bank Slip</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_treciept WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['treciept']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displaytreciept<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['treciept_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>
                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="?edittreciept=<?php echo $rowFileImage['id'];?>" class="fa fa-pencil"> Edit</a></span>
                    <div class="modal fade" id="displaytreciept<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> KRA Bank Slip</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['treciept_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>
                  <a href="?addTReciept=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:200px"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Quadruplicate</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_quadruplicate WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['quadruplicate']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displayquadruplicate<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['quadruplicate_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>
                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="?editquadrupicate=<?php echo $rowFileImage['id'];?>" class="fa fa-pencil"> Edit</a></span>
                    <div class="modal fade" id="displayquadruplicate<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Quadruplicate Form</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['quadruplicate_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>
                  <a href="?addQuadruplicate=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:200px"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Log Book</h5>
                  <?php

                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_lbook WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['lbook']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displaylbook<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['lbook_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                    </a>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="?editlbook=<?php echo $rowFileImage['id'];?>" class="fa fa-pencil"> Edit</a></span>
                    <div class="modal fade" id="displaylbook<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Log Book Form</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['lbook_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>
                  <a href="?addLBook=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:200px"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <br>
                <hr>
              </div>
            </div>
              <?php
            }elseif($rowStack['status']==$Yes){//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
              ?>
              <div class="panel panel-default" style="background-color:whitesmoke">
              <h4>
                &nbsp&nbsp&nbsp<?php echo $num;?>
                &nbsp&nbsp&nbsp
                <?php
                 $pending = "pending";
                 if($rowStack['finalDate']==$pending){ ?>
                   <span class="pull-right text-muted" style="background-color:blue">&nbsp&nbsp
                   <span class="fa fa-unlock" style="color:white"> Open</span>&nbsp&nbsp
                   </span>
                  <?php
                 } else{
                   ?>
                <span class="pull-right text-muted" style="background-color:red">&nbsp&nbsp
                   <span class="fa fa-lock"style="color:white"> Closed</span>&nbsp&nbsp
                </span>
                   <?php
                 }?>
               </h4>
              <hr>
              <div class="row">
                <div class="col-md-3">
                  <h5>&nbsp&nbsp&nbsp&nbspBill of Lading</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_billoflading WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['bol']=="Yes"){
                    ?>
                    <a href="#"  data-toggle="modal" data-target="#displaybol<?php echo $x; ?>">
                      <img src="upload/<?php echo $rowFileImage['billofLading_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                    </a>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>

                    <!-- search by atribute functionality-->
                    <div class="modal fade" id="displaybol<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Bill of Lading</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['billofLading_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                    <?php
                  }else{
                    ?>
                    &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>
                    <?php
                  }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Import Declaration Form</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_idf WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                  if($rowStack['idf']=="Yes"){
                   ?>
                   <a href="#" data-toggle="modal" data-target="#displayidf<?php echo $x; ?>">
                   <img src="upload/<?php echo $rowFileImage['idf_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                 </a>
                 &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                   <br>
                   &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>

                   <div class="modal fade" id="displayidf<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" style="width: 800px" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <h4><span class="fa  fw"> Import Declaration Form</span></h4>
                                    </div>
                                    <div class="modal-body section">
                                      <img src="upload/<?php echo $rowFileImage['idf_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                    </div>
                                    <div class="modal-footer">
                                      <div class="form-group" >
                                        <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                      </div>
                                      </form>
                                    </div>
                               </div>
                           </div>
                           </div>
                           <?php
                 }else{
                   ?>
                  &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Kenya Bureau Standards</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_kbs WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                  if($rowStack['kbs']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displaykbs<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['kbs_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>

                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
                    <div class="modal fade" id="displaykbs<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Kenya Bureau of Standards</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['kbs_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>
                   &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Export Certificate</h5>
                  <?php //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_ecert WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();


                  if($rowStack['ecert']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displayecert<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['ecert_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>
                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
                    <div class="modal fade" id="displayecert<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Export Certificate</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['ecert_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>

                  &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>

                  <?php }?>
                  <br>
                  <br>
                  <br>
                </div>

                <div class="col-md-3">
                  <h5>&nbsp&nbsp&nbsp&nbspInvoice</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_invoice WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }


                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();


                  if($rowStack['invoice']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displayinvoice<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['invoice_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>
                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
                    <div class="modal fade" id="displayinvoice<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Invoice Form</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['invoice_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                      <?php
                  }else{
                    ?>
                    &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>KRA Bank Slip</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_treciept WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['treciept']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displaytreciept<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['treciept_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>
                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
                    <div class="modal fade" id="displaytreciept<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw">KRA Bank Slip</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['treciept_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>
                    &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Quadruplicate</h5>
                  <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_quadruplicate WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['quadruplicate']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displayquadruplicate<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['quadruplicate_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                  </a>
                  &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
                    <div class="modal fade" id="displayquadruplicate<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Quadruplicate Form</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['quadruplicate_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>
                    &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <div class="col-md-3">
                  <h5>Log Book</h5>
                  <?php

                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_lbook WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['lbook']=="Yes"){
                    ?>
                    <a href="#" data-toggle="modal" data-target="#displaylbook<?php echo $x; ?>">
                    <img src="upload/<?php echo $rowFileImage['lbook_file']; ?>" class="img-thumbnail" style="width:100%; height: 150px;"></img>
                    </a>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    <br>
                    &nbsp&nbsp&nbsp&nbsp<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
                    <div class="modal fade" id="displaylbook<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" style="width: 800px" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                       <h4><span class="fa  fw"> Log Book Form</span></h4>
                                     </div>
                                     <div class="modal-body section">
                                       <img src="upload/<?php echo $rowFileImage['lbook_file']; ?>" class="img-thumbnail" style="width:100%; height: 100%;"></img>
                                     </div>
                                     <div class="modal-footer">
                                       <div class="form-group" >
                                         <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                                       </div>
                                       </form>
                                     </div>
                                </div>
                            </div>
                            </div>
                            <?php
                  }else{
                    ?>
                    &nbsp&nbsp&nbsp&nbsp<a href="#" class="fa fa-file" style="font-size:200px; color:grey"></a>
                  <?php }?>
                  <br>
                  <br>
                  <br>

                </div>
                <br>
                <hr>
              </div>
            </div>
              <?php
              }
            }
            }//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
             ?>
          </div>
        </div>

      </div>

      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>Contributors</h4>
            <?php
            $y = 0;
            $respUsers = $con->query("SELECT * FROM tbl_logs where stackNumber='$num' ORDER BY id DESC");
            while($rowUsers=$respUsers->fetch_array()){
               $d = $rowUsers['userId'];
                  //get user
                  $respFileImage = $con->query("SELECT * FROM tbl_users WHERE userID='$d'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                    $Yes = "Yes";
                    ?>

                    <div class="list-group-item">
                      <?php
                      $negative = "No";
                      if($rowFileImage['online']==$negative){
                       ?>
                       <span style="color:red"><?php echo $rowFileImage['userName'];?></span>
                       <?php
                      }else{
                        ?>
                        <span><?php echo $rowFileImage['userName'];?></span>
                        <?php
                      }
                      ?>
                      <br>
                      <?php if($rowUsers['updateData']===$Yes) { ?>
                        <span class="ribbon">
                            <div class="text">Edited</div>
                        </span>
                      <?php }?>
                      <span class="fa fa-folder"><?php echo $rowUsers['file'];?></span>
                    <span class="pull-right text-muted"><i class="fa fa-clock-o"></i> <?php echo $rowUsers['postTime'];?></span>
                  </div>
                    <?php
                    }
                  }
                  ?>
          </div>
        </div>
      </div>
    </div>

</div>


<!-- search by atribute functionality-->
<div class="modal fade" id="find" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                   <h4><span class="fa fa-search fw"> Find Stack</span></h4>
                 </div>
                 <div class="modal-body section">
                   <div class="">
                   <form action="" class="">
                   <div class="form-group input-group">
                           <input type="text" class="form-control" id="forms" onkeyup="mySearch()" placeholder="Search for a form..">
                           <span class="input-group-btn">
                               <button class="btn btn-default btn-info" type="button"><i class="fa fa-search"></i>
                               </button>
                           </span>
                       </div>
                   </form>

                   <table id="formsTable" class="table table-hover table-condensed" style="table-layout: fixed;">
                   <thead>
                    <tr>
                      <th style="width:75%;">Stack Number</th>
                      <th style="width:25%;">Action</th>
                    </tr>
                   </thead>
                   <tbody>
                    <?php
                    $respSearchForm1 = $con->query("SELECT * FROM tbl_stacks ORDER BY id DESC");
                    while($rowSearchForm1=$respSearchForm1->fetch_array()){
                      $joinIdSearchForm1 = $rowSearchForm1['id'];
                    ?>
                        <td><?php echo $rowSearchForm1['stackNumber']; ?></td>
                        <td><a href="?view=<?php echo $rowSearchForm1['stackNumber']?>" class="btn btn-info">View</a></td>

                      </tr>
                    <?php  } ?>
                    <tbody>
                   </table>
                 </div>
                 </div>
                 <div class="modal-footer">
                   <div class="form-group" >
                     <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                   </div>
                   </form>
                 </div>
            </div>
        </div>
        </div>

        <!-- search by atribute functionality-->
        <div class="modal fade" id="newStack" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                 <div class="modal-dialog" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                           <h4><span class="fa fa-folder-open fw"> Create New Stack</span></h4>
                         </div>
                         <div class="modal-body section">
                           <form method="post">
                             <div class="form-group">
                                 <label for="stackNumber">Stack Number</label>
                                 <input type="text" name="stackNumber" placeholder="Stack Number" class="form-control"  autofocus required/>
                             </div>

                               <button class="btn btn-primary btn-outline" type="submit" name="btn-add-stack"> Create</button></br>
                             </form>
                         </div>
                         <div class="modal-footer">
                           <div class="form-group" >
                             <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                           </div>
                           </form>
                         </div>
                    </div>
                </div>
                </div>
    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <script>
    function mySearch() {

      // Declare variables
      var input, filter, table, tr, td, i;
      input = document.getElementById("forms");
      filter = input.value.toUpperCase();
      table = document.getElementById("formsTable");
      tr = table.getElementsByTagName("tr");
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>
</body>

</html>

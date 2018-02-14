<?php
session_start();
//db connection
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

if(isset($_POST['btn-add-stack'])){

 $sNumber = $_POST['stackNumber'];

 $SQL = $con->prepare("INSERT INTO tbl_stacks(stackNumber, postDate) VALUES(?,now())");
 if(!$SQL){
  echo $con->error;
  $msgCreateStack = "<div class='alert alert-danger'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry!</strong>  Post failed.
     </div>
     ";
  header("refresh:5;adhome.php");
}else{

  $SQL->bind_param('s',$sNumber);
  $SQL->execute();
  header("location: adhome.php");
  $msgCreateStack = "<div class='alert alert-success'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Success !</strong>  Post success.
     </div>
     ";
 }
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

if (isset($_SESSION["errMssg"])){
  $mssg = "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Bill of lading form reqired first to proceed to the next
           </div>";
}



$BOL = "bol";
$IDF = "idf";
$KBS = "kbs";
$ECert = "ecert";
$Invoice = "invoice";
$TReciept = "treciept";
$Quadruplicate = "quadruplicate";
$LBook = "lbook";

if (isset($_SESSION['editfile'])){
if ($_SESSION['editfile']==$BOL){
  $file = $_SESSION['editfile'];
  $y = $_SESSION['editbol'];
  $respFile = $con->query("SELECT * FROM tbl_billoflading WHERE id='$y'");
  $rowFile=$respFile->fetch_array();

}else if ($_SESSION['editfile']==$IDF){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editidf'];
  $respFile = $con->query("SELECT * FROM tbl_idf WHERE id='$y'");
  $rowFile=$respFile->fetch_array();

}else if ($_SESSION['editfile']==$KBS){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editkbs'];
  $respFile = $con->query("SELECT * FROM tbl_kbs WHERE id='$y'");
  $rowFile=$respFile->fetch_array();

}else if ($_SESSION['editfile']==$ECert){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editecert'];
  $respFile = $con->query("SELECT * FROM tbl_ecert WHERE id='$y'");
  $rowFile=$respFile->fetch_array();

}else if ($_SESSION['editfile']==$Invoice){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editinvoice'];
  $respFile = $con->query("SELECT * FROM tbl_invoice WHERE id='$y'");
  $rowFile=$respFile->fetch_array();

}else if ($_SESSION['editfile']==$TReciept){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['edittreciept'];
  $respFile = $con->query("SELECT * FROM tbl_treciept WHERE id='$y'");
  $rowFile=$respFile->fetch_array();

}else if ($_SESSION['editfile']==$Quadruplicate){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editquadruplicate'];
  $respFile = $con->query("SELECT * FROM tbl_quadruplicate WHERE id='$y'");
  $rowFile=$respFile->fetch_array();

}else if ($_SESSION['editfile']==$LBook){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editlbook'];
  $respFile = $con->query("SELECT * FROM tbl_lbook WHERE id='$y'");
  $rowFile=$respFile->fetch_array();
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

    <title>Palm|Edit <?php echo $_SESSION['editfile']; ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->

    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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

    <br>
    <div class="row" style="background-color: cream">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel panel-body">
           <span><?php echo $_SESSION['editfile'];?><i class="pull-right tab"><?php echo $rowFile['stackNumber'];  ?></i></span>
           <hr>
           <?php
           $BOL = "bol";
           $IDF = "idf";
           $KBS = "kbs";
           $ECert = "ecert";
           $Invoice = "invoice";
           $TReciept = "treciept";
           $Quadruplicate = "quadruplicate";
           $LBook = "lbook";

           if($_SESSION['editfile']==$BOL){
            ?>
            <?php if (isset($mssg)){ echo $mssg; }?>
            <div class="col-lg-3">
                  <span id="message"></span>
                  <form id="uploadimage" method="POST" enctype=multipart/form-data>

                    <input type="hidden" name="userId" value="<?php echo $row['userID']; ?>" required/>

                    <input type="hidden" name="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

                    <div class="form-group">
                      <label for="billofLadingNumber"> Bill of Lading Number</label>
                        <input type="text"  name="billofLadingNumber" placeholder="" value="<?php echo $rowFile['billofLadingNumber']; ?>" class="form-control"/>
                    </div>

                   <div class="form-group">
                     <label for="shippername"> Shipper</label>
                       <input type="text" name="shippername" placeholder="Name" class="form-control" value="<?php echo $rowFile['shippername']; ?>"required/>
                   </div>

                   <div class="form-group">
                     <label for="shipperadress"> Adress</label>
                       <input type="text" name="shipperadress" placeholder="Shippers adress" class="form-control" value="<?php echo $rowFile['shipperadress']; ?>"required/>
                   </div>

                   <div class="form-group">
                     <label for="shipperlocation"> Location</label>
                       <input type="text" name="shipperlocation" placeholder="Shipper's Adress" class="form-control" value="<?php echo $rowFile['shipperlocation']; ?>"required/>
                   </div>

            </div>
            <!-- /.col-lg-8 -->
            <div class="col-lg-3">
                     <div class="form-group">
                       <label for="consigneename"> Consignee</label>
                         <input type="text" name="consigneename" placeholder="Consignee Name" class="form-control" value="<?php echo $rowFile['consigneename']; ?>"required/>
                     </div>

                     <div class="form-group">
                       <label for="consigneeadress"> Adress</label>
                         <input type="text" name="consigneeadress" placeholder="Consignee adress" class="form-control" value="<?php echo $rowFile['consigneeadress']; ?>"required/>
                     </div>

                     <div class="form-group">
                       <label for="consigneelocation"> Location</label>
                         <input type="text" name="consigneelocation" placeholder="consignee Location" class="form-control" value="<?php echo $rowFile['consigneelocation']; ?>"required/>
                     </div>

            </div>
            <!-- /.col-lg-4 -->

            <div class="col-lg-3">
                      <div class="form-group">
                        <label for="precariageBy">Precariage By</label>
                          <input type="text" name="precariageBy" placeholder="" value="<?php echo $rowFile['precariageBy']; ?>"class="form-control"/>
                      </div>

                        <div class="form-group">
                          <label for="placeofReciept">Place of Reciept</label>
                            <input type="text" name="placeofReciept" placeholder="" value="<?php echo $rowFile['placeofReciept']; ?>"class="form-control"/>
                        </div>

                        <div class="form-group">
                          <label for="vessel">Vessel</label>
                            <input type="text" name="vessel" placeholder="" value="<?php echo $rowFile['vessel']; ?>"class="form-control"/>
                        </div>

                        <div class="form-group">
                          <label for="voyno">Voy No</label>
                            <input type="text" name="voyno" placeholder="" value="<?php echo $rowFile['voyno']; ?>"class="form-control"/>
                        </div>

            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label for="loadingport">Port of Loading</label>
                  <input type="text" name="loadingport" placeholder="" value="<?php echo $rowFile['loadingport']; ?>"class="form-control"/>
              </div>

              <div class="form-group">
                <label for="dischargeport">Port of Discharge</label>
                  <input type="text" name="dischargeport" placeholder="" value="<?php echo $rowFile['dischargeport']; ?>" class="form-control"/>
              </div>

              <div class="form-group">
                <label for="finalDestination">Final Destination</label>
                  <input type="text" name="finalDestination" placeholder="" value="<?php echo $rowFile['finalDestination']; ?>" class="form-control"/>
              </div>

              <div class="form-group">
                <label for="freightName">Freight & Charges</label>
                  <input type="text"  name="freightName" placeholder="" value="<?php echo $rowFile['freightName']; ?>" class="form-control"/>
              </div>

          </div>

          <br><br>

          <div class="col-md-3">

            <div class="form-group">
              <label for="revenueTons"> Revenue Tons</label>
                <input type="text"  name="revenueTons" placeholder="" value="<?php echo $rowFile['revenueTons']; ?>"class="form-control"/>
            </div>

            <div class="form-group">
              <label for="rate"> Rate</label>
                <input type="text"  name="rate" placeholder="" value="<?php echo $rowFile['rate']; ?>"class="form-control"/>
            </div>

            <div class="form-group">
              <label for="per"> Per</label>
                <input type="text"  name="per" placeholder="" class="form-control" value="<?php echo $rowFile['per']; ?>"/>
            </div>

            <div class="form-group">
              <label for="prepaid"> Prepaid</label>
                <input type="text"  name="prepaid" placeholder="" class="form-control" value="<?php echo $rowFile['prepaid']; ?>"/>
            </div>

            <div class="form-group">
              <label for="collect"> Collect</label>
                <input type="text"  name="collect" placeholder="" class="form-control" value="<?php echo $rowFile['collect']; ?>"/>
            </div>

          </div>


          <div class="col-md-3">

            <div class="form-group">
              <label for="markNumber">Marks & Number</label>
                <input type="text" name="markNumber" placeholder="" class="form-control" value="<?php echo $rowFile['markNumber']; ?>"/>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea type="text" name="description" placeholder="" class="form-control" value="<?php echo $rowFile['description']; ?>"/><?php echo $rowFile['description']; ?></textarea>
            </div>

            <div class="form-group">
              <label for="grossweight">Gross Weight</label>
                <input type="text"  name="grossweight" placeholder="" class="form-control" value="<?php echo $rowFile['grossweight']; ?>"/>
            </div>

            <div class="form-group">
              <label for="measurement">Measurement(CBM)</label>
                <input type="text"  name="measurement" placeholder="" class="form-control" value="<?php echo $rowFile['measurement']; ?>"/>
            </div>

          </div>

          <div class="col-md-3">

            <div class="form-group">
              <label for="packagesNo">Total Number of Packages</label>
                <input type="text"  name="packagesNo" placeholder="" class="form-control" value="<?php echo $rowFile['packagesNo']; ?>"/>
            </div>
            <div class="form-group">
              <label for="freightPayable"> Freight Payable</label>
                <input type="text"  name="freightPayable" placeholder="" class="form-control" value="<?php echo $rowFile['freightPayable']; ?>"/>
            </div>

            <div class="form-group">
              <label for="numberOriginal"> Number of Original</label>
                <input type="text"  name="numberOriginal" placeholder="" class="form-control" value="<?php echo $rowFile['numberOriginal']; ?>"/>
            </div>

            <div class="form-group">
              <label for="placeOfIssue"> Place of Issue</label>
                <input type="text"  name="placeOfIssue" placeholder="" class="form-control" value="<?php echo $rowFile['placeOfIssue']; ?>"/>
            </div>

            <div class="form-group">
              <label for="dateOfIssue"> Date of Issue</label>
                <input type="text"  name="dateOfIssue" placeholder="" class="form-control" value="<?php echo $rowFile['dateOfIssue']; ?>"/>
            </div>

          </div>

          <div class="col-md-3">
            <div id="image_preview" ><center><img id="previewing" src="//placehold.it/600x350/99223" class="img-responsive"/></center></div>

           <div class="form-group">
             <label for="file">File</label>
              <input type="file" name="file" id="file"/>
           </div>

          <input type="submit" value="Upload" class="btn btn-outline btn-primary btn-block" />
         </form>
          </div>
            <?php
          }elseif($_SESSION['editfile']==$IDF){
            ?>
            <span id="message"></span>
            <form id="uploadimage" method="post">
              <div class="form-group">
                  <label for="idfNumber">IDF Number</label>
                  <input type="text" name="idfNumber" placeholder="IDF Number" class="form-control" value="<?php echo $rowFile['idfNo']; ?>" autofocus required/>
              </div>

              <input type="hidden" name="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" name="userId" value="<?php echo $row['userID']; ?>" required/>

              <div class="form-group">
                <label for="file">File</label>
                 <input type="file" name="file" id="file"/>
              </div>

                <button class="btn btn-primary btn-outline" type="submit" name="btn-submit"> Submit</button></br>
              </form>
            <?php
           }elseif($_SESSION['editfile']==$KBS){
            ?>
            <span id="message"></span>
            <form id="uploadimage" method="post">
              <div class="form-group">
                  <label for="kbsNumber">Certificate Number</label>
                  <input type="text" name="kbsNumber" placeholder="KBS Certificate Number" class="form-control"  value="<?php echo $rowFile['kbsNo']; ?>" autofocus required/>
              </div>

              <input type="hidden" name="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" name="userId" value="<?php echo $row['userID']; ?>" required/>

              <div class="form-group">
                <label for="file">File</label>
                 <input type="file" name="file" id="file"/>
              </div>

                <button class="btn btn-primary btn-outline" type="submit" name="btn-submit"> Submit</button></br>
              </form>
            <?php
           }elseif($_SESSION['editfile']==$ECert){
            ?>
            <span id="message"></span>
            <form id="uploadimage" method="post">
              <div class="form-group">
                  <label for="ecertNumber">Export Certificate Number</label>
                  <input type="text" name="ecertNumber" placeholder="Export Certificate Number" value="<?php echo $rowFile['ecertNo']; ?>"class="form-control"  autofocus required/>
              </div>

              <input type="hidden" name="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" name="userId" value="<?php echo $row['userID']; ?>" required/>

              <div class="form-group">
                <label for="file">File</label>
                 <input type="file" name="file" id="file"/>
              </div>

                <button class="btn btn-primary btn-outline" type="submit" name="btn-submit"> Submit</button></br>
              </form>
            <?php
           }elseif($_SESSION['editfile']==$Invoice){
            ?>
            <span id="message"></span>
            <form id="uploadimage" method="post">
              <div class="form-group">
                  <label for="invoiceNumber">Invoice Number</label>
                  <input type="text" name="invoiceNumber" placeholder="Invoice Number" value="<?php echo $rowFile['invoiceNo']; ?>" class="form-control"  autofocus required/>
              </div>

              <input type="hidden" name="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" name="userId" value="<?php echo $row['userID']; ?>" required/>

              <div class="form-group">
                <label for="file">File</label>
                 <input type="file" name="file" id="file"/>
              </div>

                <button class="btn btn-primary btn-outline" type="submit" name="btn-submit"> Submit</button></br>
              </form>
            <?php
          }elseif($_SESSION['editfile']==$TReciept){
            ?>
            <span id="message"></span>
            <form id="uploadimage" method="post">
              <div class="form-group">
                  <label for="trecieptNumber">Transaction Reciept Number</label>
                  <input type="text" name="trecieptNumber" placeholder="Transaction Reciept Number" value="<?php echo $rowFile['trecieptNo']; ?>" class="form-control"  autofocus required/>
              </div>

              <input type="hidden" name="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" name="userId" value="<?php echo $row['userID']; ?>" required/>

              <div class="form-group">
                <label for="file">File</label>
                 <input type="file" name="file" id="file"/>
              </div>

                <button class="btn btn-primary btn-outline" type="submit" name="btn-submit"> Submit</button></br>
              </form>
            <?php
           }elseif($_SESSION['editfile']==$Quadruplicate){
            ?>
            <span id="message"></span>
            <form id="uploadimage" method="post">
              <div class="form-group">
                  <label for="quadruplicateNumber">Quadruplicate Number</label>
                  <input type="text" name="quadruplicateNumber" placeholder="Quadruplicate Number" value="<?php echo $rowFile['quadruplicateNo']; ?>" class="form-control"  autofocus required/>
              </div>

              <input type="hidden" name="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" name="userId" value="<?php echo $row['userID']; ?>" required/>

              <div class="form-group">
                <label for="file">File</label>
                 <input type="file" name="file" id="file"/>
              </div>

                <button class="btn btn-primary btn-outline" type="submit" name="btn-submit"> Submit</button></br>
              </form>
            <?php
           }elseif($_SESSION['editfile']==$LBook){
            ?>
            <span id="message"></span>
            <form id="uploadimage" method="post">
              <div class="form-group">
                  <label for="lbookNumber">Log Book Number</label>
                  <input type="text" name="lbookNumber" placeholder="Log Book Number" value="<?php echo $rowFile['lbookNo']; ?>"class="form-control"  autofocus required/>
              </div>

              <input type="hidden" name="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" name="userId" value="<?php echo $row['userID']; ?>" required/>

              <div class="form-group">
                <label for="file">File</label>
                 <input type="file" name="file" id="file"/>
              </div>

                <button class="btn btn-primary btn-outline" type="submit" name="btn-submit"> Submit</button></br>
              </form>
            <?php
           }
           ?>
          </div>
        </div>
      </div>
    </div>

</div>


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

    <script src="editscript.js"></script>

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

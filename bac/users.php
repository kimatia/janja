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

/* code for data delete */
if(isset($_GET['deleteUser']))
{
  $negative = "No";

 $sql = $con->prepare("UPDATE tbl_users SET online=? WHERE userID=?");
 $sql->bind_param("ss",$negative,$_GET['deleteUser']);
 $sql->execute();

 header("Location: users.php");
}
/* code for data delete */

// grant user permision
if(isset($_GET['grantPermision']))
{

 $positive = "Yes";
 $sql = $con->prepare("UPDATE tbl_users SET status=? WHERE userID=?");
 $sql->bind_param("ss",$positive,$_GET['grantPermision']);
 $sql->execute();

 header("Location: users.php");
}

// limit user permision
if(isset($_GET['limitPermision']))
{

 $negative = "No";
 $sql = $con->prepare("UPDATE tbl_users SET status=? WHERE userID=?");
 $sql->bind_param("ss",$negative,$_GET['limitPermision']);
 $sql->execute();

 header("Location: users.php");
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

    <title>Palm</title>

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

    <br><br>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="row">
        <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel panel-body">

            <div class="list-group">
            <?php
            $Yes = "Yes";
            if(isset($_GET['viewUser'])){
              ?>
              <h4>User Contributions <span class="pull-right"><a href="?logs">Logs</a></span></h4>
              <?php
              $eyeD = $_GET['viewUser'];
              $respUser = $con->query("SELECT * FROM tbl_logs WHERE userId='$eyeD' ORDER BY id DESC");
              while($rowUser=$respUser->fetch_array()){
                //get user
                $respName = $con->query("SELECT * FROM tbl_users WHERE userID='$eyeD'");
                if($respName){
                  $rowName=$respName->fetch_array();
                }
            ?>
              <div class="list-group-item">
                <?php

                $negative = "No";
                if($rowName['online']==$negative){
                 ?>
                 <span style="color:red"><?php echo $rowName['userName'];?></span>
                 <?php
                }else{
                  ?>
                  <span><?php echo $rowName['userName'];?></span>
                  <?php
                }
                ?>
                <?php if($rowUser['updateData']===$Yes) { ?>
                  <span class="ribbon">
                      <div class="text">Edited</div>
                  </span>
                <?php }?>
                <span class="pull-right">Stack Number: <?php echo $rowUser['stackNumber'];?></span><br>
                <span class="fa fa-folder"><?php echo $rowUser['file'];?></span>
                <span class="pull-right">Post Time: <?php echo $rowUser['postTime'];?></span>
              </div>
            <?php
              }
              ?>
              <?php
            }elseif(isset($_GET['logs'])){
             ?>
             <h4>Contribution Logs</h4>
             <?php
             $y = 0;
             $respUsers = $con->query("SELECT * FROM tbl_logs ORDER BY id DESC");
             while($rowUsers=$respUsers->fetch_array()){
                $d = $rowUsers['userId'];
                   //get user
                   $respFileImage = $con->query("SELECT * FROM tbl_users WHERE userID='$d'");
                   if($respFileImage){
                     $rowFileImage=$respFileImage->fetch_array();
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
                       <?php if($rowUsers['updateData']===$Yes) { ?>
                         <span class="ribbon">
                             <div class="text">Edited</div>
                         </span>
                       <?php }?>
                     <span class="pull-right">Stack Number: <?php echo $rowUsers['stackNumber'];?></span><br>
                     <span class="fa fa-folder"><?php echo $rowUsers['file'];?></span>
                     <span class="pull-right">Post Time: <?php echo $rowUsers['postTime'];?></span>
                   </div>
                     <?php
                     }
                   }
                   ?>

             <?php
           }else{
            ?>
            <h4>Contribution Logs</h4>
            <?php
            $y = 0;
            $respUsers = $con->query("SELECT * FROM tbl_logs ORDER BY id DESC");
            while($rowUsers=$respUsers->fetch_array()){
               $d = $rowUsers['userId'];
                  //get user
                  $respFileImage = $con->query("SELECT * FROM tbl_users WHERE userID='$d'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
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
                      <?php if($rowUsers['updateData']===$Yes) { ?>
                        <span class="ribbon">
                            <div class="text">Edited</div>
                        </span>
                      <?php }?>
                    <span class="pull-right">Stack Number: <?php echo $rowUsers['stackNumber'];?></span><br>
                    <span class="fa fa-folder"><?php echo $rowUsers['file'];?></span>
                    <span class="pull-right">Post Time: <?php echo $rowUsers['postTime'];?></span>
                  </div>
                    <?php
                    }
                  }
                  ?>
            <?php
           }?>
            </div>
          </div>
        </div>
      </div>
        <div class="col-md-4">
          <div class="panel panel-default">

            <div class="panel-body">
              <h4>All users</h4>
            <div class="list-group">
          <?php
          $No = "No";
          $response = $con->query("SELECT * FROM tbl_users ORDER BY userID DESC");
            while($allusers = $response->fetch_array()){
              $ad = "admin";
              if($allusers['loginType']==$ad){
              ?>
              <div class="list-group-item">
              <span class="fa fa-circle" style="color:Blue;"></span><?php echo  $allusers['userName']; ?>
              <br>
              <span class=""><a href="?viewUser=<?php echo  $allusers['userID']; ?>" class="fa fa-folder-o">Veiw&nbsp&nbsp</a></span>
              <span class="pull-right text-muted">Administrator</span>
            </div>
              <?php
              }else{
                if($allusers['online']==$No){
                  ?>
                  <div class="list-group-item">
                  <span class="fa fa-circle" style="color:red;"><?php echo  $allusers['userName']; ?></span>
                  <div class='alert alert-danger'>
                  <button class='close' data-dismiss='alert'>&times;</button>
                  <strong>Deleted!</strong>  <?php echo  $allusers['userName']?> is no longer a user of this website.
                  </div>
                </div>
                <?php
                }else{
                if($allusers['status']==$No){
                ?>
                <div class="list-group-item">
                <span class="fa fa-circle" style="color:red;"></span><?php echo  $allusers['userName']; ?>
                <span class="pull-right"><a href="?deleteUser=<?php echo  $allusers['userID']; ?>" class="fa fa-trash"></a></span>
                <br>
                <span class=""><a href="?viewUser=<?php echo  $allusers['userID']; ?>" class="fa fa-folder-o">Veiw&nbsp&nbsp</a></span>
                <span class="pull-right"><a href="?grantPermision=<?php echo  $allusers['userID']; ?>" class="fa fa-check"></a></span>
                </div>
                <?php
                }else{
                ?>
                <div class="list-group-item">
                <span class="fa fa-circle" style="color:green;"></span><?php echo  $allusers['userName']; ?>
                <span class="pull-right"><a href="?deleteUser=<?php echo  $allusers['userID']; ?>" class="fa fa-trash"></a></span>
                <br>
                <span class=""><a href="?viewUser=<?php echo  $allusers['userID']; ?>" class="fa fa-folder-o">Veiw&nbsp&nbsp</a></span>
                <span class="pull-right"><a href="?limitPermision=<?php echo  $allusers['userID']; ?>" class="fa fa-times"></a></span>
                </div>
                <?php
                }
                ?>
                <?php
                }

              }

           }
          ?>
             </div>
           </div>
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

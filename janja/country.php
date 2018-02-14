

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
//country

if(isset($_POST['post_btn_country']))
    {
        $usercountry = $_POST['user_country'];// country
      
        
       
        if(empty($usercountry)){
            $errMSG = "Please insert country.";
        }
      

        // if no error occured, continue ....
        if(!isset($errMSG))
        {
          $_SESSION['userName']=$row['userName'];
            $stmt = $DB_con->prepare('INSERT INTO tbl_country(userName,userCountry,sendtime) VALUES(:uname,:ucountry,now())');
            $stmt->bindParam(':uname',$_SESSION['userName']);
            $stmt->bindParam(':ucountry',$usercountry);
            

            if($stmt->execute())
            {
              
               $successMSG = "successfully inserted new country...";
            }
            else
            {
                $errMSG = "error while inserting new country....";
            }
        }
    }
?>

<h2 id="sec2">Insert country</h2>
                <div class="row">
                <div class="col-md-12">
                <div class="panel panel-default">
                <div class="panel-body">
<form class="form-country" method="post" id="country-form" >
<fieldset>
  <?php
    if(isset($errMSG)){
            ?>
            <div class="alert alert-danger">
                <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
    }
    else if(isset($successMSG)){
        ?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
    }
    ?>
  <div class="form-group input-group">
  <span class="input-group-addon">Country&nbsp;&nbsp;&nbsp;&nbsp;</span>
      <input class="form-control" placeholder="Insert country" name="user_country"  autofocus required>
  </div>
   <div class="form-group">
            <button type="submit" class="btn btn-lg btn-success btn-block" name="post_btn_country" id="post_btn_country">
            <span class="glyphicon glyphicon-log-in"></span> &nbsp;Insert
            </button>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
  </fieldset>
  </form>
                </div>
                </div>
                </div>
                </div>
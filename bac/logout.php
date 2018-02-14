<?php

session_start();
require_once 'dbconfig.php';

//get the logged in user credentials and validate
require_once 'class.user.php';
$user_home = new USER();


$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt1 = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt1->execute(array(":uid"=>$_SESSION['userSession']));
$roww = $stmt1->fetch(PDO::FETCH_ASSOC);

$stmt2 = $user_home->runQuery("SELECT MAX(id) FROM tbl_login ");
$roww = $stmt2->fetch(PDO::FETCH_ASSOC);
//we can now access the users details from $row['appropriatedbfield']

$conn = mysqli_connect('localhost' , 'root' , 'kimatia7950', 'loginsession')or die ('problem to connect database');

$result = mysqli_query($conn , "select * from tbl_users where userEmail=:email_id ");
$email = $row['userEmail'];
$_SESSION['email'] = $email;

$query = mysqli_query($conn,"UPDATE tbl_users SET user_status = '0' WHERE userEmail = '$_SESSION[email]'");

$query = mysqli_query($conn,"UPDATE tbl_login SET logoutTime = 'w' WHERE userEmail = '$_SESSION[id]'");

$idd = $_SESSION['loginSession'];
$stmt_edit = $DB_con->prepare('SELECT * FROM tbl_login WHERE id =:uid ORDER BY id DESC LIMIT 1');
        $stmt_edit->execute(array(':uid'=>$idd));
        $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
        extract($edit_row);


$username=$edit_row['userName'];
$logintime=$edit_row['loginTime'];
$logouttime=$edit_row['LogoutTime'];
$userip=$edit_row['loginUserIp'];

$logeduser=$row['userName'];
$_SESSION['luser']=$logeduser;

$id=$row['user_login'];
$_SESSION['id']=$id;
$usercontent='now()';

$dee=$_SERVER['REMOTE_ADDR'];
  $_SESSION['REMOTE_ADDR']=$dee;


$logouttimenew=date("h:i:s a");
 $stmt2 = $DB_con->prepare('UPDATE tbl_login SET userName=:uname, loginTime=:logntime , logoutTime=:logttime , loginUserIp=:uip, logoutUserIp=:uip2 WHERE id=:uid  AND userName=:luser ');
            
            $stmt2->bindParam(':uname',$username);
            $stmt2->bindParam(':logntime',$logintime);
            $stmt2->bindParam(':logttime',$logouttimenew);
            $stmt2->bindParam(':uip',$userip);
            $stmt2->bindParam(':uip2',$_SESSION['REMOTE_ADDR']);
            $stmt2->bindParam(':uid',$_SESSION['id']);
            $stmt2->bindParam(':luser',$_SESSION['luser']);
            $stmt2->execute();

session_destroy();
if(!$user_home->is_logged_in())
{
 $user_home->redirect('login.php');
}

if($user_home->is_logged_in()!="")
{
 $user_home->logout();
 $user_home->redirect('login.php');
}
 echo "<script>window.location.assign('login.php')</script>";

?>

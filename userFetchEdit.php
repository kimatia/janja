






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
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<img src="upload/<?php echo $row['userPic']; ?>" height="150" width="150" class="round-img" alt="User Image"/>
</body>
</html>
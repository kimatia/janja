<?php
session_start();
include_once('config.php');
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

 $name = $row['userName'];
$_SESSION['name'] = $name;
if(isset($_POST['chat']))
{
$result = mysqli_query($conn , "INSERT INTO `loginsession`.`chat`(`chat_id`, `chat_person_name`,`chat_value`,`chat_time`VALUES (NULL,'$_SESSION[name]','$_POST[chat]',NOW());");
	
	}

?>
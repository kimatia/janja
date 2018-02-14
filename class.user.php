<?php

require_once 'dbconfig.php';

class USER
{

 private $conn;

 public function __construct()
 {
  $database = new Database();
  $db = $database->dbConnection();
  $this->conn = $db;
    }

 public function runQuery($sql)
 {
  $stmt = $this->conn->prepare($sql);
  return $stmt;
 }

 public function lasdID()
 {
  $stmt = $this->conn->lastInsertId();
  return $stmt;
 }

 public function register($uname,$email,$upass,$uphone,$uNatId,$uCity,$uCountry,$urole)
 {
  try
  {
   $password = md5($upass);
   $stmt = $this->conn->prepare("INSERT INTO tbl_users(userName,userEmail,userPass,userPhone,nationalId,userCity,userCountry,loginType)
    VALUES(:user_name, :user_mail, :user_pass, :user_phone, :natId,:city,:country, :user_type)");
   $stmt->bindparam(":user_name",$uname);
   $stmt->bindparam(":user_mail",$email);
   $stmt->bindparam(":user_pass",$password);
   $stmt->bindparam(":user_phone",$uphone);
   $stmt->bindparam(":natId",$uNatId);
   $stmt->bindParam(":city",$uCity);
   $stmt->bindParam(":country",$uCountry);
   $stmt->bindparam(":user_type",$urole);
   $stmt->execute();
   return $stmt;
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }

 public function login($email,$upass)
 {
  try
  {
   $stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
   $stmt->execute(array(":email_id"=>$email));
   $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

   if($stmt->rowCount() == 1)
   {
     if($userRow['userPass']==md5($upass))

  
     {
       if($userRow['loginType']=="admin"){
$_SESSION['userSession'] = $userRow['userID'];

$conn = mysqli_connect('localhost' , 'root' , 'kimatia7950', 'loginsession')or die ('problem to connect database');

$result = mysqli_query($conn , "select * from tbl_users where userEmail=:email_id ");
$email = $userRow['userEmail'];
$username = $userRow['userName'];
$_SESSION['email'] = $email;
$_SESSION['username'] = $username; 

$dee=$_SERVER['REMOTE_ADDR'];
   $_SESSION['REMOTE_ADDR']=$dee;
   $stmt = $this->conn->prepare("INSERT INTO tbl_login(userName,loginTime,loginUserIp)VALUES(:user_name,now(),:user_address)");
   $stmt->bindparam(":user_name",$username);
   $stmt->bindparam(":user_address",$_SESSION['REMOTE_ADDR']);    
   $stmt->execute();
$stmt = $this->conn->prepare("SELECT * FROM tbl_login WHERE userName=:name_id ORDER BY id DESC LIMIT 1");
   $stmt->execute(array(":name_id"=>$username));
   $row=$stmt->fetch(PDO::FETCH_ASSOC);

 $_SESSION['loginSession'] = $row['id'];

$query = mysqli_query($conn,"UPDATE tbl_users SET user_status = '1' WHERE userEmail = '$_SESSION[email]'");
$queryy = mysqli_query($conn,"UPDATE tbl_users SET user_login = '$_SESSION[loginSession]' WHERE userEmail = '$_SESSION[email]'");

   
           echo "<script>window.location.assign('adhome.php')</script>";
   
       }elseif($userRow['loginType']=="worker"){
        $_SESSION['userSession'] = $userRow['userID'];

$conn = mysqli_connect('localhost' , 'root' , 'kimatia7950', 'loginsession')or die ('problem to connect database');

$result = mysqli_query($conn , "select * from tbl_users where userEmail=:email_id ");
$email = $userRow['userEmail'];
$username = $userRow['userName'];
$_SESSION['email'] = $email;
$_SESSION['username'] = $username; 

$dee=$_SERVER['REMOTE_ADDR'];
   $_SESSION['REMOTE_ADDR']=$dee;
   $stmt = $this->conn->prepare("INSERT INTO tbl_login(userName,loginTime,loginUserIp)VALUES(:user_name,now(),:user_address)");
   $stmt->bindparam(":user_name",$username);
   $stmt->bindparam(":user_address",$_SESSION['REMOTE_ADDR']);    
   $stmt->execute();
$stmt = $this->conn->prepare("SELECT * FROM tbl_login WHERE userName=:name_id ORDER BY id DESC LIMIT 1");
   $stmt->execute(array(":name_id"=>$username));
   $row=$stmt->fetch(PDO::FETCH_ASSOC);

 $_SESSION['loginSession'] = $row['id'];

$query = mysqli_query($conn,"UPDATE tbl_users SET user_status = '1' WHERE userEmail = '$_SESSION[email]'");
$queryy = mysqli_query($conn,"UPDATE tbl_users SET user_login = '$_SESSION[loginSession]' WHERE userEmail = '$_SESSION[email]'");

         echo "<script>window.location.assign('home.php')</script>";
       }
     }
     else
     {
      header("Location: login.php?error");
      exit;
     }
   }
   else
   {
    header("Location: login.php?error");
    exit;
   }
 }catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }


 public function is_logged_in()
 {
  if(isset($_SESSION['userSession']))
  {
   return true;
  }
 }

 public function redirect($url)
 {
  header("Location: $url");
 }

 public function logout()
 {
  session_destroy();
  $_SESSION['userSession'] = false;
 }
}

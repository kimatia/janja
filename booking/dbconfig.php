
<?php global $con,$DB_con,$mysqli;
//oop PDO db connection2
   $DBhost = "localhost";
   $DBuser = "root";
   $DBpass = "kimatia7950";
   $DBname = "loginsession";
   
   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }
$conn = mysqli_connect('localhost' , 'root' , 'kimatia7950', 'loginsession')or die ('problem to connect database');
//PDO db connection1

  $DB_HOST = 'localhost';
  $DB_USER = 'root';
  $DB_PASS = 'kimatia7950';
  $DB_NAME = 'loginsession';
  
  try{
    $DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}",$DB_USER,$DB_PASS);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

     // connection2
//oop PDO db connection3
//database settings
$database_host      = 'localhost';
$database_username    = 'root';
$database_password    = 'kimatia7950';
$database_name      = 'loginsession';

//open mysql connection
$mysqli = new mysqli($database_host, $database_username, $database_password, $database_name);

//output error and exit if there's an error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
//connection3
//connection4


$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = "kimatia7950"; /* Password */
$dbname = "loginsession"; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}
//connection4
//oop db connection
class Database
{

    private $host = "localhost";
    private $db_name = "loginsession";
    private $username = "root";
    private $password = "kimatia7950";
    public $conn;

    public function dbConnection()
 {

     $this->conn = null;
        try
  {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
   $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
  catch(PDOException $exception)
  {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
$con = mysqli_connect('localhost','root','kimatia7950','loginsession');

if(!$con)
{
  echo 'unable to connect with db';
  die();
}
$conn = mysqli_connect('localhost' , 'root' , 'kimatia7950', 'loginsession')or die ('problem to connect database');


$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = "kimatia7950"; /* Password */
$dbname = "loginsession"; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}
?>

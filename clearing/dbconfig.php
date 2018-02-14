<?php global $con;

$con = mysqli_connect('localhost','root','kimatia7950','palm');

if(!$con)
{
  echo 'unable to connect with db';
  die();
}


//oop db connection
class Database
{

    private $host = "localhost";
    private $db_name = "palm";
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
?>

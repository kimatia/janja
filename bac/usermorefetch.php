<script type="text/javascript">
	function getText() {
    
  var $a =  document.getElementById('text').value;
  
    xhr = new XMLHttpRequest();
    xhr.open('POST' , 'chatdb.php',true);
    xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
    xhr.send('chat='+$a);
    xhr.onreadystatechange=function(){
      if (xhr.responseText){
      //  document.getElementById('chatarea').innerHTML=xhr.responseText;
                  }
        }
          }
          function getComment() {
    
  var $a =  document.getElementById('text').value;
  
    xhr = new XMLHttpRequest();
    xhr.open('POST' , 'comment.php',true);
    xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
    xhr.send('chat='+$a);
    xhr.onreadystatechange=function(){
      if (xhr.responseText){
      //  document.getElementById('chatarea').innerHTML=xhr.responseText;
                  }
        }
          }
</script>





    

             <?php
if(isset($_POST['btnsave']))
    {

      $name = $row['userName'];
$_SESSION['name'] = $name;
        $username = $_SESSION['name'];// user email
        $usercomment = $_POST['user_comment'];// user content
        
        $commentid=$row['chat_id'];
     
            $stmt = $DB_con->prepare('INSERT INTO comment(comment_id,comment_person_name,comment_value,comment_time) VALUES(:cid,:uname, :ucomment,now())');
            $stmt->bindParam(':uname',$username);
            $stmt->bindParam(':cid',$commentid);
            $stmt->bindParam(':ucomment',$usercomment);
          
           
            if($stmt->execute())
            {
                $successMSG = "comment successfully send ...";
               
            }
            else
            {
                $errMSG = "error while sending comment....";
            }
        
    }

include_once('dbconfig.php');
$conn = mysqli_connect('localhost' , 'root' , 'kimatia7950', 'loginsession')or die ('problem to connect database');
$result= mysqli_query($conn , "SELECT * FROM chat");
while ($row = mysqli_fetch_assoc($result)){
	//echo $row['chat_person_name']." :";
	//echo $row['chat_value']."<br>";
	
	}


  $_SESSION['userSession']=$_GET['more_id'];
   
    $stmt = $DB_con->prepare("SELECT * FROM tbl_users WHERE userID=:uid");
    $stmt->execute(array(":uid"=>$_SESSION['userSession']));

    if($stmt->rowCount() > 0)
    {
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            ?>
            <?php
            echo $row['userName']; 
            ?>
            <?php
        }
    }

?>

  
    

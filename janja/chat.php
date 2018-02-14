<?php
date_default_timezone_set("Africa/Nairobi");
session_start();
require_once 'dbconfig.php'; 
//get the logged in user credentials and validate
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('login.php');
}
$stmtt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmtt->execute(array(":uid"=>$_SESSION['userSession']));
$roww = $stmtt->fetch(PDO::FETCH_ASSOC);

//we can now access the users details from $row['appropriatedbfield']
 $stmt = $DB_con->prepare('SELECT * FROM tbl_messages ORDER BY id ASC');
 $stmt->execute();
?>

  <script>
  var timer=10;
  var view="";
  $(function (){
    function onTime(){
      setTimeout(onTime, 1000);
 
      if(timer==10){
       //alert("at 8")
  
       $.post("inbox.php",{viewing:view},function(data){
        $(".realTimeChat h5").html(data);
       })
       timer=11;
       clearTimeout(onTime); 
      }
      timer--;
    }

    onTime(); 
  });
</script>

<style type="text/css">
    
.chatLineHolder{
    height:360px;
    width:350px;
    margin-bottom:20px;
}

.chat{
    background:url('../img/chat_line_bg.jpg') repeat-x #d5d5d5;
    min-height:24px;
    padding:6px;
    border:1px solid #FFFFFF;
    
    padding:8px 6px 4px 37px;
    position:relative;
    margin:0 10px 10px 0;
}

.chat:last-child{
    margin-bottom:0;
}

.chat span{
    color:#777777;
    text-shadow:1px 1px 0 #FFFFFF;
    font-size:12px;
}

.chat .text{
    color:#444444;
    display:inline-block;
    font-size:15px;
    overflow:hidden;
    vertical-align:top;
    width:190px;
}


.chat img{
    display:block;
    
}

.chat .time{
    position:absolute;
    right:10px;
    top:12px;
    font-size:11px;
}

.chat .author{
    margin-right:0px;
    font-size:11px;
}



</style>







<?php
 

$idd=$_GET['more_id'];

 $_SESSION['sendTo']=$_GET['more_id'];
   
    $stmtto = $DB_con->prepare("SELECT * FROM tbl_users WHERE userID=:uid");
    $stmtto->execute(array(":uid"=>$_SESSION['sendTo']));
    if($stmtto->rowCount() > 0)
    {
        while($rowto=$stmtto->fetch(PDO::FETCH_ASSOC))
        {
            extract($rowto);
            $sendTo=$rowto['userName'];
            $_SESSION['sendTo']=$sendTo;
          }

          }


   
?>
<h3 style="color: black"><center><strong><?php echo "Chat with ".$sendTo;?></strong></center></h3>
<span id="messagee"></span> 
<div class="realTimeChat"><h5>Loading inbox chat...</h5></div>
 
  <form method="post" id="uploadimage" enctype="multipart/form-data" class="form-horizontal">
    
        <input class="form-control" type="text" name="user_content" id="name" placeholder="chat" />
        <input type="hidden" name="mid" value="<?php echo $idd;?>">
        <input type="hidden" name="sendTo" value="<?php echo $sendTo;?>">
        <input type="hidden" name="sid" value="<?php echo $sid;?>">

  </br>
         <button type="submit" name="btnsave" class="btn btn-success" onclick="javascript:PlaySound('sounds/sound_5.mp3');">
        <span class="glyphicon glyphicon-save"></span> &nbsp;send
        </button>
   
    
  </form>      

 

 
<!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

<script type="text/javascript">

function PlaySound(path) {
  var audioElement = document.createElement('audio');
  audioElement.setAttribute('src', path);
  audioElement.play();
}

</script>
  
    

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

include_once('dbconfig.php');
$conn = mysqli_connect('localhost' , 'root' , 'kimatia7950', 'loginsession')or die ('problem to connect database');
$result= mysqli_query($conn , "SELECT * FROM chat");
while ($row = mysqli_fetch_assoc($result)){
	//echo $row['chat_person_name']." :";
	//echo $row['chat_value']."<br>";
	
	}
    $stmt = $DB_con->prepare('SELECT * FROM chat ORDER BY chat_id DESC');
    $stmt->execute();

    if($stmt->rowCount() > 0)
    {
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            ?>
            <?php
            if(isset($_POST['btnsave']))
    {

       

        $name = $row['userName'];
        $_SESSION['name'] = $name;
        $username = $_SESSION['name'];// user email
        $usercomment = $_POST['user_comment'];// user content
        
        $commentid=$row['chat_id'];
         $_SESSION['cid'] = $commentid;
        $cid = $_SESSION['cid'];

            $stmt = $DB_con->prepare('INSERT INTO comment(comment_id,comment_person_name,comment_value,comment_time) VALUES(:cid,:uname, :ucomment,now())');
            $stmt->bindParam(':uname',$username);
            $stmt->bindParam(':cid',$cid);
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

            ?>
            <div class="col-md-12" style="padding-top: 1.8em;">
            <div id="slider">
    <div  class="rounded clear">
        <div class="row" style="background-color: purple;margin-left: 3px;margin-right: 3px;">
        <div class="panel-body">
         <p style="color: black;"><span class="glyphicon glyphicon-user"></span><?php echo $row['chat_person_name']; ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo "Date ".$row['chat_time'] ?></p>
    </br>
<div  class="rounded clear" style="background-color:#c091bb;">

                          
   
                                       <p style="color: black;"><center style="color: black;"><?php echo $row['chat_value']; ?></center></p>

                                    
                                   </br>
                                   <div class="thumbnail">
      <div class="port-7 effect-3">
                       <div id="portfolio-wrap">
                <!-- portfolio item -->
                    <div class="portfolio" >
                        <a href="upload/<?php echo $row['chat_pic']; ?>" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
                       <img src="upload/<?php echo $row['chat_pic']; ?>"  width="130px" height="100px" class="img-rounded"  />
                        <div class="portfolio-overlay">
                            <div class="thumb-info">
                                <h5 style="color: blue;"><?php echo $row['chat_person_name']; ?></h5>
                                <i class="icon-plus icon-2x"></i>
                            </div>
                        </div>
                        </a>
                    </div>
   <!-- end portfolio item -->
            </div>
            </div>
            </div>



</div>

                </div>


<div id="textbox" style="margin-left: 15px;margin-right: 15px;">

<div id="textbox">
<form>
<input class="form-control" type="text" name="user_comment" id="user_content" placeholder="comment" value="<?php echo $usercontent; ?>">
        <button type="submit" name="btncomment" value="send" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> &nbsp;send
        </button>
</form>
</div>
</div>
        </div>
        </div>
        </div>
        </div>
</div>
</div>
            <?php
        }
    }

?>

  
    

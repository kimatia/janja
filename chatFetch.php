


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
$stmtt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmtt->execute(array(":uid"=>$_SESSION['userSession']));
$roww = $stmtt->fetch(PDO::FETCH_ASSOC);
//we can now access the users details from $row['appropriatedbfield']
    

    

    $stmt = $DB_con->prepare('SELECT * FROM tbl_chat ORDER BY id DESC');
    $stmt->execute();

    if($stmt->rowCount() > 0)
    {
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
           
            if(isset($_POST['btnComment']))
    {

       

        $name = $roww['userName'];
        $_SESSION['name'] = $name;
        $usercomment = $_POST['user_comment'];// user content
        
        $commentid=$row['id'];
         $_SESSION['cid'] = $commentid;
       
            $stmt = $DB_con->prepare('INSERT INTO tbl_comment(commentID,commentUser,commentValue,commentTime) VALUES(:cid,:uname, :ucomment,now())');
            $stmt->bindParam(':uname',$_SESSION['name']);
            $stmt->bindParam(':cid', $_SESSION['cid']);
            $stmt->bindParam(':ucomment',$usercomment);
            $stmt->execute();   
        
    }
    if (isset($_POST['btnlike'])){
    //like

$idd = $row['id'];
$like_id = $DB_con->prepare('SELECT * FROM tbl_chat WHERE id =:uid');
        $like_id->execute(array(':uid'=>$idd));
        $like_row = $like_id->fetch(PDO::FETCH_ASSOC);
        extract($like_row);

$likeID=$like_row['id'];
  $userID = $row['userID'];
  $_SESSION['userID']=$userID;
  $type=0;

$stmt = $DB_con->prepare('INSERT INTO tbl_like(likeID,userID,likeType,likeTime) VALUES(:likeID,:userID,:likeType,now())');
            $stmt->bindParam(':likeID',$likeID);
            $stmt->bindParam(':userID',$_SESSION['userID']);
            $stmt->bindParam(':likeType',$type);
            $stmt->execute();
  

  

  }
  //like


            ?>

            <div class="col-md-12" style="padding-top: 1.8em;">
            <div id="slider">
    <div  class="rounded clear">
        <div class="row" style="background-color: purple;margin-left: 3px;margin-right: 3px;">
        <div class="panel-body">
         <p style="color: black;"><span class="glyphicon glyphicon-user"></span><?php echo $row['chatUser']; ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo "Date ".$row['chatTime'] ?></p>
    </br>
<div  class="rounded clear" style="background-color:#c091bb;">

                          
   
                                       <p style="color: black;"><center style="color: black;"><?php echo $row['chatValue']; ?></center></p>

                                    
                                   </br>
                                   <div id="slider">
     <div  class="rounded clear" style="background-color:#c091bb;">
                                   <div class="thumbnail">
      <div class="port-7 effect-3">
                       <div id="portfolio-wrap">
                <!-- portfolio item -->
                    <div class="portfolio" >
                        <a href="upload/<?php echo $row['chatPic']; ?>" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
                       <img src="upload/<?php echo $row['chatPic']; ?>"  width="130px" height="100px" class="img-rounded"  />
                        <div class="portfolio-overlay">
                            <div class="thumb-info">
                                <h5 style="color: blue;"><?php echo $row['chatUser']; ?></h5>
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
<span id="message5"></span>
</div>

                </div>


<div id="textbox" style="margin-left: 15px;margin-right: 15px;">

<div id="textbox">
<form>
<div class="row">

<div class="col-md-3">
  <div class="janja" ng-app='myapp'>
        <div class="content" ng-controller='fetchCtrl' >
            
            <div class="post" ng-repeat='post in posts'>
               
                <div class="post-action">

                    <input type="button" value="Like" class="like"  ng-click='setResponse(post.id,1,$index)' />&nbsp;(<span >{{ post.likes}}</span>)&nbsp;

                    <input type="button" value="Unlike" class="unlike"  ng-click='setResponse(post.id,0,$index)' />&nbsp;(<span >{{ post.unlikes }}</span>)

                </div>
            </div>
            
        </div>

        <!-- Script -->
     
    </div>
     
    
</div>
<div class="col-md-6">
<input class="form-control" type="text" name="user_comment" id="user_content" placeholder="comment and hit enter" value="<?php echo $usercontent; ?>">
   </div>
   

<div class="col-md-3">
   <a class="btn btn-danger" href="adhome.php?deletechat_id=<?php echo $row['id'];?>" title="click to delete chat" ><span class="glyphicon glyphicon-remove-circle"></span> &nbsp;Delete</a> 
   </div>
   </div>  
        </br>
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

  
    

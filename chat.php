
 <script src="js/angular.min.js"></script>
        <script>
        var fetch = angular.module('myapp', []);
        fetch.controller('fetchCtrl', ['$scope', '$http', function ($scope, $http) {
             
                // Fetch post data
                $scope.getPosts = function(){
             
                    $http({
                        method: 'post',
                        url: 'janjachat.php',
                        data: {request: 1}
                    }).then(function successCallback(response) {
                
                        $scope.posts = response.data;
                    });

                }

                $scope.getPosts(); // Fetch post data
             
                // Update user response on a post
                $scope.setResponse = function(postid,type,index){
                
                    $http({
                        method: 'post',
                        url: 'janjachat.php',
                        data: {postid: postid,type: type, request: 2}
                    }).then(function successCallback(response) {
                        // Update total likes unlikes values on the post
                        $scope.posts[index].likes=response.data.likes;
                        $scope.posts[index].unlikes=response.data.unlikes;
                        $scope.posts[index].type=response.data.type;
                    });
                }
            }
        ]);

        </script>
        <script>
  
</script>


<!DOCTYPE html>
<html>
<head>
<title>Janja | Admin</title>
<!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

     <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Begin emoji-picker Stylesheets -->
    <link href="lib/css/emoji.css" rel="stylesheet">
    <!-- End emoji-picker Stylesheets -->
    <!-- Custom Fonts -->
<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="css/style3.css" />
    <script src="bower_components/modernizr/modernizr.js"></script>
     <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/foundation/js/foundation.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/reveal.js"></script>
<script src="js/angular.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!--chat-->
<link rel="stylesheet" type="text/css" href="js/jScrollPane/jScrollPane.css" />
<link rel="stylesheet" type="text/css" href="css/page.css" />
<link rel="stylesheet" type="text/css" href="css/chat.css" />

<script src="js/jScrollPane/jquery.mousewheel.js"></script>
<script src="js/jScrollPane/jScrollPane.min.js"></script>

</head>

 <body ng-app='myapp'>
        <div  ng-controller='fetchCtrl' >
            
            <div ng-repeat='post in posts'>
               


             <?php


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
$row = $stmtt->fetch(PDO::FETCH_ASSOC);
//we can now access the users details from $row['appropriatedbfield']
  	

            ?>

            <div class="col-md-12" style="padding-top: 1.8em;">
            <div id="slider">
    <div  class="rounded clear" style="background-color: purple;margin-left: 3px;margin-right: 3px;">
        <div class="row" >
        <div class="panel-body">
         <p style="color: black;"><span class="glyphicon glyphicon-user"></span>{{ post.chatuser}}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{ post.chattime}}</p>
    </br>
<div  class="rounded clear" style="background-color:cream;">

                          
   
                                       <p style="color: black;"><center style="color: black;">{{ post.chatvalue}}</center></p>

                                    
                                   </br>
                                   <div id="slider">
     <div  class="rounded clear" style="background-color:cream;">
                                   <div class="thumbnail">
      <div class="port-7 effect-3">
                       <div id="portfolio-wrap">
                <!-- portfolio item -->
                    <div class="portfolio" >
                    <div  class="rounded clear" >

                        <a href="upload/{{ post.chatpic}}" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
                       <img src="upload/{{ post.chatpic}}"  width="130px" height="100px" class="img-rounded"  />
                        <div class="portfolio-overlay">
                            <div class="thumb-info">
                                <h5 style="color: blue;"><strong>{{ post.chatuser}}</strong></h5>
                                <i class="icon-plus icon-2x"></i>
                            </div>
                        </div>
                        </a>
                    </div>
                    </div>
   <!-- end portfolio item -->
            </div>
            </div>
            </div>

</div>
</div>

</div>

                </div>
<div class="row">
    <div class="col-md-4">
       <div class="post-action">
                    
                    <a value="Like" class="like"  ng-click='setResponse(post.id,1,$index)' /><img src="images/like.png" alt="Post" style="height: 25px ;width: 25px ;" onclick="javascript:PlaySound('sounds/sound_5.mp3');"></a>(<span ><strong>{{ post.likes}}</strong></span>)&nbsp;

                    <a value="Unlike" class="unlike"  ng-click='setResponse(post.id,0,$index)' /><img src="images/unlike.png" alt="Post" style="height: 25px ;width: 25px ;" onclick="javascript:PlaySound('sounds/sound_6.mp3');"></a>(<span ><strong>{{ post.unlikes }}</strong></span>)
                    <!-- Script -->
        
                </div>  
    </div>
     <div class="col-md-7">
<form method="post" id="uploadimage"  enctype="multipart/form-data" class="form-horizontal">
       <div class="row">
           <div class="col-md-10">
           <p class="lead emoji-picker-container">
              <input class="form-control" type="text" data-emojiable="true" name="user_content" id="user_content" placeholder="comment" />
              </p>
             <input type="hidden"  type="text" name="user_id" value="<?php echo $roww['userID'];?>" />
             <input type="hidden"  type="text" name="user_name" value="<?php echo $roww['userName'];?>" />  
           </div>
       
        <div class="col-md-2">
        <a   href="?deletee_id={{id}}" title="click to delete user" onclick="javascript:PlaySound(sounds/sound_2.mp3);"><span class="btn-danger form-control glyphicon glyphicon-remove-circle" ></span> </a>
        </div>
</div>       
</form> 
    </div>
   
</div>

                
        </div>
        </div>
        </div>
        </div>
     
            </div>
            
        </div>

          <script src="js/jquery.js"></script>

    <!-- Begin emoji-picker JavaScript -->
    <script src="js/config.js"></script>
    <script src="js/util.js"></script>
    <script src="js/jquery.emojiarea.js"></script>
    <script src="js/emoji-picker.js"></script>
    <!-- End emoji-picker JavaScript -->

    <script>
      $(function() {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: 'lib/img/',
          popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
      });
    </script>
    <script>
      // Google Analytics
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-49610253-3', 'auto');
      ga('send', 'pageview');
    </script>
 <script type="text/javascript">

function PlaySound(path) {
  var audioElement = document.createElement('audio');
  audioElement.setAttribute('src', path);
  audioElement.play();
}

</script>
    </body>

</html>

<?php




session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
include "dbconfig.php";
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
  
$data = json_decode(file_get_contents("php://input"));

$request = $data->request;
$userid = $row['userID'];

// Get all posts list and like unlike
if($request == 1){
	
	$response_arr = array();
	
    $query = "SELECT * FROM tbl_chat ORDER BY id DESC";
    $result = mysqli_query($con,$query);

    while($row = mysqli_fetch_array($result)){
        $postid = $row['id'];
        $type = -1;
        $daa= $row['chatUser'];
        $dee= $row['chatTime'];
        $dii= $row['chatValue'];
        $doo= $row['chatPic'];

        // Checking user status
        $status_query = "SELECT count(*) as cntStatus,type FROM like_unlike WHERE userid=".$userid." and postid=".$postid;
        $status_result = mysqli_query($con,$status_query);
        $status_row = mysqli_fetch_array($status_result);
        $count_status = $status_row['cntStatus'];
        if($count_status > 0){
            $type = $status_row['type'];
        }

        // Count post total likes and unlikes
        $like_query = "SELECT COUNT(*) AS cntLikes FROM like_unlike WHERE type=1 and postid=".$postid;
        $like_result = mysqli_query($con,$like_query);
        $like_row = mysqli_fetch_array($like_result);
        $total_likes = $like_row['cntLikes'];

        $unlike_query = "SELECT COUNT(*) AS cntUnlikes FROM like_unlike WHERE type=0 and postid=".$postid;
        $unlike_result = mysqli_query($con,$unlike_query);
        $unlike_row = mysqli_fetch_array($unlike_result);
        $total_unlikes = $unlike_row['cntUnlikes'];
         
 
        $response_arr[] = array("chatuser"=>$daa,"chattime"=>$dee,"chatvalue"=>$dii,"chatpic"=>$doo, "id" => $postid, "title" => $title, "content" => $content, "likes" => $total_likes, "unlikes" => $total_unlikes, "type" => $type);
    }

    echo json_encode($response_arr);
    exit;
}

// Update user response on a post
if($request == 2){
	$postid = $data->postid;
	$type = $data->type;

	// Check entry within table
	$query = "SELECT COUNT(*) AS cntpost FROM like_unlike WHERE postid=".$postid." and userid=".$userid;

	$result = mysqli_query($con,$query);
	$fetchdata = mysqli_fetch_array($result);
	$count = $fetchdata['cntpost'];

	if($count == 0){
	    $insertquery = "INSERT INTO like_unlike(userid,postid,type) values(".$userid.",".$postid.",".$type.")";
	    mysqli_query($con,$insertquery);
	}else {
	    $updatequery = "UPDATE like_unlike SET type=" . $type . " where userid=" . $userid . " and postid=" . $postid;
	    mysqli_query($con,$updatequery);
	}

	// count numbers of like and unlike in post
	$query = "SELECT COUNT(*) AS cntLike FROM like_unlike WHERE type=1 and postid=".$postid;
	$result = mysqli_query($con,$query);
	$fetchlikes = mysqli_fetch_array($result);
	$totalLikes = $fetchlikes['cntLike'];

	$query = "SELECT COUNT(*) AS cntUnlike FROM like_unlike WHERE type=0 and postid=".$postid;
	$result = mysqli_query($con,$query);
	$fetchunlikes = mysqli_fetch_array($result);
	$totalUnlikes = $fetchunlikes['cntUnlike'];


	$return_arr = array("likes"=>$totalLikes,"unlikes"=>$totalUnlikes,"type" => $type);

	echo json_encode($return_arr);
	exit;
}

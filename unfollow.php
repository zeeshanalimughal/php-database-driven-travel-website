<?php  
require "database/conn.php";
$unfollowId = $_GET['unfollowId'];
$sqlUnfollow = "DELETE FROM traveluserfollowing WHERE UIDFollowing = {$unfollowId} AND UID = {$_SESSION['logged-in-id']}";
$res = mysqli_query($conn,$sqlUnfollow);
if($res){
    header("Location:myaccount.php");
}
?>
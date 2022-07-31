<!DOCTYPE html>
<html lang="en">

<?php
require "database/conn.php";

$sqlInsertFollow = "INSERT INTO `traveluserfollowing`(`UID`, `UIDFollowing`) VALUES ('{$_SESSION['logged-in-id']}','{$_GET['userId']}')";
$res = mysqli_query($conn,$sqlInsertFollow);
if($res){
    header("Location:myaccount.php");
}else{
   $_SESSION['following'] = "You already following him";
   header("Location:users.php");
}
?>
<!-- SELECT * FROM `traveluserfollowing` INNER JOIN traveluserdetails ON traveluserdetails.UID = traveluserfollowing.UIDFollowing WHERE traveluserfollowing.UID = 2; -->
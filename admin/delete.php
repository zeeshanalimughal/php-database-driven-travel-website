<?php
require "../database/conn.php";
if (!isset($_SESSION['logged-in']) || $_SESSION['logged-in'] !== "admin@gmail.com") {
    header("Location:http://localhost/travel/");
}
$uid = $_GET['id'];
$sqlDelete1 = "DELETE FROM traveluserdetails WHERE UID  = $uid";
$sqlDelete2 = "DELETE FROM traveluser WHERE UID  = $uid";
$del1 = mysqli_query($conn,$sqlDelete1);
if($del1){
    $del2 = mysqli_query($conn,$sqlDelete2);
    if($del2){
        $_SESSION['updated'] = "User deleted successfully";
        header("Location:index.php");
    }
}

?>
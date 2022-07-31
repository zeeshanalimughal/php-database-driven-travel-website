<?php 
require "database/conn.php";
if(isset($_GET['id'])){
$imageID = $_GET['id'];
if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] === "admin@gmail.com") {
$deleteSql = "UPDATE travelimage SET TravelImageReview = NULL WHERE ImageID = $imageID ";
        $res = mysqli_query($conn,$deleteSql);
        if($res){
            header("Location:singleImage.php?imageId={$imageID}");
        }
    }
}
?>
<?php
require "database/conn.php";
if (!isset($_SESSION['logged-in'])) {
    header("Location:index.php");
} else {
    if (isset($_GET['favId'])) {
        $sqlForFavourits = "SELECT * FROM `travelimage` INNER JOIN travelimagedetails ON travelimage.ImageID=travelimagedetails.ImageID WHERE travelimage.ImageID = {$_GET['favId']}";
        $res = mysqli_query($conn, $sqlForFavourits);
        $data = mysqli_fetch_assoc($res);
        // echo $data['Path'];
        if (!isset($_SESSION['favPlaces'])) {
            $_SESSION['favPlaces'] = [];
        }
        array_push($_SESSION['favPlaces'], array(
            "ImageID" => $data['ImageID'],
            "ImagePath" => $data['Path'],
            "Title" => $data['Title'],
            "Description" => $data['Description']
        ));
        //   echo  $_SESSION['favPlaces']['Title'];
        // foreach ($_SESSION['favPlaces'] as $fav) {
        //     echo "<pre>";
        //     print_r($fav['ImageID']);
        // }
        header("Location:fav.php");
    }
}

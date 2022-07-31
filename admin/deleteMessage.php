<?php
require "../database/conn.php";
if (!isset($_SESSION['logged-in']) || $_SESSION['logged-in'] !== "admin@gmail.com") {
    header("Location:http://localhost/travel/");
}
$uid = $_GET['id'];
$sqlMessage = "DELETE FROM contact WHERE id  = $uid";

$del1 = mysqli_query($conn,$sqlMessage);
if($del1){
        $_SESSION['updated'] = "Message deleted successfully";
        header("Location:messages.php");
}

?>
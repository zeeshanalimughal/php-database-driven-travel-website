<?php
require "database/conn.php";

unset($_SESSION['favPlaces']);

header("Location:singleImage.php?imageId={$_GET['favId']}");

?>


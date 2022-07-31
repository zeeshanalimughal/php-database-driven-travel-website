<?php
require "database/conn.php";
session_destroy();
unset($_SESSION['logged-in']);
header("Location:home.php");
?>
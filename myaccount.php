<?php
require "database/conn.php";
if(! isset($_SESSION['logged-in'])){
    header("Location:index.php");
}
$yourId =  $_SESSION['logged-in-id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "links.php";  ?>
  <link rel="stylesheet" href="assets/css/myaccount.css">
    <title>Account</title>
</head>

<body>
<?php include "nav.php";  ?>

<div class="container-fluid">
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row d-flex justify-content-center ">
            <div class="col-xl-10 col-md-12">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0 ">
                        <div class="position-relative col-sm-4 bg-dark user-profile">
                            <div class=" card-block text-center text-white">
                                <h6 class="f-w-600" style="font-size: 2rem;"><?php echo $loggedInUser['FirstName'].' '.$loggedInUser['LastName']  ?></h6>
                                <p style="font-size: 1rem;"><?php echo $loggedInUser['Email'];  ?></p> <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16 mb-4"></i>
                                  <h4 class="text-white" style="margin-top: 5rem;">
                                    Following
                                  </h4>
                           
                                <ul class="list-unstyled mt-3">
                                <?php 
                                  $sqlSelectFollowing = "SELECT * FROM `traveluserfollowing` INNER JOIN traveluserdetails ON traveluserdetails.UID = traveluserfollowing.UIDFollowing WHERE traveluserfollowing.UID = $yourId;";
                                  $resFollowing = mysqli_query($conn,$sqlSelectFollowing);
                                  if(mysqli_num_rows($resFollowing)>0){
                                      while($followingData = mysqli_fetch_assoc($resFollowing)){
                                  
                                  ?>
                                  <a class="text-decoration-none" style="font-size: 18px; color: black;">
                                    <li class="bg-white d-grid  mx-4 rounded-2 mb-2">
                                    <?php echo $followingData['FirstName'].' '.$followingData['LastName'];  ?>

                                    <a class="text-decoration-none pb-1" style=" color: gray;" href="unfollow.php?unfollowId=<?php echo $followingData['UIDFollowing']  ?>">unfollow</a>
                                    </li>
                                  </a>
                                <?php   }} ?>
                                </ul>

                                <a class="btn btn-outline-light" href="logout.php">Logout</a>
                            </div>
                        </div>
                        <div class="col-sm-8">
                          <h1 class="display-6 text-center mt-4">My Account</h1>
                            <div class="card-block">
                                <h6 style="font-size: 2rem !important;"  class="mb-5 pb-2 b-b-default f-w-600">Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p style="font-size: 1.2rem !important;" class="m-b-10 f-w-600">Email</p>
                                        <h6 style="font-size: 1.2rem !important;" class="text-muted f-w-400"><?php echo $loggedInUser['Email'];  ?></h6>
                                    </div>
                                    <div  class="col-sm-6">
                                        <p style="font-size: 1.2rem !important;" class="m-b-10 f-w-600">Phone</p>
                                        <h6 style="font-size: 1.2rem !important;" class="text-muted f-w-400"><?php echo $loggedInUser['Phone'];  ?></h6>
                                    </div>
                                </div>
                                <h6 style="font-size: 2rem !important;" class="mb-5 m-t-40 pb-2 b-b-default f-w-600">Address</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p style="font-size: 1.2rem !important;" class="m-b-10 f-w-600">Address</p>
                                        <h6 style="font-size: 1.2rem !important;" class="text-muted f-w-400 m-b-20"><?php echo $loggedInUser['Address'];  ?></h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p style="font-size: 1.2rem !important;" class="m-b-10 f-w-600">City</p>
                                        <h6 style="font-size: 1.2rem !important;" class="text-muted f-w-400 m-b-20"><?php echo $loggedInUser['City'];  ?></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p style="font-size: 1.2rem !important;" class="m-b-10 f-w-600">Country</p>
                                        <h6 style="font-size: 1.2rem !important;" class="text-muted f-w-400"><?php echo $loggedInUser['Country'];  ?></h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p style="font-size: 1.2rem !important;" class="m-b-10 f-w-600">Postal</p>
                                        <h6 style="font-size: 1.2rem !important;" class="text-muted f-w-400"><?php echo $loggedInUser['Postal'];  ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php  include "footer.php" ?>

    <script src="assets/js/script.js"></script>
</body>

</html>
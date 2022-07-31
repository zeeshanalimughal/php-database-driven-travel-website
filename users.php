<?php
include "database/conn.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "links.php";  ?>
    <title>Users</title>
</head>

<body>
    <?php include "nav.php";  ?>
    <div class="container-fluid p-3 profile-page">
    <?php if (isset($_SESSION['following'])) {
                                        echo '<div class="col-3"><p class="bg-light rounded-2 text-dark text-center p-1">
                                   ' . $_SESSION['following'] . '</p></div>';
                                        unset($_SESSION['following']);
                                    }  ?>
        <div class="row">
            <h1 class="display-6">
                All Users
            </h1>
            <div class="col-md-10">
                <div class="row">
                    <?php
                    $selectUserDetails = "SELECT * FROM traveluserdetails";
                    $results = mysqli_query($conn, $selectUserDetails);
                    $totposts = 0;

                    while ($data = mysqli_fetch_assoc($results)) {
                        $selectCountPostsByUser = "SELECT COUNT(PostID) FROM `travelpost` INNER JOIN traveluserdetails ON travelpost.UID=traveluserdetails.UID WHERE traveluserdetails.UID = {$data['UID']};";
                        $res = mysqli_query($conn, $selectCountPostsByUser);
                        $row = mysqli_fetch_array($res);


                    ?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                            <div class="card profile-header p-2" style="height: 230px !important;">
                                <div class="body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <h4 class="m-t-0 m-b-0"><strong><?php echo $data['FirstName'] . ' ' . $data['LastName'];  ?></strong></h4>
                                            <span class="job_post"><?php echo $data['Email'];  ?></span>
                                            <p><?php echo $data['Address'] . ', ' . $data['City'] . ', ' . $data['Country'];  ?></p>
                                            <p style="line-height: .2rem;" class="card-text">Total Posts <strong style="font-size: 18px; margin-left: 10px;"><?php echo $row[0]; ?></strong> </p>
                                            <div>
                                                <?php  
                                                 if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] !== "admin@gmail.com") {
                                                    ?>
                                    
                                                <a class="btn btn-outline-dark btn-round" href="followProcess.php?userId=<?php echo $data['UID']; ?>">
                                               Follow
                                                </a>

                                                <?php } ?>

                                                
                                                <a class="btn btn-outline-dark btn-round" href="postsByUsers.php?userId=<?php echo $data['UID'];  ?>">
                                               View All Posts
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php }  ?>
                </div>
            </div>
            <div class="col-2 d-lg-block d-sm-none">
               <div class="image-box" style="max-height: 500px;position: relative;">
                   <img src="assets/images/banner.jpg" style="width: 100%; height: 100%; object-fit: cover;" class="img-fluid" alt="">
                   <h3 style="position: absolute; top: 65%; left: 50%; transform: translateX(-50%); color: #fff; width: 100%; text-align: center;">
                       Simle Banner
                   </h3>
               </div>
            </div>
        </div>
    </div>

    <?php  include "footer.php" ?>

    <script src="assets/js/script.js"></script>
</body>

</html>
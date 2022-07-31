<?php
require "database/conn.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "links.php";  ?>
    <title>Users Posts</title>
</head>
<body>
    <?php include "nav.php";  ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <?php 
                $selectAuthorName = "SELECT FirstName,LastName FROM traveluserdetails WHERE traveluserdetails.UID = '{$_GET['userId']}'";
                $resultAuthor = mysqli_query($conn,$selectAuthorName);
                $AuthorName = mysqli_fetch_assoc($resultAuthor);
                ?>
                <h1 class="my-3">Posts by <?php echo $AuthorName['FirstName'].' '.$AuthorName['LastName'];?></h1>
                <div class="row mb-2 mt-4">
                    <?php
                    $selectAllPosts = "SELECT * FROM `travelpost` INNER JOIN travelimage ON travelimage.ImageID = travelpost.PostID INNER JOIN traveluserdetails ON traveluserdetails.UID = travelpost.UID WHERE traveluserdetails.UID = '{$_GET['userId']}' GROUP BY travelpost.PostID;";
                    $posRes = mysqli_query($conn, $selectAllPosts);
                    if (mysqli_num_rows($posRes) > 0) {
                        while ($posts = mysqli_fetch_assoc($posRes)) {

                    ?>
                            <div class="col-md-6">
                                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-3 shadow-sm h-md-250 position-relative">
                                    <div class="col-lg-6 col-xsm-12 p-3 d-flex flex-column position-static">
                                       
                                        <h5 class="mb-2"><?php echo  $posts['Title']; ?></h5>
                                        <div class="text-muted"><?php echo  $posts['PostTime']; ?></div>
                                        <p class=""><?php
                                                    if (strlen($posts['Message']) > 30) {
                                                        $subMessage = substr($posts['Message'], 0, 40);
                                                        echo $subMessage . '. . .';
                                                    }

                                                    ?></p>
                                        <a href="viewSinglePost.php?postId=<?php echo  $posts['PostID']; ?>" class="btn btn-outline-dark">Continue reading</a>
                                    </div>
                                    <div class="col-6 d-none d-lg-block">
                                        <img style="max-height: 190px; object-fit: cover;" src="<?php echo 'assets/images/medium/' . $posts['Path'] ?>">

                                    </div>
                                </div>
                            </div>

                    <?php  }
                    } else {
                        echo '<h1 class="my-3">No post is available</h1>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <h3 class="categories">

                </h3>
            </div>
        </div>
    </div>
    <script src="assets/js/script.js"></script>

    <?php include "footer.php" ?>

</body>
</html>
<?php
require "database/conn.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "links.php";  ?>
  <title>Single Post</title>
</head>

<body>
  <?php include "nav.php";  ?>

  <?php
  $id = $_GET['postId'];

  $selectSinglePost = "SELECT * FROM `travelpost` INNER JOIN travelimage ON travelimage.ImageID = travelpost.PostID INNER JOIN traveluserdetails ON traveluserdetails.UID = travelpost.UID WHERE travelpost.PostID=$id GROUP BY travelpost.PostID;
  ";

  $posRes = mysqli_query($conn, $selectSinglePost);
  $singlePost = mysqli_fetch_assoc($posRes);
  ?>
  <div class="container-fluid p-0 m-0">
    <div class="post-image position-relative bg-dark" style="height: 500px">
      <img src="<?php echo 'assets/images/large/' . $singlePost['Path'] ?>" style="height: 100%; width: 100%; object-fit: cover; object-position: center;" alt="">

    </div>
    <div class="container">
      <div class="row mt-4">
        <div class="col-md-9">
          <h1 class="display-6">
            <?php echo  $singlePost['Title']; ?>
          </h1>
          <div class="text-muted"><b><i>Posted on:&nbsp;&nbsp; </i></b><?php echo  $singlePost['PostTime']; ?></div>
          <div class="text-muted"><b><i>Author: &nbsp;&nbsp;</i></b><?php echo  $singlePost['FirstName'] . ' ' . $singlePost['LastName']; ?></div>
          <div class="text-muted"><b><i>From: &nbsp;&nbsp;</i></b><?php echo  $singlePost['City'] . ', ' . $singlePost['Country']; ?></div>
          <div class="text-muted pb-3"><b><i>Email: &nbsp;&nbsp;</i></b><?php echo  $singlePost['Email']; ?></div>

          <p><?php echo  $singlePost['Message']; ?></p>
        </div>
        <div class="col-3">
          <div class="categories">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center pb-3">Related Posts</h5>
                <ul>

                  <?php
                  
                  // Related posts base on courrent post city,country or author name
                  $selectRelatedPosts = "SELECT * FROM `travelpost` INNER JOIN travelimage ON travelimage.ImageID = travelpost.PostID INNER JOIN traveluserdetails ON traveluserdetails.UID = travelpost.UID WHERE traveluserdetails.Country ='{$singlePost['Country']}' OR traveluserdetails.City = '{$singlePost['City']}' OR traveluserdetails.FirstName = '{$singlePost['FirstName']}' GROUP BY travelpost.PostID;
                  ";

                  $releatedPostsResults = mysqli_query($conn, $selectRelatedPosts);

                  if (mysqli_num_rows($releatedPostsResults) > 0) {
                    while ($allReleatedPosts = mysqli_fetch_assoc($releatedPostsResults)) {
                  ?>
                      <div class="my-2" style="border-bottom: 1px solid lightgray;">
                        <a class="text-decoration-none py-3 text-dark" href="viewSinglePost.php?postId=<?php echo $allReleatedPosts['PostID']  ?>">
                          <li class="list-unstyled"><b><?php echo $allReleatedPosts['Title']  ?></b></li>
                          <span class=""><?php
                                          if (strlen($allReleatedPosts['Message']) > 30) {
                                            $subMessage = substr($allReleatedPosts['Message'], 0, 35);
                                            echo $subMessage . '...';
                                          }
                                          ?></span>
                        </a>
                      </div>
                  <?php
                    }
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include "footer.php" ?>

  <script src="assets/js/script.js"></script>
</body>

</html>
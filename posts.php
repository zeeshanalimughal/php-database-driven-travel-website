<?php
require "database/conn.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "links.php";  ?>
  <title>Posts</title>
</head>

<body>
  <?php include "nav.php";  ?>


  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 col-sm-12">
        <h1 class="my-3 text-center">All Posts</h1>
        <div class="row mb-2">

          <?php
          $selectAllPosts = "SELECT * FROM `travelpost` INNER JOIN travelimage ON travelimage.ImageID = travelpost.PostID GROUP BY travelpost.PostID;

          ";

          $posRes = mysqli_query($conn, $selectAllPosts);

          while ($posts = mysqli_fetch_assoc($posRes)) {

          ?>
            <div class="col-md-6">
              <div class="row g-0 border rounded overflow-hidden flex-md-row mb-3 shadow-sm h-md-250 position-relative">
                <div class="col-lg-6 col-xsm-12 p-3 d-flex flex-column position-static">
                  <!-- <strong class="d-inline-block mb-2 text-success">Design</strong> -->
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
          <?php  } ?>
        </div>
      </div>
      <div class="col-md-2 d-lg-block d-sm-none mt-5 pt-5">
        <div class="image-box" style="max-height: 500px;position: relative;">
          <img src="assets/images/banner2.jpg" style="width: 100%; height: 100%; object-fit: cover;" class="img-fluid" alt="">
          <h3 style="position: absolute; top: 65%; left: 50%; transform: translateX(-50%); color: #fff; width: 100%; text-align: center;">
            Simle Banner
          </h3>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/script.js"></script>

  <?php include "footer.php" ?>

</body>

</html>
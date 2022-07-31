<?php
require "database/conn.php";
$imageId = $_GET['imageId'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "links.php"  ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Single Place</title>
</head>

<body>
    <?php
    include "nav.php";
    ?>
    <?php
    $selectSingleImageDetails = "SELECT * FROM `travelimage` INNER JOIN travelimagedetails ON travelimage.ImageID=travelimagedetails.ImageID
    INNER JOIN travelimagerating ON travelimagerating.ImageID = travelimagedetails.ImageID
    INNER JOIN travelpostimages ON travelpostimages.ImageID = travelimagedetails.ImageID
    WHERE travelimagedetails.ImageID = $imageId;";

    $result = mysqli_query($conn, $selectSingleImageDetails);

    $data = mysqli_fetch_assoc($result);

    ?>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <div class="image-single-show">
                    <img src="<?php echo  "assets/images/large/" . $data['Path'];  ?>" alt="<?php echo  $data['Path']; ?>" srcset="">

                </div>
            </div>
            <div class="col-md-3 col-sm-12">

                <a class="btn btn-outline-dark" role="button" id="btnOpen">
                    Open Google Map
                </a>
                <a class="btn btn-outline-dark" role="button" id="btnClose">
                    Close Google Map
                </a>

                <div class="card card-body mapCard mt-2">
                    <iframe src="<?php echo 'https://maps.google.com/maps?q=' . $data['Latitude'] . ',' . $data['Longitude'] . '&hl=es;z=14&amp;output=embed'  ?>" style="width: 100%; height: 500px;"></iframe>
                </div>
            </div>
        </div>
        <div class="row mt-2 m-r-0 mx-4">
            <div class="col-12 px-lg-5 mx-lg-5">
                <div class="details">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6">
                            <h3 class="imageTitle py-2" style="line-height: 3rem;">
                                <?php echo $data['Title']  ?>
                            </h3>
                        </div>
                        <?php
                        if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] !== "admin@gmail.com") {
                        ?>
                            <?php
                            if (isset($_SESSION['favPlaces'])) {
                                foreach ($_SESSION['favPlaces'] as $fav) {
                                    $cond = true;
                                    if ($fav['ImageID'] === $data['ImageID']) {
                                        $cond = true;
                                    } else {
                                        $cond = false;
                                    }
                                }
                            }
                            if (
                                isset($_SESSION['favPlaces']) && $cond === true
                            ) {
                            ?>
                                <div class="col-md-3">
                                    <a href="removeFavourits.php?favId=<?php echo $data['ImageID'] ?>" class="btn btn-outline-dark d-grid w-75">Remove All Favourits</a>
                                </div>

                            <?php

                            } else {
                            ?>
                                <div class="col-md-3">
                                    <a href="addToFave.php?favId=<?php echo $data['ImageID'] ?>" class="btn btn-outline-dark d-grid w-75">Add to favourites</a>
                                </div>

                            <?php
                            }
                            ?>
                        <?php
                        }
                        ?>

                    </div>
                    <p class="imageDescription">
                        <?php
                        if ($data['Description'] == "") {
                            echo "Description not found";
                        } else {
                            echo $data['Description'];
                        }
                        ?>
                    </p>
                    <?php
                    $selectAverageRating = "SELECT AVG(travelimagerating.Rating) FROM travelimagerating WHERE travelimagerating.ImageID = $imageId;
                  ";
                    $resRating = mysqli_query($conn, $selectAverageRating);
                    $rating = mysqli_fetch_row($resRating);
                    ?>
                    <div class="rating">
                        <h4>Rating</h4>
                        <div class="star-rating">
                            <?php
                            $toInt = (int)$rating[0];
                            for ($x = 0; $x <= $toInt; $x++) {
                                echo '<span class="fa fa-star" data-rating="1"></span>';
                            }
                            for ($i = 1; $i < 5 - $toInt; $i++) {
                                echo '<span class="fa fa-star-o" data-rating="1"></span>';
                            }
                            ?>
                        </div>
                    </div>
                    <?php if (isset($data['TravelImageReview'])) { ?>
                        <div class="container mb-5">
                            <h4 class="">
                                Recent Review
                            </h4>
                            <div class="row">
                                <div class="col-4">

                                    <p class="bg-light py-2 px-4">
                                        <?php echo $data['TravelImageReview']  ?>
                                    </p>
                                </div>
                                <?php if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] === "admin@gmail.com") {
                                ?>
                                    <div class="col-1">
                                        <a href="deleteReview.php?id=<?php echo $data['ImageID']; ?>" class="d-grid btn btn-outline-danger text-decoration-none">Remove</a>
                                    </div>
                                <?php }  ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php
                    if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] !== "admin@gmail.com") {
                    ?>
                        <div class="container mb-5">
                            <h4 class="">
                                Give Review
                            </h4>

                            <?php
                            if (isset($_POST['submitReview'])) {
                                // echo $_SESSION['logged-in-id'];
                                if (!empty($_POST['review'])) {
                                    $review = mysqli_real_escape_string($conn, $_POST['review']);
                                    $sqlUpdateImageDetailsReview = "UPDATE travelimage SET TravelImageReview = '{$review}' WHERE ImageID ={$data['ImageID']} ";
                                    $updateRes = mysqli_query($conn, $sqlUpdateImageDetailsReview);

                                    if ($updateRes) {
                                        $_SESSION['success'] = "Thank you for review.";
                                    }
                                }
                            }
                            ?>
                            <form method="POST">
                                <div class="row mt-2">
                                    <?php if (isset($_SESSION['success'])) {
                                        echo '<div class="col-7"><p class="bg-light p-1">
                                   ' . $_SESSION['success'] . '</p></div>';
                                        unset($_SESSION['success']);
                                    }  ?>

                                    <div class="col-6">
                                        <input type="text" class="form-control" name="review" id="">
                                    </div>
                                    <div class="col-3">
                                        <button name="submitReview" class="btn btn-dark m-l-2">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php  } ?>

                    <h4>Related Post</h4>
                    <div class="post mt-4">

                        <?php
                        $selectAllPosts = "SELECT * FROM `travelpost` INNER JOIN travelimage ON travelimage.ImageID = travelpost.PostID
                        INNER JOIN travelpostimages ON travelpostimages.ImageID = travelimage.ImageID WHERE travelpostimages.ImageID = {$data['PostID']} GROUP BY travelimage.ImageID;";

                        $posRes = mysqli_query($conn, $selectAllPosts);

                        while ($posts = mysqli_fetch_assoc($posRes)) {

                        ?>
                            <div class="col-lg-6 col-sm-12">
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
                                    <div class="col-6">
                                        <img style="max-height: 190px; object-fit: cover;" src="<?php echo 'assets/images/medium/' . $posts['Path'] ?>">

                                    </div>
                                </div>
                            </div>
                        <?php  } ?>



















                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid d-flex justify-content-center align-items-center flex-column  py-5 bg-light my-4">
        <h2 class="my-4 text-center">Related Places</h2>
        <div class="container">
            <div class="row">
                <?php
                $selectTopRatingPlaces = "SELECT * FROM `travelimage` INNER JOIN travelimagedetails ON travelimage.ImageID=travelimagedetails.ImageID
            INNER JOIN geocities on geocities.GeoNameID = travelimagedetails.CityCode
            WHERE travelimagedetails.CityCode = {$data['CityCode']} OR travelimagedetails.CountryCodeISO = '{$data['CountryCodeISO']}' LIMIT 6;";
                $topResult = mysqli_query($conn, $selectTopRatingPlaces);
                if (mysqli_num_rows($topResult) > 0) {
                    while ($dataPlaces = mysqli_fetch_assoc($topResult)) {
                ?>
                        <div class="col-md-4 col-sm-12">
                            <div class="card popularPlacesHover">
                                <a href="singleImage.php?imageId=<?php echo $dataPlaces['ImageID']  ?>" style="text-decoration: none; color: inherit;">
                                    <img src="<?php echo  "assets/images/large/" . $dataPlaces['Path']; ?>" class="card-img-top" style="object-fit: cover; width: 100%;" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $dataPlaces['Title']  ?></h5>
                                        <h6 class="card-subtitle mb-2 text-muted "><b>City: </b><?php echo $dataPlaces['AsciiName']  ?></h6>
                                        <p class="card-text"><?php
                                                                if ($dataPlaces['Description'] == "") {
                                                                    echo "Description not found";
                                                                } else {
                                                                    if (strlen($dataPlaces['Description']) > 35) {
                                                                        $subMessage = substr($dataPlaces['Description'], 0, 50);
                                                                        echo $subMessage . '...';
                                                                    }
                                                                }
                                                                ?></p>

                                    </div>
                                </a>
                            </div>
                        </div>

                    <?php  }
                } else {
                    ?>
                    <h1 class="display-4 text-center py-3">No Related Places Found</h1>
                <?php
                }
                ?>
            </div>


        </div>







    </div>

    <script>
        $('#btnOpen').on('click', () => {
            $('.mapCard').slideDown("slow");
        });
        $('#btnClose').on('click', () => {
            $('.mapCard').slideUp("slow");
        });
    </script>

    <script src="assets/js/script.js"></script>


    <?php include "footer.php" ?>

</body>

</html>
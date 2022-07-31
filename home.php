<?php
require "database/conn.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "links.php"  ?>
    <title>Home</title>
</head>

<body>


    <?php
    include "nav.php";
    ?>
    <div id="carousel-main" class="carousel  carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $selectTopRatingImages = "SELECT * FROM `travelimage` INNER JOIN travelimagedetails ON travelimage.ImageID=travelimagedetails.ImageID INNER JOIN travelimagerating ON travelimage.ImageID=travelimagerating.ImageID WHERE travelimagerating.Rating=5 LIMIT 3;";
            $result = mysqli_query($conn, $selectTopRatingImages);
            $data_intervel = 0;

            while ($data = mysqli_fetch_array($result)) {

                if ($data_intervel === 5000) {
                    $data_intervel = 0;
                } else {
                    $data_intervel += 2500;
                }
            ?>
                <div class="carousel-item <?php if ($data_intervel == 2500) {
                                                echo 'active';
                                            } else {
                                                echo '';
                                            }  ?>" data-bs-interval="<?php echo $data_intervel ?>">
                    <img src="<?php echo  "assets/images/large/" . $data['Path']; ?>">
                    <div class="carousel-caption">
                        <h5> <?php echo $data['Title']  ?></h5>
                        <p class="mt-3"> <?php
                                            if ($data['Description'] == "") {
                                                echo "Description not found";
                                            } else {
                                                echo $data['Description'];
                                            }
                                            ?></p>
                    </div>
                </div>

            <?php  } ?>
        </div>
        <button class="carousel-control-prev" style=" width: 100px;" type="button" data-bs-target="#carousel-main" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" style="width: 100px;" type="button" data-bs-target="#carousel-main" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <section class="popularPosts" style="margin-top: 2rem;">
        <h1 class="display-5 text-center pb-4">
            Popular Places
        </h1>
        <div class="container">
            <div class="row">
                <?php
                $selectTopRatingPlaces = "SELECT * FROM `travelimage` INNER JOIN travelimagedetails ON travelimage.ImageID=travelimagedetails.ImageID INNER JOIN travelimagerating ON travelimage.ImageID=travelimagerating.ImageID WHERE travelimagerating.Rating > 4 LIMIT 3 ;";
                $topResult = mysqli_query($conn, $selectTopRatingPlaces);
                while ($dataPlaces = mysqli_fetch_assoc($topResult)) {
                ?>
                    <div class="col-md-4 col-sm-12">
                        <div class="card popularPlacesHover">
                            <a href="singleImage.php?imageId=<?php echo $dataPlaces['ImageID']  ?>" style="text-decoration: none; color: inherit;">
                                <img src="<?php echo  "assets/images/large/" . $dataPlaces['Path']; ?>" class="card-img-top" style="object-fit: cover; width: 100%;" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $dataPlaces['Title']  ?></h5>

                                    <p class="card-text"><?php
                                                            if ($dataPlaces['Description'] == "") {
                                                                echo "Description not found";
                                                            } else {
                                                                echo $dataPlaces['Description'];
                                                            }
                                                            ?></p>

                                </div>
                            </a>
                        </div>
                    </div>

                <?php  } ?>
            </div>
        </div>
    </section>

    <section class="banner">
        <div class="content container d-flex justify-content-center align-items-center flex-column">
            <h1 class="text-center text-white" style="font-size: 5rem; margin-bottom: 1.5rem;">Beautiful Places For You To Vist</h1>
            <p class="text-center text-white" style="font-size: 1.2rem; padding: 0 6rem;">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique illo dolorum, architecto autem impedit sint incidunt sequi vel cupiditate iusto, labore veritatis quis. Unde incidunt repudiandae velit enim ab eum.</p>
            <a href="images.php"> <button class="btnPlaceVisit mt-5">Find Place Now</button>
            </a>
        </div>
    </section>

    <section class="recentPosts">
        <h1 class="display-5 text-center pb-4">
            Recent Posts
        </h1>
        <div class="container">
            <div class="row">
                <?php
                $selectAllPosts = "SELECT * FROM `travelpost` INNER JOIN travelimage ON travelimage.ImageID = travelpost.PostID GROUP BY travelpost.PostID LIMIT 0,3;

          ";
                $posRes = mysqli_query($conn, $selectAllPosts);
                while ($posts = mysqli_fetch_assoc($posRes)) {

                ?>
                    <div class="col-md-4 col-sm-12">
                        <div class="card">
                            <a href="viewSinglePost.php?postId=<?php echo  $posts['PostID']; ?>" style="text-decoration: none; color: inherit;">
                                <img src="<?php echo 'assets/images/medium/' . $posts['Path'] ?>" class="card-img-top" style="object-fit: cover; width: 100%;" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo  $posts['Title']; ?></h5>
                                    <div class="text-muted pb-3"><?php echo  $posts['PostTime']; ?></div>
                                    <p class=""><?php
                                                if (strlen($posts['Message']) > 90) {
                                                    $subMessage = substr($posts['Message'], 0, 90);
                                                    echo $subMessage . '. . .';
                                                }
                                                ?></p>
                                    <a href="viewSinglePost.php?postId=<?php echo  $posts['PostID']; ?>" class="btn btn-outline-dark d-grid">Continue reading</a>
                                </div>
                            </a>
                        </div>
                    </div>

                <?php  } ?>
            </div>
        </div>
    </section>

    <section class="contact" style=" margin-top: 2rem; height: 600px; display: flex; align-items: center; justify-content: center; flex-direction: column; margin-bottom: 8rem;">
        <h1 class="display-5 text-center my-5">
            Contact US
        </h1>
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-6 h-100">
                    <form method="POST" class="h-100 d-flex justify-content-center align-items-center flex-column">
                        <?php
                        if (isset($_SESSION['success'])) {
                            echo '<div class="alert w-100 alert-success alert-dismissible fade show" role="alert">
                                                        <strong>Success!</strong> ' .  $_SESSION['success'] . '
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>';
                            unset($_SESSION['success']);
                        }
                        ?>
                        <div class="form-group my-3 w-100">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control p-2" id="name">
                        </div>
                        <div class="form-group my-3 w-100">
                            <label for="email">Email address</label>
                            <input type="email" name="email" class="form-control p-2" id="email">
                        </div>

                        <div class="form-group my-3 w-100">
                            <label for="message">Message</label>
                            <textarea name="message" class="form-control p-3" id="message" rows="6"></textarea>
                        </div>
                        <button name="sendContact" class="btn btn-outline-dark d-grid w-100 mt-3 py-2" style="font-size: 22px;">Send</button>
                    </form>
                    <?php
                    if (isset($_POST['sendContact'])) {
                        $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
                        $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
                        $message = trim(mysqli_real_escape_string($conn, $_POST['message']));
                        $sqlContact = "INSERT INTO `contact`( `name`, `email`, `message`) VALUES ('$name','$email','$message')";
                        $contactRes = mysqli_query($conn, $sqlContact);
                        if ($contactRes) {
                            $_SESSION['success'] = "Messge sent successfully";
                    ?><script>
                                window.location.href = "home.php";
                            </script><?php
                                    }
                                }
                                        ?>
                </div>
                <div class="col-6 h-100">
                    <iframe style="border: 2px solid gray; margin-top: 1rem;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6328.402739832231!2d144.95873135577202!3d-37.812527334581965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x69d5ff7082948a40!2sKent%20Institute%20Australia!5e0!3m2!1sen!2s!4v1632713653689!5m2!1sen!2s" width="100%" height="100%" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>
    <?php include "footer.php" ?>
    <script src="assets/js/script.js"></script>
</body>

</html>
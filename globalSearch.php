<?php
require "database/conn.php";
if (isset($_GET['search'])) {
    $searchWord = $_GET['search'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include "links.php"  ?>
        <title>All Places</title>
    </head>

    <body>

        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>

        <?php
        include "nav.php";
        ?>


        <section class="container-fluid px-2 mt-3  gallery">
            <div class="row w-100">
                <ul class="d-flex flex-md-wrap">
                    <?php
                    $selectImage = "SELECT * FROM `travelimage` INNER JOIN travelimagedetails ON travelimage.ImageID=travelimagedetails.ImageID
                    WHERE travelimagedetails.Title LIKE '{$searchWord}%';";
                    $results = mysqli_query($conn, $selectImage);
                    if (mysqli_num_rows($results) > 0) {
                        while ($images  =  mysqli_fetch_assoc($results)) {
                    ?>
                            <li>
                                <a href="singleImage.php?imageId=<?php echo $images['ImageID']; ?>">
                                    <img loading="lazy" src="<?php echo  "assets/images/large/" . $images['Path'];  ?>" alt="">

                                    <div class="imgDetails">
                                        <h2 class="title">
                                            <?php echo $images['Title']  ?>
                                        </h2>
                                        <p class="description">
                                            <?php
                                            if ($images['Description'] == "") {
                                                echo "Description not found";
                                            } else {
                                                echo $images['Description'];
                                            }

                                            ?>
                                        </p>
                                    </div>

                                </a>
                            </li>
                    <?php
                        }
                    }else{
                        echo "<h3 class='text-center w-100 my-4'>Nothing Found</h3>";
                    }
                    ?>

                </ul>
            </div>

        </section>
        <?php include "footer.php" ?>
        <script src="assets/js/script.js"></script>
    </body>

    </html>
<?php

} else {
    header("Location:home.php");
}
?>
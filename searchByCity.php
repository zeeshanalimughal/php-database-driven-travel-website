<?php
require "database/conn.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "links.php";  ?>
  <title>City Search</title>
</head>

<body>
  <?php include "nav.php";  ?>

  <div class="container">
    <h1 class="mt-2">Search By City</h1>

    <div class="row mt-3">
      <div class="col-12 px-5">
        <form method="POST">
          <div class="row d-flex align-items-center justify-content-center">
            <div class="col-9">
              <label for="country" class="form-label">Enter City Name</label>
              <input type="text" id="city" name="city" class="form-control">
            </div>
            <div class="col-3 mt-4 d-flex align-items-center justify-content-center">
              <button type="submit" name="searchCity" class="btn btn-dark d-grid w-100" style="margin-top: 6px !important;">Search</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <?php if (isset($_POST['searchCity'])) {
      $city = trim(mysqli_real_escape_string($conn, $_POST['city']));
      $sqlSelectCity = "SELECT * FROM geocities WHERE AsciiName LIKE '%{$city}%'";
      $resCity = mysqli_query($conn, $sqlSelectCity);
      if (mysqli_num_rows($resCity) > 0) {
        $cityData = mysqli_fetch_assoc($resCity);
    ?>

        <div class="container-fluid">

          <div class="row mt-4 d-flex align-items-center justify-content-center flex-wrap">
            <div class="col-lg-4 col-md-4 col-sm-6 py-4 px-5 rounded-3 m-3 shadow-sm d-flex justify-content-center align-items-center flex-column" style="height: 200px;">
              <h3>Population </h3>
              <h2 class="text-success text-center">
                <?php echo $cityData['Population'];  ?>
              </h2>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 py-4 px-5 rounded-3 m-3 shadow-sm d-flex justify-content-center align-items-center flex-column" style="height: 200px;">
              <h3>Elevation </h3>
              <h2 class="text-success text-center">
                <?php echo $cityData['Elevation'];  ?>
              </h2>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 py-4 px-5 rounded-3 m-3 shadow-sm d-flex justify-content-center align-items-center flex-column" style="height: 200px;">
              <h3>ISO </h3>
              <h2 class="text-success text-center">
                <?php echo $cityData['CountryCodeISO'];  ?>
              </h2>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 py-4 px-5 rounded-3 m-3 shadow-sm d-flex justify-content-center align-items-center flex-column" style="height: 200px;">
              <h3>CityCode </h3>
              <h2 class="text-success text-center">
                <?php echo $cityData['GeoNameID'];  ?>
              </h2>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 py-4 px-4 rounded-3 mx-5 mt-3 shadow-sm d-flex justify-content-center align-items-center flex-column">

              <iframe src="<?php echo 'https://maps.google.com/maps?q=' . $cityData['Latitude'] . ',' . $cityData['Longitude'] . '&hl=es;z=14&amp;output=embed'  ?>" style="width: 100%; height: 500px;"></iframe>

            </div>
          </div>

        </div>

        <div class="container mt-5">
          <h1 class="display-5 my-3 py-4 text-center">Pleaces for Visit</h1>
          <div class="row">
            <?php
            $selectPlacesByCity = "SELECT * FROM `travelimagedetails` INNER JOIN geocities on geocities.GeoNameID = travelimagedetails.CityCode
            INNER JOIN travelimage ON travelimage.ImageID = travelimagedetails.ImageID WHERE CityCode = '{$cityData['GeoNameID']}' LIMIT 0,3;";
            $placesResult = mysqli_query($conn, $selectPlacesByCity);
            if (mysqli_num_rows($placesResult) > 0) {
              while ($dataPlaces = mysqli_fetch_assoc($placesResult)) {
                $dataPlaces['Path'];
            ?>
                <div class="col-lg-4 col-sm-12">
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


            <?php
              }
            }else{
              echo "<h3 class='text-center my-3'>No Place Found</h3>";
            } ?>
          </div>
        </div>


      <?php }
      ?>


    <?php
    } ?>
  </div>
  </div>

  <?php include "footer.php" ?>
  <script src="assets/js/script.js"></script>
</body>

</html>
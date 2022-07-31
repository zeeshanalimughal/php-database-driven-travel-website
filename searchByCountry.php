<?php
require "database/conn.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "links.php";  ?>
    <title>Country Search</title>
</head>

<body>
    <?php include "nav.php";  ?>

    <div class="container">
        <h1 class="mt-2 px-4">Search By Country</h1>

        <div class="row mt-3">
            <div class="col-12 px-5">
                <form method="POST">
                    <div class="row d-flex align-items-center justify-content-center">
                        <div class="col-9">
                            <label for="country" class="form-label">Select Country</label>
                            <select id="country" name="country" class="form-select">
                                <option disabled selected>Choose Country...</option>
                                <?php
                                $selectCoountry = "SELECT CountryName from geocountries";
                                $result = mysqli_query($conn, $selectCoountry);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option>' . $row["CountryName"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <button type="submit" name="searchCountry" class="btn btn-dark d-grid w-100 mt-4">Search</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <?php if (isset($_POST['searchCountry'])) {
            if (isset($_POST['country'])) {

                $country = mysqli_real_escape_string($conn, $_POST['country']);
                $sqlSelectCountry = "SELECT * FROM geocountries WHERE CountryName = '{$country}'";
                $resCountry = mysqli_query($conn, $sqlSelectCountry);
                if (mysqli_num_rows($resCountry) > 0) {
                    $countryData = mysqli_fetch_assoc($resCountry);
                }
            } else {
                echo "<h6 class='mx-4 mt-2'>Please Select Country</h6>";
            }
        ?>

            <?php if (isset($countryData)) { ?>
                
                <div class="row mt-4 d-flex align-items-center justify-content-center flex-wrap">
                    <div class="col-lg-3 col-md-3 col-sm-6 py-4 px-5 rounded-3 m-3 shadow-sm d-flex justify-content-center align-items-center flex-column" style="height: 200px;">
                        <h3>Country </h3>
                        <h2 class="text-success text-center">
                            <?php echo $countryData['CountryName'];  ?>
                        </h2>
                    </div>


                    <div class="col-lg-3 col-md-3 col-sm-6 py-4 px-5 rounded-3 m-2 shadow-sm d-flex justify-content-center align-items-center flex-column" style="height: 200px;">
                        <h3>Capital </h3>
                        <h2 class="text-success text-center">
                            <?php echo $countryData['Capital'];  ?>
                        </h2>
                    </div>


                    <div class="col-lg-3 col-md-3 col-sm-6 py-4 px-5 rounded-3 m-2 shadow-sm d-flex justify-content-center align-items-center flex-column" style="height: 200px;">
                        <h3>Area </h3>
                        <h2 class="text-success text-center">
                            <?php echo $countryData['Area'];  ?>
                        </h2>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 py-4 px-5 rounded-3 m-2 shadow-sm d-flex justify-content-center align-items-center flex-column" style="height: 200px;">
                        <h3>Population </h3>
                        <h2 class="text-success text-center">
                            <?php echo $countryData['Population'];  ?>
                        </h2>
                    </div>



                    <div class="col-lg-3 col-md-3 col-sm-6 py-4 px-5 rounded-3 m-2 shadow-sm d-flex justify-content-center align-items-center flex-column" style="height: 200px;">
                        <h3>Currency Code </h3>
                        <h2 class="text-success text-center">
                            <?php echo $countryData['CurrencyCode'];  ?>
                        </h2>
                    </div>


                    <div class="col-lg-3 col-md-3 col-sm-6 py-4 px-5 rounded-3 m-2 shadow-sm d-flex justify-content-center align-items-center flex-column" style="height: 200px;">
                        <h3>Flag Image </h3>
                        <img style="width: 80px; height: 70px;" src="<?php echo "https://www.countryflags.io/" . $countryData['fipsCountryCode'] . "/shiny/64.png"; ?>">

                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 py-4 px-5 rounded-3 mx-5 mt-3 shadow-sm d-flex justify-content-center align-items-center flex-column">
                        <h3 class="mb-4">Description</h3>

                        <?php
                        if ($countryData['CountryDescription']) {
                            echo $countryData['CountryDescription'];
                        } else {
                            echo "Description is not available";
                        }
                        ?>
                    </div>
                </div>
        <?php
            }
        } ?>
    </div>
    </div>
    <?php include "footer.php" ?>
    <script src="assets/js/script.js"></script>
</body>

</html>
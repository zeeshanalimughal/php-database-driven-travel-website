<?php
require "../database/conn.php";
if (!isset($_SESSION['logged-in']) || $_SESSION['logged-in'] !== "admin@gmail.com") {
    header("Location:http://localhost/travel/");
}
if (isset($_GET['id'])) {

    $uid = $_GET['id'];
    $fname_err =  $lname_err = $city_err = $address_err = $country_err = "";
    if (isset($_POST['update'])) {
        echo  $fname = trim(mysqli_real_escape_string($conn, $_POST['fname']));
        echo  $lname = trim(mysqli_real_escape_string($conn, $_POST['lname']));
        echo  $phone = trim(mysqli_real_escape_string($conn, $_POST['phone']));
        echo  $city = trim(mysqli_real_escape_string($conn, $_POST['city']));
        echo  $region = trim(mysqli_real_escape_string($conn, $_POST['region']));
        echo  $postal = trim(mysqli_real_escape_string($conn, $_POST['postal']));
        echo $country = trim(mysqli_real_escape_string($conn, $_POST['country']));
        echo  $address = trim(mysqli_real_escape_string($conn, $_POST['address']));

        if (empty($lname)) {
            $lname_err  = "Lastname required";
        }
        if (empty($fname)) {
            $fname_err  = "Firstname required";
        }
        if (empty($city)) {
            $city_err  = "City required";
        }
        if (empty($address)) {
            $address_err  = "Address required";
        }
        if (empty($country)) {
            $country_err  = "Country required";
        }


        if (!empty($fname) && !empty($lname)  && !empty($country) && !empty($city) && !empty($address)) {

            $d = mktime(11, 14, 54, 8, 12, 2014);
            $date = date("Y-m-d h:i:sa", $d);
            $sql1 = "UPDATE `traveluser` SET `DateLastModified`='$date' WHERE UID=$uid";

            $sql2 = "UPDATE `traveluserdetails` SET `FirstName`='$fname',`LastName`='$lname',`Address`='$address',`City`='$city',`Region`='$region',`Country`='$country',`Postal`='$postal',`Phone`='$postal' WHERE UID='$uid'";
            $q1 = mysqli_query($conn, $sql1);
            if ($q1) {
                $_SESSION['updated'] = "Updated Successfully";
                $q2 = mysqli_query($conn, $sql2);
                if ($sql2) {
                    header("Location:index.php");
                }
            }
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <link rel="stylesheet" href="../assets/css/custom.css">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <script src="../assets/js/popper.min.js"></script>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row ">
                <div class="sidebar  bg-dark text-white d-flex justify-content-center pt-5">
                    <aside>

                        <h1 class="display-5 pb-2" style="border-bottom: 3px solid #fff;">Dashboard</h1>

                        <ul style="margin-left: -20px;" class="mt-5 d-flex justify-content-center align-items-center flex-column w-100">
                            <a class="text-decoration-none text-dark my-2 btn btn-light d-grid px-5 w-100" href="index.php">
                                <li class="list-unstyled">All Users</li>
                            </a>
                            <a class="text-decoration-none text-dark my-2 btn btn-light d-grid px-5 w-100" href="messages.php">
                                <li class="list-unstyled">Messages</li>
                                <a class="text-decoration-none text-dark my-2 btn btn-light d-grid px-5 w-100" href="http://localhost/travel/home.php">
                                    <li class="list-unstyled">Go to site</li>
                                </a>
                                <a class="text-decoration-none text-dark my-2 btn btn-light d-grid px-5 w-100" href="../logout.php">
                                    <li class="list-unstyled">Logout</li>
                                </a>

                        </ul>
                    </aside>
                </div>
                <div class="main min-vh-100 col-md-9  bg-white">
                    <button class="toggle btn btn-outline-dark mt-1" style="font-size: 25px;">☰</button>
                    <div class="w-100 min-vh-100 container-fluid d-flex justify-content-center ">
                        <div class="mt-5  pb-4 d-flex justify-content-center">
                            <div class="col-lg-12">

                                <?php
                                if (isset($_GET['id'])) {
                                    $selectUpdatedUserRecord = "SELECT * FROM traveluserdetails WHERE UID = $uid ";
                                    $users = mysqli_query($conn, $selectUpdatedUserRecord);
                                    $data = mysqli_fetch_assoc($users);
                                }
                                ?>

                                <form method="POST" class="g-3 bg-light p-5 rounded-3">
                                    <h1 class="display-6 text-center py-2">Update User</h1>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <label for="fname" class="form-label">First name</label>
                                            <input type="text" name="fname" class="p-3 form-control" value="<?php echo $data['FirstName']  ?>" id="fname">
                                            <?php
                                            if ($fname_err !== "") {
                                                echo '<p class="text-danger">' . $fname_err . '</p>';
                                            }
                                            ?>

                                        </div>

                                        <div class="col-md-6">

                                            <label for="lname" class="form-label"><span class="text-danger">*</span> Last name</label>
                                            <input type="text" value="<?php echo $data['LastName']  ?>" name="lname" class="p-3 form-control" id="lname">
                                            <?php
                                            if ($lname_err !== "") {
                                                echo '<p class="text-danger">' . $lname_err . '</p>';
                                            }
                                            ?>


                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-12">
                                            <label for="address" class="form-label"><span class="text-danger">*</span> Address</label>
                                            <input type="text" value="<?php echo $data['Address']  ?>" name="address" class="p-3 form-control" id="address" placeholder="1234 Main St">
                                            <?php
                                            if ($address_err !== "") {
                                                echo '<p class="text-danger">' . $address_err . '</p>';
                                            }
                                            ?>
                                        </div>
                                        <div class="row">


                                            <div class="col-md-6">
                                                <label for="city" class="form-label"><span class="text-danger">*</span> City</label>
                                                <input type="text" value="<?php echo $data['City']  ?>" name="city" class="p-3 form-control" id="city">
                                                <?php
                                                if ($city_err !== "") {
                                                    echo '<p class="text-danger">' . $city_err . '</p>';
                                                }
                                                ?>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="postal" class="form-label">Postal</label>
                                                <input type="text" value="<?php echo $data['Postal']  ?>" name="postal" class="p-3 form-control" id="postal">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="region" class="form-label">Region</label>
                                                <select id="region" name="region" class="form-select p-3">
                                                    <option disabled>Choose...</option>
                                                    <option selected value="<?php echo $data['Region']  ?>"><?php echo $data['Region']  ?></option>
                                                    <?php
                                                    $selectCoountry = "SELECT Continent from geocountries";
                                                    $result = mysqli_query($conn, $selectCoountry);
                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                        echo '<option>' . $row["Continent"] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="country" class="form-label"><span class="text-danger">*</span> country</label>
                                                <select id="country" name="country" class="form-select p-3">
                                                    <option disabled>Choose...</option>
                                                    <option selected value="<?php echo $data['Country']  ?>"><?php echo $data['Country']  ?></option>

                                                    <?php
                                                    $selectCoountry = "SELECT CountryName from geocountries";
                                                    $result = mysqli_query($conn, $selectCoountry);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option>' . $row["CountryName"] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <?php
                                                if ($country_err !== "") {
                                                    echo '<p class="text-danger">' . $country_err . '</p>';
                                                }
                                                ?>
                                            </div>
                                            <div class="col-6">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" value="<?php echo $data['Phone']  ?>" name="phone" class="p-3 form-control" id="phone">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 d-grid ">
                                                <button type="submit" name="update" style="font-size: 22px;" class="mt-3 btn btn-outline-primary">Update</button>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../assets/js/script.js"></script>
    </body>

    </html>
<?php
}
?>
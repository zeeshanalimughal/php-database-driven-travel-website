
<?php

require "database/conn.php";
if(isset($_SESSION['logged-in'])){
    header("Location:home.php");
}else{

$fname_err = $password_err = $username_err = $lname_err = $city_err = $address_err = $country_err = $email_err = "";
if (isset($_POST['register'])) {
    $fname = trim(mysqli_real_escape_string($conn, $_POST['fname']));
    $lname = trim(mysqli_real_escape_string($conn, $_POST['lname']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $phone = trim(mysqli_real_escape_string($conn, $_POST['phone']));
    $city = trim(mysqli_real_escape_string($conn, $_POST['city']));
    $region = trim(mysqli_real_escape_string($conn, $_POST['region']));
    $postal = trim(mysqli_real_escape_string($conn, $_POST['postal']));
    $country = trim(mysqli_real_escape_string($conn, $_POST['country']));
    $address = trim(mysqli_real_escape_string($conn, $_POST['address']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));

    if (empty($lname)) {
        $lname_err  = "Lastname required";
    }
    if (empty($fname)) {
        $fname_err  = "Firstname required";
    }
    if (empty($username)) {
        $username_err  = "Firstname required";
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

    if (empty($email)) {
        $email_err  = "Email required";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err  = "Email is not valid";
        }
    }

    if (empty($password)) {
        $password_err  = "Please enter password";
    } else {
        if (strlen($password) < 6) {
            $password_err = "Password must be greater than 6 characters";
        } else {
            $password_err = "";
        }
    }




    if (!empty($fname) && !empty($lname) && !empty($email) && !empty($country) && !empty($city) && !empty($address) && empty($password_err)) {
        $checkUserExists = "SELECT UserName from traveluser WHERE UserName = '$email'";
        $res = mysqli_query($conn, $checkUserExists);
        if (mysqli_num_rows($res) > 0) {
            $email_err  = "Email is already exists";
        } else {
            $d = mktime(11, 14, 54, 8, 12, 2014);
            $date = date("Y-m-d h:i:sa", $d);
            $sql1 = "INSERT INTO `traveluser`(`UserName`, `Pass`, `State`, `DateJoined`, `DateLastModified`) VALUES ('$email','$password',1,'$date','$date')";

            $sql2 = "INSERT INTO `traveluserdetails`(`FirstName`, `LastName`, `Address`, `City`, `Region`, `Country`, `Postal`, `Phone`, `Email`, `Privacy`) VALUES ('$fname','$lname','$address','$city','$region','$country','$postal','$phone','$email','1')";

            $q1 = mysqli_query($conn, $sql1);
            if ($q1) {
                $_SESSION['registered'] = "Registered Successfully";
                $q2 = mysqli_query($conn, $sql2);
                if ($sql2) {
                    header("Location:index.php");
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "links.php"  ?>
    <title>Register</title>
</head>

<body>
<?php include "nav.php";  ?>
    <div class="bg-dark min-vh-100 container-fluid d-flex justify-content-center align-items-center">
        <div class="mt-5 w-75 pb-4 d-flex justify-content-center align-items-center">
            <div class="col-lg-8 col-md-12 col-sm-12 ">
                <form method="POST" class="g-3 bg-white p-4 rounded-3">
                    <h1 class="display-5 text-center py-2">Register</h1>

                    <div class="row">

                        <div class="col-md-6">
                            <label for="fname" class="form-label">First name</label>
                            <input type="text" name="fname" class="form-control" id="fname">
                            <?php
                            if ($fname_err !== "") {
                                echo '<p class="text-danger">' . $fname_err . '</p>';
                            }
                            ?>

                        </div>

                        <div class="col-md-6">

                            <label for="lname" class="form-label"><span class="text-danger">*</span> Last name</label>
                            <input type="text" name="lname" class="form-control" id="lname">
                            <?php
                            if ($lname_err !== "") {
                                echo '<p class="text-danger">' . $lname_err . '</p>';
                            }
                            ?>


                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="username" class="form-control" name="username" id="username">
                            <?php
                            if ($username_err !== "") {
                                echo '<p class="text-danger">' . $username_err . '</p>';
                            }
                            ?>
                        </div>


                        <div class="col-md-6">
                            <label for="email" class="form-label"><span class="text-danger">*</span> Email</label>
                            <input type="email" name="email" class="form-control" id="email">
                            <?php
                            if ($email_err !== "") {
                                echo '<p class="text-danger">' . $email_err . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-12">
                            <label for="address" class="form-label"><span class="text-danger">*</span> Address</label>
                            <input type="text" name="address" class="form-control" id="address" placeholder="1234 Main St">
                            <?php
                            if ($address_err !== "") {
                                echo '<p class="text-danger">' . $address_err . '</p>';
                            }
                            ?>
                        </div>


                        <div class="col-md-6">
                            <label for="city" class="form-label"><span class="text-danger">*</span> City</label>
                            <input type="text" name="city" class="form-control" id="city">
                            <?php
                            if ($city_err !== "") {
                                echo '<p class="text-danger">' . $city_err . '</p>';
                            }
                            ?>
                        </div>
                        <div class="col-md-4">
                            <label for="region" class="form-label">Region</label>
                            <select id="region" name="region" class="form-select">
                                <option disabled>Choose...</option>
                                <?php
                                $selectCoountry = "SELECT Continent from geocountries";
                                $result = mysqli_query($conn, $selectCoountry);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option>' . $row["Continent"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="postal" class="form-label">Postal</label>
                            <input type="text" name="postal" class="form-control" id="postal">
                        </div>


                        <div class="row">
                            <div class="col-6">
                                <label for="country" class="form-label"><span class="text-danger">*</span> country</label>
                                <select id="country" name="country" class="form-select">
                                    <option disabled>Choose...</option>
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
                                <input type="text" name="phone" class="form-control" id="phone">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password">
                                <?php
                                if ($password_err !== "") {
                                    echo '<p class="text-danger">' . $password_err . '</p>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-grid ">
                                <button type="submit" name="register" class="mt-3 btn btn-outline-dark">Register</button>
                            </div>
                        </div>
                        <div class="col-12 mt-2 text-center">
                            <a href="index.php" class="link-dark">Already have an account</a>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script src="assets/js/script.js"></script>
</body>

</html>
<?php
}
?>
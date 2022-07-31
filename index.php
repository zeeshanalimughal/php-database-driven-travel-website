<?php

require "database/conn.php";
if(isset($_SESSION['logged-in'])){
    header("Location:home.php");
}else{

$password_err = $email_err = "";
if (isset($_POST['login'])) {
     $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
      $password = trim(mysqli_real_escape_string($conn, $_POST['password']));



    if (empty($email)) {
        $email_err  = "Email required";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err  = "Please enter vlid email";
        }
    }
    if (empty($password)) {
        $password_err  = "Please enter password";
    }
    if (!empty($email) && !empty($password)) {
        $checkUserExists = "SELECT UID, UserName,Pass from traveluser WHERE UserName = '$email' AND Pass = '$password' AND State = 1";
        $res = mysqli_query($conn, $checkUserExists);
        if (mysqli_num_rows($res) > 0) {
            $userId = mysqli_fetch_assoc($res);
            $_SESSION['logged-in'] = $email;
            $_SESSION['logged-in-id'] = $userId['UID'];
          header("Location:home.php");
        } else {
        $sqlAdmin = "SELECT * FROM admin WHERE username = '{$email}' AND password = '{$password}'";
        $adminRes = mysqli_query($conn,$sqlAdmin);
        if(mysqli_num_rows($adminRes)>0){
            $_SESSION['logged-in'] = $email;
            header("Location:home.php");
        }else{
            $_SESSION['error'] = "Your account dosen't exists";
        }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php include "links.php"  ?>
    <title>Login</title>
</head>

<body>
<?php include "nav.php";  ?>
    <div class="bg-dark min-vh-100 container-fluid d-flex justify-content-center align-items-center">
        <div class="row w-75 pb-4 d-flex justify-content-center align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12 ">
                <form method="POST" class="bg-white p-4 rounded-3">

                    <h1 class="display-5 text-center py-3">Login</h1>
                    <?php
                    if (isset($_SESSION['registered'])) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> ' .  $_SESSION['registered'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                        unset($_SESSION['registered']);
                    }
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Alert!</strong> ' .  $_SESSION['error'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                        unset($_SESSION['error']);
                    }


                    ?>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email">
                        <?php
                            if ($email_err !== "") {
                                echo '<p class="text-danger">' . $email_err . '</p>';
                            }
                            ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"></label>Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                        <?php
                            if ($password_err !== "") {
                                echo '<p class="text-danger">' . $password_err . '</p>';
                            }
                            ?>
                    </div>

                    <div class="d-grid ">
                        <button class="mt-2 btn btn-outline-dark" name="login" type="submit">Login</button>
                    </div>
                    <div class="col-12 mt-2 text-center ">
                        <a href="register.php" class="link-dark">Don't have an account... ?</a>
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
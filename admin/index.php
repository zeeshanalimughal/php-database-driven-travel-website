<?php
require "../database/conn.php";
if(!isset($_SESSION['logged-in']) || $_SESSION['logged-in']!="admin@gmail.com"){
  header("Location:http://localhost/travel/");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="../assets/css/custom.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <script src="../assets/js/popper.min.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
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
            <a class="text-decoration-none text-dark my-2 btn btn-light d-grid px-5 w-100" href="/travel/home.php">
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
        <h1 class="display-5 text-center">All Users List</h1>
  
        <div class="container table-responsive mt-2">
        <?php
        if (isset($_SESSION['updated'])) {
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success!</strong> ' .  $_SESSION['updated'] . '
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
          unset($_SESSION['updated']);
        }
        ?>
          <table class="table table-bordered">
            <thead class="thead-dark bg-dark  text-white">
              <tr class="py-3">
                <th class="py-3" scope="col">#</th>
                <th class="py-3" scope="col">Name</th>
                <th class="py-3" scope="col">Email</th>
                <th class="py-3" scope="col">City</th>
                <th class="py-3" scope="col">Region</th>
                <th class="py-3" scope="col">Country</th>
                <th class="py-3" scope="col">Edit</th>
                <th class="py-3" scope="col">Remove</th>

              </tr>
            </thead>
            <tbody>
              <?php
              $selectUsers = "SELECT * from traveluserdetails";
              $result = mysqli_query($conn, $selectUsers);
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

              ?>
                  <tr>
                    <td><?php echo $row['UID'];  ?></td>
                    <td><?php echo $row['FirstName'] . ' ' . $row['LastName'];  ?></td>
                    <td><?php echo $row['Email'];  ?></td>
                    <td><?php echo $row['City'];  ?></td>
                    <td><?php echo $row['Region'];  ?></td>
                    <td><?php echo $row['Country'];  ?></td>
                    <td><a href="edit.php?id=<?php echo $row['UID'];  ?>" class="btn btn-outline-warning d-grid">Edit</a></td>

                    <td><a href="delete.php?id=<?php echo $row['UID'];  ?>" class="btn btn-outline-danger d-grid">Delete</a></td>
                  </tr>
              <?php

                }
              }

              ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>

  <script src="../assets/js/script.js"></script>
</body>

</html>l
<?php
if (isset($_SESSION['logged-in'])) {
    $selectUserDetails = "SELECT traveluser.UserName,traveluser.State,traveluserdetails.* FROM traveluser
    INNER JOIN traveluserdetails ON traveluser.UserName = traveluserdetails.Email AND traveluserdetails.Email = '{$_SESSION['logged-in']}'
    GROUP BY traveluserdetails.UID;";

    $selectUserLoggedinDetails = mysqli_query($conn, $selectUserDetails);
    if (mysqli_num_rows($selectUserLoggedinDetails) > 0) {
        $loggedInUser = mysqli_fetch_assoc($selectUserLoggedinDetails);
    }
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#" style="font-size: 28px; font-weight: bold; margin-left: 10px;">Travel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul style="font-size: 20px;" class="navbar-nav me-auto mb-2 mx-4 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="about.php">About Us</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Browse
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="posts.php">Posts</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="images.php">Images</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="users.php">Users</a></li>
                    </ul>
                </li>
            </ul>
            <form action="globalSearch.php?search=<?php if (isset($_GET['search'])) {
                                                        echo $_GET['search'];
                                                    }  ?>" method="GET" class="mx-3 d-flex align-items-center justify-content-between flex-grow-1">
                <input class="form-control mr-2 flex-grow-1" type="search" placeholder="Search Places" name="search" aria-label="Search">
            </form>
            <ul style="font-size: 20px;" class=" navbar-nav me-auto mb-2 mx-4">
                <?php
                if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] !== "admin@gmail.com") {
                ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="myaccount.php">MyAccount</a>
                    </li>
                <?php
                }
                ?>
                <?php
                if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] === "admin@gmail.com") {
                    echo '<li class="nav-item">
                <a class="nav-link active" aria-current="page" href="admin/">Dashoard</a></li>';
                } else {
                    echo '<li class="nav-item">
                   <a class="nav-link active" aria-current="page" href="fav.php">Fav</a></li>';
                }
                ?>

                <?php
                if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] !== "admin@gmail.com") {
                    echo ' 
                     <li class="nav-item">
                    <a class="nav-link active" aria-current="page" style="cursor:pointer;">' . $loggedInUser['FirstName'] . '</a>
                 </li>
                 <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="logout.php">Logout</a>
                 </li>
                 ';
                } else  if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] === "admin@gmail.com") {

                    echo ' 
                    <li class="nav-item">
                   <a class="nav-link active" aria-current="page" style="cursor:pointer;">admin</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link active" aria-current="page" href="logout.php">Logout</a>
                </li>
                ';
                } else {
                    echo '
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="register.php">Register/Login</a>
                </li>';
                }

                ?>

            </ul>

        </div>
    </div>
</nav>
<div class="container-fluid py-2" style="background: #212121;">
    <div class="container">
        <a class="text-decoration-none btn btn-sm btn-light" href="searchByCountry.php">Search by Country</a>
        <a class="text-decoration-none btn btn-sm btn-light mx-3" href="searchByCity.php">Search by City</a>
    </div>
</div>
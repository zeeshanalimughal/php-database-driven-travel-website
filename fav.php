<?php
require "database/conn.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "links.php";  ?>
  <title>Fav</title>
</head>

<body>
  <?php include "nav.php";  ?>

  <section class="container-fluid px-2  gallery">
    <h1 class="mt-3 mx-3 fav-heading">You Favirout Place</h1>
    <?php  if(isset($_SESSION['favPlaces'])){
      ?>
      
      <div class="row w-100">
            <ul class="d-flex flex-md-wrap">
                <?php
         foreach($_SESSION['favPlaces'] as $fav){
         ?>
                        <li>
                            <a  href="singleImage.php?imageId=<?php echo $fav['ImageID'];?>">
                                    <img loading="lazy" src="<?php echo  "assets/images/large/" . $fav['ImagePath'];  ?>" alt="">

                                    <div class="imgDetails">
                                        <h2 class="title">
                                           <?php echo $fav['Title']  ?>
                                        </h2>
                                        <p class="description">
                                        <?php
                                        if($fav['Description']==""){
                                            echo "Description not found";
                                        }else{
                                            echo $fav['Description'] ;
                                        }
                                         
                                         ?>
                                        </p>
                                    </div>

                            </a>
                        </li>
                <?php
                    }
                
                ?>

            </ul>
        </div>
      <?php
    }else{
      ?>
      <script>
        document.querySelector(".fav-heading").innerHTML="Favourit place is not added";
      </script>
      <?php
    } 
    
    ?>
         

    </section> 




  <?php include "footer.php" ?>

  <script src="assets/js/script.js"></script>
</body>

</html>
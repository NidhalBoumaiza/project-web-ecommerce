<?php

session_start();

include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");

?>


<!-- Cover -->
<main>
  <div class="hero">
    <a href="shop.php" class="btn btn-info" style="float:right; margin-right:10%;"><h3>View all products</h3>
    </a>
  </div>
  <!-- Main -->
  <div class="wrapper">
    <h1>Featured Collection<h1>

  </div>



  <div id="content" class="container"><!-- container Starts -->

    <div class="row"><!-- row Starts -->

      <?php

      getProducts();

      ?>

    </div><!-- row Ends -->

  </div><!-- container Ends -->

  </body>

  </html>
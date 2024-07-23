<?php
session_start();

include("includes/db.php");
include("includes/header.php");

?>
<!-- MAIN -->
<main>
  <!-- HERO -->
  <div class="nero">
    <div class="nero__heading">
      <span class="nero__bold">shop</span> AT BM
    </div>
    <p class="nero__text">
    </p>
  </div>
</main>


<?php
$db = mysqli_connect("localhost", "root", "", "ecom_store");

$aMan = $aPCat = $aCat = array();

function processArray($input, &$output)
{
  if (isset($_REQUEST[$input]) && is_array($_REQUEST[$input])) {
    foreach ($_REQUEST[$input] as $sVal) {
      if ((int)$sVal != 0) {
        $output[(int)$sVal] = (int)$sVal;
      }
    }
  }
}

processArray('man', $aMan);
processArray('p_cat', $aPCat);
processArray('cat', $aCat);

function getRealUserIp()
{
  switch (true) {
    case (!empty($_SERVER['HTTP_X_REAL_IP'])):
      return $_SERVER['HTTP_X_REAL_IP'];
    case (!empty($_SERVER['HTTP_CLIENT_IP'])):
      return $_SERVER['HTTP_CLIENT_IP'];
    case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
      return $_SERVER['HTTP_X_FORWARDED_FOR'];
    default:
      return $_SERVER['REMOTE_ADDR'];
  }
}
function getProducts($db, $aMan, $aPCat, $aCat)
{
  $aWhere = array();

  if (!empty($aMan)) {
    $aWhere[] = "manufacturer_id IN (" . implode(",", $aMan) . ")";
  }

  if (!empty($aPCat)) {
    $aWhere[] = "p_cat_id IN (" . implode(",", $aPCat) . ")";
  }

  if (!empty($aCat)) {
    $aWhere[] = "cat_id IN (" . implode(",", $aCat) . ")";
  }

  $sWhere = (count($aWhere) > 0 ? ' WHERE ' . implode(' AND ', $aWhere) : '');

  $query = "SELECT * FROM products $sWhere ORDER BY 1 DESC";
  $result = mysqli_query($db, $query);

  while ($row = mysqli_fetch_array($result)) {
    $pro_id = $row['product_id'];
    $pro_title = $row['product_title'];
    $pro_price = $row['product_price'];
    $pro_img1 = $row['product_img1'];

    echo "
        <div class='col-md-4 col-sm-6 center-responsive'>
            <div class='product'>
                <a href='details.php?pro_id=$pro_id'>
                    <img src='admin_area/product_images/$pro_img1' class='img-responsive'>
                </a>
                <div class='text'>
                    <h3><a href='details.php?pro_id=$pro_id'>$pro_title</a></h3>
                    <p class='price'>$$pro_price</p>
                    <p class='buttons'>
                        <a href='details.php?pro_id=$pro_id' class='btn btn-default'>View Details</a>
                        <a href='details.php?pro_id=$pro_id' class='btn btn-primary'>
                            <i class='fa fa-shopping-cart'></i> Add to Cart
                        </a>
                    </p>
                </div>
            </div>
        </div>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop</title>
  <link rel="stylesheet" href="styles/bootstrap.min.css">
  <link rel="stylesheet" href="styles/style.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>

<body>

  <div class="container">
    <div class="row">

  <script>
    $(document).ready(function() {
      $('.get_manufacturer, .get_p_cat, .get_cat').on('change', function() {
        var selectedFilters = [];

        $('.get_manufacturer:checked').each(function() {
          selectedFilters.push('man[]=' + $(this).val());
        });

        $('.get_p_cat:checked').each(function() {
          selectedFilters.push('p_cat[]=' + $(this).val());
        });

        $('.get_cat:checked').each(function() {
          selectedFilters.push('cat[]=' + $(this).val());
        });

        window.location.href = 'shop.php?' + selectedFilters.join('&');
      });
    });
  </script>

</body>

</html>
<div id="content"><!-- content Starts -->
  <div class="container"><!-- container Starts -->

    <div class="col-md-12"><!--- col-md-12 Starts -->



    </div><!--- col-md-12 Ends -->

    <div class="col-md-3"><!-- col-md-3 Starts -->

      <?php include("includes/sidebar.php"); ?>

    </div><!-- col-md-3 Ends -->

    <div class="row"><!-- col-md-9 Starts --->


      <?php getProducts($db, $aMan, $aPCat, $aCat); ?>

    </div><!-- row Ends -->

    <center><!-- center Starts -->


    </center><!-- center Ends -->



  </div><!-- col-md-9 Ends --->



</div><!--- wait Ends -->

</div><!-- container Ends -->
</div><!-- content Ends -->



<?php



?>

<script src="js/jquery.min.js"> </script>

<script src="js/bootstrap.min.js"></script>

<script>
  $(document).ready(function() {

    /// Hide And Show Code Starts ///

    $('.nav-toggle').click(function() {

      $(".panel-collapse,.collapse-data").slideToggle(700, function() {

        if ($(this).css('display') == 'none') {

          $(".hide-show").html('Show');

        } else {

          $(".hide-show").html('Hide');

        }

      });

    });

    /// Hide And Show Code Ends ///

    /// Search Filters code Starts ///

    $(function() {

      $.fn.extend({

        filterTable: function() {

          return this.each(function() {

            $(this).on('keyup', function() {

              var $this = $(this),

                search = $this.val().toLowerCase(),

                target = $this.attr('data-filters'),

                handle = $(target),

                rows = handle.find('li a');

              if (search == '') {

                rows.show();

              } else {

                rows.each(function() {

                  var $this = $(this);

                  $this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();

                });

              }

            });

          });

        }

      });

      $('[data-action="filter"][id="dev-table-filter"]').filterTable();

    });

    /// Search Filters code Ends ///

  });
</script>


<script>
  $(document).ready(function() {

    // getProducts Function Code Starts

    function getProducts($db, $aMan, $aPCat, $aCat) {

      // Manufacturers Code Starts

      var sPath = '';

      var aInputs = $('li').find('.get_manufacturer');

      var aKeys = Array();

      var aValues = Array();

      iKey = 0;

      $.each(aInputs, function(key, oInput) {

        if (oInput.checked) {

          aKeys[iKey] = oInput.value

        };

        iKey++;

      });

      if (aKeys.length > 0) {

        var sPath = '';

        for (var i = 0; i < aKeys.length; i++) {

          sPath = sPath + 'man[]=' + aKeys[i] + '&';

        }

      }

      // Manufacturers Code ENDS

      // Products Categories Code Starts

      var aInputs = Array();

      var aInputs = $('li').find('.get_p_cat');

      var aKeys = Array();

      var aValues = Array();

      iKey = 0;

      $.each(aInputs, function(key, oInput) {

        if (oInput.checked) {

          aKeys[iKey] = oInput.value

        };

        iKey++;

      });

      if (aKeys.length > 0) {

        for (var i = 0; i < aKeys.length; i++) {

          sPath = sPath + 'p_cat[]=' + aKeys[i] + '&';

        }

      }

      // Products Categories Code ENDS

      // Categories Code Starts

      var aInputs = Array();

      var aInputs = $('li').find('.get_cat');

      var aKeys = Array();

      var aValues = Array();

      iKey = 0;

      $.each(aInputs, function(key, oInput) {

        if (oInput.checked) {

          aKeys[iKey] = oInput.value

        };

        iKey++;

      });

      if (aKeys.length > 0) {

        for (var i = 0; i < aKeys.length; i++) {

          sPath = sPath + 'cat[]=' + aKeys[i] + '&';

        }

      }

      // Categories Code ENDS

      // Loader Code Starts

      $('#wait').html('<img src="images/load.gif">');

      // Loader Code ENDS

      // ajax Code Starts

      $.ajax({

        url: "load.php",

        method: "POST",

        data: sPath + 'sAction=getProducts',

        success: function(data) {

          $('#Products').html('');

          $('#Products').html(data);

          $("#wait").empty();

        }

      });

      // ajax Code Ends

    }


    // getProducts Function Code Ends

    $('.get_manufacturer').click(function() {

      getProducts($db, $aMan, $aPCat, $aCat);

    });


    $('.get_p_cat').click(function() {

      getProducts($db, $aMan, $aPCat, $aCat);

    });

    $('.get_p_cat').click(function() {

      getProducts($db, $aMan, $aPCat, $aCat);

    });


  });
</script>

</body>

</html>
<?php $shop_php_included = true; ?>
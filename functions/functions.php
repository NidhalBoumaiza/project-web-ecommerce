<?php

$db = mysqli_connect("localhost", "root", "", "ecom_store");
if (!$db) {
  // Handle database connection error
  die("Database connection failed: " . mysqli_connect_error());
}
/// IP address code starts /////
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
/// IP address code Ends /////


// items function Starts ///
function items()
{
  global $db;

  $ip_add = getRealUserIp();

  $get_items = "select * from cart where ip_add='$ip_add'";

  $run_items = mysqli_query($db, $get_items);

  $count_items = mysqli_num_rows($run_items);

  echo $count_items;
}
// items function Ends ///

// total_price function Starts //
function total_price()
{
  global $db;

  $ip_add = getRealUserIp();

  $total = 0;

  $select_cart = "select * from cart where ip_add='$ip_add'";

  $run_cart = mysqli_query($db, $select_cart);

  while ($record = mysqli_fetch_array($run_cart)) {

    $pro_id = $record['p_id'];

    $pro_qty = $record['qty'];

    $sub_total = $record['p_price'] * $pro_qty;

    $total += $sub_total;
  }

  echo "$" . $total;
}
// total_price function Ends ///

// getProducts function Starts ///
function getProducts()
{
  global $db;

  $aWhere = array();
  $aPath = '';

  // Check if manufacturer filter is applied
  if (isset($_REQUEST['man']) && is_array($_REQUEST['man'])) {
    foreach ($_REQUEST['man'] as $sKey => $sVal) {
      if ((int)$sVal != 0) {
        $aWhere[] = 'manufacturer_id=' . (int)$sVal;
        $aPath .= 'man[]=' . (int)$sVal . '&';
      }
    }
  }

  // Check if product category filter is applied
  if (isset($_REQUEST['p_cat']) && is_array($_REQUEST['p_cat'])) {
    foreach ($_REQUEST['p_cat'] as $sKey => $sVal) {
      if ((int)$sVal != 0) {
        $aWhere[] = 'p_cat_id=' . (int)$sVal;
        $aPath .= 'p_cat[]=' . (int)$sVal . '&';
      }
    }
  }

  // Check if category filter is applied
  if (isset($_REQUEST['cat']) && is_array($_REQUEST['cat'])) {
    foreach ($_REQUEST['cat'] as $sKey => $sVal) {
      if ((int)$sVal != 0) {
        $aWhere[] = 'cat_id=' . (int)$sVal;
        $aPath .= 'cat[]=' . (int)$sVal . '&';
      }
    }
  }

  // Build SQL query with the applied filters
  $per_page = 6;
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  } else {
    $page = 1;
  }

  $start_from = ($page - 1) * $per_page;

  $sLimit = " order by 1 DESC LIMIT $start_from,$per_page";

  $sWhere = (count($aWhere) > 0 ? ' WHERE ' . implode(' OR ', $aWhere) : '') . $sLimit;

  $get_products = "SELECT * FROM products" . $sWhere;

  $run_products = mysqli_query($db, $get_products);

  while ($row_products = mysqli_fetch_array($run_products)) {

    $pro_id = $row_products['product_id'];

    $pro_title = $row_products['product_title'];

    $pro_price = $row_products['product_price'];

    $pro_img1 = $row_products['product_img1'];

    echo "
    <div class='col-md-4 col-sm-6 center-responsive' >
      <div class='product' >
        <a href='details.php?pro_id=$pro_id' >
          <img src='admin_area/product_images/$pro_img1' class='img-responsive' >
        </a>
        <div class='text' >
          <h3><a href='details.php?pro_id=$pro_id' >$pro_title</a></h3>
          <p class='price' >$$pro_price</p>
          <p class='buttons' >
            <a href='details.php?pro_id=$pro_id' class='btn btn-default' >View Details</a>
            <a href='details.php?pro_id=$pro_id' class='btn btn-primary'>
              <i class='fa fa-shopping-cart'></i> Add to Cart
            </a>
          </p>
        </div>
      </div>
    </div>
    ";
  }
}

// getProducts function Ends ///

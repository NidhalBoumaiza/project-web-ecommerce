<?php
$db = mysqli_connect("localhost", "root", "", "ecom_store");

$aMan = $aPCat = $aCat = array();
processArray('man', $aMan);
processArray('p_cat', $aPCat);
processArray('cat', $aCat);

?>

<div class="panel panel-default sidebar-menu">
    <div class="panel-heading">
        <h3 class="panel-title">Manufacturers</h3>
    </div>
    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked category-menu">
            <?php
            $get_manfacturer = "SELECT * FROM manufacturers";
            $run_manfacturer = mysqli_query($db, $get_manfacturer);
            while ($row_manfacturer = mysqli_fetch_array($run_manfacturer)) {
                $manufacturer_id = $row_manfacturer['manufacturer_id'];
                $manufacturer_title = $row_manfacturer['manufacturer_title'];
                $manufacturer_image = $row_manfacturer['manufacturer_image'];
                if ($manufacturer_image != "") {
                    $manufacturer_image = "<img src='admin_area/other_images/$manufacturer_image' width='20px'>&nbsp;";
                }
            ?>
                <li class="checkbox checkbox-primary">
                    <label>
                        <input <?php if (isset($aMan[$manufacturer_id])) echo "checked='checked'"; ?> type="checkbox" value="<?php echo $manufacturer_id; ?>" class="get_manufacturer">
                        <span><?php echo $manufacturer_image . $manufacturer_title; ?></span>
                    </label>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<!-- Products Categories -->
<div class="panel panel-default sidebar-menu">
    <div class="panel-heading">
        <h3 class="panel-title">Products Categories</h3>
    </div>
    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked category-menu">
            <?php
            $get_p_cats = "SELECT * FROM product_categories";
            $run_p_cats = mysqli_query($db, $get_p_cats);
            while ($row_p_cats = mysqli_fetch_array($run_p_cats)) {
                $p_cat_id = $row_p_cats['p_cat_id'];
                $p_cat_title = $row_p_cats['p_cat_title'];
                $p_cat_image = $row_p_cats['p_cat_image'];
                if ($p_cat_image != "") {
                    $p_cat_image = "<img src='admin_area/other_images/$p_cat_image' width='20'>&nbsp;";
                }
            ?>
                <li class="checkbox checkbox-primary">
                    <label>
                        <input <?php if (isset($aPCat[$p_cat_id])) echo "checked='checked'"; ?> type="checkbox" value="<?php echo $p_cat_id; ?>" class="get_p_cat">
                        <span><?php echo $p_cat_image . $p_cat_title; ?></span>
                    </label>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<!-- Categories -->
<div class="panel panel-default sidebar-menu">
    <div class="panel-heading">
        <h3 class="panel-title">Categories</h3>
    </div>
    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked category-menu">
            <?php
            $get_cat = "SELECT * FROM categories";
            $run_cat = mysqli_query($db, $get_cat);
            while ($row_cat = mysqli_fetch_array($run_cat)) {
                $cat_id = $row_cat['cat_id'];
                $cat_title = $row_cat['cat_title'];
                $cat_image = $row_cat['cat_image'];
                if ($cat_image != "") {
                    $cat_image = "<img src='admin_area/other_images/$cat_image' width='20'>&nbsp;";
                }
            ?>
                <li class="checkbox checkbox-primary">
                    <label>
                        <input <?php if (isset($aCat[$cat_id])) echo "checked='checked'"; ?> type="checkbox" value="<?php echo $cat_id; ?>" class="get_cat">
                        <span><?php echo $cat_image . $cat_title; ?></span>
                    </label>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

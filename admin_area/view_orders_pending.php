<?php


if (!isset($_SESSION['admin_email'])) {

    echo "<script>window.open('login.php','_self')</script>";
} else {


?>

    <div class="row"><!-- 1 row Starts -->

        <div class="col-lg-12"><!-- col-lg-12 Starts -->

            <ol class="breadcrumb"><!-- breadcrumb Starts  --->

                <li class="active">

                    <i class="fa fa-dashboard"></i> Dashboard / View Orders

                </li>

            </ol><!-- breadcrumb Ends  --->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 1 row Ends -->


    <div class="row"><!-- 2 row Starts -->

        <div class="col-lg-12"><!-- col-lg-12 Starts -->

            <div class="panel panel-default"><!-- panel panel-default Starts -->

                <div class="panel-heading"><!-- panel-heading Starts -->

                    <h3 class="panel-title"><!-- panel-title Starts -->

                        <i class="fa fa-money fa-fw"></i> View Orders

                    </h3><!-- panel-title Ends -->

                </div><!-- panel-heading Ends -->

                <div class="panel-body"><!-- panel-body Starts -->

                    <div class="table-responsive"><!-- table-responsive Starts -->

                        <table class="table table-bordered table-hover table-striped"><!-- table table-bordered table-hover table-striped Starts -->

                            <thead><!-- thead Starts -->

                                <tr>

                                    <th>#</th>
                                    <th>customer_id </th>
                                    <th>Invoice</th>

                                    <th>Qty</th>
                                    <th>Size</th>
                                    <th>Order Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>


                                </tr>

                            </thead><!-- thead Ends -->


                            <tbody><!-- tbody Starts -->

                                <?php

                                $i = 0;

                                $get_orderss = "SELECT * FROM customer_orders WHERE order_status='pending'";

                                $run_orderss = mysqli_query($con, $get_orderss);

                                while ($row_orders = mysqli_fetch_array($run_orderss)) {


                                    $c_id = $row_orders['customer_id'];

                                    $invoice_no = $row_orders['invoice_no'];

                                    $qty = $row_orders['qty'];

                                    $size = $row_orders['size'];

                                    $order_status = $row_orders['order_status'];
                                    $order_date = $row_orders['order_date'];
                                    $due_amount = $row_orders['due_amount'];
                                    $i++;

                                ?>

                                    <tr>

                                        <td><?php echo $i; ?></td>

                                        <td>
                                            <?php

                                            $get_customer = "select * from customers where customer_id='$c_id'";

                                            $run_customer = mysqli_query($con, $get_customer);

                                            $row_customer = mysqli_fetch_array($run_customer);

                                            $customer_email = $row_customer['customer_email'];

                                            echo $customer_email;

                                            ?>
                                        </td>

                                        <td bgcolor="orange"><?php echo $invoice_no; ?></td>

                                        <td><?php echo $qty; ?></td>

                                        <td><?php echo $size; ?></td>

                                        <td><?php echo $order_date; ?></td>

                                        <td>$<?php echo $due_amount; ?></td>

                                        <td>
                                            <?php

                                            if ($order_status == 'pending') {

                                                echo $order_status = '<div style="color:red;">Pending</div>';
                                            } 

                                            ?>
                                        </td>

                                        <td>

                                            <a href="index.php?order_delete=<?php echo $order_id; ?>">

                                                <i class="fa fa-trash-o"></i> Delete

                                            </a>

                                        </td>


                                    </tr>

                                <?php } ?>

                            </tbody><!-- tbody Ends -->

                        </table><!-- table table-bordered table-hover table-striped Ends -->

                    </div><!-- table-responsive Ends -->

                </div><!-- panel-body Ends -->

            </div><!-- panel panel-default Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 2 row Ends -->


<?php } ?>
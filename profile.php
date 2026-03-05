<?php
include("template.php");
head("My Orders", 0);
$cusobj = new MysqliDb(HOST, USER, PWD, DB);
$cusobj->where("cust_id", $_SESSION["CUST"]);
$cusobj->where("om_status",-1,"<>");
$cusobj->orderBy("om_date","DESC");
$cusobj->join("tbl_order_detail od", "od.om_id=om.om_id");
$orders = $cusobj->get("tbl_order_master om", null, "od.od_json,od.price,om.om_date,od.qty,om_status,om_total");
?>

<!-- page-title -->
<div class="tf-page-title"
    style="background-color: #fbae16;background-image: url('<?php echo ROOT ?>images/bg.png');background-size: cover;background-repeat: no-repeat;">
    <div class="container-full">
        <div class="heading text-center">My Orders</div>
        <!-- <p class="text-center text-2 text_black-2 mt_5">We’re here to help—reach out with any questions or support needs. </p> -->
    </div>
</div>
<!-- /page-title -->
<section class="flat-spacing-11">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="wrap-sidebar-account">
                            <ul class="my-account-nav">
                                <li><a href="<?php echo ROOT ?>orders" class="my-account-nav-item active">Orders</a></li>
                                <li><a href="<?php echo ROOT ?>account-details" class="my-account-nav-item ">Account Details</a></li>
                                <li><a href="<?php echo ROOT ?>change-password" class="my-account-nav-item">Change Password</a></li>
                                <li><a href="<?php echo ROOT ?>logout" class="my-account-nav-item">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                   <div class="col-lg-9">
                        <div class="my-account-content account-order">
                            <div class="wrap-account-order">
                                <?php
                                 if (!empty($orders)) {
                                    ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="fw-6">Product</th>
                                            <th class="fw-6">Total Price</th>
                                            <th class="fw-6">Order Date</th>
                                            <th class="fw-6">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $od) {
                                                    $pdtdtl = json_decode($od["od_json"]);
                                                ?>
                                        <tr class="tf-order-item">
                                            <td> <div class="d-flex flex-wrap align-items-center ">
                                                                <!-- <div class="cart-product-img overflow-hidden"><a href="#"> -->
                                                                    <img class="img-fluid" style="width: 80px;padding-right: 10px;" src="<?php echo ROOT . "uploads/thumb/" . $pdtdtl->image ?>" alt="Cart Image 1"></a>
                                                                <!-- </div> -->
                                                                <h6 class="mb-0"><a href="#"><?php echo $pdtdtl->name ?></a>
                                                                    <br>
                                                                    <span style="font-size: 14px;">Quantity : <?php echo $od["qty"] ?> | Color : <?php echo $pdtdtl->color ?> | Size : <?php echo $pdtdtl->size ?> </span>
                                                                </h6>
                                                            </div></td>
                                            <td><span class="price"><?php echo "AED " . ($od["price"]*$od["qty"]) ?></span></td>
                                            <td><?php echo date("j M Y", strtotime($od["om_date"])); ?></td>
                                            
                                            <td><div class="badge"><?php echo $od["om_status"]==0?"Processing":"Shipped" ?></div></td>
                                            
                                        </tr>
                                        <?php } ?>
                                       

                                    </tbody>
                                </table>
                                <?php } else {
                                        echo "<p>No orders to display.</p>";
                                    } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- page-cart -->

        <div class="btn-sidebar-account">
            <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount" aria-controls="offcanvas"><i
                    class="icon icon-sidebar-2"></i></button>
        </div>
   <div class="btn-sidebar-account">
            <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount" aria-controls="offcanvas"><i
                    class="icon icon-sidebar-2"></i></button>
        </div>
        <!-- sidebar account-->
    <div class="offcanvas offcanvas-start canvas-filter canvas-sidebar canvas-sidebar-account" id="mbAccount">
        <div class="canvas-wrapper">
            <header class="canvas-header">
                <span class="title">SIDEBAR ACCOUNT</span>
                <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
            </header>
            <div class="canvas-body sidebar-mobile-append">

            </div>

        </div>
    </div>
    <!-- End sidebar account -->
<?php footer(); ?>
</div>

<?php scripts(); ?>

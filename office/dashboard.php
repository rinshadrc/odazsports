<?php
include("template.php");
head("Odaz Sports | Dashboard");
main_nav();

$db = new MysqliDb(HOST, USER, PWD, DB);

// Fetch total confirmed orders (om_status=2 → delivered/confirmed)
$db->where("om_status", -1,"<>");
$totalOrders = $db->getValue("tbl_order_master", "count(*)");

// Fetch total customers
$totalCustomers = $db->getValue("tbl_customers", "count(*)");
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6">
      
      <!-- Total Orders -->
      <div class="col-xxl-6 col-sm-6">
        <div class="card h-100">
          <div class="card-body d-flex justify-content-between align-items-center">
            <!-- Left side icon -->
            <div class="avatar">
              <div class="avatar-initial bg-label-warning rounded-3">
                <i class="ri-shopping-cart-2-line ri-24px"></i>
              </div>
            </div>
            <!-- Right side value + label -->
            <div class="text-end">
              <h5 class="mb-1"><?php echo $totalOrders; ?></h5>
              <div class="badge bg-label-warning rounded-pill">Total Confirmed Orders</div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Total Customers -->
      <div class="col-xxl-6 col-sm-6">
        <div class="card h-100">
          <div class="card-body d-flex justify-content-between align-items-center">
            <!-- Left side icon -->
            <div class="avatar">
              <div class="avatar-initial bg-label-info rounded-3">
                <i class="ri-user-line ri-24px"></i>
              </div>
            </div>
            <!-- Right side value + label -->
            <div class="text-end">
              <h5 class="mb-1"><?php echo $totalCustomers; ?></h5>
              <div class="badge bg-label-info rounded-pill">Total Customers</div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <?php
  footer();
  scripts();
  ?>
</body>
</html>

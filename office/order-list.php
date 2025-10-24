<?php
include("template.php");
head("Odaz Sports | List of Orders");
main_nav();
ini_set("display_errors",0);
$sts=$_GET["sts"]?:null;
?>
<!-- Vendors CSS -->
<link rel="stylesheet" href="<?php echo ROOT ?>plugins/datatables-bs5/datatables.bootstrap5.css">

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Items List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Orders List</h5>
            </div>
            <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0 p-5 ">
                <div class="col-md-3 date_filter"></div>
            </div>
            <div class="card-datatable table-responsive">
                <?php
                $orderobj = new MysqliDb(HOST, USER, PWD, DB);
                if($sts==0){
                $orderobj->where("om_status",[0,1], "IN");
                }else if($sts==2){
                $orderobj->where("om_status", 2);
                }else{
                $orderobj->where("om_status", -1, "<>");
                }
                $orderobj->orderBy("om_id", "DESC");
                $orderarr = $orderobj->get("tbl_order_master", null, "om_id,fname,lname,mobile,postcode,address,city,landmark,state,om_total,om_date,om_status,om_num");
                //echo $orderobj->getLastQuery();
                ?>
                <table class="tblOrders table">
                    <thead>
                        <tr>
                            <th>Si NO</th>
                            <th>Order Number</th>
                            <th>Customer</th>
                            <th>Address</th>
                            <th>Order Date</th>
                            <!-- <th>Amount</th> -->
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $status = ["0" => ["label" => "Pending","class" => "bg-label-warning"],"1"=> ["label" => "Accepted",  "class" => "bg-label-primary"],"2" => ["label" => "Delivered", "class" => "bg-label-success"]];

                        foreach ($orderarr as $key => $itm) {
                        ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $itm["om_num"]; ?></td>
                                <td><?php echo $itm["fname"]." ".$itm["lname"]."<br>".$itm["mobile"]; ?></td>
                                <td><?php echo $itm["state"]."<br>".$itm["postcode"]; ?></td>
                                <td><?php echo date("j M Y", strtotime($itm["om_date"])); ?></td>
                                <!-- <td><?php echo "₹".$itm["om_total"] ?></td> -->
                                <td><div class="badge <?php echo $status[$itm["om_status"]]["class"]; ?> rounded-pill"><?php echo $status[$itm["om_status"]]["label"]; ?></div></td>
                                <td>
                                <a href="#" class="btn btn-sm btn-outline-primary me-3 waves-effect openModal" data-id="<?php echo $itm["om_id"] ?>"><i class="tf-icons ri-sticky-note-line ri-14px me-1"></i>Details</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- Offcanvas to add new item -->
            
        </div>
    </div>
    <!-- / Content -->

  <!--/ Order Details Modal  -->

  <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-0">
          <div class="text-center mb-6">
            <h5 class="mb-2 badge bg-label-info" id="orderNum"></h5> 
          </div>
          <div class="card h-100">
            <div class="card-body">
              <div id="custDetails" style="font-size: 13px; line-height: 1.6;"></div>
            </div>
          </div>
          <div class="card mt-4">
            <h5 class="card-header text-secondary">Order Products</h5>
            <div class="table-responsive text-nowrap">
              <table class="table" style="font-size: 13px;">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Colour</th>
                    <th>Quantity</th>
                    <th>Price</th>
                  </tr>
                </thead >
                <tbody class="table-border-bottom-0" id="orderProducts"> 
                </tbody>
              
              </table>
            </div>
          </div>
          <div class="card h-100" style="margin-top: 10px;">
            <div class="card-body">
              <div style="text-align: center;">
                  <a class="btn btn-primary text-white" id="btnStatus"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Order Details Modal Ends -->

    <?php footer();
    scripts(); ?>

    <script src="<?php echo ROOT ?>plugins/datatables-bs5/datatables-bootstrap5.js"></script>
    <script>
        $(function() {

            $(".tblOrders").DataTable({
                pageLength: 100,
                dom: '<"row"<"col-md-2 d-flex align-items-center justify-content-md-start justify-content-center"<"dt-action-buttons mt-5 mt-md-0"B>><"col-md-10"<"d-flex align-items-center justify-content-md-end justify-content-center"<"me-4"f><"add-new">>>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                language: {
                    sLengthMenu: "Show _MENU_",
                    search: "",
                    searchPlaceholder: "Search Items",
                    paginate: {
                        next: '<i class="ri-arrow-right-s-line"></i>',
                        previous: '<i class="ri-arrow-left-s-line"></i>'
                    }
                },
                dom: '<"row"<"col-md-2 d-flex align-items-center justify-content-md-start justify-content-center"<"dt-action-buttons mt-5 mt-md-0"B>><"col-md-10"<"d-flex align-items-center justify-content-md-end justify-content-center"<"me-4"f><"add-new">>>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                language: {
                    sLengthMenu: "Show _MENU_",
                    search: "",
                    searchPlaceholder: "Search Order",
                    paginate: {
                        next: '<i class="ri-arrow-right-s-line"></i>',
                        previous: '<i class="ri-arrow-left-s-line"></i>'
                    } 
                },
                buttons: [{
                    extend: "collection",
                    className: "btn btn-outline-secondary dropdown-toggle waves-effect waves-light",
                    text: '<span class="d-flex align-items-center"><i class="ri-upload-2-line ri-16px me-2"></i> <span class="d-none d-sm-inline-block">Export</span></span>',
                    buttons: [{
                            extend: "excel",
                            text: '<i class="ri-file-excel-line me-1"></i>Excel',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [1, 2, 3,4,5]
                            }
                        },
                        {
                            extend: "print",
                            text: '<i class="ri-printer-line me-1"></i>Print', 
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [1, 2, 3,4,5]
                            }
                        },
                        {
                            extend: "csv",
                            text: '<i class="ri-file-text-line me-1"></i>Csv',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [1, 2, 3,4,5]
                            } 
                        },

                        {
                            extend: "pdf",
                            text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [1, 2, 3,4,5]
                            }
                        },

                    ]
                }],
                initComplete: function() {
                    this.api()
                        .columns(4)
                        .every(function() {
                            var t = this,
                                n = $('<select class="form-select form-select-sm text-capitalize"><option value=""> All Date </option></select>')
                                .appendTo(".date_filter")
                                .on("change", function() {
                                    var e = $.fn.dataTable.util.escapeRegex($(this).val());
                                    t.search(e ? "^" + e + "$" : "", !0, !1).draw();
                                });
                            t.data()
                                .unique()
                                .sort()
                                .each(function(e, t) {
                                    n.append('<option value="' + e + '">' + e + "</option>");
                                });
                        });
                },

            });

    $(document).on("click",".openModal",function(evt) {
    evt.preventDefault();
    id=$(this).data("id");
    $.ajax({
        url: '<?php echo ROOT?>ajax/sale-ajax.php',
        type: 'POST', 
        data: {action: 'orderDetails', omid: id},
        beforeSend: function() {
            $("#orderProducts").empty();
        },
        success:function(response){
            try {
                let orderdetails = $.parseJSON(response);

                $("#detailModal").modal("show");

                $("#orderNum").text(orderdetails.master.om_num);
                $("#custDetails").html(
                  (orderdetails.master.mobile   ? "<strong>Mobile:</strong> " + orderdetails.master.mobile + "<br>" : "") +
                  (orderdetails.master.address  ? orderdetails.master.address   + "<br>" : "") +
                  (orderdetails.master.landmark ? orderdetails.master.landmark  + "<br>" : "") +
                  (orderdetails.master.city     ? orderdetails.master.city      + "<br>" : "") +
                  (orderdetails.master.state    ? orderdetails.master.state     + "<br>" : "") +
                  (orderdetails.master.postcode ? orderdetails.master.postcode  : "")
              );
                let prdHTML = "";
                $.each(orderdetails.detail, function(i, item){
                    prdHTML += `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.size}</td>
                            <td>${item.color}</td>
                            <td>${item.qty}</td>
                            <td>${item.price}</td>
                        </tr>
                    `;
                });
                prdHTML += `
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total Price</strong></td>
                        <td><strong>${orderdetails.master.om_total}</strong></td>
                    </tr>
                `;

                $("#orderProducts").html(prdHTML);

                // Handle status button
                let status = parseInt(orderdetails.master.om_status);
                btnstatus={0:{"class":"btn btn-warning text-white","text":"Accept Order",},1:{"class":"btn btn-primary text-white","text":"Dispatch Order",},2:{"class":"btn btn-success text-white","text":"Delivered"}}  
                $("#btnStatus").attr({"data-omid":id,"class":btnstatus[status].class,"data-sts":status}).html(btnstatus[status].text).prop("disabled", (status == 2));

            } catch (err){	
                console.log(err)
            }
        } 
    });
});
let clicked = false; // define globally or outside the function

$(document).on("click", "#btnStatus", function() {
    if (clicked) {
        return false;
    }
    clicked = true;

    let omid = $(this).data("omid");
    let cursts = parseInt($(this).data("sts"));
    let nxtsts = cursts + 1;  // increment status properly

    $.ajax({
        url: '<?php echo ROOT?>ajax/sale-ajax.php',
        type: 'POST',
        data: {action: 'updateStatus', omid: omid, status: nxtsts},
        success: function(response) {
            clicked = false; // reset lock

            try {
                let res = $.parseJSON(response);
                if (res.status === "done") {
                       location.reload(); // reload the whole page
                } else {
                    console.log("error updating status");
                }
            } catch (err) {
                console.log(err);
            }
        },
        error: function() {
            clicked = false; // reset lock on error too
        }
    });
});
// $(document).on('hidden.bs.modal', '#detailModal', function () {
//     location.reload(); // reload the whole page
// });



        });
    </script>
    </body>

    </html>
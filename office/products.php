<?php
include("template.php");
head("Odaz Sports | List of Products");
main_nav();

$pdtobj = new MysqliDb(HOST, USER, PWD, DB);
$pdtobj->where("pm_status", 9, "<>");
$pdtobj->where("pd_status", 9, "<>");
$pdtobj->join("tbl_category ct", "ct.ct_id=pm.ct_id", "INNER");
$pdtobj->join("tbl_product_detail pd", "pd.pm_id=pm.pm_id","INNER");
$pdtobj->groupBy("pm.pm_id");
$pdtarray = $pdtobj->get("tbl_product_master pm", null, "pm.pm_id,pm_name,pm_desc,pm_code,pm_note,pm_status,pm.ct_id,sct_id,is_featured,offer_tag,pm_image,ct.ct_title");

?>
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <section class="custom">
      <div class="row mb-5 border-bottom">
        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-6 text-center text-sm-start gap-2">
          <div class="mb-2 mb-sm-0">
            <h5 class="card-title mb-0 ms-2 text-nowrap text-red">Products</h5>
          </div>
          <div>
            <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search Product">
          </div>
        </div>
      </div>
      <div class="row ">
        <h6 class="text-light fw-medium" id="msgNoData"></h6>
        <?php foreach ($pdtarray as $pdts){ ?>
          <div class="col-12 col-sm-4 col-lg-4 mb-6 tile" data-pdt="<?php echo strtolower($pdts["pm_name"]); ?>">
            <div class="card">
              <div class="front" style="padding: var(--bs-card-spacer-y) var(--bs-card-spacer-x);">
                <div class="row">
                  <div class="col-md-4">
                    <div> <img class="bor8" src="<?php echo $pdts['pm_image'] ? ROOT . 'uploads/' . $pdts['pm_image'] : ROOT . 'uploads/default.jpg' ?>" alt="Image" style="width: 100%;border-radius: 8px;">
                    </div>
                  </div>
                  <div class="col-md-8 text-left">
                    <h6 class="mt-4 fw-medium" style="margin-top: 0px !important;margin-bottom: 5px;"><?php echo $pdts["pm_name"] ?></h6>
                    <p style="font-size: 12px;margin-bottom: 5px;">Product No. : <?php echo $pdts["pm_code"] ?></p>
                    <p style="font-size: 12px;margin-bottom: 5px;">Category : <?php echo $pdts["ct_title"] ?></p>
                   
                    <div class="d-flex text-left">
                      <a href="<?php echo ADMINROOT . "update-product/" . $pdts["pm_id"] ?>" class="btn btn-sm  btn-outline-secondary btn-icon waves-effect me-4" ><i class="ri-edit-box-line "></i></a>
                      <a href="#" class="btn btn-sm  btn-outline-danger btn-icon waves-effect me-4 openDelModal" data-title="Product" data-type="products" data-delid="<?php echo $pdts["pm_id"] ?>"><i class="ri-delete-bin-line "></i></a>
                      <a href="#" class="btn btn-sm btn-outline-primary me-3 waves-effect openModal" data-id="<?php echo $pdts['pm_id']; ?>" data-no="<?php echo $pdts['pm_code']; ?>" data-ttl="<?php echo $pdts['pm_name']; ?>" data-desc="<?php echo $pdts['pm_desc']; ?>" data-tag="<?php echo $pdts['offer_tag']; ?>"><i class="tf-icons ri-sticky-note-line ri-14px me-1"></i>Details</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      
    </section>
  </div>
  <!-- / Content -->

  <!--/ Product Details Modal  -->

  <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-0">
          <div class="text-center mb-6">
            <h5 class="mb-2" id="pdtName"></h5> 
          </div>
          <div class="card h-100">
            <div class="card-body row widget-separator">
              <div class="col-sm-6 border-shift border-end text-nowrap d-flex flex-column justify-content-between ">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <div style="font-size: 13px;" class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <p class="mb-0">Pdt No</p>
                    </div>
                    <div class="badge bg-label-primary rounded-pill" id="pdtNo"></div>
                  </div>
                </div>
                
              </div>
              <div class="col-sm-6  text-nowrap d-flex flex-column  border-end justify-content-between ">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <div style="font-size: 13px;" class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <p class="mb-0">Offer Tag</p>
                    </div>
                    <div class="badge bg-label-warning rounded-pill" id="pdtTag"></div>
                  </div>
                </div>
               
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="d-flex align-items-center gap-2 mb-1">
                  <div style="font-size: 13px;" class="d-flex w-100 flex-wrap align-items-center gap-2">
                    <div class="me-2">
                      <p class="mb-0">Description :</p>
                        <span id="pdtDesc"></span>
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card mt-4">
            <h5 class="card-header text-secondary">Product Variant</h5>
            <div class="table-responsive text-nowrap">
              <table class="table" style="font-size: 13px;">
                <thead>
                  <tr>
                    <th>Sizes</th>
                    <th>Colours</th>
                    <th>Price</th>
                    <th>Strike Price</th>
                  </tr>
                </thead >
                <tbody class="table-border-bottom-0" id="prd_itms"> 
                </tbody>
              </table>
            </div>
          </div>
          <div class="card mt-4">
            <h5 class="card-header text-secondary">Product Images</h5>
            <div class="row ps-5" id="imgWrapper"></div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
  <!--/ Product Details Modal Ends -->

<?php footer();
scripts();
?>
<script src="<?php echo ROOT ?>plugins/select2/select2.js"></script>
<script>
$(function() {
//SEARCH PRODUCTS
  $("#searchInput").on("keyup", function() {
    const searchWord = $(this).val().toLowerCase();
    let hasVisible = false;
    $(".tile").each(function() {
      const title = $(this).data("pdt");
      if (title.toLowerCase().indexOf(searchWord) != -1) {
        $(this).show();
        hasVisible = true;
      } else {
        $(this).hide();
      } 
    });
    if (hasVisible) {
      $("#msgNoData").html("");
    } else { 
      $("#msgNoData").html("No Product Found");
    }
  });
  //GETTING PRODUCT DETAILS

$(document).on("click",".openModal",function(evt) {
  evt.preventDefault();
  $("#imgWrapper").empty();
  id=$(this).data("id");
  $("#pdtName").html($(this).data("ttl"));
  $("#pdtNo").html($(this).data("no"));
  $("#pdtDesc").html($(this).data("desc"));
  $("#pdtTag").html($(this).data("tag")); 

  $.ajax({
  url: '<?php echo ROOT?>ajax/product-ajax.php',
  type: 'POST', 
  data: {'action': 'productDetails','product_id':id},
  beforeSend: function() {
    $("#prd_itms").empty();
  },
  success:function(retDt){
  // console.log(retDt);
  try{
  jsndt=$.parseJSON(retDt);
  variant=jsndt.variants;
  images=jsndt.images;
  $.each(variant,function(idx,itm){
     th="<tr><td>"+itm.sz_title+"</td><td>"+itm.clname+"</td><td>"+itm.pd_price+"</td><td>"+itm.pd_strikeprice+"</td></tr>";
  $("#prd_itms").append(th);
  });
  if(images.length){
  $.each(images, function(idx, img) {
   row = `<div class="col-md-3 mb-3">
       <div class="card">
         <img src="<?php echo ROOT ?>/uploads/thumb/${img.img_name}"  class="card-img-top img-fluid">
       </div>
     </div>`;
   $("#imgWrapper").append(row);
  });
}else{
  row = `<p class="m-5">No Other Images for this Product</p>`;
   $("#imgWrapper").append(row);

}
  $("#detailModal").modal("show");
  }
  catch (err){	
  }
  }
  });
});
});
</script>
</body>
</html>
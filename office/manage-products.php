<?php
include("template.php");
$pid=$_GET["id"];
ini_set("display_errors",0);
$pckobj=new MysqliDb(HOST,USER,PWD,DB);
if($pid){
   $pckobj->where("pm_id",$pid);
   $product=$pckobj->getOne("tbl_product_master","pm_id,pm_name,pm_desc,pm_code,ct_id,sct_id,is_featured,offer_tag,pm_image");
   //echo $pckobj->getLastQuery();exit;
}
head($pid ?"Update Products":"Create Products");
main_nav();
?>
<link rel="stylesheet" type="text/css" href="<?php echo ROOT ?>plugins/select2/select2.css">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT ?>plugins/cropit/cropit.css">
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- Hoverable Table rows -->
    <div class="row" style="margin-top: 30px;">
      <!-- Form controls -->
      <div class="col-xl-12">
        <!-- HTML5 Inputs -->
        <div class="card mb-6">
          <h5 class="card-header"><?php echo $pid ?"Update Products":"Create Products"?></h5><br>
          <div class="card-body">
            <form id="frmPdtMaster">
              <input type="hidden" name="action" value="addPdtMaster">
              <input type="hidden" name="pmid" id="pmid" value="<?php echo $product["pm_id"]?>" >

              <div class="row">
                <div class="col-xl-4">
                  <div class="form-floating form-floating-outline mb-6">
                    <input class="form-control required" type="text" id="txtpdtnm" name="txtpdtnm" placeholder="Product Name" value="<?php echo $product["pm_name"]?>" />
                    <label for="txtpdtnm">Product Name</label>
                  </div>
                </div>
                
                <div class="col-xl-4">
                  <div class="form-floating form-floating-outline mb-6">
                    <select class="form-select required" name="selCatgry" id="selCatgry">
                      <option value="">Select Category</option>
                      <?php
                      $catobj = new MysqliDb(HOST, USER, PWD, DB);
                      $catobj->where("ct_status",0);
                      $catarr = $catobj->get("tbl_category", null, "ct_id,ct_title");
                      foreach ($catarr as $key => $cat) {
                        $sel=$product['ct_id']==$cat["ct_id"]?"selected":"";
                        echo "<option value='$cat[ct_id]' $sel>$cat[ct_title]</option>";
                      }
                      ?>
                    </select>
                    <label for="selCatgry">Category</label>
                  </div>
                </div>
                <div class="col-xl-4">
                  <div class="form-floating form-floating-outline mb-6">
                    <select class="form-select required" name="selSubCatgry" id="selSubCatgry">
                      <option value="">Select</option>
                      <?php
                      $catobj->where("sct_status",0);
                      $catarr = $catobj->get("tbl_sub_category", null, "sct_id,sct_title");
                      foreach ($catarr as $key => $cat) {
                        $sel=$product['sct_id']==$cat["sct_id"]?"selected":"";
                        echo "<option value='$cat[sct_id]' $sel>$cat[sct_title]</option>";
                      }
                      ?>
                    </select>
                    <label for="selSubCatgry">Sub Category</label>
                  </div>
                </div>
              </div>
              <div class="row">
                
                <div class="col-xl-4">
                  <div class="form-floating form-floating-outline mb-6">
                    <input class="form-control" id="txtTag" name="txtTag" placeholder="Offer tag on Product" type="text" value="<?php echo $product["offer_tag"]?>" />
                    <label for="txtTag">offer Tag</label>
                  </div>
                </div>
                <div class="col-xl-4">
                  <div class="form-floating form-floating-outline mb-6">
                    <input class="form-control" id="txtCode" name="txtCode" placeholder="Product Code" type="text" value="<?php echo $product["pm_code"]?>"/>
                    <label for="txtCode">Product Code</label>
                  </div>
                </div>
                <div class="col-xl-4">
                      <label class="switch">
                          <input type="checkbox" class="switch-input" value="1" <?php echo $product["is_featured"]==1?"checked='checked'":""?>  id="chkFeatured" name="chkFeatured" />
                          <span class="switch-toggle-slider"><span class="switch-on"></span><span class="switch-off"></span>
                          </span>
                          <span class="switch-label">Is Featured ?</span>
                      </label>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col-xl-6">
                  <div class="form-floating form-floating-outline mb-6">
                    <textarea class="form-control h-px-100" id="txtpdtdesc" name="txtpdtdesc" placeholder="Discription for Product" ><?php echo $product["pm_desc"]?></textarea>
                    <label for="txtpdtdesc">Description</label>
                  </div>
                </div>
                <div class="col-xl-2"></div>
                
                <div class="col-xl-2 no-padding">
                    <h6>Add featured Image </h6>
                    <div class="image-editor  text-center" style="padding-right: 25px;" data-width="180" data-height="250" data-zoom="4" data-image="<?php echo ROOT."uploads/".$product["pm_image"]?>">
                      <input type="hidden" name="masterImageName" value="<?php echo $product["pm_image"]?>" />
                      <input type="file" class="cropit-image-input hidden exclude">
                      <div class="cropit-image-preview">
                        <div class="error-msg">The image size should be greater than 720 X 1005 </div>
                      </div><input type="range" class="cropit-image-zoom-input">
                      <input type="hidden" name="masterImage" class="hidden-image-data exclude" />
                      <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-warning imgSelect"><i class="ri-file-image-fill"></i> Upload Photo</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-2"></div>
                <hr>
                
                <div class="col-md-12">
                  <h6>Add more Images</h6>
            <div class="row" id="cropWrap">
               <?php
              $imobj = new MysqliDb(HOST, USER, PWD, DB);
              if ($pid) {
                $imobj->where("pm_id", $pid);
                $imgar = $imobj->getvalue("tbl_images", "img_name", null);
              }
              if ($imobj->count > 0) {
                $len = sizeof($imgar) - 1;
                foreach ($imgar as $index => $img) {
                  $btn = $len == $index ? "<button type='button' class='btn btn-sm btn-success imgBlk' data-img='$img'><i class='ri-file-add-line'></i> Add new</button>" : "<button type='button' class='btn btn-sm btn-danger imgBlk' data-img='$img'><i class='ri-delete-bin-line' ></i> Remove</button>";
              ?>
                <div class="image-editor col-md-2 text-center" data-width="180" data-height="250" data-zoom="4" data-image="<?php echo $img ? ROOT . "/uploads/" . $img : ""; ?>">
                    <input type="file" class="cropit-image-input hidden">
                    <div class="cropit-image-preview">
                      <div class="error-msg">The image size should be greater than 720 X 1005</div>
                    </div>

                    <input type="range" class="cropit-image-zoom-input exclude">
                    <input type="hidden" name="image-data[<?php echo $img ?>]" class="hidden-image-data exclude" />
                    <div class="clearfix"></div>
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-primary imgSelect"><i class="ri-file-image-fill"></i></button> <?php echo $btn ?>
                    </div>
                  </div>
                <?php }
              } else { ?>

             <div class="image-editor col-md-2 text-center" data-width="180" data-height="250" data-zoom="4" data-image="">
                  <input type="file" class="cropit-image-input hidden exclude">
                  <div class="cropit-image-preview">
                    <div class="error-msg">The image size should be greater than 720 X 1005</div>
                  </div>
                  <input type="range" class="cropit-image-zoom-input">
                  <input type="hidden" name="image-data[]" class="hidden-image-data exclude" />
                  <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-primary imgSelect"><i class="ri-file-image-fill"></i></button><button type='button' class='btn btn-sm btn-success imgBlk'><i class='ri-file-add-line'></i> Add new</button>
                  </div>
                </div>
            </div>
              <?php } ?>
          </div>
                <button class="btn btn-primary mt-5" id="btnSaveMaster"><?php echo $pid?"Update":"Save & Add Variants" ?></button>
            </form>
              <div id="masterNot" class="mt-5"></div>
            </div>
            <?php if($pid){?>
              <div class="row">
                <div class="table-responsive text-nowrap">
                  <table class="table tblinpt">
                    <thead>
                      <tr>
                        <th style='width:25%'>Sizes</th>
                        <th style='width:25%'>Colour</th>
                        <th>Price</th>
                        <th>Strike Price</th>
                        <th>Tools</th>
                      </tr>
                    </thead>
                    <tbody id="tbdy">
                      <form id="frmPdtDetail">
                        <input type="hidden" name="action" value="addPdtDetail">
                        <input type="hidden" name="pmid" value="<?php echo $pid?>">
                      <input type="hidden" name="pdid" id="pdid">
                      <tr>
                        
                        <td><select name='selSizes[]' class="form-select selSizes required" id="selSizes" multiple="multiple">
                            <option value=''>Select Size</option>
                            <?php 
                              $variantobj=new MysqliDb(HOST,USER,PWD,DB);
                              $variantobj->where('sz_status',9,"<>");
                              $variantobj->orderBy('sz_title',"DESC");
                              $sizearr=$variantobj->get("tbl_sizes",null,'sz_id,sz_title');
                              foreach ($sizearr as $key => $itm) {
                              echo "<option value='$itm[sz_id]'> $itm[sz_title]</option>";
                              }
                              ?>
                          </select>
                        </td>
                        <td>
                          <select name='selColour[]' id="selColour" class="form-select selColour required" multiple="multiple">
                            <option value=''>Select Colours</option>
                            <?php 
                              $variantobj->where('cl_status',9,"<>");
                              $colorarr=$variantobj->get("tbl_colours",null,'cl_id,cl_name');
                              foreach ($colorarr as $key => $itm) {
                              echo "<option value='$itm[cl_id]'> $itm[cl_name]</option>";
                              }
                              ?>
                          </select>
                        </td>
                        <td><input type="text" class="form-control numeric required" name="txtPrice" id="txtPrice" placeholder="Price"></td>
                        <td><input type="text" class="form-control numeric required" name="txtStrikePrice" id="txtStrikePrice" placeholder="Strike Price"></td>
                        <td>
                          <a class="btn btn-danger d-none" id="btnCancel">Cancel</a>
                        <button class="btn btn-primary" id="btnSaveDetail">Save</button></td>
                      </tr>
                    </tr>
                       <div id="detailNot" class="mt-5"></div>
                      </form>
                      <?php 
                        $variantobj=new MysqliDb(HOST,USER,PWD,DB);
                        $variantobj->groupBy("pd.pd_id");
                        $variantobj->where("pd.pm_id",$pid);
                        $variantobj->where("pd.pd_status",0);
                        $variantobj->join("tbl_colours cl","JSON_CONTAINS(pd.pd_color,cl.cl_id)", "LEFT");
                        $variantobj->join("tbl_sizes sc","pd.sz_id=sc.sz_id");
                        $dtlarr=$variantobj->get("tbl_product_detail pd",null,"pd.pd_id,pd.pm_id,pd_price,sz_title,pd_strikeprice,pd.sz_id,pd_color,sc.sz_code,GROUP_CONCAT(DISTINCT cl.cl_name) AS clname");
                        foreach ($dtlarr as $key=> $dt){
                      ?>
                      <tr>
                        <td><?php echo $dt["sz_title"]?></td>
                        <td><?php echo $dt["clname"] ?></td>
                        <td><?php echo $dt["pd_price"]?></td>
                        <td><?php echo $dt["pd_strikeprice"]?></td>
                        <td><button type="button" class='btn btn-sm btn-outline-primary waves-effect btnEditDetail' data-id="<?php echo $dt["pd_id"] ?>" data-price="<?php echo $dt["pd_price"] ?>" data-sprice="<?php echo $dt["pd_strikeprice"] ?>" data-color="<?php echo $dt["pd_color"] ?>" data-size="<?php echo $dt["sz_id"] ?>" ><i class="ri-edit-box-line"></i></button>
                      <button type="button" class='btn btn-sm btn-outline-danger waves-effect openDelModal' data-title="Product Detail" data-type="productdetail" data-delid="<?php echo $dt["pd_id"] ?>"><i class="ri-delete-bin-line"></i></button>
                      </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            <?php }?>
        </div>
      </div>
    </div>
  </div>
  <!-- / Content -->
  <?php footer();
  scripts(); ?>
  <script src="<?php echo ROOT ?>plugins/select2/select2.js"></script>
  <script src="<?php echo ROOT ?>plugins/cropit/jquery.cropit.js"></script>
  <script>
$(function() {
/*ASSIGN SELECT2*/

  $(".selColour").each(function() {
    $(this).select2({
      placeholder: "Select Colour",
      dropdownParent: $(this).parent()
    }); 
  });
  
    $(".selSizes").each(function() {
    $(this).select2({ 
      placeholder: "Select Sizes",
      dropdownParent: $(this).parent() 
    }); 
  }); 
/*ASSIGN SELECT2 ENDS*/
  // $(".select2-container").removeClass('required');

/*ASSIGN CROPIT FOR UPLOAD*/
   
    $(document).on("click", ".imgSelect", function() {
      $(this).closest(".image-editor").find(".cropit-image-input").click();
    });
initCropit();

    function imgErr(obj) {
        $(this)[0].$preview.addClass('is-invalid');
    }
/*ASSIGN CROPIT FOR UPLOAD*/

/*SUBMIT PRODUCTS MASTER*/

      $(document).on("submit", "#frmPdtMaster", function(e) {
      e.preventDefault();
      valid = true;
      $(".is-invalid").removeClass("is-invalid");
      $('#frmPdtMaster .required').each(function() { 
        if (!$(this).val()) {
          valid = false;
          $(this).addClass('is-invalid');
        }
      });
      var formValue = new FormData($('#frmPdtMaster')[0]);
      // console.log(formValue);
      $("#masterNot").html("");
      msg = "";
      btnhtml=$("#btnSaveMaster").html();
      if (valid) {
      $("#btnSaveMaster").attr({"disabled":"disabled"}).html("Processing...");

        var ImageURL = "";
        ImageURL = $('.image-editor').cropit('export', {
          type: 'image/jpeg',
          quality: .9
        });
        if (ImageURL) {
          var block = ImageURL.split(";");
          var contentType = block[0].split(":")[1];
          var realData = block[1].split(",")[1];
          blob = b64toBlob(realData, contentType);
          name = "cr" + $('.image-editor').find('.hidden-image-data').attr("name");
          formValue.append(name, blob);
        }
        var MultiImageURL = "";
          $('#cropWrap .image-editor').each(function(index,imcrp){
          MultiImageURL = $(this).cropit('export',{type: 'image/jpeg',quality: .9});
          if (MultiImageURL) {

          var block = MultiImageURL.split(";");
          var contentType = block[0].split(":")[1];
          var realData = block[1].split(",")[1];
          blob = b64toBlob(realData, contentType);
          name="cr"+$(this).find('.hidden-image-data').attr("name");
          formValue.append(name, blob);
          }
          });
        $.ajax({ 
          type: 'POST',
          data: formValue,
          contentType: false,
          processData: false,
          cache: false,
          url: '<?php echo ROOT ?>ajax/product-ajax.php',
          success: function(data) {
            try {
          $("#btnSaveMaster").removeAttr("disabled").html(btnhtml);

              // console.log(data);
              jsn = $.parseJSON(data);
              if (jsn.status == 'done') {
                alert = `<div class='alert alert-success' role='alert'>Product details updated successfully</div>`;
                  $("#masterNot").html(alert);
                  window.location.href = "<?php echo ADMINROOT ?>update-product/"+jsn.pmid;
                // location.reload();
              }
            } catch (exp) {}
          },
          error: function(a, b, err) {
            console.log(err)
          }
        });
      } else {
        alert = `<div class='alert alert-danger alert-dismissible' role='alert'>Please check all required inputs<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
        $("#masterNot").html(alert);
      }
    });
/* PRODUCTS MASTER END*/

/*SUBMIT PRODUCTS DETAIL*/

      $(document).on("submit", "#frmPdtDetail", function(e) {
      e.preventDefault();
      valid = true;
      $(".is-invalid").removeClass("is-invalid");
        $('.tblinpt .required').each(function() {
        let $field = $(this);

    if ($field.is("select")) {
      if ($field.prop("multiple")) {
        if (!$field.val() || $field.val().length === 0) {
          valid = false;
          $field.addClass("is-invalid");
        }
      } else {
        if (!$field.val()) {
          valid = false;
          $field.addClass("is-invalid");
        }
      }
    } else {
      if (!$field.val().trim()) {
        valid = false;
        $field.addClass("is-invalid");
      }
    }
  });
      $("#selSizes").prop("disabled", false);
      var formValue = new FormData($('#frmPdtDetail')[0]);
      $("#detailNot").html("");
      msg = "";
      if (valid) {
        $.ajax({
          type: 'POST',
          data: formValue,
          contentType: false,
          processData: false,
          cache: false,
          url: '<?php echo ROOT ?>ajax/product-ajax.php',
          success: function(data) {
            try {
              // console.log(data);
              jsn = $.parseJSON(data);
              if (jsn.status == 'done') {
                alert = `<div class='alert alert-success' role='alert'>Product details updated successfully</div>`;
                  $("#detailNot").html(alert);
                  location.reload();
              }
            } catch (exp) {}
          },
          error: function(a, b, err) {
            console.log(err)
          }
        });
      } else {
        alert = `<div class='alert alert-danger alert-dismissible' role='alert'>Please check all required inputs<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
        $("#detailNot").html(alert);
      }
    });
/*SUBMIT PRODUCTS DETAIL ENDS*/
/*EDIT PRODUCTS DETAIL*/

	$(document).on("click", ".btnEditDetail", function(evt) {
			evt.preventDefault(); 
			$("#btnCancel").removeClass("d-none");
			$("#pdid").val($(this).data("id"));
			$("#selColour").val($(this).data("color"));
			$("#selSizes").val($(this).data("size"));
			$("#selSizes").attr("disabled", true);
			$("#txtPrice").val($(this).data("price"));
			$("#txtStrikePrice").val($(this).data("sprice"));
      $("#selColour,#selSizes").select2({
       width: "100%"
      });
    
			//  scrollTo(0,0);
		});

/*EDIT PRODUCTS DETAIL ENDS*/

$(document).on("click", ".imgBlk", function(evt) {
      evt.preventDefault();
      blk = $(this).closest(".image-editor");
      if ($(this).hasClass("btn-danger")) {
        if ($(this).data("img")) {
          $("<input>").attr({
            "type": "hidden",
            "name": "delimg[]" 
          }).val($(this).data("img")).appendTo("#frmPdtMaster");
        }
        $(blk).remove();
      } else {
        crp = $(blk).clone();
        $(".imgBlk").attr("class", "btn btn-sm btn-danger imgBlk").html("<i class='ri-delete-bin-line'></i> Remove");
        $(crp).find(".cropit-image-preview").css("background", "");
        $(crp).find(".cropit-image-input").val("");
        $(crp).find(".hidden-image-data").attr("name", "image-data[]");


        $(crp).appendTo("#cropWrap");
        mywdth = $(crp).data("width");
        myht = $(crp).data("height");
        zoom = $(crp).data("zoom");
        $('.image-editor').cropit({
          "width": mywdth,
          "height": myht,
          "exportZoom": zoom,
          "onFileReaderError": function() {},
          "onImageError": imgErr
        });
      }
    });

function initCropit(){
$('.image-editor').each(function(index,fld){
{
src=$(this).data("image");
mywdth=$(this).data("width");
myht=$(this).data("height");
zoom=$(this).data("zoom");
console.log(src);
$(this).cropit({"width":mywdth,"height":myht,"exportZoom":zoom,"onImageError":imgErr,"onFileReaderError":function(obj){console.log(obj)}});
if(src){
$(this).cropit('imageSrc', src);
}
}
});
}


	$(document).on("click", "#btnCancel", function() {
			$("#btnCancel").addClass("d-none");
			$("#pdid,#selColour,#selSizes,#txtPrice,#txtStrikePrice").val("");
			 $("#selSizes").attr("disabled", false);
       $("#selColour,#selSizes").select2({
       width: "100%"
      });
		});


});
</script>
</body>
</html> 
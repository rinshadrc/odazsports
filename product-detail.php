
<?php
include("template.php");
head("Product Details", 0);
$pid = $_GET["id"];
$pdtobj = new MysqliDb(HOST, USER, PWD, DB);
$pdtobj->where("pm_id", $pid);
$pdtobj->where("pm_status", 0);
$pdtobj->join("tbl_sub_category sct", "pm.sct_id=sct.sct_id");
$pdtobj->join("tbl_category ct", "pm.ct_id=ct.ct_id");
$pdtmstarr = $pdtobj->getOne("tbl_product_master pm", "pm_id,pm_name,pm_desc,pm_code,pm_note,pm.sct_id,pm_status,is_featured,offer_tag,pm_image,ct.ct_title,sct.sct_title");
$pdtobj->where("pm_id", $pid);
$pdtimgs = $pdtobj->get("tbl_images", null, "img_name");
// print_r($pdtimgs);exit;

$pdtobj->where("pm_id", $pid);
$pdtobj->where("pd_status", 0);
$pdtobj->groupBy("pd.pd_id");
$pdtobj->join("tbl_colours cl", "JSON_CONTAINS(pd.pd_color,cl.cl_id)", "LEFT");
$pdtobj->join("tbl_sizes sc", "pd.sz_id=sc.sz_id");
$pdtdtlarr = $pdtobj->get("tbl_product_detail pd", null, "pd.pd_id,pm_id,pd_price,pd_strikeprice,pd.sz_id,pd_color,sz_code,sz_title,GROUP_CONCAT(cl.cl_code SEPARATOR '|') AS clcode,GROUP_CONCAT(cl.cl_name) AS clname");
// echo $pdtobj->getLastQuery();exit;
foreach ($pdtdtlarr as $pdt) {
    $pdtdtl[$pdt["pd_id"]] = array("pdtid" => $pdt["pd_id"], "clrname" => $pdt["clname"], "clrid" => $pdt["pd_color"], "code" => $pdt["clcode"], "size" => $pdt["sz_id"], "sizename" => $pdt["sz_code"], "price" => $pdt["pd_price"],"strikeprice"=>$pdt["pd_strikeprice"],"sizetitle"=>$pdt["sz_title"]);
}


echo "<script> var productdtl=" . json_encode($pdtdtl) . "; var pdtMaster=" . json_encode($pdtmstarr) . " </script>";
?>

        <!-- breadcrumb -->
        <div class="tf-breadcrumb">
            <div class="container">
                <div class="tf-breadcrumb-wrap d-flex justify-content-between flex-wrap align-items-center">
                    <div class="tf-breadcrumb-list">
                        <a href="index.html" class="text">Home</a>
                        <i class="icon icon-arrow-right"></i>
                        <a href="#" class="text"><?php echo $pdtmstarr["ct_title"] ?></a>
                        <i class="icon icon-arrow-right"></i>
                        <a href="<?php echo ROOT ."products/".$pdtmstarr["sct_id"] ?>" class="text"><?php echo $pdtmstarr["sct_title"] ?></a>
                        <i class="icon icon-arrow-right"></i>
                        <span class="text"><?php echo $pdtmstarr["pm_name"] ?></span>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- /breadcrumb -->
        <!-- default -->
        <section class="flat-spacing-4 pt_0">
            <div class="tf-main-product section-image-zoom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="tf-product-media-wrap sticky-top">
                                <div class="thumbs-slider">
                                    <div dir="ltr" class="swiper tf-product-media-thumbs other-image-zoom"
                                        data-direction="vertical">
                                        <div class="swiper-wrapper stagger-wrap">
                                            <div class="swiper-slide stagger-item">
                                                <div class="item">
                                                    <img class="lazyload" data-src="<?php echo  ROOT . 'uploads/thumb/' . $pdtmstarr["pm_image"] ?>" src="<?php echo  ROOT . 'uploads/thumb/' . $pdtmstarr["pm_image"] ?>" alt="img-product">
                                                </div>
                                            </div> 
                                             <?php
                                                foreach ($pdtimgs as $img) { ?>
                                                    <div class="swiper-slide stagger-item">
                                                        <div class="item">
                                                            <img class="lazyload" data-src="<?php echo  ROOT . 'uploads/thumb/' . $img["img_name"] ?>" src="<?php echo  ROOT . 'uploads/thumb/' . $img["img_name"] ?>" alt="img-product">
                                                        </div>
                                                    </div> 
                                                <?php } ?>
                                        </div>
                                    </div>
                                     <div dir="ltr" class="swiper tf-product-media-main" id="gallery-swiper-started">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <a href="#" target="_blank" class="item"
                                                    data-pswp-width="770px" data-pswp-height="1075px">
                                                    <img class="tf-image-zoom lazyload"
                                                        data-zoom="<?php echo  ROOT . 'uploads/' . $pdtmstarr["pm_image"] ?>"
                                                        data-src="<?php echo  ROOT . 'uploads/' . $pdtmstarr["pm_image"] ?>"
                                                        src="<?php echo  ROOT . 'uploads/' . $pdtmstarr["pm_image"] ?>" alt="img-product">
                                                </a>
                                            </div>
                                            <?php
                                            
                                                foreach ($pdtimgs as $img) { ?>
                                                    <div class="swiper-slide">
                                                        <a href="#" target="_blank" class="item" data-pswp-width="770px" data-pswp-height="1075px">
                                                            <img class="tf-image-zoom lazyload"
                                                                data-zoom="<?php echo  ROOT . 'uploads/' . $img["img_name"] ?>"
                                                                data-src="<?php echo  ROOT . 'uploads/' . $img["img_name"] ?>"
                                                                src="<?php echo  ROOT . 'uploads/' . $img["img_name"] ?>" alt="img-product">
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                        </div>
                                        <div class="swiper-button-next button-style-arrow thumbs-next"></div>
                                        <div class="swiper-button-prev button-style-arrow thumbs-prev"></div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="tf-product-info-wrap position-relative">
                                <div class="tf-zoom-main"></div>
                                <div class="tf-product-info-list other-image-zoom">
                                    <div class="tf-product-info-title">
                                        <h5 class="text-uppercase"><?php echo $pdtmstarr["pm_name"] ?></h5>
                                    </div>
                                    <?php if($pdtmstarr["is_featured"]){?>
                                    <div class="tf-product-info-badges">
                                        <div class="badges">Best seller</div>
                                        <div class="product-status-content">
                                            <i class="icon-lightning"></i>
                                            <p class="fw-6">Selling fast!</p>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="tf-product-info-price">
                                        <div class="price-on-sale" id="pdtprice"></div>
                                        <div class="compare-at-price" id="pdtstrkprice"></div>
                                            <?php echo $pdtmstarr["offer_tag"] ? "<div class='badges-on-sale'>" . $pdtmstarr['offer_tag'] . "</div>" : "" ?>
                                    </div>
                           
                                    <div class="tf-product-info-variant-picker">
                                        
                                        <div class="variant-picker-item" >
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="variant-picker-label">
                                                    Size: <span class="fw-6 variant-picker-label-value" id="sizeshow"></span>
                                                </div>
                                                <a href="#find_size" data-bs-toggle="modal" class="find-size fw-6">Find
                                                    your size</a>
                                            </div>
                                            <div class="variant-picker-values" id="sizewrpr"></div>
                                        </div>
                                        <div class="variant-picker-item">
                                            <div class="variant-picker-label">
                                                Color: <span
                                                    class="fw-6 variant-picker-label-value value-currentColor" id="colorshow">Beige</span>
                                            </div>
                                            <div class="variant-picker-values" id="colorwrpr">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tf-product-info-quantity">
                                        <div class="quantity-title fw-6">Quantity</div>
                                        <div class="wg-quantity">
                                            <span class="btn-quantity btn-decrease">-</span>
                                            <input type="text" class="quantity-product" name="number" value="1" id="pdtquantity">
                                            <span class="btn-quantity btn-increase">+</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                <div class="tf-product-info-buy-button">
                                            <a href="#" class="tf-btn btn-fill justify-content-center w-100 fw-6 fs-16 flex-grow-1 animate-hover-btn " id="addtocart">Add to cart</a>
                                                    
                                    </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="tf-product-info-buy-button">
                                            <a href="#" class="tf-btn btn-fill justify-content-center w-100 fw-6 fs-16 flex-grow-1 animate-hover-btn " id="btnBuynowcart" style="background-color: black!important;"><span>Buy Now &nbsp;</span></a>
                                    </div>
                                        </div>
                                    </div>
                                    <div class="tf-product-info-delivery-return">
                                        <div class="row">
                                            <div class="col-xl-6 col-12">
                                                <div class="tf-product-delivery">
                                                    <div class="icon">
                                                        <i class="icon-delivery-time"></i>
                                                    </div>
                                                    <p>Estimate delivery times: <span class="fw-7">3-6 days</span>
                                                        (India), <span class="fw-7">12-26 days</span> (International).</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-12">
                                                <div class="tf-product-delivery mb-0">
                                                    <div class="icon">
                                                        <i class="icon-return-order"></i>
                                                    </div>
                                                    <p>Return within <span class="fw-7">30 days</span> of purchase.
                                                        Duties & taxes are non-refundable.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tf-product-info-trust-seal">
                                        <div class="tf-product-trust-mess">
                                            <i class="icon-safe"></i>
                                            <p class="fw-6">Guarantee Safe  Checkout</p>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- /default -->
        <!-- tabs -->
        <section class="flat-spacing-17 pt_0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="widget-tabs style-has-border">
                            <ul class="widget-menu-tab">
                                <li class="item-title active">
                                    <span class="inner">Description</span>
                                </li>
                                <li class="item-title">
                                    <span class="inner">Additional Information</span>
                                </li>
                            </ul>
                            <div class="widget-content-tab">
                                <div class="widget-content-inner active">
                                    <div class="">
                                        <p class="mb_30"><?php echo $pdtmstarr["pm_desc"] ?></p>
                                        
                                    </div>
                                </div>
                                <div class="widget-content-inner">
                                    <div class="tf-product-des-demo">
                                            <div class="right">
                                                <h3 class="fs-16 fw-5">Features</h3>
                                                <ul>
                                                    <li>Front button placket</li>
                                                    <li> Adjustable sleeve tabs</li>
                                                    <li>Babaton embroidered crest at placket and hem</li>
                                                </ul>
                                                <h3 class="fs-16 fw-5">Materials Care</h3>
                                                <ul class="mb-0">
                                                    <li>Content: 100% LENZING™ ECOVERO™ Viscose</li>
                                                    <li>Care: Hand wash</li>
                                                    <li>Imported</li>
                                                </ul>
                                            </div>
                                            <div class="left">
                                                <h3 class="fs-16 fw-5">Materials Care</h3>
                                                <div class="d-flex gap-10 mb_15 align-items-center">
                                                    <div class="icon">
                                                        <i class="icon-machine"></i>
                                                    </div>
                                                    <span>Machine wash max. 30ºC. Short spin.</span>
                                                </div>
                                                <div class="d-flex gap-10 mb_15 align-items-center">
                                                    <div class="icon">
                                                        <i class="icon-iron"></i>
                                                    </div>
                                                    <span>Iron maximum 110ºC.</span>
                                                </div>
                                                <div class="d-flex gap-10 mb_15 align-items-center">
                                                    <div class="icon">
                                                        <i class="icon-bleach"></i>
                                                    </div>
                                                    <span>Do not bleach/bleach.</span>
                                                </div>
                                                <div class="d-flex gap-10 mb_15 align-items-center">
                                                    <div class="icon">
                                                        <i class="icon-dry-clean"></i>
                                                    </div>
                                                    <span>Do not dry clean.</span>
                                                </div>
                                                <div class="d-flex gap-10 align-items-center">
                                                    <div class="icon">
                                                        <i class="icon-tumble-dry"></i>
                                                    </div>
                                                    <span>Tumble dry, medium hear.</span>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /tabs -->
 <!-- product -->
    <?php
    $pdtobj = new MysqliDb(HOST, USER, PWD, DB);
    $pdtobj->where("sct_id", $pdtmstarr["sct_id"]);
    $pdtobj->where("pm_status", 0);
    $pdtobj->where("pm.pm_id", $pid, "!=");
    $pdtobj->groupBy("pm.pm_id");
    $pdtobj->join("tbl_product_detail pd", "pd.pm_id=pm.pm_id");
    $catpdts = $pdtobj->get("tbl_product_master pm", null, "pm.pm_id,pm_name,pm_desc,pm_code,pm_status,is_featured,offer_tag,pm_image,pd.pd_price");
    if(!empty($catpdts)){
                        ?>
        <section class="flat-spacing-1 pt_0">
            <div class="container">
                <div class="flat-title">
                    <span class="title">People Also Bought</span>
                </div>
                <div class="hover-sw-nav hover-sw-2">
                    <div dir="ltr" class="swiper tf-sw-product-sell wrap-sw-over" data-preview="4" data-tablet="3"
                        data-mobile="2" data-space-lg="30" data-space-md="15" data-pagination="2" data-pagination-md="3"
                        data-pagination-lg="3">
                        <div class="swiper-wrapper">
                               <?php
                    foreach ($catpdts as $pdt) {

                    ?>
                            <div class="swiper-slide" lazy="true">

                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <a href="<?php echo ROOT . "product-detail/" . $pdt["pm_id"] ?>" class="product-img">
                                            <img class="lazyload img-product" data-src="<?php echo ROOT . "uploads/" . $pdt['pm_image'] ?>"
                                                src="<?php echo ROOT . "uploads/" . $pdt['pm_image'] ?>" alt="image-product">
                                            <img class="lazyload img-hover" data-src="<?php echo ROOT . "uploads/" . $pdt['pm_image'] ?>"
                                                src="<?php echo ROOT . "uploads/" . $pdt['pm_image'] ?>" alt="image-product">
                                        </a>
                                        <div class="list-product-btn">
                                            <a href="#" data-bs-toggle="modal" data-id="<?php echo $pdt["pm_id"]?>" data-img="<?php echo $pdt["pm_image"]?>" data-name="<?php echo $pdt["pm_name"]?>"
                                                class="box-icon bg_white quick-add tf-btn-loading">
                                                <span class="icon icon-bag"></span>
                                                <span class="tooltip">Quick Add</span>
                                            </a>
                                            <a href="<?php echo ROOT ."product-detail/".$pdt["pm_id"] ?>"
                                                class="box-icon bg_white quickview tf-btn-loading">
                                                <span class="icon icon-view"></span>
                                                <span class="tooltip">View</span>
                                            </a>
                                        </div>
                                        
                                    </div>
                                    <div class="card-product-info">
                                        <a href="<?php echo ROOT . "product-detail/" . $pdt["pm_id"] ?>" class="title link"><?php echo $pdt["pm_name"] ?></a>
                                        <span class="price">₹ <?php echo $pdt["pd_price"] ?></span>
                                        
                                    </div>
                                </div>
                            </div>
                            <?php }
                            ?>
                        </div>
                    </div>
                    <div class="nav-sw nav-next-slider nav-next-product box-icon w_46 round"><span
                            class="icon icon-arrow-left"></span></div>
                    <div class="nav-sw nav-prev-slider nav-prev-product box-icon w_46 round"><span
                            class="icon icon-arrow-right"></span></div>
                    <div class="sw-dots style-2 sw-pagination-product justify-content-center"></div>
                </div>
            </div>
        </section>
        <?php } ?>
        <!-- /product -->

       <?php footer();?>
</div>

<?php scripts();?>


<!-- Javascript -->

<script src="<?php echo ROOT ?>js/drift.min.js"></script>
<script src="<?php echo ROOT ?>js/photoswipe-lightbox.umd.min.js"></script>
<script src="<?php echo ROOT ?>js/photoswipe.umd.min.js"></script>
<script src="<?php echo ROOT ?>js/zoom.js"></script>
<script>
    // var size, pdtid, rate, colorname, colorid, sizeid;
// $(document).ready(function () {

        renderProductDetail();
    function renderProductDetail(id) { 
        $("#colorwrpr,#sizewrpr,#pdtprice,#pdtstrkprice,#sizeshow,#colorshow").html("");
        
        activecls = "activecolor";
        currentpdt = id || Object.keys(productdtl)[0];
        curentItem = productdtl[currentpdt]; 
        $.each(productdtl, function(key, sz) {

            $("<label class='pdtSize style-text' data-value='"+sz.sizename+"' data-id='" + key + "' data-size='" + sz.sizename+ "' data-sizeid='" + sz.size+ "'>").html(sz.sizename).appendTo("#sizewrpr");
        });
        $(".pdtSize[data-id='" + currentpdt + "']").addClass("activesize");
        $("#sizeshow").html(curentItem.sizetitle)

        clridarr = JSON.parse(curentItem.clrid);
        clrnamear=curentItem.clrname.split(",");
        clrcodearr=curentItem.code.split("|");
        price = curentItem.price.toFixed(2);
        rate = price;
        pdtid = curentItem.pdtid;
        size = curentItem.sizename;
        sizeid = curentItem.size;
        colorname = clrnamear[0];
        colorid = clridarr[0];
        $("#pdtprice").html("₹ " + price);
        $("#pdtstrkprice").html("₹ " + curentItem.strikeprice.toFixed(2));
        index = 0;
        activecls = "activecolor";
        
        $.each(clridarr, function(key, color) {
            $("<label class='pdtcolor hover-tooltip radius-60 "+activecls+"' data-clrid='" + color + "' data-clrnm='" + clrnamear[index] + "'><span class='btn-checkbox' style='background:"+clrcodearr[index]+";'></span><span class='tooltip'>"+clrnamear[index]+"</span></label>").appendTo("#colorwrpr");
            index++;
            activecls = "";
        });
        $("#colorshow").html(clrnamear[0])
    }

    $(document).on("click", "#btnBuynowcart", function(atg) {
        let qty = parseInt($("#pdtquantity").val()) || 1;
  let adminPhone = "919745452364";
  let msg = "";
  let total = 0;

    let name = decodeURIComponent(pdtMaster.pm_name.replace(/\+/g, ' '));
    msg += `• ${name} (${colorname}, ${size})\n`;
    msg += `Qty: ${qty} × ₹${rate}\n\n`;
    total += parseFloat(rate) * parseInt(qty);


  msg += "-------------------------\n";
  msg += `Total: ₹${total.toFixed(2)}`;

  let encodedMsg = encodeURIComponent(msg);
  let waUrl = `https://wa.me/${adminPhone}?text=${encodedMsg}`;

  window.open(waUrl, "_blank");
  setTimeout(() => {
    location.reload();
  }, 1000);
        
    });
$(document).on("click", ".pdtSize", function(atg) { 
        atg.preventDefault();
        myid = $(this).data("id");
        sizeid = $(this).data("sizeid");
        size = $(this).data("size");
        renderProductDetail(myid);
    });
    $(document).on("click", ".pdtcolor", function(atg) {
        atg.preventDefault();
        colorname = $(this).data("clrnm");
        colorid = $(this).data("clrid");
        $(".pdtcolor").removeClass("activecolor");
        $(this).addClass("activecolor");
        $("#colorshow").html($(this).data("clrnm"))
    });
    $(document).on("click", "#addtocart", function(e) {
        // console.log("hi here")
        e.preventDefault();

        let qty = parseInt($("#pdtquantity").val()) || 1;
        let cartitems = JSON.parse(localStorage.getItem("cart") || "[]");
        let found = false;
        $.each(cartitems, function(key, item) {
            if (item.sizeid == sizeid && item.pdid == pdtid && item.colorid == colorid) {
                item.qty = parseInt(item.qty) + qty;
                found = true;
            }
        })
        if (!found) {
            cartitems.push({
                pmid: pdtMaster.pm_id,
                name: pdtMaster.pm_name,
                img: pdtMaster.pm_image,
                rate: rate,
                qty: qty,
                size: size,
                pdid: pdtid,
                sizeid: sizeid,
                colorname: colorname,
                colorid: colorid
            });
        }

        localStorage.setItem("cart", JSON.stringify(cartitems));
        renderCartModal();
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        $("#shoppingCart").modal("show")
    });
// });

</script>


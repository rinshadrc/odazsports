<?php
include("template.php");
head("Products List", 0);
ini_set("display_errors",0);

$catid = isset($_GET['cat']) ? intval($_GET['cat']) : null;
$pdtobj = new MysqliDb(HOST, USER, PWD, DB);
if($catid){
$pdtobj->where("pm.sct_id", $catid);
}
$pdtobj->where("pm_status", 9, "<>");
$pdtobj->where("pd_status", 9, "<>");
$pdtobj->orderBy("pm_id", "DESC");
$pdtobj->groupBy("pm.pm_id");
$pdtobj->join("tbl_sub_category sct", "pm.sct_id=sct.sct_id");
$pdtobj->join("tbl_product_detail pd", "pd.pm_id=pm.pm_id");
$pdtarray = $pdtobj->get("tbl_product_master pm", null, "pm.pm_id,pm.sct_id,pm_name,pm_desc,pm_code,pm_note,pm_status,is_featured,offer_tag,pm_image,pd.pd_price,sct.sct_title");

?>

<!-- page-title -->
<div class="tf-page-title" style="background-color: #fbae16;background-image: url('<?php echo ROOT?>images/bg.png');background-size: cover;background-repeat: no-repeat;">
    <div class="container-full">
        <div class="heading text-center"><?php echo ($catid && !empty($pdtarray))? "Collections of ".$pdtarray[0]["sct_title"]:"All Collections" ?></div>
        <p class="text-center text-2 text_black-2 mt_5">Explore our complete collection of premium products crafted with quality and care. 
            Find the perfect choice that suits your needs and style. </p>
    </div>
</div>
<!-- /page-title -->

<!-- Section Product -->
<section class="flat-spacing-2">
    <div class="container">
        <div class="tf-shop-control grid-3 align-items-center">
            <div class="tf-control-filter">
                <a href="#filterShop" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft" class="tf-btn-filter"><span class="icon icon-filter"></span><span class="text">Filter</span></a>
            </div>
            <ul class="tf-control-layout d-flex justify-content-center">
                <li class="tf-view-layout-switch sw-layout-2" data-value-layout="tf-col-2">
                    <div class="item"><span class="icon icon-grid-2"></span></div>
                </li>
                <li class="tf-view-layout-switch sw-layout-3" data-value-layout="tf-col-3">
                    <div class="item"><span class="icon icon-grid-3"></span></div>
                </li>
                <li class="tf-view-layout-switch sw-layout-4 active" data-value-layout="tf-col-4">
                    <div class="item"><span class="icon icon-grid-4"></span></div>
                </li>
                <li class="tf-view-layout-switch sw-layout-5" data-value-layout="tf-col-5">
                    <div class="item"><span class="icon icon-grid-5"></span></div>
                </li>
                <li class="tf-view-layout-switch sw-layout-6" data-value-layout="tf-col-6">
                    <div class="item"><span class="icon icon-grid-6"></span></div>
                </li>
            </ul>

        </div>
        <!-- <div class="wrapper-control-shop">
            <div class="meta-filter-shop">
                <div id="product-count-grid" class="count-text"></div>
                <div id="product-count-list" class="count-text"></div>
                <div id="applied-filters"></div>
                <button id="remove-all" class="remove-all-filters" style="display: none;">Remove All <i class="icon icon-close"></i></button>
            </div> -->
            
            <div class="tf-grid-layout wrapper-shop tf-col-4" id="gridLayout">

                <?php
                if(!empty($pdtarray)){
                
                foreach ($pdtarray as $pdt) { ?>
                <div class="card-product grid" data-availability="In stock" data-brand="Ecomus">
                    <div class="card-product-wrapper">
                        <a href="<?php echo ROOT ."product-detail/".$pdt["pm_id"] ?>" class="product-img">
                            <img class="lazyload img-product" data-src="<?php echo ROOT . "uploads/" . $pdt["pm_image"] ?>"
                                src="<?php echo ROOT . "uploads/" . $pdt["pm_image"] ?>" alt="image-product">
                            <img class="lazyload img-hover" data-src="<?php echo ROOT . "uploads/" . $pdt["pm_image"] ?>"
                                src="<?php echo ROOT . "uploads/" . $pdt["pm_image"] ?>" alt="image-product">
                        </a>
                        <div class="list-product-btn absolute-2">
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
                        <a href="<?php echo ROOT ."product-detail/".$pdt["pm_id"] ?>" class="title link"><?php echo $pdt["pm_name"] ?></a>
                        <span class="price current-price">AED  <?php echo $pdt["pd_price"]; ?></span>  
                    </div>
                </div>
                
                <?php } ?>



                <!-- pagination -->
                <ul class="wg-pagination tf-pagination-list">
                    <li class="active"><a href="#" class="pagination-link">1</a>
                    </li>
                    <li>
                        <a href="#" class="pagination-link animate-hover-btn">2</a>
                    </li>
                    <li>
                        <a href="#" class="pagination-link animate-hover-btn">3</a>
                    </li>
                    <li>
                        <a href="#" class="pagination-link animate-hover-btn">4</a>
                    </li>
                    <li>
                        <a href="#" class="pagination-link animate-hover-btn">
                            <span class="icon icon-arrow-right"></span>
                        </a>
                    </li>
                </ul>
<?php
                }else{
                    echo "<p class='text-center'>No Products to Display</p>";
                } ?>
            </div>

        </div>
    </div>
</section>
<!-- /Section Product -->

<?php footer();?>
</div>

<?php scripts();?>

<script src="<?php echo ROOT ?>js/nouislider.min.js"></script>
<script src="<?php echo ROOT ?>js/shop.js"></script>
<script>
localStorage.removeItem("checkoutProduct")
</script>

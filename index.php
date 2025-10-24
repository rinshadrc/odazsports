<?php
include("template.php");
head("Home Page");

$pdtobj = new MysqliDb(HOST, USER, PWD, DB);
$pdtobj->where("pm_status", 9, "<>");
$pdtobj->orderBy("is_featured", "DESC");
$pdtobj->orderBy("pm_id", "DESC");
$pdtobj->groupBy("pm.pm_id");
$pdtobj->join("tbl_category ct", "ct.ct_id=pm.ct_id", "INNER");
$pdtobj->join("tbl_product_detail pd", "pd.pm_id=pm.pm_id");
$pdtobj->join("tbl_sizes sz", "pd.sz_id=sz.sz_id", "INNER");

$pdtarray = $pdtobj->get("tbl_product_master pm", null, "pm.pm_id,ct.ct_id,ct.ct_title,pm_name,pm_desc,pm_code,pm_note,pm_status,sct_id,is_featured,offer_tag,pm_image,pd.pd_price,GROUP_CONCAT(sz.sz_code) AS sizes");
// error_log($pdtobj->getLastQuery());
// echo $pdtobj->getLastQuery();exit;
$latestProducts = array_slice($pdtarray, 0, 4);

foreach ($pdtarray as $pdt) {
    $catgrs[$pdt["ct_id"]] = array("cat_name" => $pdt["ct_title"]);
    // Only keep max 8 products per category
    if (!isset($products[$pdt["ct_id"]]) || count($products[$pdt["ct_id"]]) < 8) {
        $products[$pdt["ct_id"]][] = $pdt;
}
}
?>
        <!-- Slider -->
        <section class="tf-slideshow slider-effect-fade slider-video position-relative">
            <div class="wrap-slider">
                <video src="images/slider/slider-video.mp4" autoplay muted playsinline loop></video>
                <div class="box-content">
                    <div class="container">
                        <p class="fade-item fade-item-1 subheading text-white fw-7">SPRING COLLECTION</p>
                        <h1 class="fade-item fade-item-2 heading text-white">End of<br> Season Sale</h1>
                        <a href="<?php echo ROOT?>"
                            class="fade-item fade-item-3 tf-btn fill-outline-light btn-icon radius-3"><span>Shop collection</span><i class="icon icon-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Slider -->
        <!-- Collection -->
        <section class="flat-spacing-18">
            <div class="container">
                <div class="masonry-layout-v2">
                    <div class="item-1 collection-item-v5 hover-img wow fadeInUp" data-wow-delay="0s">
                        <div class="collection-inner">
                            <a href="#" class="collection-image img-style">
                                <img class="lazyload" data-src="images/collections/collection-64.jpg"
                                    src="images/collections/collection-64.jpg" alt="collection-img">
                            </a>
                            <div class="collection-content">
                                <a href="<?php echo ROOT?>products" class="collection-title"><span>Accessories</span><i
                                        class="icon icon-arrow1-top-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="item-2 collection-item-v5 hover-img wow fadeInUp" data-wow-delay="0s">
                        <div class="collection-inner">
                            <a href="#" class="collection-image img-style">
                                <img class="lazyload" data-src="images/collections/collection-24.jpg"
                                    src="images/collections/collection-24.jpg" alt="collection-img">
                            </a>
                            <div class="collection-content">
                                <a href="<?php echo ROOT?>products" class="collection-title"><span>Men</span><i
                                        class="icon icon-arrow1-top-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="item-3 collection-item-v5 hover-img wow fadeInUp" data-wow-delay="0s">
                        <div class="collection-inner">
                            <a href="#" class="collection-image img-style">
                                <img class="lazyload" data-src="images/collections/collection-42.jpg"
                                    src="images/collections/collection-42.jpg" alt="collection-img">
                            </a>
                            <div class="collection-content">
                                <a href="<?php echo ROOT?>products" class="collection-title"><span>Women</span><i
                                        class="icon icon-arrow1-top-left"></i></a>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </section>
        <!-- /Collection -->
        <!-- Product -->
        <section class="flat-spacing-6 pt_0">
            <div class="container">
                <div class="flat-title wow fadeInUp" data-wow-delay="0s">
                    <span class="title">POPULAR COLLECTIONS</span>
                    <div class="d-flex gap-16 align-items-center">
                        <div class="nav-sw-arrow nav-next-slider nav-next-product"><span
                                class="icon icon-arrow1-left"></span></div>
                        <a href="<?php echo ROOT?>products" class="tf-btn btn-line fs-12 fw-6">VIEW ALL</a>
                        <div class="nav-sw-arrow nav-prev-slider nav-prev-product"><span
                                class="icon icon-arrow1-right"></span></div>
                    </div>
                </div>
                <div class="hover-sw-nav hover-sw-2">
                    <div dir="ltr" class="swiper tf-sw-product-sell wrap-sw-over" data-preview="4" data-tablet="3" data-mobile="2" data-space-lg="30" data-space-md="15" data-pagination="2" data-pagination-md="3" data-pagination-lg="3">
                        <div class="swiper-wrapper">

                        <?php foreach ($latestProducts as $ltpdt) { ?>
                            <div class="swiper-slide" lazy="true">
                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <a href="<?php echo ROOT ."product-detail/".$ltpdt["pm_id"] ?>" class="product-img">
                                            <img class="lazyload img-product" data-src="<?php echo ROOT . "uploads/" . $ltpdt["pm_image"] ?>"
                                                src="<?php echo ROOT . "uploads/" . $ltpdt["pm_image"] ?>" alt="<?php echo $ltpdt["pm_name"] ?>">
                                            <img class="lazyload img-hover" data-src="<?php echo ROOT . "uploads/" . $ltpdt["pm_image"] ?>"
                                                src="<?php echo ROOT . "uploads/" . $ltpdt["pm_image"] ?>" alt="<?php echo $ltpdt["pm_name"] ?>">
                                        </a>
                                        <div class="list-product-btn">
                                            <a href="#" class="box-icon bg_white quick-add tf-btn-loading" data-id="<?php echo $ltpdt["pm_id"]?>" data-img="<?php echo $ltpdt["pm_image"]?>" data-name="<?php echo $ltpdt["pm_name"]?>">
                                                <span class="icon icon-bag"></span>
                                                <span class="tooltip">Quick Add</span>
                                            </a>


                                            <a href="<?php echo ROOT ."product-detail/".$ltpdt["pm_id"] ?>"  class="box-icon bg_white quickview tf-btn-loading">
                                                <span class="icon icon-view"></span>
                                                <span class="tooltip">View</span>
                                            </a>
                                        </div>
                                        <div class="size-list">
                                            <?php 
                                            $sizearr=explode(",",$ltpdt["sizes"]);
                                            foreach($sizearr as $size){
                                                echo "<span>$size</span>";
                                            }
                                            ?>
                                           
                                        </div>
                                    </div>
                                    <div class="card-product-info">
                                        <a href="#" class="title link"><?php echo $ltpdt["pm_name"] ?></a>
                                        <span class="price">₹<?php echo $ltpdt["pd_price"] ?></span>
                                        
                                    </div>
                                </div>
                            </div>
                            
                                <?php } ?>
                            
                        </div>
                    </div>
                    <div class="nav-sw nav-next-slider nav-next-product box-icon w_46 round"><span
                            class="icon icon-arrow-left"></span></div>
                    <div class="nav-sw nav-prev-slider nav-prev-product box-icon w_46 round"><span
                            class="icon icon-arrow-right"></span></div>
                </div>
            </div>
        </section>
        <!-- /Product -->
        <!-- Shop Collection -->
        <section class="flat-spacing-4 pt_0">
            <div class="container">
                <div class="tf-grid-layout md-col-2 tf-img-with-text style-2" style="background-color: #fbae16;background-image: url('images/bg.png');background-size: cover;background-repeat: no-repeat;">
                    <div class="tf-image-wrap wow fadeInUp" data-wow-delay="0s">
                        <img class="lazyload" data-src="images/collections/collection-65.jpg"
                            src="images/collections/collection-65.jpg" alt="collection-img">
                    </div>
                    <div class="tf-content-wrap text-center w-100 wow fadeInUp" data-wow-delay="0s">
                        <span class="sub-heading text-uppercase fw-7">GET YOUR FASHION FIX HERE</span>
                        <div class="heading">Spring Collections</div>
                        <p class="description">Shop our luxury silk button-up blouses made with ultra-soft, <br
                                class="d-none d-xl-block"> washable silk.</p>
                        <a href="#"
                            class="tf-btn style-2 btn-fill radius-3 animate-hover-btn">Shop collection</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Shop Collection -->
        <!-- Categories -->
        <section class="flat-spacing-5 pt_0">
            <div class="container">
                
                <div class="flat-animate-tab">
                    <ul class="widget-tab-3 style-3 d-flex justify-content-center wow fadeInUp" data-wow-delay="0s" role="tablist">

                    <?php
                    $firstTab = true;
                    foreach ($catgrs as $ctid => $cat) { ?>
                    <li class="nav-tab-item" role="presentation">
                            <a href="#tab<?php echo $ctid ?>" class="<?php echo $firstTab ? 'active' : ''; ?>" data-bs-toggle="tab"><?php echo $cat["cat_name"] ?></a>
                        </li>
                      
                    <?php
                        $firstTab = false;
                    } ?>
                       
                    </ul>
                    <div class="tab-content">
                        <?php
                    $firstPane = true;
                    foreach ($products as $catid => $product) { ?>
                        <div class="tab-pane hover-sw-nav <?php echo $firstPane ? 'show active' : ''; ?>" id="tab<?php echo $catid ?>" role="tabpanel">
                            <div class="tf-sw-product-sell wrap-sw-over" data-preview="4" data-tablet="3"
                                data-mobile="2" data-space-lg="30" data-space-md="15" data-pagination="2"
                                data-pagination-md="2" data-pagination-lg="1">
                                <div class="swiper-wrapper">
                                     <?php foreach ($product as $pdt) { 
                                        ?>
                                    <div class="swiper-slide">
                                        <div class="card-product">
                                            <div class="card-product-wrapper">
                                                <a href="<?php echo ROOT ."product-detail/".$pdt["pm_id"] ?>" class="product-img">
                                                    <img class="lazyload img-product"
                                                        data-src="<?php echo ROOT . "uploads/" . $pdt["pm_image"] ?>"
                                                        src="<?php echo ROOT . "uploads/" . $pdt["pm_image"] ?>" alt="<?php echo $pdt["pm_name"] ?>">
                                                    <img class="lazyload img-hover"
                                                        data-src="<?php echo ROOT . "uploads/" . $pdt["pm_image"] ?>"
                                                        src="<?php echo ROOT . "uploads/" . $pdt["pm_image"] ?>" alt="<?php echo $pdt["pm_name"] ?>">
                                                </a>
                                                <div class="list-product-btn">
                                                    <a href="#"
                                                        class="box-icon bg_white quick-add tf-btn-loading" data-id="<?php echo $pdt["pm_id"]?>" data-img="<?php echo $pdt["pm_image"]?>" data-name="<?php echo $pdt["pm_name"]?>">
                                                        <span class="icon icon-bag"></span>
                                                        <span class="tooltip">Quick Add</span>
                                                    </a>


                                                    <a href="<?php echo ROOT ."product-detail/".$pdt["pm_id"] ?>"
                                                        class="box-icon bg_white quickview tf-btn-loading">
                                                        <span class="icon icon-view"></span>
                                                        <span class="tooltip">View</span>
                                                    </a>
                                                </div>
                                                <div class="size-list">
                                                    <?php 
                                            $sizearr=explode(",",$pdt["sizes"]);
                                            foreach($sizearr as $size){
                                                echo "<span>$size</span>";
                                            }
                                            ?>
                                                </div>
                                            </div>
                                            <div class="card-product-info">
                                                <a href="#" class="title link"><?php echo $pdt["pm_name"] ?></a>
                                                <span class="price">₹<?php echo $pdt["pd_price"]; ?></span>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="sw-dots style-2 sw-pagination-product justify-content-center"></div>
                        </div>
                        <?php
                        $firstPane = false;
                    } ?>
                       

                    </div>
                </div>
            </div>
        </section>
        <!-- Banner collection -->
        <section class="tf-slideshow slider-video position-relative">
            <div class="banner-wrapper">
                <video src="images/slider/slider-video-2.mp4" autoplay muted playsinline loop></video>
                <div class="box-content text-center">
                    <div class="container wow fadeInUp" data-wow-delay="0s">
                        <p class="subheading text-white fw-7">FREE SHIPPING OVER ORDER $120</p>
                        <h1 class="heading text-white">Spring Collection</h1>
                        <p class="description text-white">Here is your chance to upgrade your wardrobe with a variation
                            of styles</p>
                        <a href="<?php echo ROOT ?>products"
                            class="tf-btn btn-md btn-light-icon btn-icon radius-3 animate-hover-btn"><span>Shop
                                now</span><i class="icon icon-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Banner collection -->
        <!-- Testimonial -->
        <section class="flat-spacing-12 line">
            <div class="container">
                <div class="wrap-carousel wrapper-thumbs-testimonial flat-thumbs-testimonial">
                    <div class="box-left wow fadeInUp" data-wow-delay="0s">
                        <div dir="ltr" class="swiper tf-thumb-tes" data-preview="1" data-space="30">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="img-sw-thumb">
                                        <img class="lazyload img-product" data-src="images/item/tes-wear2.jpg"
                                            src="images/item/tes-wear2.jpg" alt="image-product">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="img-sw-thumb">
                                        <img class="lazyload img-product" data-src="images/item/tes-wear4.jpg"
                                            src="images/item/tes-wear4.jpg" alt="image-product">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="box-right wow fadeInUp" data-wow-delay="0s">
                        <div dir="ltr" class="swiper tf-sw-tes-2" data-preview="1" data-space-lg="40"
                            data-space-md="30">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="testimonial-item lg">
                                        <div class="icon icon-quote"></div>
                                        <div class="rating">
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                        </div>
                                        <p class="text fw-5">
                                            I have been shopping with this web fashion site for over a year nowand I can
                                            confidently say it is the best online fashion site out there.
                                        </p>
                                        <div class="divider"></div>
                                        <div class="author box-author">
                                            <div class="box-img d-md-none">
                                                <img class="lazyload img-product" data-src="images/item/tes-wear4.jpg"
                                                    src="images/item/tes-wear4.jpg" alt="image-product">
                                            </div>
                                            <div class="content">
                                                <div class="name">Jenifer Unix</div>
                                                <a href="#" class="metas link">Purchase item :
                                                    <span>Oversized Printed T-shirt</span></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-item lg">
                                        <div class="icon icon-quote"></div>
                                        <div class="rating">
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                        </div>
                                        <p class="text fw-5">
                                            Fashion website is impressive! The user-friendly interface and excellent
                                            customer service make shopping a breeze.
                                        </p>
                                        <div class="divider"></div>
                                        <div class="author box-author">
                                            <div class="box-img d-md-none">
                                                <img class="lazyload img-product" data-src="images/item/tes-wear1.jpg"
                                                    src="images/item/tes-wear1.jpg" alt="image-product">
                                            </div>
                                            <div class="content">
                                                <div class="name">Robert smith</div>
                                                <a href="#" class="metas link">Purchase item : <span>
                                                        The Scot Collar Mint</span></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nav-sw nav-next-slider nav-next-tes-2 lg"><span class="icon icon-arrow-left"></span>
                        </div>
                        <div class="nav-sw nav-prev-slider nav-prev-tes-2 lg"><span
                                class="icon icon-arrow-right"></span></div>
                        <div class="sw-dots style-2 sw-pagination-tes-2"></div>
                    </div>

                </div>
            </div>
        </section>
        <!-- /Testimonial -->
        <!-- Shop Gram -->
        <section class="flat-spacing-1 pb-0">
            <div class="container">
                <div class="flat-title wow fadeInUp" data-wow-delay="0s">
                    <span class="title">Be active. Be social</span>
                    <p class="sub-title">Inspire and let yourself be inspired, from one unique fashion to another.</p>
                </div>
                <div class="wrap-carousel wrap-shop-gram">
                    <div dir="ltr" class="swiper tf-sw-shop-gallery" data-preview="5" data-tablet="3" data-mobile="2"
                        data-space-lg="7" data-space-md="7">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="gallery-item hover-img wow fadeInUp" data-wow-delay="0s">
                                    <div class="img-style">
                                        <img class="lazyload img-hover" data-src="images/shop/gallery/activewear-gallery5.jpg"
                                            src="images/shop/gallery/activewear-gallery5.jpg" alt="image-gallery">
                                    </div>
                                    <a href="#quick_add" data-bs-toggle="modal" class="box-icon"><span
                                            class="icon icon-bag"></span> <span class="tooltip">Quick Add</span></a>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="gallery-item hover-img wow fadeInUp" data-wow-delay=".1s">
                                    <div class="img-style">
                                        <img class="lazyload img-hover" data-src="images/shop/gallery/activewear-gallery4.jpg"
                                            src="images/shop/gallery/activewear-gallery4.jpg" alt="image-gallery">
                                    </div>
                                    <a href="#quick_add" data-bs-toggle="modal" class="box-icon"><span
                                            class="icon icon-bag"></span> <span class="tooltip">Quick Add</span></a>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="gallery-item hover-img wow fadeInUp" data-wow-delay=".2s">
                                    <div class="img-style">
                                        <img class="lazyload img-hover" data-src="images/shop/gallery/activewear-gallery3.jpg"
                                            src="images/shop/gallery/activewear-gallery3.jpg" alt="image-gallery">
                                    </div>
                                    <a href="#quick_add" data-bs-toggle="modal" class="box-icon"><span
                                            class="icon icon-bag"></span> <span class="tooltip">Quick Add</span></a>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="gallery-item hover-img wow fadeInUp" data-wow-delay=".3s">
                                    <div class="img-style">
                                        <img class="lazyload img-hover" data-src="images/shop/gallery/activewear-gallery2.jpg"
                                            src="images/shop/gallery/activewear-gallery2.jpg" alt="image-gallery">
                                    </div>
                                    <a href="#" class="box-icon"><span class="icon icon-bag"></span>
                                        <span class="tooltip">View product</span></a>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="gallery-item hover-img wow fadeInUp" data-wow-delay=".4s">
                                    <div class="img-style">
                                        <img class="lazyload img-hover" data-src="images/shop/gallery/activewear-gallery1.jpg"
                                            src="images/shop/gallery/activewear-gallery1.jpg" alt="image-gallery">
                                    </div>
                                    <a href="#" class="box-icon"><span class="icon icon-bag"></span>
                                        <span class="tooltip">View product</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sw-dots style-2 justify-content-center sw-pagination-gallery"></div>
                </div>
            </div>
        </section>


        <!-- /Look book -->
        <!-- Marquee -->
        <div class="tf-marquee marquee-lg line">
            <div class="wrap-marquee">
                <div class="marquee-item">
                    <p>Use <a href="#" title="#">code GET30</a> at checkout for 30% off your first order</p>
                </div>
                <div class="marquee-item">
                    <p>Use <a href="#" title="#">code GET30</a> at checkout for 30% off your first order</p>
                </div>
                <div class="marquee-item">
                    <p>Use <a href="#" title="#">code GET30</a> at checkout for 30% off your first order</p>
                </div>
            </div>
        </div>
      
       <?php footer();?>

    </div>
       <?php scripts();?>

   
  
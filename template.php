<?php 
include("includes/config.php");
include("includes/MysqliDb.php");

function head($title="Odaz Sports",$homepage=true){
 global $categories;
$pdtobj = new MysqliDb(HOST, USER, PWD, DB);
$pdtobj->where("ct_status", 0);
$pdtobj->join("tbl_sub_category sct", "sct.ct_id=ct.ct_id AND sct.sct_status=0");
$pdtobj->orderBy("ct.ct_id", "ASC");
$catgryarr = $pdtobj->get("tbl_category ct", null, "ct.ct_id, ct.ct_title, sct.sct_id, sct.sct_title");
// $pdtobj->where("is_featured",1);
$pdtobj->groupBy("pm.pm_id");
$pdtobj->join("tbl_product_detail pd", "pd.pm_id=pm.pm_id");
$pdtarray = $pdtobj->get("tbl_product_master pm", null, "pm.pm_id,ct_id,pm_name,pm_desc,pm_code,pm_note,pm_status,sct_id,is_featured,offer_tag,pm_image,pd.pd_price");

foreach($catgryarr as $row){
    $categories[$row["ct_id"]][] = Array("catname"=>$row["ct_title"],"catid"=>$row["ct_id"],"subcatname"=>$row["sct_title"],"subcatid"=>$row["sct_id"]); 
}
$featured = [];
foreach ($pdtarray as $p) {
        $featured[$p['ct_id']][] = $p;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <meta charset="utf-8">
    <title><?php echo $title?></title>

    <meta name="author" content="odazsports.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="odazsports">

    <!-- font -->
    <link rel="stylesheet" href="<?php echo ROOT ?>fonts/fonts.css">
    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo ROOT ?>fonts/font-icons.css">
    <link rel="stylesheet" href="<?php echo ROOT ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ROOT ?>css/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo ROOT ?>css/animate.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT ?>css/styles.css" />

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="<?php echo ROOT ?>images/ico.jpeg">
    <link rel="apple-touch-icon-precomposed" href="<?php echo ROOT ?>images/ico.jpeg">
<style>
    .activesize{
        background-color: black!important;
        color: white!important;
    }
      .activecolor{
        border-color: black!important;
        box-shadow: 0 0.4rem 0.4rem rgba(0, 0, 0, 0.1019607843);
    }
   
</style>
</head>

<body class="preload-wrapper">
<?php //if($homepage){?>

    <!-- preload -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->
    <div id="wrapper">
        <!-- Announcement Bar -->
<?php if($homepage){?>

        <div class="announcement-bar bg_primary">
            <div class="container-full">
                <div class="row justify-content-center">
                    <div class="col-xl-3 col-md-4 col-12 text-center wrap-announcement-bar-2">
                        <div dir="ltr" class="swiper tf-sw-top_bar" data-preview="1" data-space="0" data-loop="true"
                            data-speed="1000" data-delay="2000">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <p class="noti-bar-text text-white fw-5">Welcome to our store</p>
                                </div>
                                <div class="swiper-slide">
                                    <p class="noti-bar-text text-white fw-5">10% Off Your First Order </p>
                                </div>
                            </div>
                        </div>
                        <div class="navigation-topbar nav-next-topbar"><span class="icon icon-arrow-left"></span></div>
                        <div class="navigation-topbar nav-prev-topbar"><span class="icon icon-arrow-right"></span></div>
                    </div>
                </div>
                <span class="icon-close close-announcement-bar"></span>
            </div>
        </div>
<?php } ?>

        <!-- /Announcement Bar -->
        <!-- Header -->
        <header id="header" class="header-default <?php echo $homepage?"header-absolute header-white":""?> ">
            <div class="container-full px_15 lg-px_40">
                <div class="row wrapper-header align-items-center">
                    <div class="col-md-4 col-3 tf-lg-hidden">
                        <a href="#mobileMenu" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                            class="btn-mobile">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16"
                                fill="none">
                                <path
                                    d="M2.00056 2.28571H16.8577C17.1608 2.28571 17.4515 2.16531 17.6658 1.95098C17.8802 1.73665 18.0006 1.44596 18.0006 1.14286C18.0006 0.839753 17.8802 0.549063 17.6658 0.334735C17.4515 0.120408 17.1608 0 16.8577 0H2.00056C1.69745 0 1.40676 0.120408 1.19244 0.334735C0.978109 0.549063 0.857702 0.839753 0.857702 1.14286C0.857702 1.44596 0.978109 1.73665 1.19244 1.95098C1.40676 2.16531 1.69745 2.28571 2.00056 2.28571ZM0.857702 8C0.857702 7.6969 0.978109 7.40621 1.19244 7.19188C1.40676 6.97755 1.69745 6.85714 2.00056 6.85714H22.572C22.8751 6.85714 23.1658 6.97755 23.3801 7.19188C23.5944 7.40621 23.7148 7.6969 23.7148 8C23.7148 8.30311 23.5944 8.59379 23.3801 8.80812C23.1658 9.02245 22.8751 9.14286 22.572 9.14286H2.00056C1.69745 9.14286 1.40676 9.02245 1.19244 8.80812C0.978109 8.59379 0.857702 8.30311 0.857702 8ZM0.857702 14.8571C0.857702 14.554 0.978109 14.2633 1.19244 14.049C1.40676 13.8347 1.69745 13.7143 2.00056 13.7143H12.2863C12.5894 13.7143 12.8801 13.8347 13.0944 14.049C13.3087 14.2633 13.4291 14.554 13.4291 14.8571C13.4291 15.1602 13.3087 15.4509 13.0944 15.6653C12.8801 15.8796 12.5894 16 12.2863 16H2.00056C1.69745 16 1.40676 15.8796 1.19244 15.6653C0.978109 15.4509 0.857702 15.1602 0.857702 14.8571Z"
                                    fill="currentColor"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="<?php echo ROOT ?>" class="logo-header">
                            <?php if($homepage){?>
                            <img src="<?php echo ROOT ?>images/logo/logo-white%402x.png" alt="logo" class="logo">
                            <?php }else{?>
                            <img src="<?php echo ROOT ?>images/logo-bk.png" alt="logo" class="logo">

                                <?php } ?>
                        </a>
                    </div>
                    <div class="col-xl-6 tf-md-hidden">
                        <nav class="box-navigation text-center">
                            <ul class="box-nav-ul d-flex align-items-center justify-content-center gap-30">
                                <li class="menu-item">
                                    <a href="<?php echo ROOT ?>" class="item-link">Home</a>

                                </li>
                             
                                <?php foreach($categories as $catid => $subcats){ ?>
                                <li class="menu-item">
                                    <a href="#" class="item-link"><?php echo $subcats[0]["catname"] ?> <i class="icon icon-arrow-down"></i></a>
                                    <div class="sub-menu mega-menu">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <div class="mega-menu-item">
                                                        <div class="menu-heading">Categories
                                                        </div>
                                                            <?php if (!empty(array_filter($subcats))):  ?>

                                                        <ul class="menu-list">
                                                                    <?php foreach($subcats as $subcat){
                                                                        if ($subcat) {
                                                                            echo "<li><a href='".ROOT ."products/$subcat[subcatid]' class='menu-link-text link'>$subcat[subcatname]</a></li>";
                                                                        }
                                                                    } ?>
                                                            <?php endif; ?>

                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="menu-heading">Best seller</div>
                                                    <div class="hover-sw-nav hover-sw-2">
                                                        <div dir="ltr" class="swiper tf-product-header">
                                                            <div class="swiper-wrapper">

                                                            <?php foreach($featured[$catid] as $pdt){?>
                                                                <div class="swiper-slide" lazy="true">
                                                                    <div class="card-product">
                                                                        <div class="card-product-wrapper">
                                                                            <a href="#" class="product-img">
                                                                                <img class="lazyload img-product" data-src="<?php echo ROOT . "uploads/" . $pdt["pm_image"] ?>" src="<?php echo ROOT . "uploads/" . $pdt["pm_image"] ?>" alt="image-product">
                                                                                <img class="lazyload img-hover"
                                                                                    data-src="<?php echo ROOT . "uploads/" . $pdt["pm_image"] ?>"
                                                                                    src="<?php echo ROOT . "uploads/" . $pdt["pm_image"] ?>"
                                                                                    alt="image-product">
                                                                            </a>
                                                                            <div class="list-product-btn absolute-2">
                                                                                <a href="#quick_add" data-bs-toggle="modal"
                                                                                    class="box-icon bg_white quick-add tf-btn-loading" data-id="<?php echo $pdt["pm_id"]?>" data-img="<?php echo $pdt["pm_image"]?>" data-name="<?php echo $pdt["pm_name"]?>">
                                                                                    <span class="icon icon-bag"></span>
                                                                                    <span class="tooltip">Quick Add</span>
                                                                                </a>
                                                                                

                                                                                <a href="<?php echo ROOT ."product-detail/".$pdt["pm_id"] ?>" class="box-icon bg_white quickview tf-btn-loading">
                                                                                    <span class="icon icon-view"></span>
                                                                                    <span class="tooltip"> View</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-product-info">
                                                                            <a href="#" class="title link"><?php echo $pdt["pm_name"]?></a>
                                                                            <span class="price">₹<?php echo $pdt["pd_price"]; ?></span>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php } ?>
                                                                
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="nav-sw nav-next-slider nav-next-product-header box-icon w_46 round">
                                                            <span class="icon icon-arrow-left"></span>
                                                        </div>
                                                        <div
                                                            class="nav-sw nav-prev-slider nav-prev-product-header box-icon w_46 round">
                                                            <span class="icon icon-arrow-right"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                               <?php }?>
                                
                                <li class="menu-item position-relative">
                                    <a href="<?php echo ROOT?>" class="item-link">About Us</a>
                                </li>
                                <li class="menu-item"><a
                                        href="<?php echo ROOT?>"
                                        class="item-link">Contact Us</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-xl-3 col-md-4 col-3">
                        <ul class="nav-icon d-flex justify-content-end align-items-center gap-20">

                            <!-- <li class="nav-account"><a href="#login" data-bs-toggle="modal" class="nav-icon-item"><i
                                        class="icon icon-account"></i></a></li> -->
                            <!--  <li class="nav-wishlist"><a href="#" class="nav-icon-item"><i
                                        class="icon icon-heart"></i><span class="count-box">0</span></a></li> -->
                            <li class="nav-cart"><a href="#shoppingCart" data-bs-toggle="modal" class="nav-icon-item"><i
                                        class="icon icon-bag"></i><span class="count-box">0</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- /Header -->
  <!-- mobile menu -->
    <div class="offcanvas offcanvas-start canvas-mb" id="mobileMenu">
        <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
        <div class="mb-canvas-content">
            <div class="mb-body">
                <ul class="nav-ul-mb" id="wrapper-menu-navigation">
                    <li class="nav-mb-item">
                        <a href="<?php echo ROOT?>"
                            class="mb-menu-link">Home</a>
                    </li>

                    <?php foreach($categories as $catid => $subcats){ ?>

                    <li class="nav-mb-item">
                        <a href="#dropdown-menu-five" class="collapsed mb-menu-link current" data-bs-toggle="collapse"
                            aria-expanded="true" aria-controls="dropdown-menu-five">
                            <span><?php echo $subcats[0]["catname"]?></span>
                            <span class="btn-open-sub"></span>
                        </a>
                        <div id="dropdown-menu-five" class="collapse">
                            <ul class="sub-nav-menu">
                                <?php foreach($subcats as $subcat){?>

                                <li><a href="<?php echo ROOT ."products/".$subcat["subcatid"] ?>" class="sub-nav-link"><?php echo $subcat["subcatname"] ?></a></li>
                               
<?php } ?>
                            </ul>
                        </div>

                    </li>

                    <?php } ?>

                   
                    <li class="nav-mb-item">
                        <a href="<?php echo ROOT?>"
                            class="mb-menu-link">About Us</a>
                    </li>
                    <li class="nav-mb-item">
                        <a href="<?php echo ROOT?>"
                            class="mb-menu-link">Contact Us</a>
                    </li>
                </ul>
                <div class="mb-other-content">

                    <div class="mb-notice">
                        <a href="<?php echo ROOT ?>" class="text-need">Need help ?</a>
                    </div>
                    <ul class="mb-info"> <br>
                        <li>Address: Lorem Ipsum is simply dummy <br>
                            the printing and </li>
                        <li>Email: <b>info@odaz.com</b></li>
                        <li>Phone: <b>(212) 555-1234</b></li>
                    </ul>
                </div>
            </div>
            <div class="mb-bottom">
                <a href="#" class="site-nav-icon"><i class="icon icon-account"></i>Login</a>

            </div>
        </div>
    </div>
    <!-- /mobile menu -->
      <!-- Filter -->
    <div class="offcanvas offcanvas-start canvas-filter" id="filterShop">
        <div class="canvas-wrapper">
            <header class="canvas-header">
                <div class="filter-icon">
                    <span class="icon icon-filter"></span>
                    <span>Filter</span>
                </div>
                <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
            </header>
            <div class="canvas-body">
                <div class="widget-facet wd-categories">
                    
                    <div class="facet-title">
                        <a href="<?php echo ROOT ?>products"><span class="current" style="color: #fcaf17;;">All Products</span></a>
                        <span class="icon icon-arrow-right"></span>
                    </div>
                    
                </div>
            <?php foreach($categories as $catid => $subcats){ ?>
                <div class="widget-facet wd-categories">
                    <div class="facet-title" data-bs-target="#categories<?php echo $catid ?>" data-bs-toggle="collapse" aria-expanded="true"
                        aria-controls="categories">
                        <span class="current" style="color: #fcaf17;;"><?php echo $subcats[0]["catname"] ?></span>
                        <span class="icon icon-arrow-up"></span>
                    </div>
                    <div id="categories<?php echo $catid ?>" class="collapse show">
                        <ul class="list-categoris current-scrollbar mb_36">
                             <?php foreach($subcats as $subcat){?>
                            <li class="cate-item"><a href="<?php echo ROOT ."products/".$subcat["subcatid"] ?>"><span><?php echo $subcat["subcatname"]?></span></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                
                <?php } ?>
               
            </div>
        </div>
    </div>
    <!-- End Filter -->

<?php }
//}
function footer(){
?>
 <!-- Icon box -->
        <section class="flat-spacing-1 flat-iconbox wow fadeInUp" data-wow-delay="0s">
            <div class="container">
                <div class="wrap-carousel wrap-mobile">
                    <div dir="ltr" class="swiper tf-sw-mobile" data-preview="1" data-space="15">
                        <div class="swiper-wrapper wrap-iconbox">
                            <div class="swiper-slide">
                                <div class="tf-icon-box style-row">
                                    <div class="icon">
                                        <i class="icon-shipping"></i>
                                    </div>
                                    <div class="content">
                                        <div class="title fw-4">Free Shipping</div>
                                        <p>Free shipping over order $120</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tf-icon-box style-row">
                                    <div class="icon">
                                        <i class="icon-payment fs-22"></i>
                                    </div>
                                    <div class="content">
                                        <div class="title fw-4">Flexible Payment</div>
                                        <p>Pay with Multiple Credit Cards</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tf-icon-box style-row">
                                    <div class="icon">
                                        <i class="icon-return fs-20"></i>
                                    </div>
                                    <div class="content">
                                        <div class="title fw-4">14 Day Returns</div>
                                        <p>Within 30 days for an exchange</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tf-icon-box style-row">
                                    <div class="icon">
                                        <i class="icon-suport"></i>
                                    </div>
                                    <div class="content">
                                        <div class="title fw-4">Premium Support</div>
                                        <p>Outstanding premium support</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="sw-dots style-2 sw-pagination-mb justify-content-center"></div>
                </div>
            </div>
        </section>
        <!-- Footer -->
        <footer id="footer" class="footer background-black md-pb-70">
            <div class="footer-wrap">
                <div class="footer-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-4 col-md-6 col-12">
                                <div class="footer-infor">
                                    <div class="footer-logo">
                                        <a href="<?php echo ROOT ?>">
                                            <img alt="" src="images/logo/logo-white%402x.png" style="width: 150px;">
                                        </a>
                                    </div>
                                    <ul>
                                        <li>
                                            <p>Address: Lorem Ipsum is simply dummy text of <br> the printing and </p>
                                        </li>
                                        <li>
                                            <p>Email: <a href="#">info@odaz.com</a></p>
                                        </li>
                                        <li>
                                            <p>Phone: <a href="#">(123) 555-1234</a></p>
                                        </li>
                                    </ul>
                                    <a href="<?php echo ROOT ?>contact-1.html" class="tf-btn btn-line">Get direction<i
                                            class="icon icon-arrow1-top-left"></i></a>
                                    <ul class="tf-social-icon d-flex gap-10 style-white">
                                        <li><a href="#" class="box-icon w_34 round social-facebook social-line"><i
                                                    class="icon fs-14 icon-fb"></i></a></li>
                                        <li><a href="#" class="box-icon w_34 round social-twiter social-line"><i
                                                    class="icon fs-12 icon-Icon-x"></i></a></li>
                                        <li><a href="#" class="box-icon w_34 round social-instagram social-line"><i
                                                    class="icon fs-14 icon-instagram"></i></a></li>
                                        <li><a href="#" class="box-icon w_34 round social-tiktok social-line"><i
                                                    class="icon fs-14 icon-tiktok"></i></a></li>
                                        <li><a href="#" class="box-icon w_34 round social-pinterest social-line"><i
                                                    class="icon fs-14 icon-pinterest-1"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-6 col-12 footer-col-block">
                                <div class="footer-heading footer-heading-desktop">
                                    <h6>Menu</h6>
                                </div>
                                <div class="footer-heading footer-heading-moblie">
                                    <h6>Menu</h6>
                                </div>
                                <ul class="footer-menu-list tf-collapse-content">
                                    <li>
                                        <a href="<?php echo ROOT ?>" class="footer-menu_item">Home</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ROOT ?>" class="footer-menu_item"> About US
                                        </a>
                                    </li>
 <li>
                                        <a href="<?php echo ROOT ?>" class="footer-menu_item">Contact Us</a>
                                    </li>
                                    
                                   
                                </ul>
                            </div>
                    <?php
                     global $categories;
                    foreach($categories as $catid => $subcats){ ?>
                            <div class="col-xl-2 col-md-6 col-12 footer-col-block">
                                <div class="footer-heading footer-heading-desktop">
                                    <h6><?php echo $subcats[0]["catname"]?></h6>
                                </div>
                                <div class="footer-heading footer-heading-moblie">
                                    <h6><?php echo $subcats[0]["catname"]?></h6>
                                </div>
                                <ul class="footer-menu-list tf-collapse-content">
                                <?php foreach($subcats as $subcat){?>
                                    <li>
                                        <a href="<?php echo ROOT ."products/".$subcat["subcatid"] ?>" class="footer-menu_item"><?php echo $subcat["subcatname"] ?>

                                        </a>
                                    </li>
<?php } ?>
                                </ul>
                            </div>
<?php } ?>

                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div
                                    class="footer-bottom-wrap d-flex gap-20 flex-wrap justify-content-between align-items-center">
                                    <div style="width: 100%;text-align: center;" class="footer-menu_item">© 2025 Odaz. All Rights Reserved</div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- /Footer -->

         <!-- gotop -->
    <button id="goTop">
        <span class="border-progress"></span>
        <span class="icon icon-arrow-up"></span>
    </button>
    <!-- /gotop -->


   



    <!-- shoppingCart -->
    <div class="modal fullRight fade modal-shopping-cart" id="shoppingCart">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="header">
                    <div class="title fw-5">Shopping cart</div>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="wrap">

                    <div class="tf-mini-cart-wrap">
                        <div class="tf-mini-cart-main">
                            <div class="tf-mini-cart-sroll">
                                <div class="tf-mini-cart-items">
                                    <div class="tf-mini-cart-item">
                                        <div class="tf-mini-cart-image">
                                            <a href="#">
                                                <img src="images/products/white-2.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="tf-mini-cart-info">
                                            <a class="title link" href="#">T-shirt</a>
                                            <div class="meta-variant">Light gray</div>
                                            <div class="price fw-6">$25.00</div>
                                            <div class="tf-mini-cart-btns">
                                                <div class="wg-quantity small">
                                                    <span class="btn-quantity minus-btn">-</span>
                                                    <input type="text" name="number" value="1">
                                                    <span class="btn-quantity plus-btn">+</span>
                                                </div>
                                                <div class="tf-mini-cart-remove">Remove</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tf-mini-cart-item">
                                        <div class="tf-mini-cart-image">
                                            <a href="#">
                                                <img src="images/products/white-3.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="tf-mini-cart-info">
                                            <a class="title link" href="#">Oversized Motif T-shirt</a>
                                            <div class="price fw-6">$25.00</div>
                                            <div class="tf-mini-cart-btns">
                                                <div class="wg-quantity small">
                                                    <span class="btn-quantity minus-btn">-</span>
                                                    <input type="text" name="number" value="1">
                                                    <span class="btn-quantity plus-btn">+</span>
                                                </div>
                                                <div class="tf-mini-cart-remove">Remove</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tf-minicart-recommendations">
                                    <div class="tf-minicart-recommendations-heading">
                                        <div class="tf-minicart-recommendations-title">You may also like</div>
                                        <div class="sw-dots small style-2 cart-slide-pagination"></div>
                                    </div>
                                    <div dir="ltr" class="swiper tf-cart-slide">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="tf-minicart-recommendations-item">
                                                    <div class="tf-minicart-recommendations-item-image">
                                                        <a href="#">
                                                            <img src="images/products/white-3.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="tf-minicart-recommendations-item-infos flex-grow-1">
                                                        <a class="title" href="#">Loose Fit
                                                            Sweatshirt</a>
                                                        <div class="price">$25.00</div>
                                                    </div>
                                                    <div class="tf-minicart-recommendations-item-quickview">
                                                        <div class="btn-show-quickview quickview hover-tooltip">
                                                            <span class="icon icon-view"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="tf-minicart-recommendations-item">
                                                    <div class="tf-minicart-recommendations-item-image">
                                                        <a href="#">
                                                            <img src="images/products/white-2.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="tf-minicart-recommendations-item-infos flex-grow-1">
                                                        <a class="title" href="#">Loose Fit Hoodie</a>
                                                        <div class="price">$25.00</div>
                                                    </div>
                                                    <div class="tf-minicart-recommendations-item-quickview">
                                                        <div class="btn-show-quickview quickview hover-tooltip">
                                                            <span class="icon icon-view"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tf-mini-cart-bottom">

                            <div class="tf-mini-cart-bottom-wrap">
                                <div class="tf-cart-totals-discounts">
                                    <div class="tf-cart-total">Subtotal</div>
                                    <div class="tf-totals-total-value fw-6">$49.99 USD</div>
                                </div>
                                <div class="tf-cart-tax">Taxes and <a href="#">shipping</a> calculated at checkout</div>
                                <div class="tf-mini-cart-line"></div>

                                <div class="tf-mini-cart-view-checkout">
                                    <a href="#"
                                        class="tf-btn btn-outline radius-3 link w-100 justify-content-center">View
                                        cart</a>
                                    <a href="#"
                                        class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"><span>Check
                                            out</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="tf-mini-cart-tool-openable add-note">
                            <div class="overplay tf-mini-cart-tool-close"></div>
                            <div class="tf-mini-cart-tool-content">
                                <label for="Cart-note" class="tf-mini-cart-tool-text">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18"
                                            viewBox="0 0 16 18" fill="currentColor">
                                            <path
                                                d="M5.12187 16.4582H2.78952C2.02045 16.4582 1.39476 15.8325 1.39476 15.0634V2.78952C1.39476 2.02045 2.02045 1.39476 2.78952 1.39476H11.3634C12.1325 1.39476 12.7582 2.02045 12.7582 2.78952V7.07841C12.7582 7.46357 13.0704 7.77579 13.4556 7.77579C13.8407 7.77579 14.1529 7.46357 14.1529 7.07841V2.78952C14.1529 1.25138 12.9016 0 11.3634 0H2.78952C1.25138 0 0 1.25138 0 2.78952V15.0634C0 16.6015 1.25138 17.8529 2.78952 17.8529H5.12187C5.50703 17.8529 5.81925 17.5407 5.81925 17.1555C5.81925 16.7704 5.50703 16.4582 5.12187 16.4582Z">
                                            </path>
                                            <path
                                                d="M15.3882 10.0971C14.5724 9.28136 13.2452 9.28132 12.43 10.0965L8.60127 13.9168C8.51997 13.9979 8.45997 14.0979 8.42658 14.2078L7.59276 16.9528C7.55646 17.0723 7.55292 17.1993 7.58249 17.3207C7.61206 17.442 7.67367 17.5531 7.76087 17.6425C7.84807 17.7319 7.95768 17.7962 8.07823 17.8288C8.19879 17.8613 8.32587 17.8609 8.44621 17.8276L11.261 17.0479C11.3769 17.0158 11.4824 16.9543 11.5675 16.8694L15.3882 13.0559C16.2039 12.2401 16.2039 10.9129 15.3882 10.0971ZM10.712 15.7527L9.29586 16.145L9.71028 14.7806L12.2937 12.2029L13.2801 13.1893L10.712 15.7527ZM14.4025 12.0692L14.2673 12.204L13.2811 11.2178L13.4157 11.0834C13.6876 10.8115 14.1301 10.8115 14.402 11.0834C14.6739 11.3553 14.6739 11.7977 14.4025 12.0692Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span>Add Order Note</span>
                                </label>
                                <textarea name="note" id="Cart-note" placeholder="How can we help you?"></textarea>
                                <div class="tf-cart-tool-btns justify-content-center">
                                    <div
                                        class="tf-mini-cart-tool-primary text-center w-100 fw-6 tf-mini-cart-tool-close">
                                        Close</div>
                                </div>
                            </div>
                        </div>
                        <div class="tf-mini-cart-tool-openable add-gift">
                            <div class="overplay tf-mini-cart-tool-close"></div>
                            <form class="tf-product-form-addgift">
                                <div class="tf-mini-cart-tool-content">
                                    <div class="tf-mini-cart-tool-text">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M4.65957 3.64545C4.65957 0.73868 7.89921 -0.995558 10.3176 0.617949L11.9997 1.74021L13.6818 0.617949C16.1001 -0.995558 19.3398 0.73868 19.3398 3.64545V4.32992H20.4286C21.9498 4.32992 23.1829 5.56311 23.1829 7.08416V9.10087C23.1829 9.61861 22.7632 10.0383 22.2454 10.0383H21.8528V20.2502C21.8528 20.254 21.8527 20.2577 21.8527 20.2614C21.8467 22.3272 20.1702 24 18.103 24H5.89634C3.82541 24 2.14658 22.3212 2.14658 20.2502V10.0384H1.75384C1.23611 10.0384 0.816406 9.61865 0.816406 9.10092V7.08421C0.816406 5.56304 2.04953 4.32992 3.57069 4.32992H4.65957V3.64545ZM6.53445 4.32992H11.0622V3.36863L9.27702 2.17757C8.10519 1.39573 6.53445 2.2357 6.53445 3.64545V4.32992ZM12.9371 3.36863V4.32992H17.4649V3.64545C17.4649 2.2357 15.8942 1.39573 14.7223 2.17756L12.9371 3.36863ZM3.57069 6.2048C3.08499 6.2048 2.69128 6.59851 2.69128 7.08421V8.16348H8.31067L8.3107 6.2048H3.57069ZM8.31071 10.0384V18.5741C8.31071 18.9075 8.48779 19.2158 8.77577 19.3838C9.06376 19.5518 9.4193 19.5542 9.70953 19.3901L11.9997 18.0953L14.2898 19.3901C14.58 19.5542 14.9356 19.5518 15.2236 19.3838C15.5115 19.2158 15.6886 18.9075 15.6886 18.5741V10.0383H19.9779V20.2137C19.9778 20.2169 19.9778 20.2201 19.9778 20.2233V20.2502C19.9778 21.2857 19.1384 22.1251 18.103 22.1251H5.89634C4.86088 22.1251 4.02146 21.2857 4.02146 20.2502V10.0384H8.31071ZM21.308 8.16344V7.08416C21.308 6.59854 20.9143 6.2048 20.4286 6.2048H15.6886V8.16344H21.308ZM13.8138 6.2048H10.1856V16.9672L11.5383 16.2024C11.8246 16.0405 12.1748 16.0405 12.461 16.2024L13.8138 16.9672V6.2048Z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="tf-gift-wrap-infos">
                                            <p>Do you want a gift wrap?</p>
                                            Only
                                            <span class="price fw-6">$5.00</span>
                                        </div>
                                    </div>
                                    <div class="tf-cart-tool-btns">
                                        <button type="submit"
                                            class="tf-btn fw-6 w-100 justify-content-center btn-fill animate-hover-btn radius-3"><span>Add
                                                a gift wrap</span></button>
                                        <div
                                            class="tf-mini-cart-tool-primary text-center w-100 fw-6 tf-mini-cart-tool-close">
                                            Cancel</div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tf-mini-cart-tool-openable estimate-shipping">
                            <div class="overplay tf-mini-cart-tool-close"></div>
                            <div class="tf-mini-cart-tool-content">
                                <div class="tf-mini-cart-tool-text">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="15"
                                            viewBox="0 0 21 15" fill="currentColor">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.441406 1.13155C0.441406 0.782753 0.724159 0.5 1.07295 0.5H12.4408C12.7896 0.5 13.0724 0.782753 13.0724 1.13155V2.91575H16.7859C18.8157 2.91575 20.5581 4.43473 20.5581 6.42296V11.8878C20.5581 12.2366 20.2753 12.5193 19.9265 12.5193H18.7542C18.4967 13.6534 17.4823 14.5 16.2703 14.5C15.0582 14.5 14.0439 13.6534 13.7864 12.5193H7.20445C6.94692 13.6534 5.93259 14.5 4.72054 14.5C3.50849 14.5 2.49417 13.6534 2.23664 12.5193H1.07295C0.724159 12.5193 0.441406 12.2366 0.441406 11.8878V1.13155ZM2.26988 11.2562C2.57292 10.1881 3.55537 9.40578 4.72054 9.40578C5.88572 9.40578 6.86817 10.1881 7.17121 11.2562H11.8093V1.76309H1.7045V11.2562H2.26988ZM13.0724 4.17884V6.68916H19.295V6.42296C19.295 5.2348 18.2252 4.17884 16.7859 4.17884H13.0724ZM19.295 7.95226H13.0724V11.2562H13.8196C14.1227 10.1881 15.1051 9.40578 16.2703 9.40578C17.4355 9.40578 18.4179 10.1881 18.7209 11.2562H19.295V7.95226ZM4.72054 10.6689C4.0114 10.6689 3.43652 11.2437 3.43652 11.9529C3.43652 12.662 4.0114 13.2369 4.72054 13.2369C5.42969 13.2369 6.00456 12.662 6.00456 11.9529C6.00456 11.2437 5.42969 10.6689 4.72054 10.6689ZM16.2703 10.6689C15.5611 10.6689 14.9863 11.2437 14.9863 11.9529C14.9863 12.662 15.5611 13.2369 16.2703 13.2369C16.9794 13.2369 17.5543 12.662 17.5543 11.9529C17.5543 11.2437 16.9794 10.6689 16.2703 10.6689Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="fw-6">Estimate Shipping</span>
                                </div>
                                <div class="field">
                                    <p>Country</p>
                                    <select class="tf-select w-100" id="ShippingCountry_CartDrawer-Form"
                                        name="address[country]" data-default="">
                                        <option value="---" data-provinces="[]">---</option>
                                        <option value="Australia"
                                            data-provinces="[['Australian Capital Territory','Australian Capital Territory'],['New South Wales','New South Wales'],['Northern Territory','Northern Territory'],['Queensland','Queensland'],['South Australia','South Australia'],['Tasmania','Tasmania'],['Victoria','Victoria'],['Western Australia','Western Australia']]">
                                            Australia</option>
                                        <option value="Austria" data-provinces="[]">Austria</option>
                                        <option value="Belgium" data-provinces="[]">Belgium</option>
                                        <option value="Canada"
                                            data-provinces="[['Alberta','Alberta'],['British Columbia','British Columbia'],['Manitoba','Manitoba'],['New Brunswick','New Brunswick'],['Newfoundland and Labrador','Newfoundland and Labrador'],['Northwest Territories','Northwest Territories'],['Nova Scotia','Nova Scotia'],['Nunavut','Nunavut'],['Ontario','Ontario'],['Prince Edward Island','Prince Edward Island'],['Quebec','Quebec'],['Saskatchewan','Saskatchewan'],['Yukon','Yukon']]">
                                            Canada</option>
                                        <option value="Czech Republic" data-provinces="[]">Czechia</option>
                                        <option value="Denmark" data-provinces="[]">Denmark</option>
                                        <option value="Finland" data-provinces="[]">Finland</option>
                                        <option value="France" data-provinces="[]">France</option>
                                        <option value="Germany" data-provinces="[]">Germany</option>
                                        <option value="Hong Kong"
                                            data-provinces="[['Hong Kong Island','Hong Kong Island'],['Kowloon','Kowloon'],['New Territories','New Territories']]">
                                            Hong Kong SAR</option>
                                        <option value="Ireland"
                                            data-provinces="[['Carlow','Carlow'],['Cavan','Cavan'],['Clare','Clare'],['Cork','Cork'],['Donegal','Donegal'],['Dublin','Dublin'],['Galway','Galway'],['Kerry','Kerry'],['Kildare','Kildare'],['Kilkenny','Kilkenny'],['Laois','Laois'],['Leitrim','Leitrim'],['Limerick','Limerick'],['Longford','Longford'],['Louth','Louth'],['Mayo','Mayo'],['Meath','Meath'],['Monaghan','Monaghan'],['Offaly','Offaly'],['Roscommon','Roscommon'],['Sligo','Sligo'],['Tipperary','Tipperary'],['Waterford','Waterford'],['Westmeath','Westmeath'],['Wexford','Wexford'],['Wicklow','Wicklow']]">
                                            Ireland</option>
                                        <option value="Israel" data-provinces="[]">Israel</option>
                                        <option value="Italy"
                                            data-provinces="[['Agrigento','Agrigento'],['Alessandria','Alessandria'],['Ancona','Ancona'],['Aosta','Aosta Valley'],['Arezzo','Arezzo'],['Ascoli Piceno','Ascoli Piceno'],['Asti','Asti'],['Avellino','Avellino'],['Bari','Bari'],['Barletta-Andria-Trani','Barletta-Andria-Trani'],['Belluno','Belluno'],['Benevento','Benevento'],['Bergamo','Bergamo'],['Biella','Biella'],['Bologna','Bologna'],['Bolzano','South Tyrol'],['Brescia','Brescia'],['Brindisi','Brindisi'],['Cagliari','Cagliari'],['Caltanissetta','Caltanissetta'],['Campobasso','Campobasso'],['Carbonia-Iglesias','Carbonia-Iglesias'],['Caserta','Caserta'],['Catania','Catania'],['Catanzaro','Catanzaro'],['Chieti','Chieti'],['Como','Como'],['Cosenza','Cosenza'],['Cremona','Cremona'],['Crotone','Crotone'],['Cuneo','Cuneo'],['Enna','Enna'],['Fermo','Fermo'],['Ferrara','Ferrara'],['Firenze','Florence'],['Foggia','Foggia'],['Forlì-Cesena','Forlì-Cesena'],['Frosinone','Frosinone'],['Genova','Genoa'],['Gorizia','Gorizia'],['Grosseto','Grosseto'],['Imperia','Imperia'],['Isernia','Isernia'],['L'Aquila','L’Aquila'],['La Spezia','La Spezia'],['Latina','Latina'],['Lecce','Lecce'],['Lecco','Lecco'],['Livorno','Livorno'],['Lodi','Lodi'],['Lucca','Lucca'],['Macerata','Macerata'],['Mantova','Mantua'],['Massa-Carrara','Massa and Carrara'],['Matera','Matera'],['Medio Campidano','Medio Campidano'],['Messina','Messina'],['Milano','Milan'],['Modena','Modena'],['Monza e Brianza','Monza and Brianza'],['Napoli','Naples'],['Novara','Novara'],['Nuoro','Nuoro'],['Ogliastra','Ogliastra'],['Olbia-Tempio','Olbia-Tempio'],['Oristano','Oristano'],['Padova','Padua'],['Palermo','Palermo'],['Parma','Parma'],['Pavia','Pavia'],['Perugia','Perugia'],['Pesaro e Urbino','Pesaro and Urbino'],['Pescara','Pescara'],['Piacenza','Piacenza'],['Pisa','Pisa'],['Pistoia','Pistoia'],['Pordenone','Pordenone'],['Potenza','Potenza'],['Prato','Prato'],['Ragusa','Ragusa'],['Ravenna','Ravenna'],['Reggio Calabria','Reggio Calabria'],['Reggio Emilia','Reggio Emilia'],['Rieti','Rieti'],['Rimini','Rimini'],['Roma','Rome'],['Rovigo','Rovigo'],['Salerno','Salerno'],['Sassari','Sassari'],['Savona','Savona'],['Siena','Siena'],['Siracusa','Syracuse'],['Sondrio','Sondrio'],['Taranto','Taranto'],['Teramo','Teramo'],['Terni','Terni'],['Torino','Turin'],['Trapani','Trapani'],['Trento','Trentino'],['Treviso','Treviso'],['Trieste','Trieste'],['Udine','Udine'],['Varese','Varese'],['Venezia','Venice'],['Verbano-Cusio-Ossola','Verbano-Cusio-Ossola'],['Vercelli','Vercelli'],['Verona','Verona'],['Vibo Valentia','Vibo Valentia'],['Vicenza','Vicenza'],['Viterbo','Viterbo']]">
                                            Italy</option>
                                        <option value="Japan"
                                            data-provinces="[['Aichi','Aichi'],['Akita','Akita'],['Aomori','Aomori'],['Chiba','Chiba'],['Ehime','Ehime'],['Fukui','Fukui'],['Fukuoka','Fukuoka'],['Fukushima','Fukushima'],['Gifu','Gifu'],['Gunma','Gunma'],['Hiroshima','Hiroshima'],['Hokkaidō','Hokkaido'],['Hyōgo','Hyogo'],['Ibaraki','Ibaraki'],['Ishikawa','Ishikawa'],['Iwate','Iwate'],['Kagawa','Kagawa'],['Kagoshima','Kagoshima'],['Kanagawa','Kanagawa'],['Kumamoto','Kumamoto'],['Kyōto','Kyoto'],['Kōchi','Kochi'],['Mie','Mie'],['Miyagi','Miyagi'],['Miyazaki','Miyazaki'],['Nagano','Nagano'],['Nagasaki','Nagasaki'],['Nara','Nara'],['Niigata','Niigata'],['Okayama','Okayama'],['Okinawa','Okinawa'],['Saga','Saga'],['Saitama','Saitama'],['Shiga','Shiga'],['Shimane','Shimane'],['Shizuoka','Shizuoka'],['Tochigi','Tochigi'],['Tokushima','Tokushima'],['Tottori','Tottori'],['Toyama','Toyama'],['Tōkyō','Tokyo'],['Wakayama','Wakayama'],['Yamagata','Yamagata'],['Yamaguchi','Yamaguchi'],['Yamanashi','Yamanashi'],['Ōita','Oita'],['Ōsaka','Osaka']]">
                                            Japan</option>
                                        <option value="Malaysia"
                                            data-provinces="[['Johor','Johor'],['Kedah','Kedah'],['Kelantan','Kelantan'],['Kuala Lumpur','Kuala Lumpur'],['Labuan','Labuan'],['Melaka','Malacca'],['Negeri Sembilan','Negeri Sembilan'],['Pahang','Pahang'],['Penang','Penang'],['Perak','Perak'],['Perlis','Perlis'],['Putrajaya','Putrajaya'],['Sabah','Sabah'],['Sarawak','Sarawak'],['Selangor','Selangor'],['Terengganu','Terengganu']]">
                                            Malaysia</option>
                                        <option value="Netherlands" data-provinces="[]">Netherlands</option>
                                        <option value="New Zealand"
                                            data-provinces="[['Auckland','Auckland'],['Bay of Plenty','Bay of Plenty'],['Canterbury','Canterbury'],['Chatham Islands','Chatham Islands'],['Gisborne','Gisborne'],['Hawke's Bay','Hawke’s Bay'],['Manawatu-Wanganui','Manawatū-Whanganui'],['Marlborough','Marlborough'],['Nelson','Nelson'],['Northland','Northland'],['Otago','Otago'],['Southland','Southland'],['Taranaki','Taranaki'],['Tasman','Tasman'],['Waikato','Waikato'],['Wellington','Wellington'],['West Coast','West Coast']]">
                                            New Zealand</option>
                                        <option value="Norway" data-provinces="[]">Norway</option>
                                        <option value="Poland" data-provinces="[]">Poland</option>
                                        <option value="Portugal"
                                            data-provinces="[['Aveiro','Aveiro'],['Açores','Azores'],['Beja','Beja'],['Braga','Braga'],['Bragança','Bragança'],['Castelo Branco','Castelo Branco'],['Coimbra','Coimbra'],['Faro','Faro'],['Guarda','Guarda'],['Leiria','Leiria'],['Lisboa','Lisbon'],['Madeira','Madeira'],['Portalegre','Portalegre'],['Porto','Porto'],['Santarém','Santarém'],['Setúbal','Setúbal'],['Viana do Castelo','Viana do Castelo'],['Vila Real','Vila Real'],['Viseu','Viseu'],['Évora','Évora']]">
                                            Portugal</option>
                                        <option value="Singapore" data-provinces="[]">Singapore</option>
                                        <option value="South Korea"
                                            data-provinces="[['Busan','Busan'],['Chungbuk','North Chungcheong'],['Chungnam','South Chungcheong'],['Daegu','Daegu'],['Daejeon','Daejeon'],['Gangwon','Gangwon'],['Gwangju','Gwangju City'],['Gyeongbuk','North Gyeongsang'],['Gyeonggi','Gyeonggi'],['Gyeongnam','South Gyeongsang'],['Incheon','Incheon'],['Jeju','Jeju'],['Jeonbuk','North Jeolla'],['Jeonnam','South Jeolla'],['Sejong','Sejong'],['Seoul','Seoul'],['Ulsan','Ulsan']]">
                                            South Korea</option>
                                        <option value="Spain"
                                            data-provinces="[['A Coruña','A Coruña'],['Albacete','Albacete'],['Alicante','Alicante'],['Almería','Almería'],['Asturias','Asturias Province'],['Badajoz','Badajoz'],['Balears','Balears Province'],['Barcelona','Barcelona'],['Burgos','Burgos'],['Cantabria','Cantabria Province'],['Castellón','Castellón'],['Ceuta','Ceuta'],['Ciudad Real','Ciudad Real'],['Cuenca','Cuenca'],['Cáceres','Cáceres'],['Cádiz','Cádiz'],['Córdoba','Córdoba'],['Girona','Girona'],['Granada','Granada'],['Guadalajara','Guadalajara'],['Guipúzcoa','Gipuzkoa'],['Huelva','Huelva'],['Huesca','Huesca'],['Jaén','Jaén'],['La Rioja','La Rioja Province'],['Las Palmas','Las Palmas'],['León','León'],['Lleida','Lleida'],['Lugo','Lugo'],['Madrid','Madrid Province'],['Melilla','Melilla'],['Murcia','Murcia'],['Málaga','Málaga'],['Navarra','Navarra'],['Ourense','Ourense'],['Palencia','Palencia'],['Pontevedra','Pontevedra'],['Salamanca','Salamanca'],['Santa Cruz de Tenerife','Santa Cruz de Tenerife'],['Segovia','Segovia'],['Sevilla','Seville'],['Soria','Soria'],['Tarragona','Tarragona'],['Teruel','Teruel'],['Toledo','Toledo'],['Valencia','Valencia'],['Valladolid','Valladolid'],['Vizcaya','Biscay'],['Zamora','Zamora'],['Zaragoza','Zaragoza'],['Álava','Álava'],['Ávila','Ávila']]">
                                            Spain</option>
                                        <option value="Sweden" data-provinces="[]">Sweden</option>
                                        <option value="Switzerland" data-provinces="[]">Switzerland</option>
                                        <option value="United Arab Emirates"
                                            data-provinces="[['Abu Dhabi','Abu Dhabi'],['Ajman','Ajman'],['Dubai','Dubai'],['Fujairah','Fujairah'],['Ras al-Khaimah','Ras al-Khaimah'],['Sharjah','Sharjah'],['Umm al-Quwain','Umm al-Quwain']]">
                                            United Arab Emirates</option>
                                        <option value="United Kingdom"
                                            data-provinces="[['British Forces','British Forces'],['England','England'],['Northern Ireland','Northern Ireland'],['Scotland','Scotland'],['Wales','Wales']]">
                                            United Kingdom</option>
                                        <option value="United States"
                                            data-provinces="[['Alabama','Alabama'],['Alaska','Alaska'],['American Samoa','American Samoa'],['Arizona','Arizona'],['Arkansas','Arkansas'],['Armed Forces Americas','Armed Forces Americas'],['Armed Forces Europe','Armed Forces Europe'],['Armed Forces Pacific','Armed Forces Pacific'],['California','California'],['Colorado','Colorado'],['Connecticut','Connecticut'],['Delaware','Delaware'],['District of Columbia','Washington DC'],['Federated States of Micronesia','Micronesia'],['Florida','Florida'],['Georgia','Georgia'],['Guam','Guam'],['Hawaii','Hawaii'],['Idaho','Idaho'],['Illinois','Illinois'],['Indiana','Indiana'],['Iowa','Iowa'],['Kansas','Kansas'],['Kentucky','Kentucky'],['Louisiana','Louisiana'],['Maine','Maine'],['Marshall Islands','Marshall Islands'],['Maryland','Maryland'],['Massachusetts','Massachusetts'],['Michigan','Michigan'],['Minnesota','Minnesota'],['Mississippi','Mississippi'],['Missouri','Missouri'],['Montana','Montana'],['Nebraska','Nebraska'],['Nevada','Nevada'],['New Hampshire','New Hampshire'],['New Jersey','New Jersey'],['New Mexico','New Mexico'],['New York','New York'],['North Carolina','North Carolina'],['North Dakota','North Dakota'],['Northern Mariana Islands','Northern Mariana Islands'],['Ohio','Ohio'],['Oklahoma','Oklahoma'],['Oregon','Oregon'],['Palau','Palau'],['Pennsylvania','Pennsylvania'],['Puerto Rico','Puerto Rico'],['Rhode Island','Rhode Island'],['South Carolina','South Carolina'],['South Dakota','South Dakota'],['Tennessee','Tennessee'],['Texas','Texas'],['Utah','Utah'],['Vermont','Vermont'],['Virgin Islands','U.S. Virgin Islands'],['Virginia','Virginia'],['Washington','Washington'],['West Virginia','West Virginia'],['Wisconsin','Wisconsin'],['Wyoming','Wyoming']]">
                                            United States</option>
                                        <option value="Vietnam" data-provinces="[]">Vietnam</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <p>Zip code</p>
                                    <input type="text" name="text" placeholder="">
                                </div>
                                <div class="tf-cart-tool-btns">
                                    <a href="#"
                                        class="tf-btn fw-6 justify-content-center btn-fill w-100 animate-hover-btn radius-3"><span>Estimate</span></a>
                                    <div
                                        class="tf-mini-cart-tool-primary text-center fw-6 w-100 tf-mini-cart-tool-close">
                                        Cancel</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /shoppingCart -->


    <!-- modal quick_add -->
    <div class="modal fade modalDemo popup-quickadd" id="mdl_quick_add">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="wrap">
                    <div class="tf-product-info-item">
                        <div class="image">
                            <img id="pdtimg">
                        </div>
                        <div class="content">
                            <a href="#" id="pdtname" class="text-capitalize fw-bold"></a>
                            <div class="tf-product-info-price">
                                <div class="price" id="itmPrice"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tf-product-info-variant-picker mb_15">
                        
                        <div class="variant-picker-item">
                            <div class="variant-picker-label">
                                Size: <span class="fw-6 variant-picker-label-value" id="showsize"></span>
                            </div>
                            <div class="variant-picker-values" id="sizeWraper">
                            </div>
                        </div>
                        <div class="variant-picker-item" id="colorWrpr">
                            <div class="variant-picker-label">
                                Color: <span class="fw-6 variant-picker-label-value" id="showcolor"></span>
                            </div>
                            <div class="variant-picker-values" id="colorWraper"></div>
                        </div>
                    </div>
                    <div class="tf-product-info-quantity mb_15">
                        <div class="quantity-title fw-6">Quantity</div>
                        <div class="wg-quantity">
                            <span class="btn-quantity minus-btn">-</span>
                            <input type="text" name="number" value="1">
                            <span class="btn-quantity plus-btn">+</span>
                        </div>
                    </div>
                    <div class="tf-product-info-buy-button">
                        <form class="">
                            <a href="#"
                                class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn-add-to-cart"><span>Add to cart&nbsp;</span><span class="tf-qty-price"></span></a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal quick_add -->

    <!-- modal find_size -->
    <div class="modal fade modalDemo tf-product-modal popup-findsize" id="find_size">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <div class="demo-title">Size chart</div>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="tf-rte">
                    <div class="tf-table-res-df">
                        <h6>Size guide</h6>
                        <table class="tf-sizeguide-table">
                            <thead>
                                <tr>
                                    <th>Size</th>
                                    <th>US</th>
                                    <th>Bust</th>
                                    <th>Waist</th>
                                    <th>Low Hip</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>XS</td>
                                    <td>2</td>
                                    <td>32</td>
                                    <td>24 - 25</td>
                                    <td>33 - 34</td>
                                </tr>
                                <tr>
                                    <td>S</td>
                                    <td>4</td>
                                    <td>34 - 35</td>
                                    <td>26 - 27</td>
                                    <td>35 - 26</td>
                                </tr>
                                <tr>
                                    <td>M</td>
                                    <td>6</td>
                                    <td>36 - 37</td>
                                    <td>28 - 29</td>
                                    <td>38 - 40</td>
                                </tr>
                                <tr>
                                    <td>L</td>
                                    <td>8</td>
                                    <td>38 - 29</td>
                                    <td>30 - 31</td>
                                    <td>42 - 44</td>
                                </tr>
                                <tr>
                                    <td>XL</td>
                                    <td>10</td>
                                    <td>40 - 41</td>
                                    <td>32 - 33</td>
                                    <td>45 - 47</td>
                                </tr>
                                <tr>
                                    <td>XXL</td>
                                    <td>12</td>
                                    <td>42 - 43</td>
                                    <td>34 - 35</td>
                                    <td>48 - 50</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tf-page-size-chart-content">
                        <div>
                            <h6>Measuring Tips</h6>
                            <div class="title">Bust</div>
                            <p>Measure around the fullest part of your bust.</p>
                            <div class="title">Waist</div>
                            <p>Measure around the narrowest part of your torso.</p>
                            <div class="title">Low Hip</div>
                            <p class="mb-0">With your feet together measure around the fullest part of your hips/rear.
                            </p>
                        </div>
                        <div>
                            <img class="sizechart lazyload" data-src="images/shop/products/size_chart2.jpg"
                                src="images/shop/products/size_chart2.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <!-- /modal find_size -->


<?php } 
function scripts(){
?>


    <!-- Javascript -->
    <script src="<?php echo ROOT ?>js/bootstrap.min.js"></script>
    <script src="<?php echo ROOT ?>js/jquery.min.js"></script>
    <script src="<?php echo ROOT ?>js/swiper-bundle.min.js"></script>
    <script src="<?php echo ROOT ?>js/carousel.js"></script>
    <script src="<?php echo ROOT ?>js/count-down.js"></script>
    <script src="<?php echo ROOT ?>js/bootstrap-select.min.js"></script>
    <script src="<?php echo ROOT ?>js/lazysize.min.js"></script>
    <script src="<?php echo ROOT ?>js/bootstrap-select.min.js"></script>
    <script src="<?php echo ROOT ?>js/wow.min.js"></script>
    <script src="<?php echo ROOT ?>js/multiple-modal.js"></script>
    <script src="<?php echo ROOT ?>js/main.js"></script>



<script>
$(document).ready(function () {

var ROOT = "<?php echo ROOT ?>"; 
var size, pdtid, rate, colorname, colorid, sizeid;
var pdtdetails;
    function renderDetails(id) { 
        $("#colorWraper,#sizeWraper,#itmPrice,#showsize,#showcolor").html("");
        
        activecls = "activecolor";
        currentpdt = id || Object.keys(pdtdetails)[0];
        curentItem = pdtdetails[currentpdt]; 
        $.each(pdtdetails, function(key, sz) {

            $("<label class='pdtSz style-text' data-value='"+sz.sizename+"' data-id='" + key + "' data-size='" + sz.sizename+ "' data-sizeid='" + sz.size+ "'>").html(sz.sizename).appendTo("#sizeWraper");
        });
        $(".pdtSz[data-id='" + currentpdt + "']").addClass("activesize");
        $("#showsize").html(curentItem.sizetitle)

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
        $("#itmPrice").html("₹ " + price);
        index = 0;
        activecls = "activecolor";
        
        $.each(clridarr, function(key, color) {
            $("<label class='pdtclr hover-tooltip radius-60 "+activecls+"' data-clrid='" + color + "' data-clrnm='" + clrnamear[index] + "'><span class='btn-checkbox' style='background:"+clrcodearr[index]+";'></span><span class='tooltip'>"+clrnamear[index]+"</span></label>").appendTo("#colorWraper");
            index++;
            activecls = "";
        });
        $("#showcolor").html(clrnamear[0])
    }

$(document).on("click", ".pdtSz", function(atg) { 
        atg.preventDefault();
        myid = $(this).data("id");
        sizeid = $(this).data("sizeid");
        size = $(this).data("size");
        renderDetails(myid);
    });
    $(document).on("click", ".pdtclr", function(atg) {
        atg.preventDefault();
        colorname = $(this).data("clrnm");
        colorid = $(this).data("clrid");
        $(".pdtclr").removeClass("activecolor");
        $(this).addClass("activecolor");
        $("#showcolor").html($(this).data("clrnm"))
    });

$(document).on("click", ".quick-add", function () {
        id=$(this).data("id");
        name=$(this).data("name");
        img=ROOT+"uploads/thumb/"+$(this).data("img");
        $("#pdtname").html("");
        $("#pdtimg").attr("src", "");
        $("#pdtname").html(name);
        $("#pdtimg").attr("src",img);

        $.ajax({
        url: ROOT +'ajax/common-ajax.php',
        type: 'POST',
        data: {action: "productDetails", "id": id},
        success: function(response) {
            try {
                let jresp = $.parseJSON(response);
                if (jresp.status == "done") {
                    pdtdetails=jresp.variants;
                    renderDetails();
                    $("#mdl_quick_add").modal("show");
                } else {
                    console.log("Failed to get product detail");
                }
            } catch (err) {
                console.log(err);
            }
        }
    });
           
});
   
  
});
</script>
</body>
</html>
<?php } ?>


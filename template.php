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
    .is-invalid{
        border: 1px solid red!important;
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
                                                                            <a href="<?php echo ROOT ."product-detail/".$pdt["pm_id"] ?>" class="product-img">
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
                                                                            <a href="<?php echo ROOT ."product-detail/".$pdt["pm_id"] ?>" class="title link"><?php echo $pdt["pm_name"]?></a>
                                                                            <span class="price">AED <?php echo $pdt["pd_price"]; ?></span>
                                                                            
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
                                    <a href="<?php echo ROOT?>aboutus" class="item-link">About Us</a>
                                </li>
                                <li class="menu-item"><a
                                        href="<?php echo ROOT?>contactus"
                                        class="item-link">Contact Us</a></li>
                                        <?php if($_SESSION["CUST"]){?>
                                         <li class="menu-item"><a
                                        href="<?php echo ROOT?>profile"
                                        class="item-link">My Account</a></li>
                                        <?php }?>

                            </ul>
                        </nav>
                    </div>
                    <div class="col-xl-3 col-md-4 col-3">
                        <ul class="nav-icon d-flex justify-content-end align-items-center gap-20">

                            <?php if(!$_SESSION["CUST"]){
echo "<li class='nav-account'><a href='#login' data-bs-toggle='modal' class='nav-icon-item'><i class='icon icon-account'></i></a></li>";
                            }
                            ?>
                            <!--  <li class="nav-wishlist"><a href="#" class="nav-icon-item"><i
                                        class="icon icon-heart"></i><span class="count-box">0</span></a></li> -->
                            <li class="nav-cart"><a href="#shoppingCart" data-bs-toggle="modal" class="nav-icon-item"><i
                                        class="icon icon-bag"></i><span class="count-box"></span></a></li>
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
                        <a href="<?php echo ROOT?>aboutus"
                            class="mb-menu-link">About Us</a>
                    </li>
                    <li class="nav-mb-item">
                        <a href="<?php echo ROOT?>contactus"
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
            <!-- <div class="mb-bottom">
                <a href="#" class="site-nav-icon"><i class="icon icon-account"></i>Login</a>

            </div> -->
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
                                            <img alt="" src="<?php echo ROOT ?>images/logo/logo-white%402x.png" style="width: 150px;">
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
                                    <a href="<?php echo ROOT ?>contactus" class="tf-btn btn-line">Get direction<i
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
                                        <a href="<?php echo ROOT ?>aboutus" class="footer-menu_item"> About US
                                        </a>
                                    </li>
 <li>
                                        <a href="<?php echo ROOT ?>contactus" class="footer-menu_item">Contact Us</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ROOT ?>terms" class="footer-menu_item">Terms & Conditions</a>
                                    </li> <li>
                                        <a href="<?php echo ROOT ?>privacy-policy" class="footer-menu_item">Privacy Policy</a>
                                    </li> <li>
                                        <a href="<?php echo ROOT ?>cookie-policy" class="footer-menu_item">Cookie Policy</a>
                                    </li><li>
                                        <a href="<?php echo ROOT ?>refund-policy" class="footer-menu_item"> Refund Policy</a>
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
                                    <div style="width: 100%;text-align: center;" class="footer-menu_item">© 2026 Odaz. All Rights Reserved</div>

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
                                <div class="tf-mini-cart-items" id="cartWrapper">
                                </div>
                                
                            </div>
                        </div>
                        <div class="tf-mini-cart-bottom">

                            <div class="tf-mini-cart-bottom-wrap">
                                <div class="tf-cart-totals-discounts">
                                    <div class="tf-cart-total">Subtotal</div>
                                    <div class="tf-totals-total-value fw-6" id="cartTotal"></div>
                                </div>
                                
                                <div class="tf-mini-cart-line"></div>

                                <div class="tf-mini-cart-view-checkout">
                                    <a href="<?php echo ROOT?>checkout" class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center" id="cartCheckout">Check out</a>
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
                            <input type="text" name="number" value="1" id="pdtqty">
                            <span class="btn-quantity plus-btn">+</span>
                        </div>
                    </div>
                    <div class="tf-product-info-buy-button">
                       
                            <a href="#" class="tf-btn btn-fill justify-content-center fw-6 fs-16 w-100 flex-grow-1 animate-hover-btn btn-add-to-cart">Add to cart</a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal quick_add -->
      <!-- modal login -->
    <div class="modal modalCentered fade form-sign-in modal-part-content" id="login">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <div class="demo-title">Log in</div>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="tf-login-form">
                    <form id="frmLogin">
                        <input type="hidden" name="action" value="login">

                        <div class="tf-field style-1">
                            <input class="tf-field-input tf-input" placeholder=" " type="text" name="txtLogEmail" id="txtLogEmail">
                            <label class="tf-field-label" for="">Email *</label>
                        </div>
                        <div class="tf-field style-1">
                            <input class="tf-field-input tf-input" placeholder=" " type="password" name="txtLogPwd" id="txtLogPwd">
                            <label class="tf-field-label" for="">Password *</label>
                        </div>
                        <div>
                            <a href="#forgotPassword" data-bs-toggle="modal" class="btn-link link">Forgot your
                                password?</a>
                        </div>
                        <div class="bottom">
                            <div class="w-100">
                                <button type="submit" id="btnLogin"
                                    class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"><span>Log
                                        in</span></button>
                            </div>
                            <div class="w-100">
                                <a href="#register" data-bs-toggle="modal" class="btn-link fw-6 w-100 link">
                                    New customer? Create your account
                                    <i class="icon icon-arrow1-top-left"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mt-2" id="LogErrMsg"></div>

            </div>
        </div>
    </div>
    <div class="modal modalCentered fade form-sign-in modal-part-content" id="forgotPassword">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <div class="demo-title">Reset your password</div>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="tf-login-form">
                    <form id="frmForgot">
                        <input type="hidden" name="action" value="reset">

                        <div>
                            <p>Sign up for early Sale access plus tailored new arrivals, trends and promotions. To opt
                                out, click unsubscribe in our emails</p>
                        </div>
                        <div class="tf-field style-1">
                            <input class="tf-field-input tf-input" placeholder=" " type="email" name="txtFgtEmail" id="txtFgtEmail">
                            <label class="tf-field-label" for="">Email *</label>
                        </div>
                        <div>
                            <a href="#login" data-bs-toggle="modal" class="btn-link link">Cancel</a>
                        </div>
                        <div class="bottom">
                            <div class="w-100">
                                <button type="submit" id="btnForgt"
                                    class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"><span>Reset
                                        password</span></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mt-2" id="FgtErrMsg"></div>

            </div>
        </div>
    </div>
    <div class="modal modalCentered fade form-sign-in modal-part-content" id="register">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <div class="demo-title">Register</div>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="tf-login-form">
                    <form id="frmRegister">
                        <input type="hidden" name="action" value="register">
                        <div class="tf-field style-1">
                            <input class="tf-field-input tf-input" placeholder=" " type="text" name="txtname" id="txtname">
                            <label class="tf-field-label" for="">First name</label>
                        </div>
                        <div class="tf-field style-1">
                            <input class="tf-field-input tf-input" placeholder=" " type="text" name="txtmobile" id="txtmobile">
                            <label class="tf-field-label" for="">Mobile No.</label>
                        </div>
                        <div class="tf-field style-1">
                            <input class="tf-field-input tf-input" placeholder=" " type="text" name="txtEmail" id="txtEmail">
                            <label class="tf-field-label" for="">Email *</label>
                        </div>
                        <div class="tf-field style-1">
                            <input class="tf-field-input tf-input" placeholder=" " type="password" name="txtpwd" id="txtpwd">
                            <label class="tf-field-label" for="">Password *</label>
                        </div>
                        <div class="tf-field style-1">
                            <input class="tf-field-input tf-input" placeholder=" " type="password" id="confirmpwd">
                            <label class="tf-field-label" for="">Confirm Password *</label>
                        </div>
                        <div class="bottom">
                            <div class="w-100">
                                <button type="submit" class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center" id="btnRegister"><span>Register</span></button>
                            </div>
                            <div class="w-100">
                                <a href="#login" data-bs-toggle="modal" class="btn-link fw-6 w-100 link">
                                    Already have an account? Log in here
                                    <i class="icon icon-arrow1-top-left"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mt-2" id="RegErrMsg"></div>

            </div>
        </div>
    </div>
    <!-- /modal login -->

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
var size, pdtid, rate, colorname, colorid, sizeid,pmid,img,name,qty;
var ROOT = "<?php echo ROOT ?>"; 
    
$(document).ready(function () {

renderCartModal();


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
        $("#itmPrice").html("AED  " + price);
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
        $("#pdtqty").val(1)
        pmid=$(this).data("id");
        name=$(this).data("name");
        img=$(this).data("img");
        imgpath=ROOT+"uploads/thumb/"+img;
        $("#pdtname").html("");
        $("#pdtimg").attr("src", "");
        $("#pdtname").html(name);
        $("#pdtimg").attr("src",imgpath);

        $.ajax({
        url: ROOT +'ajax/common-ajax.php',
        type: 'POST',
        data: {action: "productDetails", "id": pmid},
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

$(document).on("click", ".btn-add-to-cart", function(e) {
        e.preventDefault();
        

        let qty = parseInt($("#pdtqty").val()) || 1;
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
                pmid: pmid,
                name: name,
                img: img,
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
        $("#mdl_quick_add").modal("hide");
        $("#shoppingCart").modal("show")
    });
// $(document).on("click", "#cartCheckout", function (e) {
//   e.preventDefault();

//   let products = JSON.parse(localStorage.getItem("cart") || "[]");
//   if (products.length === 0) {
//     alert("Your cart is empty!");
//     return;
//   }

//   let adminPhone = "919745452364";
 
//   let msg = "";
//   let total = 0;

//   products.forEach(p => {
//     if (!p.pmid) return;
//     let name = decodeURIComponent(p.name.replace(/\+/g, ' '));
//     msg += `• ${name} (${p.colorname}, ${p.size})\n`;
//     msg += `Qty: ${p.qty} × AED ${p.rate}\n\n`;
//     total += parseFloat(p.rate) * parseInt(p.qty);
//   });

//   msg += "-------------------------\n";
//   msg += `Total: AED ${total.toFixed(2)}`;

//   let encodedMsg = encodeURIComponent(msg);

//   let walink = "https://web.whatsapp.com/send";
//   if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
//     walink = "whatsapp://send";
//   }

//   let waUrl = `${walink}?phone=${adminPhone}&text=${encodedMsg}`;

//   window.open(waUrl, "_blank");

//   setTimeout(() => {
//     localStorage.removeItem("cart");
//     location.reload();
//   }, 1000);
// });


// Remove cart item
$(document).on("click", ".remove-cart", function () {
    let index = $(this).closest("li").data("index");
    let cart = JSON.parse(localStorage.getItem("cart") || "[]");
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCartModal();
});

jQuery(document).on('submit', '#frmRegister', function(event) {
event.preventDefault();
$("#RegErrMsg").html("");
$('#frmRegister is-invalid').removeClass('is-invalid');
regvalid=true;
msg="";
//register txtRname txtRmobile txtRemail btnReglog
if($("#txtname").val()==""){
$("#txtname").addClass('is-invalid');
msg+="Please enter your name<br>";
regvalid=false;  
}
if ($("#txtEmail").val().trim() === "") {
    $("#txtEmail").addClass('is-invalid');
    msg += "Enter Email ID<br>";
    regvalid = false;
}
else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($("#txtEmail").val())) {
    $("#txtEmail").addClass('is-invalid');
    msg += "Enter a valid Email ID<br>";
    regvalid = false;
}
if(! /^\d{9}$/.test($("#txtmobile").val())){
$("#txtmobile").addClass('is-invalid');
msg+="Enter a valid mobile number<br>";
regvalid=false; 
}
// password check
if($("#txtpwd").val()==""){
    $("#txtpwd").addClass('is-invalid');
    msg+="Please enter password<br>";
    regvalid=false;  
}

// confirm password check
if($("#confirmpwd").val()==""){
    $("#confirmpwd").addClass('is-invalid');
    msg+="Please confirm your password<br>";
    regvalid=false;  
} else if($("#txtpwd").val() != $("#confirmpwd").val()){
    $("#confirmpwd").addClass('is-invalid');
    msg+="Passwords do not match<br>";
    regvalid=false;  
}

if(regvalid){
$("#btnRegister").html("Processing..").attr("disabled","disabled");

jQuery.ajax({
url: '<?php echo ROOT?>ajax/customer-ajax.php',
type: 'POST',
data:$("#frmRegister").serialize(),
success: function(response, textStatus, xhr) {
$("#btnRegister").html("Register").removeAttr("disabled");
try{
jresp=$.parseJSON(response);
if(jresp.status=="done"){
$("<div>").addClass('text-success').html("Successfully registered").appendTo('#RegErrMsg');
window.location.href="<?php echo ROOT?>"

}
if(jresp.status=="exist"){
$("<div>").addClass('text-danger').html(jresp.msg).appendTo('#RegErrMsg');

}
}catch(exp){
$("<div>").addClass('text-danger').html("Something went wrong, Please try again").appendTo('#RegErrMsg');
}
//called when successful
},
error: function(xhr, textStatus, errorThrown) {
//called when there is an error
}
});
}else{
$("<div>").addClass('text-danger').html(msg).appendTo('#RegErrMsg');
}
});

jQuery(document).on('submit', '#frmForgot', function(event) {
event.preventDefault();
valid=true;
$("#FgtErrMsg").html(""); 
if($("#txtFgtEmail").val()==""){
$("#txtFgtEmail").addClass('is-invalid');
msg+="Please enter your Email Id<br>";
valid=false;  
}
if(valid){

$("#btnForgt").html("Processing..").attr("disabled","disabled");
jQuery.ajax({
url: '<?php echo ROOT?>ajax/customer-ajax.php',
type: 'POST',
data:$("#frmForgot").serialize(),
success: function(response, textStatus, xhr) {
$("#btnForgt").html("Reset").removeAttr("disabled");
try{
jresp=$.parseJSON(response);
if(jresp.status=="done"){
$("<div>").addClass('text-success').html("Your profile password has been reset.<br>Please check your Email to get new password").appendTo('#FgtErrMsg');
}
if(jresp.status=="notexist"){
$("<div>").addClass('text-danger').html("The Email ID is not registered in Odaz Sports").appendTo('#FgtErrMsg');
}
}catch(exp){
$("<div>").addClass('text-danger').html("Something went wrong, Please try again").appendTo('#FgtErrMsg');
}
},
error: function(xhr, textStatus, errorThrown) {
}
});

}else{
$("<div>").addClass('text-danger').html("Please check all inputs").appendTo('#FgtErrMsg');
    
}

}); 
jQuery(document).on('submit', '#frmLogin', function(event) { 
event.preventDefault();
logvalid=true;
$("#LogErrMsg").html("");
if($("#txtLogEmail").val()==""){
$("#txtLogEmail").addClass('is-invalid');
msg+="Please enter your Email ID<br>";
logvalid=false;  
}
if(logvalid){
$("#btnLogin").html("Processing..").attr("disabled","disabled");
jQuery.ajax({
url: '<?php echo ROOT?>ajax/customer-ajax.php',
type: 'POST',
data:$("#frmLogin").serialize(),
success: function(response, textStatus, xhr) { 
$("#btnLogin").html("Login").removeAttr("disabled");
try{
jresp=$.parseJSON(response);
if(jresp.status=="done"){
// location.reload();
window.location.href="<?php echo ROOT?>"
}
if(jresp.status=="error"){
$("<div>").addClass('text-danger').html("Password Incorrect").appendTo('#LogErrMsg');

}
if(jresp.status=="empty"){
$("<div>").addClass('text-danger').html("Username or Password Incorrect").appendTo('#LogErrMsg');
}
}catch(exp){
$("<div>").addClass('text-danger').html("Something went wrong, Please try again").appendTo('#LogErrMsg');
}
},
error: function(xhr, textStatus, errorThrown) {
}
});
}else{
$("<div>").addClass('text-danger').html(msg).appendTo('#LogErrMsg');
}

});
  
});
function renderCartModal() {
        var cartTotal = 0;
        let cart = JSON.parse(localStorage.getItem("cart") || "[]");
        let $wrapper = $("#cartWrapper");
        $wrapper.empty();

        if (cart.length === 0) {
            $wrapper.html("<div class='tf-mini-cart-item'><p>Your cart is empty</p></div>");
            $("#cartTotal").html("AED 0.00");
            $(".count-box").hide();  // hide badge when empty
            return;
        }
        

        $.each(cart, function (index, item) {
            let li =`<div class="tf-mini-cart-item" data-index="${index}">
                                        <div class="tf-mini-cart-image">
                                            <a href="#">
                                                <img src="${ROOT}uploads/thumb/${item.img}" alt="">
                                            </a>
                                        </div>
                                        <div class="tf-mini-cart-info">
                                            <a class="title link" href="${ROOT + "product-detail/" + item.pmid}">${item.name}</a>
                                            <div class="meta-variant">${item.size},${item.colorname}</div>
                                            <div class="price fw-6">AED ${(item.rate * item.qty).toFixed(2)}</div>

                                            <div class="tf-mini-cart-btns">
                                                <div class="wg-quantity small">
                                                    <div class="meta-variant" style="padding:0px 0px 0px 21px;">Qty : ${item.qty}</div>
                                                </div>
                                                <div class="tf-mini-cart-remove remove-cart">Remove</div>
                                            </div>
                                        </div>
                                                

                                    </div>`;
            $wrapper.append(li);
            cartTotal += (item.rate * item.qty);
        });
        $("#cartTotal").html("AED " + cartTotal.toFixed(2));
        // Update badge
        $(".count-box").text(cart.length).show();  
    }
</script>
</body>
</html>
<?php } ?>


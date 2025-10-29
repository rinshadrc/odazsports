<?php
include("../includes/config.php");
include("../includes/functions.php");
include("../includes/MysqliDb.php");

$menuobj = new MysqliDb(HOST, USER, PWD, DB);
$menuobj->where("up.u_type", $_SESSION["UTYPE"]);
$menuobj->groupBy("mm.mm_id,md.md_id");
$menuobj->orderBy("mm.mm_order,md.md_order", "ASC");
$menuobj->join("mv_menumaster mm", "up.mm_id=mm.mm_id");
$menuobj->join("mv_menudetail md", "md.mm_id=mm.mm_id AND md.md_id=up.md_id", "LEFT");
$menuar = $menuobj->get("mv_upermit up", null, "mm.mm_id,mm.mm_title,mm.mm_url,mm.mm_icon,mm.mm_display,mm.mm_order,mm.classname,md.md_icon,md.md_slug,md_titile,md_url,md_menu");
// echo $menuobj->getLastQuery();exit;
$acess = array();
$module = array();
foreach ($menuar as $menu) {
  $acess[$menu["mm_url"]] = 1;
  $acess[$menu["md_url"]] = 1;
  $module[$menu["md_slug"]] = 1;
}
if (!$_SESSION["LOGGED"]) {
  header("location:" . ADMINROOT . "login");
}
function head($title="Movieclicks Headoffice Module"){
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr" data-theme="theme-default" data-assets-path="<?php echo ROOT ?>adminassets/" data-template="vertical-menu-template" data-style="light">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title><?php echo $title?></title>
  <meta name="description" content="Movie Clicks" />
  <meta name="keywords" content="Movie Clicks">
  <!-- Canonical SEO -->


  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?php echo ROOT ?>images/ico.jpeg" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;ampdisplay=swap" rel="stylesheet">

  <!-- Icons -->
  <link rel="stylesheet" href="<?php echo ROOT ?>adminassets/fonts/remixicon/remixicon.css" />
  <link rel="stylesheet" href="<?php echo ROOT ?>adminassets/fonts/flag-icons.css" />

  <!-- Menu waves for no-customizer fix -->
  <link rel="stylesheet" href="<?php echo ROOT ?>adminassets/css/node-waves.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="<?php echo ROOT ?>adminassets/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="<?php echo ROOT ?>adminassets/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="<?php echo ROOT ?>adminassets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="<?php echo ROOT ?>adminassets/css/typeahead.css" />

  <!-- Helpers -->
  <script type="text/javascript">
    window.templateName = document.documentElement.getAttribute("data-template");
    var ROOT = "<?php echo ROOT ?>";
  </script>
  <!-- Core JS -->


</head>

<body>

  <!-- Layout wrapper -->
  <?php 
}
  function main_nav()
  {
    global $menuar;
    foreach ($menuar as $menu) {
      if ($menu["mm_display"] == 1) {
        $mainMenu[$menu["mm_id"]] = array("url" => $menu["mm_url"], "title" => $menu["mm_title"], "icon" => $menu["mm_icon"], "classname" => $menu["classname"]);
        if ($menu["md_menu"] == 1) {
          $subMenu[$menu["mm_id"]][] = array("url" => $menu["md_url"], "title" => $menu["md_titile"], "icon" => $menu["md_icon"]);
        }
      }
    } ?>
    <div class="layout-wrapper layout-content-navbar  ">
      <div class="layout-container">
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" style="box-shadow: 0 .25rem .875rem 0 rgba(38,43,67,.16);">
          <div class="app-brand demo " style="padding-left: 44px;">
            <a href="<?php echo ROOT ?>" class="app-brand-link">
              <span class="app-brand-logo demo">
                <span style="color:var(--bs-primary);">
                  <img src="<?php echo ROOT ?>images/logo-bk.png" alt style="width: 11%;">
                </span>
              </span>
              <!-- <span class="app-brand-text demo menu-text fw-semibold ms-2">Movieclicks</span> -->
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z" fill-opacity="0.9" />
                <path d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z" fill-opacity="0.4" />
              </svg>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            
              <!-- Apps & Pages -->
            <li class="menu-header mt-5 mb-3">
              <span class="menu-header-text" >MAIN NAVIGATION</span>
            </li>

            <?php foreach ($mainMenu as $mindex => $main) { ?>

              <li class="menu-item">
                <a href="<?php echo $main["url"] ? ADMINROOT . $main["url"] : '#'; ?>" class="menu-link <?php echo $subMenu[$mindex] ? 'menu-toggle' : ''; ?>">
                  <i class="menu-icon tf-icons <?php echo $main["icon"] ?>"></i>
                  <div><?php echo $main["title"]; ?></div>
                </a>
                <?php echo $subMenu[$mindex] ? "<ul class='menu-sub'>" : " ";
                foreach ($subMenu[$mindex] as $sub) { ?>
              <li class="menu-item"><a href="<?php echo ADMINROOT . $sub["url"] ?>" class="menu-link">
                  <div><?php echo $sub["title"] ?></div>
                </a></li>
            <?php }
                echo $subMenu[$mindex] ? "</ul>" : ""
            ?>
            </li>
          <?php } ?>

          </ul>

        </aside>
        <!-- / Menu -->
        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0   d-xl-none ">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="ri-menu-fill ri-22px"></i>
              </a>
            </div>
            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <!-- <div class="navbar-nav align-items-center">
                            <div class="nav-item navbar-search-wrapper mb-0">
                                <a class="nav-item nav-link search-toggler fw-normal px-0" href="javascript:void(0);">
                                    <i class="ri-search-line ri-22px scaleX-n1-rtl me-3"></i>
                                    <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                                </a>
                            </div>
                        </div> -->
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Notification -->
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-4 me-xl-1">
                  <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <i class="ri-notification-2-line ri-22px"></i>
                    <span class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end py-0">
                    <li class="dropdown-menu-header border-bottom py-50">
                      <div class="dropdown-header d-flex align-items-center py-2">
                        <h6 class="mb-0 me-auto">Notification</h6>
                        <div class="d-flex align-items-center">
                          <span class="badge rounded-pill bg-label-primary fs-xsmall me-2">2 New</span>
                          <a href="javascript:void(0)" class="btn btn-text-secondary rounded-pill btn-icon dropdown-notifications-all" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i class="ri-mail-open-line text-heading ri-20px"></i></a>
                        </div>
                      </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container">
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <img src="<?php echo ROOT ?>adminassets/img/avatars/1.png" alt class="rounded-circle">
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="small mb-1">Congratulation Lettie 🎉</h6>
                              <small class="mb-1 d-block text-body">Won the monthly best seller gold badge</small>
                              <small class="text-muted">1h ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ri-close-line ri-20px"></span></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-danger">CF</span>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1 small">Charles Franklin</h6>
                              <small class="mb-1 d-block text-body">Accepted your connection</small>
                              <small class="text-muted">12hr ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ri-close-line ri-20px"></span></a>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </li>
                    <li class="border-top">
                      <div class="d-grid p-4">
                        <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                          <small class="align-middle">View all notifications</small>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
                <!--/ Notification -->

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="<?php echo ROOT ?>adminassets/img/avatars/1.png" alt class="rounded-circle">
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="pages-account-settings-account.html">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-2">
                            <div class="avatar avatar-online">
                              <img src="<?php echo ROOT ?>adminassets/img/avatars/1.png" alt class="rounded-circle">
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-medium d-block small"><?php echo $_SESSION["USER"] ?></span>
                            <small class="text-muted"><?php echo ($_SESSION["UTYPE"] == 1) ? "Super Admin" : ($_SESSION["UTYPE"] == 2 ? "Admin" : "User"); ?></small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="<?php echo ADMINROOT ?>">
                        <i class="ri-user-3-line ri-22px me-3"></i><span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <div class="d-grid px-4 pt-2 pb-1">
                        <a class="btn btn-sm btn-danger d-flex" href="<?php echo ADMINROOT ?>logout" target="_blank">
                          <small class="align-middle">Logout</small>
                          <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->
        <?php } ?>

        <!-- Content wrapper -->

                  <!-- Content comes here -->

        <!-- Content wrapper ends -->
        <?php
        function footer()
        {
        ?>
          <!-- Footer -->
          <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">
              <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                <div class="text-body mb-2 mb-md-0">
                  Copyright © 2025-2026 Odaz Sports. All rights reserved.
                </div>
                <div class="d-none d-lg-inline-block">

                  <a href="#" target="_blank" class="footer-link d-none d-sm-inline-block">Version 2.3.2</a>

                </div>
              </div>
            </div>
          </footer>
          <!-- / Footer -->
          <div class="content-backdrop fade"></div>
        </div>
      </div>
      <!-- / Layout page -->
    </div>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!--/ Delete Confirm Modal -->

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-simple modal-dialog-centered">
        <div class="modal-content text-center">
          <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>

          <div class="modal-body p-3">
            <div class="mb-3">
              <i class="ri-error-warning-line" style="color: #ffcc00; font-size: 4rem;"></i>
            </div>

            <h4 class="mb-2">Are you sure?</h4>
            <p class="mb-3">You won't be able to revert <span id="delType"></span> !</p>
            <p class="mb-3 text-danger" id="delErr"></p>

            <div class="d-flex justify-content-center gap-3">
              <button type="button" class="btn btn-danger" id="btnDelete">Yes, Delete It!</button>
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Delete Confirm Modal Ends -->

    <!-- Core JS -->

  <?php }
  function scripts()
  {
  ?>
<script src="<?php echo ROOT ?>adminassets/js/config.js"></script>
<script src="<?php echo ROOT ?>adminassets/js/jquery.js"></script>
    <script src="<?php echo ROOT ?>adminassets/js/popper.js"></script>
    <script src="<?php echo ROOT ?>adminassets/js/bootstrap.js"></script>
    <script src="<?php echo ROOT ?>adminassets/js/common.js"></script>
    <!-- Vendors JS -->
    <script src="<?php echo ROOT ?>adminassets/js/helpers.js"></script>
    <script src="<?php echo ROOT ?>adminassets/js/template-customizer.js"></script>
    <script src="<?php echo ROOT ?>adminassets/js/node-waves.js"></script>
    <!-- <script src="<?php echo ROOT ?>adminassets/js/i18n.js"></script> -->
    <script src="<?php echo ROOT ?>adminassets/js/menu.js"></script>
    <!-- Vendors JS -->
    <script src="<?php echo ROOT ?>adminassets/js/typeahead.js"></script>
    <script src="<?php echo ROOT ?>adminassets/js/hammer.js"></script>
    <!-- Main JS -->
    <script src="<?php echo ROOT ?>adminassets/js/main.js"></script>
    <script>
    urlnow=location.href;
    // console.log(urlnow);
    $(".menu-link").each(function(key,atg){
      mylink=$(this).attr("href");
      if(urlnow.indexOf(mylink)!=-1){
        prtLi=$(this).closest(".menu-item");
        $(prtLi).addClass("active");
        // console.log(prtLi);
        // console.log(prtLi.closest("ul .menu-item"))
        $(prtLi).closest("ul").closest(".menu-item").addClass("open active");
      }
      
    });
  </script>
  <?php } ?>

  
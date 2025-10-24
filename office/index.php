
  <?php
  include("../includes/config.php");
  if($_SESSION["LOGGED"])
  {

  header("location:".ADMINROOT."dashboard");

  }
  $msg="";
  if(isset($_POST["btnLogin"]))
  {
  include("../includes/MysqliDb.php");
    $uname=$_POST["txtUname"];
    $pwd=md5($_POST["txtPwd"]);
    $loginobj=new MysqliDb(HOST,USER,PWD,DB);
    $loginobj->where("u_email",$uname);
    $loginobj->where("u_pwd",$pwd);
    $loginobj->where("u_status",0);
    $logarray=$loginobj->getOne("mv_user","u_id,u_name,u_type");
    if($loginobj->count>0)
    {
      $_SESSION["LOGGED"]=$logarray["u_id"];
      $_SESSION["USER"]=$logarray["u_name"];
    $_SESSION["UTYPE"]=$logarray["u_type"];
     header("location:".ADMINROOT."dashboard");

    }
    else
    {
      $msg="<div class='alert alert-danger alert-dismissible' role='alert'>
                  Please Check Your Credentials !
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
                  </button>
                  </div>";
    }

  }
  ?>
  <!DOCTYPE html>
  <html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr" data-theme="theme-default" data-assets-path="<?php echo ROOT ?>adminassets/" data-template="vertical-menu-template" data-style="light">

  <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
      <title>Odaz Sports</title>
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

      <!-- Helpers -->
      <script type="text/javascript">
          window.templateName = document.documentElement.getAttribute("data-template")
      </script>
    

  </head>

  <body>
  <!-- Content -->

  <div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
      <div class="authentication-inner py-6">

        <!-- Login -->
          <div class="card p-md-7 p-1"  style="position: absolute; top: 23rem; left: 50%; transform: translate(-50%, -50%);">

          <!-- Logo -->
         <div class="app-brand justify-content-center mt-5">
  <a class="app-brand-link gap-2">
    <span class="app-brand-logo demo">
      <img src="<?php echo ROOT ?>images/logo-bk.png" alt
           style="max-width: 150px; height: auto; display: block; margin: 0 auto;">
    </span>
  </a>
</div>
          <!-- /Logo -->

          <div class="card-body mt-1">
            <p class="mb-5">Please sign-in to your account and start the session</p>

            <form id="" class="mb-5"  method="POST">
              <div class="form-floating form-floating-outline mb-5">
                <input type="text" class="form-control" id="email" name="txtUname" placeholder="Enter your email or username" autofocus>
                <label for="email">Email or Username</label>
              </div>
              <div class="mb-5">
                <div class="form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input type="password" id="password" class="form-control" name="txtPwd" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                      <label for="password">Password</label>
                    </div>
                    <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                  </div>
                </div>
              </div>
            
              <div class="mb-5">
                <button class="btn btn-red d-grid w-100" type="submit" name="btnLogin">Sign in</button>
              </div>
              <?php echo $msg ;?>
              
            </form>

          </div>
        </div>
        <!-- /Login -->
        <!-- <img alt="mask" src="../../adminassets/img/illustrations/auth-basic-login-mask-light.png" class="authentication-image d-none d-lg-block" data-app-light-img="illustrations/auth-basic-login-mask-light.png" data-app-dark-img="illustrations/auth-basic-login-mask-dark.html" /> -->
      </div>
    </div>
  </div>

  <!-- / Content -->


  <!-- Main JS -->
  <script src="<?php echo ROOT ?>adminassets/js/helpers.js"></script>

  <script src="<?php echo ROOT ?>adminassets/js/jquery.js"></script>
      <script src="<?php echo ROOT ?>adminassets/js/popper.js"></script>
      <script src="<?php echo ROOT ?>adminassets/js/bootstrap.js"></script>
      <script src="<?php echo ROOT ?>adminassets/js/common.js"></script>
  <script src="<?php echo ROOT ?>adminassets/js/main.js"></script>

    
  </body>
  </html>
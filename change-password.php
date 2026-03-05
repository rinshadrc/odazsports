<?php
include("template.php");
head("Change Password", 0);

?>

<!-- page-title -->
<div class="tf-page-title"
    style="background-color: #fbae16;background-image: url('<?php echo ROOT ?>images/bg.png');background-size: cover;background-repeat: no-repeat;">
    <div class="container-full">
        <div class="heading text-center">Change Password</div>
    </div>
</div>
<!-- /page-title -->
<section class="flat-spacing-11">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="wrap-sidebar-account">
                            <ul class="my-account-nav">
                                <li><a href="<?php echo ROOT ?>profile" class="my-account-nav-item ">Orders</a></li>
                                <li><a href="<?php echo ROOT ?>account-details" class="my-account-nav-item ">Account Details</a></li>
                                <li><a href="<?php echo ROOT ?>change-password" class="my-account-nav-item active">Change Password</a></li>
                                <li><a href="<?php echo ROOT ?>logout" class="my-account-nav-item">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="my-account-content account-edit">
                            <div class="">
                                    <form class="" id="frmchangepwd">
                                        <input type="hidden" name="action" value="changePwd">
                                   <div class="row"> <div class="col-md-6"> 
                                    <div class="tf-field style-1 mb_30">
                                        <input class="tf-field-input tf-input" placeholder=" " type="password"
                                           name="newpwd" id="newpwd">
                                        <label class="tf-field-label fw-4 text_black-2" for="property5">New
                                            password</label>
                                    </div> </div><div class="col-md-6"> 
                                    <div class="tf-field style-1 mb_30">
                                        <input class="tf-field-input tf-input" placeholder=" " type="password"
                                           name="repwd" id="repwd">
                                        <label class="tf-field-label fw-4 text_black-2" for="property6">Confirm
                                            password</label>
                                    </div>
                                    
                                    </div> </div>
                                    
                                    
                                    
                                    
                                    <div class="mb_20">
                                        <button type="submit"
                                            class="tf-btn w-100 radius-3 btn-fill animate-hover-btn justify-content-center" id="btnpwd">Save
                                            Changes</button>
                                    </div>
                                </form>
                                    <div class="mt-4" id="pwdNot"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- page-cart -->

        <div class="btn-sidebar-account">
            <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount" aria-controls="offcanvas"><i
                    class="icon icon-sidebar-2"></i></button>
        </div>
   <div class="btn-sidebar-account">
            <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount" aria-controls="offcanvas"><i
                    class="icon icon-sidebar-2"></i></button>
        </div>
        <!-- sidebar account-->
    <div class="offcanvas offcanvas-start canvas-filter canvas-sidebar canvas-sidebar-account" id="mbAccount">
        <div class="canvas-wrapper">
            <header class="canvas-header">
                <span class="title">SIDEBAR ACCOUNT</span>
                <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
            </header>
            <div class="canvas-body sidebar-mobile-append">

            </div>

        </div>
    </div>
    <!-- End sidebar account -->
<?php footer(); ?>
</div>

<?php scripts(); ?>
<script>
     /*CHANGE PASSWORD*/
    jQuery(document).on("submit", "#frmchangepwd", function(evt) {
        evt.preventDefault();
        $('#frmchangepwd is-invalid').removeClass('is-invalid');
        pwdvalid = true;
        msg = "";
        if ($("#newpwd").val() == "") {
            $("#newpwd").addClass('is-invalid');
            msg += "Password should not be empty<br>";
            pwdvalid = false;
        }
        if ($("#repwd").val() != $("#newpwd").val()) {
            $("#repwd").addClass('is-invalid');
            msg += "Password and confirm password must be identical<br>";
            pwdvalid = false;
        }
        //console.log(pwdvalid);
        if (pwdvalid) {
            $("#btnPwd").html("Processing..").attr("disabled", "disabled");

            jQuery.ajax({
                url: '<?php echo ROOT ?>ajax/customer-ajax.php',
                type: 'POST',
                data: $("#frmchangepwd").serialize(),
                success: function(response, textStatus, xhr) {
                    //console.log(response);
                    $("#btnPwd").html("Change Password").removeAttr("disabled");
                    try {
                        jresp = $.parseJSON(response);
                        if (jresp.status == "done") {
                            $("<div>").addClass('text-success').html("Password Updated Successfully").appendTo('#pwdNot');
                            location.reload();
                        }
                    } catch (exp) {}
                }
            });
        } else {
            $("<div>").addClass('text-danger').html(msg).appendTo('#pwdNot');
        }
    }); 
</script>

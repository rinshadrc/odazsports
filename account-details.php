<?php
include("template.php");
head("Account Details", 0);
$cusobj = new MysqliDb(HOST, USER, PWD, DB);
$cusobj->where("cust_id", $_SESSION["CUST"]);
$custar = $cusobj->getOne("tbl_customers", "cust_id,cust_name,cust_mobile,cust_email,cust_pwd,postcode,apartment,state,city,address,cust_status");

?>

<!-- page-title -->
<div class="tf-page-title"
    style="background-color: #fbae16;background-image: url('<?php echo ROOT ?>images/bg.png');background-size: cover;background-repeat: no-repeat;">
    <div class="container-full">
        <div class="heading text-center">Account Details</div>
    </div>
</div>
<!-- /page-title -->
<section class="flat-spacing-11">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="wrap-sidebar-account">
                            <ul class="my-account-nav">
                                <li><a href="<?php echo ROOT ?>profile" class="my-account-nav-item">Orders</a></li>
                                <li><a href="<?php echo ROOT ?>account-details" class="my-account-nav-item active">Account Details</a></li>
                                <li><a href="<?php echo ROOT ?>change-password" class="my-account-nav-item">Change Password</a></li>
                                <li><a href="<?php echo ROOT ?>logout" class="my-account-nav-item">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="my-account-content account-edit">
                            <div >
                                <form class="" id="frmeditprofile">
                                    <input type="hidden" name="action" value="updateCustomer">
                                    
                                    <div class="row"> 
                                    
                                    <div class="col-md-6"> <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" name="name" value="<?php echo $custar["cust_name"]?>">
                                        <label class="tf-field-label fw-4 text_black-2" for="property1">First name</label>
                                    </div> </div> <div class="col-md-6"> <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" value="<?php echo $custar["cust_mobile"]?>" name="phone">
                                        <label class="tf-field-label fw-4 text_black-2" for="property2">Mobile</label>
                                    </div> </div> 
                                    
                                    
                                    
                                    <div class="col-md-6">  <div class="box row" style="padding-bottom: 15px;">
                            <fieldset class="box fieldset col-md-12">
                                <!-- <label for="state">Emirates</label> -->
                                <div class="select-custom">
                                    <select class="tf-select w-100" id="state" name="state">
    <option value="Abu Dhabi" <?= ($custar["state"] == "Abu Dhabi") ? "selected" : "" ?>>Abu Dhabi</option>
    <option value="Ajman" <?= ($custar["state"] == "Ajman") ? "selected" : "" ?>>Ajman</option>
    <option value="Dubai" <?= ($custar["state"] == "Dubai") ? "selected" : "" ?>>Dubai</option>
    <option value="Fujairah" <?= ($custar["state"] == "Fujairah") ? "selected" : "" ?>>Fujairah</option>
    <option value="Ras al-Khaimah" <?= ($custar["state"] == "Ras al-Khaimah") ? "selected" : "" ?>>Ras al-Khaimah</option>
    <option value="Umm al-Quwain" <?= ($custar["state"] == "Umm al-Quwain") ? "selected" : "" ?>>Umm al-Quwain</option>
</select>
                                </div>
                            </fieldset>
                             </div></div>
                                    
                                    <div class="col-md-6">  <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" value="<?php echo $custar["city"]?>" name="city">
                                        <label class="tf-field-label fw-4 text_black-2" for="property2">Town/City</label>
                                    </div></div>
                                    
                                    
                                    <div class="col-md-6"> <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" value="<?php echo $custar["apartment"]?>" name="apartment">
                                        <label class="tf-field-label fw-4 text_black-2" for="property2">Apartment</label>
                                    </div> </div> 
                                    
                                    
                                    
                                    <div class="col-md-6"> <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="email"value="<?php echo $custar["cust_email"]?>" name="email">
                                        <label class="tf-field-label fw-4 text_black-2" for="property3">Email</label>
                                    </div>    </div> 
                                    
                                    
                                    <div class="col-md-12"> <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" value="<?php echo $custar["address"]?>" name="address">
                                        <label class="tf-field-label fw-4 text_black-2" for="property2">Address</label>
                                    </div> </div>
                                    
                                    </div>
                                   
                                   
                               
                                   
                                   
                                   
                                      
                                   
                                    <div class="mb_20">
                                        <button type="submit" class="tf-btn w-100 radius-3 btn-fill animate-hover-btn justify-content-center" id="btnsubmit">Save Changes</button>
                                    </div>
                                </form>
                                    <div class="mt-4" id="profNot"></div>

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
    jQuery(document).on("submit", "#frmeditprofile", function(evt) {
        evt.preventDefault();
        $('#frmeditprofile is-invalid').removeClass('is-invalid');
            $("#btnsubmit").html("Processing..").attr("disabled", "disabled");
            jQuery.ajax({
                url: '<?php echo ROOT ?>ajax/customer-ajax.php',
                type: 'POST',
                data: $("#frmeditprofile").serialize(),
                success: function(response, textStatus, xhr) {
                    $("#btnsubmit").html("Update").removeAttr("disabled");
                    try {
                        jresp = $.parseJSON(response);
                        if (jresp.status == "done") {
                            $("<div>").addClass('text-success').html("Profile Updated Successfully").appendTo('#profNot');
                            location.reload();
                        }else{
                            $("<div>").addClass('text-danger').html("Something went wrong").appendTo('#profNot');

                        }
                        
                    } catch (exp) {
                        $("<div>").addClass('text-danger').html("Something went wrong, Please try again").appendTo('#profNot');
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                }
            }); 
       
    });
   
</script>

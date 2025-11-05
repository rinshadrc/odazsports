<?php
include("template.php");
head("Contact Us", 0);

?>

        <!-- page-title -->
        <div class="tf-page-title"
            style="background-color: #fbae16;background-image: url('<?php echo ROOT?>images/bg.png');background-size: cover;background-repeat: no-repeat;">
            <div class="container-full">
                <div class="heading text-center">Contact Us</div>
                <p class="text-center text-2 text_black-2 mt_5">Lorem Ipsum is simply dummy text of the printing and
                    typesetting industry. </p>
            </div>
        </div>
        <!-- /page-title -->
<section class="flat-spacing-21">
            <div class="container">
                <div class="tf-grid-layout gap30 lg-col-2">
                    <div class="tf-content-left">
                        <h5 class="mb_20">Visit Our Store</h5>
                        <div class="mb_20">
                            <p class="mb_15"><strong>Address</strong></p>
                            <p>Lorem Ipsum is simply dummy text of the printing and</p>
                        </div>
                        <div class="mb_20">
                            <p class="mb_15"><strong>Phone</strong></p>
                            <p>91 91454 52364</p>
                        </div>
                        <div class="mb_20">
                            <p class="mb_15"><strong>Email</strong></p>
                            <p>info@odazsports.com</p>
                        </div>
                        <div class="mb_36">
                            <p class="mb_15"><strong>Open Time</strong></p>
                            <p class="mb_15">Our store has re-opened for shopping, </p>
                            <p>exchange Every day 11am to 7pm</p>
                        </div>
                        <div>
                            <ul class="tf-social-icon d-flex gap-20 style-default">
                                <li><a href="#" class="box-icon link round social-facebook border-line-black"><i class="icon fs-14 icon-fb"></i></a></li>
                                <li><a href="#" class="box-icon link round social-twiter border-line-black"><i class="icon fs-12 icon-Icon-x"></i></a></li>
                                <li><a href="#" class="box-icon link round social-instagram border-line-black"><i class="icon fs-14 icon-instagram"></i></a></li>
                                <li><a href="#" class="box-icon link round social-tiktok border-line-black"><i class="icon fs-14 icon-tiktok"></i></a></li>
                                <li><a href="#" class="box-icon link round social-pinterest border-line-black"><i class="icon fs-14 icon-pinterest-1"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tf-content-right">
                        <h5 class="mb_20">Get in Touch</h5>
                        <p class="mb_24">If you’ve got great products your making or looking to work with us then drop
                            us a line.</p>
                        <div>
                            <form class="form-contact" id="contactform" action="https://themesflat.co/html/ecomus/contact/contact-process.php" method="post" novalidate="novalidate">
                                <div class="d-flex gap-15 mb_15">
                                    <fieldset class="w-100">
                                        <input type="text" name="name" id="name" required="" placeholder="Name *">
                                    </fieldset>
                                    <fieldset class="w-100">
                                        <input type="email" name="email" id="email" required="" placeholder="Email *">
                                    </fieldset>
                                </div>
                                <div class="mb_15">
                                    <textarea placeholder="Message" name="message" id="message" required="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="send-wrap">
                                    <button type="submit" class="tf-btn w-100 radius-3 btn-fill animate-hover-btn justify-content-center">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <div></div></section>
<?php footer();?>
</div>

<?php scripts();?>


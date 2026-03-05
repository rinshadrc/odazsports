<?php
include("template.php");
head("Payment Failed", 0);

?>

        <!-- page-title -->
        <div class="tf-page-title"
            style="background-color: #fbae16;background-image: url('<?php echo ROOT?>images/bg.png');background-size: cover;background-repeat: no-repeat;padding-bottom: 130px;
  padding-top: 130px;">
            <div class="container-full">
                <div class="heading text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M0 0h24v24H0V0z" fill="none"></path>
                                    <path d="M15.32 3H8.68c-.26 0-.52.11-.7.29L3.29 7.98c-.18.18-.29.44-.29.7v6.63c0 .27.11.52.29.71l4.68 4.68c.19.19.45.3.71.3h6.63c.27 0 .52-.11.71-.29l4.68-4.68c.19-.19.29-.44.29-.71V8.68c0-.27-.11-.52-.29-.71l-4.68-4.68c-.18-.18-.44-.29-.7-.29zM12 17.3c-.72 0-1.3-.58-1.3-1.3s.58-1.3 1.3-1.3 1.3.58 1.3 1.3-.58 1.3-1.3 1.3zm0-4.3c-.55 0-1-.45-1-1V8c0-.55.45-1 1-1s1 .45 1 1v4c0 .55-.45 1-1 1z">
                                    </path>
                                </svg>
                                </div>
                <div class="heading text-center">Payment Failed</div>
                <p class="text-center text-2 text_black-2 mt_5">Your payment couldn’t be processed—please try again or use another method. </p>
            </div>
        </div>
        <!-- /page-title -->

<?php footer();?>
</div>

<?php scripts();?>


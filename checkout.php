
<?php
include("template.php");
head("Checkout Page", 0);
$cusobj = new MysqliDb(HOST, USER, PWD, DB);
$cusobj->where("cust_id", $_SESSION["CUST"]);
$custar = $cusobj->getOne("tbl_customers", "cust_id,cust_name,cust_mobile,cust_email,cust_pwd,postcode,apartment,state,city,address,cust_status");

?>

    <!-- page-title -->
    <div class="tf-page-title" style="background-color: #fbae16;background-image: url('images/bg.png');background-size: cover;background-repeat: no-repeat;">
        <div class="container-full">
            <div class="heading text-center">Check Out</div>
            <!-- <p class="text-center text-2 text_black-2 mt_5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p> -->
        </div>
    </div>
    <!-- /page-title -->

        <!-- page-cart -->
        <section class="flat-spacing-11">
            <div class="container">
                <div class="tf-page-cart-wrap layout-2">
                    <div class="tf-page-cart-item">
                        <h5 class="fw-5 mb_20">Billing details</h5>
                        <form id="formProceed">
                                <input type="hidden" name="action" value="proceedPayment">
                            <div class="box grid-2">
                                <fieldset class="fieldset">
                                    <label for="first-name">First Name</label>
                                    <input type="text" id="first-name" placeholder="" name="fname" class="required" value="<?php echo $custar["cust_name"]?>">
                                </fieldset>
                                <fieldset class="fieldset">
                                    <label for="last-name">Last Name</label>
                                    <input type="text" id="last-name" name="lname" class="">
                                </fieldset>
                            </div>
                            
                            <fieldset class="box fieldset">
                                <label for="country">Country/Region</label>
                                <div class="select-custom">
                                    <select class="tf-select w-100" id="country" name="state" data-default="">
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                    </select>
                                </div>
                            </fieldset>
                            <fieldset class="box fieldset">
                                <label for="city">Town/City</label>
                                <input type="text" id="city" name="city" class="required" value="<?php echo $custar["city"]?>">
                            </fieldset>
                             <fieldset class="box fieldset">
                                <label for="apartment">Apartment</label>
                                <input type="text" id="apartment" name="apartment" class="required" value="<?php echo $custar["apartment"]?>">
                            </fieldset>
                            <fieldset class="box fieldset">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" class="required" value="<?php echo $custar["address"]?>">
                            </fieldset>
                            <fieldset class="box fieldset">
                                <label for="phone">Phone Number</label>
                                <input type="number" id="txtMobile" name="mobile" class="required numeric" value="<?php echo $custar["cust_mobile"]?>">
                            </fieldset>
                            <fieldset class="box fieldset">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="required" value="<?php echo $custar["cust_email"]?>">
                            </fieldset>
                            <!-- <fieldset class="box fieldset">
                                <label for="note">Order notes (optional)</label>
                                <textarea name="note" id="note" name="notes"></textarea>
                            </fieldset> -->
                    </div>
                    <div class="tf-page-cart-footer">
                        <div class="tf-cart-footer-inner">
                            <h5 class="fw-5 mb_20">Your order</h5>
                            <div class="tf-page-cart-checkout widget-wrap-checkout">
                                <ul class="wrap-checkout-product" id="cartContainer">
                                  
                                </ul>
                                <div class="coupon-box">
                                    <input type="text" placeholder="Discount code">
                                    <a href="#"
                                        class="tf-btn btn-sm radius-3 btn-fill btn-icon animate-hover-btn">Apply</a>
                                </div>
                                <div class="d-flex justify-content-between line pb_20">
                                    <h6 class="fw-5">Total</h6>
                                    <h6 class="total fw-5" id="grandTotal"></h6>
                                </div>
                                <div class="wd-check-payment">
                                    <div class="fieldset-radio mb_20">
                                        <input type="radio" name="payment" id="bank" class="tf-check" checked>
                                        <label for="bank">Direct bank transfer</label>

                                    </div>
                                    <!-- <div class="fieldset-radio mb_20">
                                        <input type="radio" name="payment" id="delivery" class="tf-check">
                                        <label for="delivery">Cash on delivery</label>
                                    </div> -->
                                    <p class="text_black-2 mb_20">Your personal data will be used to process your order,
                                        support your experience throughout this website, and for other purposes
                                        described in our <a href="<?php echo ROOT ?>privacy-policy"
                                            class="text-decoration-underline">privacy policy</a>.</p>
                                    <div class="box-checkbox fieldset-radio mb_20">
                                        <input type="checkbox" id="check-agree" class="tf-check">
                                        <label for="check-agree" class="text_black-2">I have read and agree to the website <a href="<?php echo ROOT ?>terms" class="text-decoration-underline">terms and conditions</a>.</label>
                                    </div>
                                </div>
                                <button type="submit" id="btnproceed" class="tf-btn radius-3 btn-fill btn-icon animate-hover-btn justify-content-center">Place order</button>
                                <p id="errMsg" class="m-3 text-danger"></p>
                        </form>
                        <!-- <div id="buttonPaymentListContainer"></div> -->

                    </div>
                </div>
            </div>
        </section>
        <!-- page-cart -->

<div class="modal fade" id="paymentModal"
     tabindex="-1"
     data-bs-backdrop="static"
     data-bs-keyboard="false">

  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Complete Payment</h5>
        <!-- <button type="button" class="btn-close btnCancelPayment"></button> -->
      </div>

      <div class="modal-body">
        <div id="buttonPaymentListContainer">Processing...</div>
      </div>

      <div class="modal-footer">
        <button type="button"
                class="btn btn-outline-danger" id="btnCancelPayment">
          Cancel Payment
        </button>
      </div>

    </div>
  </div>
</div>


<?php footer();?>
</div>

<?php scripts();?>
<script>
// $(document).ready(function(){
//  $('#paymentModal').modal('show'); 
//   return false 

// });
let products = []; 
let isCart=false;
var master;
if (localStorage.getItem("checkoutProduct")) {
    let parsed = JSON.parse(localStorage.getItem("checkoutProduct"));
    products = Array.isArray(parsed) ? parsed : [parsed];  
} else if (localStorage.getItem("cart")) {
    products = JSON.parse(localStorage.getItem("cart"));
    isCart=true;
}
$("#cartContainer,#grandTotal").html(""); 
subtotal = 0;
shippingfee=0
$.each(products, function (key, p) {
        let rowTotal = p.rate * p.qty;
        subtotal += rowTotal;
        let html = `<li class="checkout-product-item">
                                        <figure class="img-product">
                                            <img src="<?php echo ROOT?>uploads/${p.img}" alt="${p.name}">
                                            <span class="quantity">${p.qty}</span>
                                        </figure>
                                        <div class="content">
                                            <div class="info">
                                                <p class="name">${p.name}</p>
                                                <span class="variant">${p.colorname} / ${p.size}</span>
                                            </div>
                                            <span class="price">AED ${rowTotal}</span>
                                        </div>
                                    </li>`;

        
        $("#cartContainer").append(html);
    });
gtotal=subtotal+shippingfee;
$("#grandTotal").html("AED " + gtotal.toFixed(2)); // final price (already inclusive)

/*SUBMIT TO PAYMENT */
 
    $(document).on("submit", "#formProceed", function(e) {
      e.preventDefault();
      valid = true;
      msg = "";
      $(".is-invalid").removeClass("is-invalid");
      $('#formProceed .required').each(function() {
        if (!$(this).val()) {
          valid = false;
          $(this).addClass('is-invalid');
          msg="Please check all required inputs</br>";
        }
      });
       var filter = /^[0-9]{9}$/;
        if (!filter.test($("#txtMobile").val())) { 
            valid = false;
            msg += "Enter a valid digit mobile number</br>";
        }
      var formValue = new FormData($('#formProceed')[0]);
      formValue.append("products", JSON.stringify(products)); 
      $("#errMsg").html("");
      if (valid) {
        $("#errMsg").html("");
        $("#btnproceed").prop("disabled", true).html("Processing...");

        $.ajax({
          type: 'POST',
          data: formValue,
          contentType: false,
          processData: false,
          cache: false,
          url: '<?php echo ROOT ?>ajax/sale-ajax.php',
          success: function(data) {
            try {
              jsnresp = $.parseJSON(data);
              if (jsnresp.status == 'done') {

              master=jsnresp.master;
              const captureContext = jsnresp.token;
              launchCheckout(captureContext);
              }else{
                $("#errMsg").html("Something went wrong");
              }
            } catch (exp) {} 
          },
          error: function(a, b, err) {
            console.log(err)
          }
        });
      } else {
        $("#errMsg").html(msg);
      }
    });
async function launchCheckout(captureContext) {
  try {
    const jwt = decodeJwt(captureContext);
    const clientLibrary = jwt.ctx[0].data.clientLibrary;
    const integrity = jwt.ctx[0].data.clientLibraryIntegrity;

    await loadCyberSource(clientLibrary, integrity);

    // ✅ Accept IS async in your SDK
    const accept = await Accept(captureContext);

    // ✅ unifiedPayments exists only after Accept resolves
    const up = await accept.unifiedPayments(true);

    const tt = await up.show({
      containers: {
        paymentSelection: "#buttonPaymentListContainer"
      }
    });
    const result = await up.complete(tt);
    const decoded=decodeJwt(result)
    if (decoded.status === "AUTHORIZED" && decoded.outcome === "AUTHORIZED") {
    confirmBooking(decoded.id);
} else {
       window.location.href = "<?php echo ROOT ?>payment-failed";
}
} catch (err) {
    console.error("Unified Checkout error:", err);
    window.location.href = "<?php echo ROOT ?>payment-failed";
  }
}

function decodeJwt(token) {
  const payload = token.split('.')[1];
  const base64 = payload.replace(/-/g, '+').replace(/_/g, '/');
  return JSON.parse(atob(base64));
}
function loadCyberSource(clientLibrary, integrity) {
  if (document.querySelector(`script[src="${clientLibrary}"]`)) {
    $('#paymentModal').modal('show');
    return Promise.resolve();
  }

  $('#paymentModal').modal('show');

  return new Promise((resolve, reject) => {
    const script = document.createElement("script");
    script.src = clientLibrary;
    script.integrity = integrity;
    script.crossOrigin = "anonymous";
    script.onload = resolve;
    script.onerror = reject;
    document.head.appendChild(script);
  });
}


 function confirmBooking(paymentId) {
  jQuery.ajax({
    url: '<?php echo ROOT ?>ajax/sale-ajax.php',
    type: 'POST',
    data: {
      action: 'confirmPayment',
      master: master,
      paymentId:paymentId
    },
    success: function (data) {
      try {
        const jsresp = JSON.parse(data);
 
        if (jsresp.status === "done") {

          if (isCart) {
            localStorage.removeItem("cart");
          }
          localStorage.removeItem("checkoutProduct");

          window.location.href = "<?php echo ROOT ?>payment-success";

        } else {
          window.location.href = "<?php echo ROOT ?>payment-failed";
        }
      } catch (e) {
        window.location.href = "<?php echo ROOT ?>payment-failed";
      }
    },
    error: function () {
      window.location.href = "<?php echo ROOT ?>payment-failed";
    }
  });
}

$("#btnCancelPayment").on("click", function () {
    window.location.href = "<?php echo ROOT ?>payment-failed";

});

  


/*SUBMIT TO PAYMENT ENDS*/
</script>
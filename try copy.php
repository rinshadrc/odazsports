<script>

     function decodeJwt(token) {
  const payload = token.split(".")[1];
  const base64 = payload.replace(/-/g, "+").replace(/_/g, "/");
  return JSON.parse(atob(base64));
}
function loadCyberSource(clientLibrary, integrity) {
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
async function launchCheckout(captureContext) {
  try {
    const jwt = decodeJwt(captureContext);

    await loadCyberSource(
      jwt.data.clientLibrary,
      jwt.data.clientLibraryIntegrity
    );

    const sidebar = true;

    const showArgs = {
      containers: {
        paymentSelection: "#buttonPaymentListContainer"
      }
    };

    const accept = await Accept(captureContext);
    const up = await accept.unifiedPayments(sidebar);

    const transientToken = await up.show(showArgs);
    const completeResponse = await up.complete(transientToken);

    console.log("Complete response:", completeResponse);

    // Send transientToken to server
    sendTokenToServer(transientToken);

  } catch (error) {
    console.error("Unified Checkout error:", error);
    $("#errMsg").html("Payment failed to initialize");
  }
}

</script>

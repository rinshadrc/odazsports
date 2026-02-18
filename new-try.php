<?php
$url = "https://apitest.cybersource.com/up/v1/capture-contexts";
$post_data = [
    "targetOrigins" => ["https://odazsports.com"],
    "clientVersion" => "0.34",
    "country" => "US",
    "locale" => "en_US",
    "allowedCardNetworks" => ["VISA", "MASTERCARD"],
    "allowedPaymentTypes" => ["CLICKTOPAY"],
    "data" => [
        "orderInformation" => [
            "amountDetails" => [
                "totalAmount" => "13.00",
                "currency" => "USD"
            ]
        ],
        "clientReferenceInformation" => [
            "code" => "ORDER123"
        ]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
}
curl_close($ch);
print_r($response);
// var_dump($response);
?>

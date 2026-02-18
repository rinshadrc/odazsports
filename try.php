<?php

$merchantId = "cybodazllc"; 
$keyId      = "70e6eb0f-ecf2-47b2-8fe8-5c6b5798c5b2";
$secretKey  = "2TMt2Fq233cTUw4kG38n+XLCFsMDgpICRTGwOohNDIY=";

$host = "api.cybersource.com";
// $host = "apitest.cybersource.com";
$url  = "https://$host/up/v1/capture-contexts";
$totalprice=13.5;

/* ---------- REQUEST BODY ---------- */
$payloadArray = [
    "targetOrigins" => ["https://odazsports.com"],
  "clientVersion" => "0.34",
    "buttonType" => "CHECKOUT_AND_CONTINUE",

    "allowedCardNetworks" => ["VISA", "MASTERCARD"],
    "allowedPaymentTypes" => ["PANENTRY", "CLICKTOPAY"],

    "country" => "AE",
    "locale" => "en_AE",
    "data" => [
        "orderInformation" => [
           
        "billTo" => [
            "firstName" => "test",
            "lastName" => "d",
            "email" => "test@gmail.com",
            "phoneNumber" => "987456256",
            "address1" => "d",
            "locality" => "d",
            "buildingNumber"=>"55",
            // "postalCode"=>"45678",
            // "administrativeArea" => "sd",
            "country" => "AE"
        ],


        "shipTo" => [
            "firstName" => "test",
            "lastName" => "g",
            "address1" => "hgh",
            "locality" => "hg",
            // "administrativeArea" => "nbh",
            "country" => "AE",
            "buildingNumber"=>"56",
            // "postalCode"=>"56566"
        ],
         "amountDetails" => [
                "totalAmount" => (string)$totalprice,
                "currency" => "USD"
            ]
        ],
        "clientReferenceInformation" => [
            "code" => "ORDER123"
        ]
    ],
    "completeMandate"=> [
"type"=> "CAPTURE"
]
];

$payload = json_encode($payloadArray, JSON_UNESCAPED_SLASHES);

/* ---------- DATE & DIGEST ---------- */
$date = gmdate("D, d M Y H:i:s") . " GMT";
$digest = base64_encode(hash("sha256", $payload, true));
$digestHeader = "SHA-256=".$digest;

/* ---------- SIGNATURE STRING ---------- */
$requestTarget = "post /up/v1/capture-contexts";

$signatureString =
    "host: $host\n" .
    "date: $date\n" .
    "request-target: $requestTarget\n" .
    "digest: $digestHeader\n" .
    "v-c-merchant-id: $merchantId";

/* ---------- SIGNATURE ---------- */
$signature = base64_encode(
    hash_hmac(
        "sha256",
        $signatureString,
        base64_decode($secretKey),
        true
    )
);

/* ---------- HEADERS ---------- */
$signatureHeader =
    'keyid="'.$keyId.'", algorithm="HmacSHA256", headers="host date request-target digest v-c-merchant-id", signature="'.$signature.'"';

$headers = [
    "Content-Type: application/json",
    "Accept: application/json",
    "Host: $host",
    "Date: $date",
    "Digest: $digestHeader",
    "Signature: $signatureHeader",
    "v-c-merchant-id: $merchantId"
];

/* ---------- CURL ---------- */
$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => true
]);
// echo "<pre>";
// echo "STRING TO SIGN:\n$signatureString\n\n";
// echo "SIGNATURE:\n$signature\n";
// exit;
$response = curl_exec($ch);

if ($response === false) {
    echo "CURL ERROR: " . curl_error($ch);
} else {
    echo $response;
}

curl_close($ch);

<?php
include("../includes/config.php");
include("../includes/MysqliDb.php");
include("../includes/functions.php");
ini_set("display_errors", 0);
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    die("cheating");
}

$action = $_REQUEST['action'];
switch ($action):


        /****  PRODUCT MASTER   ****/
    case 'proceedPayment':
        // ini_set("display_errors",1);
        $db = new MysqliDb(HOST, USER, PWD, DB);
        $products = json_decode($_POST["products"], true);
        $pdtids = array_column($products, "pdid");
        // Fetch product prices from DB
        $db->where("pd_id", $pdtids, "IN");
        $priceData = $db->map("pd_id")->get("tbl_product_detail", null, "pd_id, pd_price");
        $str="1234567890QWERTYUPASDFGHJKZXCVBN";
        for($i=0;$i<=6;$i++)
        {
            $recip.=substr($str,rand(0,31),1);
        }
        $recip="CC".$recip;
        // Insert into order master
        $orderData = [
            "fname"    => $_POST["fname"],
            "lname"    => $_POST["lname"],
            "mobile"   => $_POST["mobile"],
            "postcode" => $_POST["postcode"],
            "address"  => $_POST["address"],
            "city"     => $_POST["city"],
            "landmark" => $_POST["landmark"],
            "state"    => $_POST["state"],
            "om_num"    => $recip,
            "cust_id"  => $_SESSION["CUST"] ?: null,
            "om_status" => -1
        ];
        $orderId = $db->insert("tbl_order_master", $orderData);
        $values = [];
        $totalprice = 0;
        foreach ($products as $p) {
            $dtlarr = ["name"  => $p["name"], "color" => $p["colorname"], "size"  => $p["size"], "image" => $p["img"]];
            $jsndt = json_encode($dtlarr);
            $realPrice = $priceData[$p["pdid"]] ?? 0;
            $totalprice += $realPrice * $p["qty"];
            $values[] = "($orderId,$p[pmid],$p[pdid],$p[sizeid],$p[colorid],$p[qty],$realPrice,'$jsndt',-1)";
        }
        if (!empty($values)) {
            $query = "INSERT INTO tbl_order_detail (om_id, pm_id, pd_id, sz_id, cl_id, qty, price, od_json, od_status) VALUES " . implode(",", $values);
            $db->rawQuery($query);
        }
        if($totalprice <= 499){
            $totalprice += SHIPPING;
        }
        
        $db->where("om_id",$orderId);
        $db->update("tbl_order_master",["om_total"=>$totalprice]);
        try {


$merchantId = "cybodazllc"; 
$keyId      = "70e6eb0f-ecf2-47b2-8fe8-5c6b5798c5b2";
$secretKey  = "2TMt2Fq233cTUw4kG38n+XLCFsMDgpICRTGwOohNDIY=";

$host = "api.cybersource.com";
// $host = "apitest.cybersource.com";
$url  = "https://$host/up/v1/capture-contexts";

/* ---------- REQUEST BODY ---------- */
$payloadArray = [
    "targetOrigins" => ["https://odazsports.com"],
    "clientVersion" => "0.34",
    "buttonType" => "CHECKOUT_AND_CONTINUE",

    "allowedCardNetworks" => ["VISA", "MASTERCARD"],
    "allowedPaymentTypes" => ["PANENTRY", "CLICKTOPAY"],

    "country" => "AE",
    "locale" => "en_AE",


    "completeMandate" => [
        "type" => "CAPTURE"
    ],

    "data" => [
  "orderInformation" => [
     "amountDetails" => [
        "totalAmount" => (string)$totalprice,
        "currency" => "AED"
    ],
    // "billTo" => [
    //     "firstName" => $_POST['fname'],
    //     "lastName" => $_POST['lname'],
    //     "email" => $_POST['email'],
    //     "phoneNumber" => $_POST['mobile'],
    //     "address1" => $_POST['address'],
    //     "locality" => $_POST['city'],
    //     "administrativeArea" => $_POST['state'],
    //     "buildingNumber"=>"56",
    //     "postalCode"=>"56566",
    //     "country" => "AE"
    // ],
    // "shipTo" => [
    //     "firstName" => $_POST['fname'],
    //     "lastName" => $_POST['lname'],
    //     "address1" => $_POST['address'],
    //     "locality" => $_POST['city'],
    //     "administrativeArea" => $_POST['state'],
    //     "buildingNumber"=>"56",
    //     "postalCode"=>"56566",
    //     "country" => "AE"
    // ],
   
  "clientReferenceInformation" => [
            "code" => $recip
        ]
  ]

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

$response = curl_exec($ch);

if ($response === false) {
    $out=Array("status" => "error", "message" => "CURL ERROR: " . curl_error($ch));
} else {
    $out=Array("status" => "done", "token" => $response,"master"=>$orderId);
}

// curl_close($ch);
 } catch (Exception $e) {
            $out=Array("status" => "error", "message" => $e->getMessage());
        }

echo json_encode($out);
break;

case "confirmPayment":

$omid = $_POST["master"];
$db = new MysqliDb(HOST, USER, PWD, DB);

/* Optional safety check */
$db->where("om_id", $omid);
$order = $db->getOne("tbl_order_master");

if (!$order || $order["om_status"] == 0) {
    echo json_encode(["status" => "failed"]);
    break;
}

/* Mark order as PAID */
$db->where("om_id", $omid);
$db->update("tbl_order_master", ["om_status" => 0]);

$db->where("om_id", $omid);
$db->update("tbl_order_detail", ["od_status" => 0]);

echo json_encode(["status" => "done"]);
break;



case "confirmPayment-tets":
    $omid   = $_POST["master"];
    $transientToken  = $_POST["transientToken"];
    $db  = new MysqliDb(HOST, USER, PWD, DB);

    $db->where("om_id", $omid);
    $order = $db->getOne("tbl_order_master", "om_total,om_num");

    $amount = number_format($order["om_total"], 2, ".", "");

    $payloadArray = [
        "clientReferenceInformation" => [
            "code" => $order["om_num"]
        ],
        "processingInformation" => [
            "commerceIndicator" => "internet",
            "capture" => true
        ],
        "tokenInformation" => [
            "transientTokenJwt" => $transientToken
        ],
        "orderInformation" => [
            "amountDetails" => [
                "totalAmount" => $amount,
                "currency" => "AED"
            ]
        ]
    ];

    $payload = json_encode($payloadArray);

$merchantId = "cybodazllc"; 
$keyId      = "70e6eb0f-ecf2-47b2-8fe8-5c6b5798c5b2";
$secretKey  = "2TMt2Fq233cTUw4kG38n+XLCFsMDgpICRTGwOohNDIY=";

 $host     = "apitest.cybersource.com";
    $resource = "/pts/v2/payments";
    $url      = "https://".$host.$resource;
 // 🔹 Create signature headers 
    $date   = gmdate("D, d M Y H:i:s \G\M\T");
    $digest = base64_encode(hash("sha256", $payload, true));

    $signatureString =
        "host: ".$host."\n" .
        "date: ".$date."\n" .
        "request-target: post ".$resource."\n" .
        "digest: SHA-256=".$digest."\n" .
        "v-c-merchant-id: ".$merchantId;

    $signature = base64_encode(
        hash_hmac(
            "sha256",
            $signatureString,
            base64_decode($secretKey),
            true
        )
    );

    // 🔹 CURL request
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_HTTPHEADER     => [
            "Content-Type: application/json",
            "Host: ".$host,
            "Date: ".$date,
            "Digest: SHA-256=".$digest,
            'Signature: keyid="'.$keyId.'", algorithm="HmacSHA256", headers="host date request-target digest v-c-merchant-id", signature="'.$signature.'"',
            "v-c-merchant-id: ".$merchantId
        ]
    ]);

    $response = curl_exec($ch);
    // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // curl_close($ch);

    $resp = json_decode($response, true);

     if (isset($resp["status"]) && in_array($resp["status"], ["AUTHORIZED", "COMPLETED"])) {
           // Update statuses
            $db->where("om_id", $omid);
            $db->update("tbl_order_master", ["om_status" => 0]);
            $db->where("om_id", $omid);
            $db->update("tbl_order_detail", ["od_status" => 0]);

    // Fetch customer mobile & products
    // $db->where("om_id", $omid);
    // $orderMaster = $db->getOne("tbl_order_master", "mobile, om_num");

    // $db->where("om_id", $omid);
    // $orderDetails = $db->get("tbl_order_detail", null, "od_json, qty");

    // Build product list
    // $productList = [];
    // foreach ($orderDetails as $od) {
    //     $json = json_decode($od["od_json"], true);
    //     $pname = $json["name"] ?? "Product";
    //     $qty   = $od["qty"];
    //     $productList[] = $pname . " (" . $qty . ")";
    // }

    // $productsText = implode(", ", $productList);

    // Prepare SMS text
    // $msgtxt = "Dear Customer, your order {$orderMaster['om_num']} has been confirmed.\n\n".
    //           "Products: {$productsText}\n".
    //           "Your order will be delivered within 10 days.\n".
    //           "For queries, contact: +91 9778403774\n\n".
    //           "Thank you for shopping with us!";

    // // Send SMS
    // sendSMS($orderMaster["mobile"], $msgtxt);

    $out = ["status" => "done"];
    }else{
    $out = ["status" => "failed","message"=>$resp];

    }
    echo json_encode($out);
    break;


case "orderDetails":
    $omid=$_POST['omid'];
    $odobj=new MysqliDb(HOST,USER,PWD,DB);
    $odobj->where("om_id",$omid);
    $out["master"]=$odobj->getOne("tbl_order_master","mobile,postcode,address,city,landmark,state,om_status,om_total,om_num");

    $odobj->where("om_id",$omid);
    $orderdtlarr=$odobj->get("tbl_order_detail",null,"qty,(qty*price) as price,od_json,od_status");
    foreach ($orderdtlarr as $dtl) {
        $od_json = json_decode($dtl["od_json"], true); 
        $out["detail"][] = [
            "qty"      => $dtl["qty"],
            "price"    => $dtl["price"],
            "status"   => $dtl["od_status"],
            "name"     => $od_json["name"] ?? "",
            "color"    => $od_json["color"] ?? "",
            "size"     => $od_json["size"] ?? "",
            "image"    => $od_json["image"] ?? ""
        ];
    }
    echo json_encode($out);
break;

case "updateStatus":
    $omid=$_POST['omid'];
    $status=$_POST['status'];
    $odobj=new MysqliDb(HOST,USER,PWD,DB);
    $odobj->where("om_id",$omid);
    $odobj->update("tbl_order_master",Array("om_status"=>$status));

    $odobj->where("om_id",$omid);
    $odobj->update("tbl_order_detail",Array("od_status"=>$status));

    if(!$odobj->getLastError()){
        $out["status"]="done";
    }else{
        $out["status"]="error";
    }
    echo json_encode($out);
break;
endswitch;

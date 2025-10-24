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

        $pgkey = "rzp_test_RFoAGdggYFjrUH";
        $pgpwd = "fLpIDFV58HOZ3oXyXuJXy607";
        $headers = ['Content-Type: application/json'];
        try {
            $rz = curl_init();
            curl_setopt($rz, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($rz, CURLOPT_USERPWD, $pgkey . ":" . $pgpwd);
            curl_setopt($rz, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($rz, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($rz, CURLOPT_URL, "https://api.razorpay.com/v1/orders/");

            $postData = array(
                "amount" => $totalprice * 100,
                "currency" => "INR",
                "receipt" => $recip,
                "payment_capture" => "1"
            );
            curl_setopt($rz, CURLOPT_POSTFIELDS, json_encode($postData));
            $pgresponse = curl_exec($rz);
            // print_r($pgresponse);exit;
            $pgjson=json_decode($pgresponse,1);
            if($pgjson["status"]=="created"){
                $response=Array("status" => "done", "order_id" => $pgjson["id"],"master"=>$orderId,"recip"=>$recip, "total" => $totalprice, "cname" => $_POST["fname"], "cmobile" => $_POST["mobile"]);
            }
            curl_close($rz);
            if (curl_errno($rz)) {
                echo 'cURL error: ' . curl_error($rz);
                exit;
            } else {
            }
        } catch (Exception $e) {
            $response=Array("status" => "error", "message" => $e->getMessage());
        }
        echo json_encode($response);
        break;

case "confirmPayment":
    $omid   = $_POST["master"];
    $omnum  = $_POST["ordernum"];
    $db  = new MysqliDb(HOST, USER, PWD, DB);

    // Update statuses
    $db->where("om_id", $omid);
    $db->update("tbl_order_master", ["om_status" => 0]);
    $db->where("om_id", $omid);
    $db->update("tbl_order_detail", ["od_status" => 0]);

    // Fetch customer mobile & products
    $db->where("om_id", $omid);
    $orderMaster = $db->getOne("tbl_order_master", "mobile, om_num");

    $db->where("om_id", $omid);
    $orderDetails = $db->get("tbl_order_detail", null, "od_json, qty");

    // Build product list
    $productList = [];
    foreach ($orderDetails as $od) {
        $json = json_decode($od["od_json"], true);
        $pname = $json["name"] ?? "Product";
        $qty   = $od["qty"];
        $productList[] = $pname . " (" . $qty . ")";
    }

    $productsText = implode(", ", $productList);

    // Prepare SMS text
    $msgtxt = "Dear Customer, your order {$orderMaster['om_num']} has been confirmed.\n\n".
              "Products: {$productsText}\n".
              "Your order will be delivered within 10 days.\n".
              "For queries, contact: +91 9778403774\n\n".
              "Thank you for shopping with us!";

    // Send SMS
    sendSMS($orderMaster["mobile"], $msgtxt);

    $response = ["status" => "done"];
    echo json_encode($response);
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

<?php
include("../includes/config.php");
include("../includes/MysqliDb.php");
include("../includes/functions.php");
ini_set("display_errors",0);
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		die("cheating");
	}
$action=$_REQUEST['action'];
switch($action):

/****  PRODUCT MASTER   ****/	

case "productDetails":
	
	$pmid=$_POST['id'];

	$variantobj=new MysqliDb(HOST,USER,PWD,DB);
	$variantobj->groupBy("pd.pd_id");
	$variantobj->where("pd.pm_id",$pmid);
	$variantobj->where("pd.pd_status",0);
	$variantobj->join("tbl_colours cl","JSON_CONTAINS(pd.pd_color,cl.cl_id)", "LEFT");
	$variantobj->join("tbl_sizes sc","pd.sz_id=sc.sz_id");
	$pdtdtlarr=$variantobj->get("tbl_product_detail pd",null,"pd.pd_id,pd.pm_id,pd_price,sz_title,pd_strikeprice,pd.sz_id,pd_color,sc.sz_code,GROUP_CONCAT(cl.cl_name) AS clname,GROUP_CONCAT(cl.cl_code SEPARATOR '|') AS clcode");
    foreach ($pdtdtlarr as $pdt) {
    $pdtdtl[$pdt["pd_id"]] = array("pdtid" => $pdt["pd_id"], "clrname" => $pdt["clname"], "clrid" => $pdt["pd_color"], "code" => $pdt["clcode"], "size" => $pdt["sz_id"], "sizename" => $pdt["sz_code"],"sizetitle"=>$pdt["sz_title"], "price" => $pdt["pd_price"]);
}
if(!$variantobj->getLastError()){
	$out["status"]="done";
	$out["variants"]=$pdtdtl;
    }else{
       	$out["status"]="error";

    }
	echo json_encode($out);
	break;

case "getWhishlist":
	
	$wishobj = new MysqliDb(HOST, USER, PWD, DB);
	$wishobj->where("cust_id",$_SESSION["CUST"]);
	$wishobj->where("wl_status", 9, "<>");
	$wishobj->orderBy("wl.wl_id", "DESC");
	$wishobj->groupBy("pm.pm_id");
	$wishobj->join("tbl_product_master pm", "pm.pm_id=wl.pm_id");
	$wishobj->join("tbl_product_detail pd", "pd.pm_id=pm.pm_id","INNER");
	$wishpdtarr = $wishobj->get("tbl_wishlist wl", null, "wl.wl_id,pm.pm_id,pm.pm_name,pm.pm_image,pd.pd_price");
	
	$out["whishlist"]=$wishpdtarr;
	$out["status"]="done";
	echo json_encode($out);
	break;

case "removeWhishlist":

    $wl_id = intval($_POST["id"]);
    $wishobj = new MysqliDb(HOST, USER, PWD, DB);
    $wishobj->where("wl_id", $wl_id);
    $wishobj->where("cust_id", $_SESSION["CUST"]);
    $deleted = $wishobj->delete("tbl_wishlist");
    if ($deleted) {
        $out["status"] = "done";
    } else {
        $out["status"] = "fail";
    }
    echo json_encode($out);
    break;

case "toggleWhishlist":
    if (!isset($_SESSION["CUST"])) {
        echo json_encode(["status" => "not_logged_in"]);
        break;
    }

    $pm_id = intval($_POST["id"]);
    $cust_id = $_SESSION["CUST"];

    $db = new MysqliDb(HOST, USER, PWD, DB);
    $db->where("cust_id", $cust_id);
    $db->where("pm_id", $pm_id);
    $exists = $db->getOne("tbl_wishlist");
    if ($exists) {
        $db->where("cust_id", $cust_id);
        $db->where("pm_id", $pm_id);
        $db->delete("tbl_wishlist");
		$out["status"]="removed";
    } else {
        $data = ["cust_id" => $cust_id,"pm_id" => $pm_id,"wl_status" => 0];
    	$db->insert("tbl_wishlist", $data);
		$out["status"]="added";
    }
	echo json_encode($out);
    break;


endswitch;
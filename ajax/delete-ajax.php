<?php
include("../includes/config.php");
include("../includes/MysqliDb.php");
include("../includes/functions.php");
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		//die("cheating");
	}
$action=$_REQUEST['action'];
switch($action):

/*DELETE EMPLOYEE*/	
case 'delusers':
	// print_r($_POST);exit;
	$delId=$_POST['delid'];
	$delobj=new MysqliDb(HOST,USER,PWD,DB);
	$delobj->where("u_id",$delId);
	$delobj->update("mv_user",Array("u_status"=>9));
	if(!$delobj->getLastError()){
		echo json_encode(Array("status"=>"done"));
	}
	else{
		echo json_encode(Array("status"=>"error"));
	}
		break;
	/*DELETE EMPLOYEE ENDS*/
	
/*DELETE User Type */
case 'delusertype':
	$delId=$_POST['delid'];
	$delobj=new MysqliDb(HOST,USER,PWD,DB);
	$delobj->where('ut_id',$delId);
	$delobj->delete("mv_utype");
	if(!$delobj->getLastError()){
		echo json_encode(Array("status"=>"done"));
	}
	else{
		echo json_encode(Array("status"=>"error"));
	}
	break;
/*DELETE User Type ENDS*/
/*DELETE DISTRIBUTOR*/

case "delcategory":
$delobj=new MysqliDb(HOST,USER,PWD,DB);
$delid=$_POST["delid"];

$sqlarray=Array("ct_status"=>9);
if($delid)
{
$delobj->where("ct_id",$delid); 
$delobj->update("tbl_category",$sqlarray);  
}
echo json_encode(Array("status"=>"done"));
break;	
/*DELETE DISTRIBUTOR*/

/*DELETE ITEMS*/
case 'delsubcategory':
	$delId=$_POST['delid'];
	$delobj=new MysqliDb(HOST,USER,PWD,DB);
	$delobj->where('sct_id',$delId);
	$delobj->update("tbl_sub_category",Array("sct_status"=>9));
	echo json_encode(Array("status"=>"done"));
	break;
/*DELETE ITEMS ENDS*/

/*DELETE products*/
case 'delproducts':
	$delId=$_POST['delid'];	
	$delobj=new MysqliDb(HOST,USER,PWD,DB);
	$delobj->where("pm_id",$delId);
	$delobj->update("tbl_product_detail",Array("pd_status"=>9));

	$delobj->where("pm_id",$delId);
	$delimg=$delobj->get("tbl_images",null,"img_name");

	$delobj->where("pm_id",$delId);
	$delobj->update("tbl_images",Array("img_status"=>9));

	$delobj->where("pm_id",$delId);
	$delobj->update("tbl_product_master",Array("pm_status"=>9));

	foreach($delimg as $del){
		unlink("../uploads/$del");
		unlink("../uploads/medium/$del");
		unlink("../uploads/thumb/$del");
	}

	if(!$delobj->getLastError()){
		echo json_encode(Array("status"=>"done"));
	}
	else{
		echo json_encode(Array("status"=>"error"));
	}
	
	break;
/*DELETE products ENDS*/
/*DELETE product DETAIL*/

case 'delproductdetail':
// print_r($_POST);exit;
$delId=$_POST['delid'];	
$delobj=new MysqliDb(HOST,USER,PWD,DB);
$delobj->where("pd_id",$delId);
$delobj->update("tbl_product_detail",Array("pd_status"=>9));
if(!$delobj->getLastError()){
$out['status']="done";	
}
else{
$out['status']="error";	
}
echo json_encode($out);
break;
/*DELETE product DETAIL ENDS*/

	
endswitch;
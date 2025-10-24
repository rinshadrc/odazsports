<?php
include("../includes/config.php");
include("../includes/MysqliDb.php");
include("../includes/functions.php");
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		die("cheating");
	}
$action=$_REQUEST['action'];
switch($action):
/*CREATE/UPDATE employee*/	
case 'employee':
//print_r($_POST);exit;
ini_set('display_errors',0);
$uid=$_POST["uId"];
$name=$_POST["txtEmpnm"];
$usrtyp=$_POST["selType"];
$phone=$_POST["txtMobile"];
$email=$_POST["txtEmail"];
$addr=$_POST["txtAddr"];

$empobj=new MysqliDb(HOST,USER,PWD,DB);
$emparr=Array("u_name"=>$name,"u_type"=>$usrtyp,"u_email"=>$email,"u_phone"=>$phone,"u_address"=>$addr);
if($uid){
	$empobj->where("u_id",$uid);
	$empobj->update("mv_user",$emparr);
}
else{
	$emparr["u_pwd"]=md5("123456");
	$empobj->insert("mv_user",$emparr);
}
$out["status"]="done";
if($empobj->getLastError()){
	$out["status"]="error";
}
//echo $empobj->getLastError();
//print_r($out);exit;
echo json_encode($out);
break;
/*CREATE/UPDATE employee ENDS*/	
case"changePwd":
		$empIdPwd=$_POST["empIdPwd"];
		$pwd=md5($_POST["txtEmpPwd"]);
		$empobj=new MysqliDb(HOST,USER,PWD,DB);
		$empobj->where("u_id",$empIdPwd);
		$empobj->update("mv_user",Array("u_pwd"=>$pwd));
		echo json_encode(Array("status"=>"done"));
		break;
        /*USER PERMISSION*/
case 'accPrmsn':
    $etype=$_POST['etype'];
    $prntarr=$_POST['chkPrnt'];
    $sbmnuarr=$_POST['chkchld'];
    $delids=$_POST['delids'];
    //print_r($prntarr);
    $out["status"]="done";
    $mastr=Array();
    foreach ($prntarr as $mindex => $menu) {
        if($menu=="NULL"){
        $mastr[]=Array($mindex,NULL,$etype);
        }
    
        foreach ($sbmnuarr[$mindex] as $sbindex => $sub) {
            if($sub=="NULL"){
        $mastr[]=Array($mindex,$sbindex,$etype);		
                
        }
        }
        }
    $menuobj=new MysqliDb(HOST,USER,PWD,DB);
    $ids=$menuobj->insertMulti("mv_upermit",$mastr,Array("mm_id","md_id","u_type"));
    //echo $menuobj->getLastQuery();
    
    if($delids[0]){
    $menuobj->where("up_id",$delids,"IN");
    $menuobj->delete("mv_upermit");}
    if($menuobj->getLastError()){
        $out["status"]="error";
    }
    echo json_encode($out);
        break;

        /*CREATE/UPDATE USER TYPE*/	
case 'userType':
    //print_r($_POST);exit;
    $utid=$_POST["utId"];
    $uname=$_POST["txtUser"];
    $usrobj=new MysqliDb(HOST,USER,PWD,DB);
    $updtarr=Array("ut_name"=>$uname);
    if($utid){
    $usrobj->where("ut_id",$utid);
    $usrobj->update("mv_utype",$updtarr);
    }
    else{
    $usrobj->insert("mv_utype",$updtarr);
    }
    if($usrobj->getLastError()){
    $out["status"]="error";
    }	
    else{
    $out["status"]="done";
    }
    echo json_encode($out);
    
        break;
    /*CREATE/UPDATE USER TYPE ENDS*/
endswitch;
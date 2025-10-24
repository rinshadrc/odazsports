<?php
include("../includes/config.php");
include("../includes/functions.php");
include("../includes/MysqliDb.php");
include("../includes/PHPMailerAutoload.php");
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
	die("cheating");
	}
$action=$_REQUEST['action'];
switch ($action):

case "register": 
$name=$_POST["txtname"];
$mobile=$_POST["txtmobile"];
$pwd=$_POST["txtpwd"];

$regobj=new MysqliDb(HOST,USER,PWD,DB);
$regobj->where("cust_mobile",$mobile,"LIKE");
$loginarray=$regobj->getOne("tbl_customers","cust_email,cust_name,cust_id,cust_mobile");
if($regobj->count >0)
{
$out["msg"]=$loginarray["cust_mobile"]." given mobile number already in use";
$out["status"]="exist";
}
else
{
$regarry=Array("cust_name"=>$name,"cust_mobile"=>$mobile,"cust_pwd"=>$pwd);
$regobj->insert("tbl_customers",$regarry);
if(!$regobj->getLastError()){
$out["status"]="done";
}
}
echo json_encode($out);
break;
case "login":
  // print_r($_POST);exit;
  $usr=$_POST["txtmobile"];
  $pwd=$_POST["txtpwd"];
  $logobj=new MysqliDb(HOST,USER,PWD,DB);
  $logobj->where("cust_pwd",$pwd);
  $logobj->where("cust_mobile",$usr,"LIKE");
  $loginarray=$logobj->getOne("tbl_customers","cust_email,cust_name,cust_id,cust_mobile,cust_pwd");
  // echo $logobj->getLastQuery();exit;
  if($logobj->count >0)
  {
if($loginarray['cust_pwd']==$pwd){
  $_SESSION["CUST"]=  $loginarray["cust_id"];
  $_SESSION["USERNAME"]=  $loginarray["cust_name"];
  $return["status"]="done";
  }
  else{
  $return["status"]="error";
  }
  }
  else{
  $return["status"]="empty";
  }
echo json_encode($return);
break;

case "reset": 
  // print_r($_POST);exit;
  // ini_set("display_errors",1);
$mobile=$_POST["txtmobile"];

$regobj=new MysqliDb(HOST,USER,PWD,DB);
$regobj->where("cust_mobile",$mobile,"LIKE");
$regobj->getOne("tbl_customers","cust_name,cust_id,cust_mobile");

if($regobj->count >0)
{
$str="1234567890asdfghjklzxcvbnmqwertyuiopASDGHJKLZXCVBNMQWERTYUIOP";
  for($i=0;$i<=5;$i++)
  {
    $pwd.=substr($str,rand(0,62),1);
  }

$regarry=Array("cust_pwd"=>$pwd,"cust_status"=>"1");
$regobj->where("cust_mobile",$mobile,"LIKE");
$regobj->update("tbl_customers",$regarry);

if(!$regobj->getLastError()){
$msgtxt="Your reset password is $pwd";
sendSMS($mobile,$msgtxt);
$out["status"]="done";

}
}
else
{
  $out["status"]="notexist";
}
echo json_encode($out);
break;
case "updateCustomer":
//print_r($_POST);exit;
$name=$_POST["name"];
$phone=$_POST["phone"];
$email=$_POST["email"];
$city=$_POST["city"];
$state=$_POST["state"];
$postcode=$_POST["postcode"];
$landmark=$_POST["landmark"];
$address=$_POST["address"];
$custData=array("cust_name"=>$name,"cust_mobile"=>$phone,"cust_email"=>$email,"postcode"=>$postcode,"landmark"=>$landmark,"state"=>$state,"city"=>$city,"address"=>$address);
$cusobj=new MysqliDb(HOST,USER,PWD,DB);
$cusobj->where("cust_id",$_SESSION["CUST"]);
$cusobj->update("tbl_customers",$custData);
if(!$cusobj->getLastError()){
$out["status"]="done";
}else{
$out["status"]="error";

}
echo json_encode($out);
break;
case"changePwd":
$pwd=$_POST["repwd"];
$cusobj=new MysqliDb(HOST,USER,PWD,DB);
$cusobj->where("cust_id",$_SESSION["CUST"]);
$cusobj->update("tbl_customers",Array("cust_pwd"=>$pwd));
if(!$cusobj->getLastError()){
$out["status"]="done";
}else{
$out["status"]="error";

}
echo json_encode($out);
break;

endswitch;



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

case 'addPdtMaster':
	
	$pmid=$_POST["pmid"];
	$pdtnm=$_POST["txtpdtnm"];
	$pdtdesc=$_POST["txtpdtdesc"];
	$pdtcode=$_POST["txtCode"];
	$offertag=$_POST["txtTag"];
	$cagry=$_POST['selCatgry'];
	$subcagry=$_POST['selSubCatgry'];
	$featured=$_POST["chkFeatured"]?:0;
	$img=$_FILES["crmasterImage"];
	$imgname=$_POST["masterImageName"];
	$imgar = $_FILES['crimage-data']?:[];
	$delimg=$_POST["delimg"];

	$dir="../uploads/";
	if($img){
		$file =  $imgname?$imgname:time() . "0.jpg";//echo $file;exit;
		$success = move_uploaded_file($img["tmp_name"],$dir .$file);
		$imgproperty = getimagesize($dir .$file);
		$img_id = imagecreatefromjpeg($dir .$file); 
		$imwidth=$imgproperty[0];
		$imheight=$imgproperty[1];
		$twidth=$imwidth*(0.32);
		$theight=$imheight*(0.32);
		fn_resize($img_id,$imwidth,$imheight,$dir."thumb/" .$file,$twidth,$theight);

	}
	$pdtobj=new MysqliDb(HOST,USER,PWD,DB);
	$pdtobj->startTransaction();
	$pdtmastarr=Array("pm_name"=>$pdtnm,"pm_desc"=>$pdtdesc,"pm_code"=>$pdtcode,"offer_tag"=>$offertag,"ct_id"=>$cagry,"sct_id"=>$subcagry,"is_featured"=>$featured,"pm_image"=>$file);
	
	if($pmid){
		$pdtobj->where("pm_id",$pmid);
		$pdtobj->update("tbl_product_master",$pdtmastarr);

	}else{
		$pdtobj->insert("tbl_product_master",$pdtmastarr);
		$pmid=$pdtobj->getInsertId();
	}
	if(sizeof($imgar)>0){
		//print_r($imgnamear);exit;
   foreach($imgar["tmp_name"] as $imnm=>$img){
	$i++;
    $file =  strpos($imnm,".")?$imnm:time() . "$i.jpg";
    if(!strpos($imnm,"jpg")){
    $imsql[]="('$pmid','$file')";
    }
    //echo $img;
    $success = move_uploaded_file($img,$dir.$file);
    $imgproperty = getimagesize($dir .$file);
    
    $imwidth=$imgproperty[0];
    $imheight=$imgproperty[1];
    $norwdth=$imwidth*(0.75);
    $norht=$imheight*(0.75);
    $medwidth=$imwidth*(0.5);
    $medheight=$imheight*(0.5);
    $twidth=$imwidth*(0.19);
    $theight=$imheight*(0.19);
    $img_id = imagecreatefromjpeg($dir.$file);
    fn_resize($img_id,$imwidth,$imheight,$dir."thumb/" .$file,$twidth,$theight);
    }
}
// echo json_encode($imsql);exit;
	if($imsql > 0){
		$pdtobj->rawQuery("INSERT INTO  tbl_images (pm_id,img_name)VALUES ".implode(",",$imsql));
	}
	if($delimg>0){
		foreach($delimg as $del){
			unlink("../uploads/$del");
			unlink("../uploads/thumb/$del");
		}
		$pdtobj->where("img_name",$delimg,"IN");
		$pdtobj->delete("tbl_images");
		//echo $pdtobj->getLastQuery();
	}
	
	if(!$pdtobj->getLastError()){
	$pdtobj->commit();
	$out['status']="done";	
	$out['pmid']=$pmid;	
	}
	else{
	$out['status']="error";	
	}
	echo json_encode($out);
	break;
/****  PRODUCT MASTER ENDS  ****/	
/****  PRODUCT DEATIL   ****/	
case 'addPdtDetail':
	// print_r($_POST);exit;
	ini_set("display_errors",0);

	$pmid=$_POST["pmid"];
	$pdid=$_POST["pdid"];
	$colorjsn=json_encode($_POST["selColour"],JSON_NUMERIC_CHECK);
	$sizesarr=$_POST["selSizes"];
	$price=$_POST["txtPrice"];
	$strikeprice=$_POST["txtStrikePrice"]?:null;
	$pdtobj=new MysqliDb(HOST,USER,PWD,DB);
	$pdtobj->startTransaction();
	if($pdid){
		$pdtdtlarr=Array("pd_price"=>$price,"pd_strikeprice"=>$strikeprice,"pd_color"=>$colorjsn,"sz_id"=>$sizesarr[0]);
		$pdtobj->where("pd_id",$pdid);	
		$pdtobj->update("tbl_product_detail",$pdtdtlarr);
	}else{
		foreach($sizesarr as $key => $sz){
			$dtlarr[]="($pmid,$price,$strikeprice,'$colorjsn',$sz)";
		}
		$dtlsql="INSERT INTO tbl_product_detail (pm_id,pd_price,pd_strikeprice,pd_color,sz_id) VALUES ".implode(', ', $dtlarr);
		$pdtobj->rawQuery($dtlsql);
	}
	if(!$pdtobj->getLastError()){


	$pdtobj->commit();
	$out['status']="done";	
	}
	else{
	$out['status']="error";	
	}
	echo json_encode($out);
	break;
/****  PRODUCT DEATIL ENDS  ****/	

case "productDetails":
	
	$product_id=$_POST['product_id'];

	$variantobj=new MysqliDb(HOST,USER,PWD,DB);
	$variantobj->groupBy("pd.pd_id");
	$variantobj->where("pd.pm_id",$product_id);
	$variantobj->where("pd.pd_status",0);
	$variantobj->join("tbl_colours cl","JSON_CONTAINS(pd.pd_color,cl.cl_id)", "LEFT");
	$variantobj->join("tbl_sizes sc","pd.sz_id=sc.sz_id");
	$pdtdtl=$variantobj->get("tbl_product_detail pd",null,"pd.pd_id,pd.pm_id,pd_price,sz_title,pd_strikeprice,pd.sz_id,pd_color,sc.sz_code,GROUP_CONCAT(DISTINCT cl.cl_name) AS clname");
	
	$variantobj->where("pm_id",$product_id);
	$images=$variantobj->get("tbl_images",null,"img_name");
	
	// echo $variantobj->getLastQuery();exit;
	$out["variants"]=$pdtdtl;
	$out["images"]=$images;
	echo json_encode($out);
	break;



endswitch;
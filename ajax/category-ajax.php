<?php
include("../includes/config.php");
include("../includes/MysqliDb.php");
include("../includes/functions.php");
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    //die("cheating");
}
$action = $_REQUEST['action'];
switch ($action):
/***ITEM-CATEGORY***/
    case "addCategory":
        // ini_set("display_errors",1);
        $catobj = new MysqliDb(HOST, USER, PWD, DB);
        // print_r($_POST);exit;
        $catid = $_POST["catId"];
        $catnm = $_POST["txtCatname"];
        $category = array("ct_title" => $catnm);
        if ($catid) {
            $catobj->where("ct_id", $catid);
            $catobj->update("tbl_category", $category);
        } else {
            $catobj->insert("tbl_category", $category);
        }
        $out["status"] = "done";

        echo json_encode($out);
        break;
/***CREATE/EDIT ITEMS IN STORE***/
    case 'addSubCategory':
        // ini_set("display_errors",1);
        $catobj = new MysqliDb(HOST, USER, PWD, DB);
        // print_r($_POST);exit;
        $catid = $_POST["catId"];
        $subcatnm = $_POST["txtCatname"];
        $catnm = $_POST["selCatgry"];
        $category = array("sct_title" => $subcatnm,"ct_id"=>$catnm);
        if ($catid) {
            $catobj->where("sct_id", $catid);
            $catobj->update("tbl_sub_category", $category);
        } else {
            $catobj->insert("tbl_sub_category", $category);
        }
        $out["status"] = "done";

        echo json_encode($out);
        break;
/***CREATE/EDIT ITEMS IN STORE ENDS***/


endswitch;

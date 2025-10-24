<?php
session_start();
ob_start();
ini_set("display_errors",0);
ini_set( 'date.timezone', 'Asia/Calcutta' );
ini_set("serialize_precision", -1);
ini_set("precision", 14);
define("ROOT",$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/odazsports/');
define("HOST", "localhost");
define("USER","root");
define("DB","odazsports");
define("PWD","");
define("ADMINROOT",$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/odazsports/office/');
define("FILESIZE", "2048000");
define("DIR", $_SERVER["DOCUMENT_ROOT"]."/odazsports/");
define("IMGDIR",$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/odazsports/uploads/');
define("SHIPPING",70);

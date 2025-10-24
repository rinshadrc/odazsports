<?php
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

$EMAILOBJ = new PHPMailer(true);

//Tell PHPMailer to use SMTP
$EMAILOBJ->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$EMAILOBJ->SMTPDebug = 0;


//Ask for HTML-friendly debug output
$EMAILOBJ->Debugoutput = 'html';

//Set the hostname of the mail server
$EMAILOBJ->Host = 'smtp.gmail.com';
// use
// $EMAILOBJ->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$EMAILOBJ->Port =587;

//Set the encryption system to use - ssl (deprecated) or tls
$EMAILOBJ->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$EMAILOBJ->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$EMAILOBJ->Username = "mailtomovieclicks@gmail.com";
//Password to use for SMTP authentication
// $EMAILOBJ->Password = "Pwd4movieclick";--->email password
$EMAILOBJ->Password = "ishdclkyjyxldhww "; //app pwd


//Set who the message is to be sent from
$EMAILOBJ->setFrom('mailtomovieclicks@gmail.com', "Redcherry Cinemas");


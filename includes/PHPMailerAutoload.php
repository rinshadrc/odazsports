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

// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$EMAILOBJ->Port =587;

//Set the encryption system to use - ssl (deprecated) or tls
$EMAILOBJ->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$EMAILOBJ->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$EMAILOBJ->Username = "odazsports@gmail.com";
//Password to use for SMTP authentication
$EMAILOBJ->Password = "fapzwatcamxgvxjk"; //app pwd


//Set who the message is to be sent from
// $EMAILOBJ->setFrom('odazsports@gmail.com', "Odaz Sports");
// $EMAILOBJ->Subject = 'test mail from odaz';
// $content="<!DOCTYPE html><html><head><title>Show closing details of "."redesigns"."</title></head><body><h1>test mail odaz sports</h1>/body></html>";

// $mailfoot="</body></html>";
// $EMAILOBJ->SMTPDebug=2;
// $EMAILOBJ->addAddress("rinshadredcherry@gmail.com", "rinshad");
// $EMAILOBJ->msgHTML($content);
// $EMAILOBJ->send();


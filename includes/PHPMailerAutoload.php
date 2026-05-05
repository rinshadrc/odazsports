<?php
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

$EMAILOBJ = new PHPMailer(true);

$EMAILOBJ->isSMTP();
$EMAILOBJ->SMTPDebug = 0;
$EMAILOBJ->Host = 'smtp.gmail.com';
$EMAILOBJ->Port =587;
$EMAILOBJ->SMTPSecure = 'tls';
$EMAILOBJ->SMTPAuth = true;
$EMAILOBJ->Username = "odazsports@gmail.com";
$EMAILOBJ->isHTML(true);
$EMAILOBJ->Password = "fapzwatcamxgvxjk"; //app pwd
$EMAILOBJ->setFrom('odazsports@gmail.com', "Odaz Sports");




<?php
$fp=fopen("demo/uploads/odaz.txt","w");
$result=json_encode($_POST);
$result.=file_get_contents('php://input');
$result.="result";
fwrite($fp,$result);
fclose($fp);


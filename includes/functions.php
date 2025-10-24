<?php
function fn_resize($img_id,$width,$height,$name,$nw =100,
$nh =100) {
$target_layer=imagecreatetruecolor($nw,$nh);
imagecopyresampled($target_layer,$img_id,0,0,0,0,$nw,$nh, $width,$height);
imagejpeg($target_layer,$name);
}

function check_access($opt="",$text=""){
    global $acess,$module;
    $permitted=false;
    if($opt){
    if(array_key_exists($opt, $module)){
    return $text?$text:true;
    } 
    else{
    return false;    
    }  
    }else{
    foreach ($acess as $key => $value) {
    if(strpos($_SERVER["REQUEST_URI"],$key)){
    $permitted=true;
    break;
    }
    }
    if($permitted)
    return true;
    else
    header("location:".ROOT."no-permission");
    } 
    }
function is_alive( $url ) {
  $timeout = 10;
  $ch = curl_init();
  curl_setopt ( $ch, CURLOPT_URL, $url );
  curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
  $http_respond = curl_exec($ch);
  $http_respond = trim( strip_tags( $http_respond ) );
  $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
  if ( ( $http_code == "200" ) || ( $http_code == "302" ) ) {
    return true;
  } else {
    // return $http_code;, possible too
    return false;
  }
  curl_close( $ch );
}

function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
    /*
    $interval can be:
    yyyy - Number of full years
    q - Number of full quarters
    m - Number of full months
    y - Difference between day numbers
        (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
    d - Number of full days
    w - Number of full weekdays
    ww - Number of full weeks
    h - Number of full hours
    n - Number of full minutes
    s - Number of full seconds (default)
    */

    if (!$using_timestamps) {
        $datefrom = strtotime($datefrom, 0);
        $dateto = strtotime($dateto, 0);
    }
    $difference = $dateto - $datefrom; // Difference in seconds

    switch($interval) {

    case 'yyyy': // Number of full years

        $years_difference = floor($difference / 31536000);
        if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
            $years_difference--;
        }
        if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
            $years_difference++;
        }
        $datediff = $years_difference;
        break;

    case "q": // Number of full quarters

        $quarters_difference = floor($difference / 8035200);
        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
            $months_difference++;
        }
        $quarters_difference--;
        $datediff = $quarters_difference;
        break;

    case "m": // Number of full months

        $months_difference = floor($difference / 2678400);
        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
            $months_difference++;
        }
        $months_difference--;
        $datediff = $months_difference;
        break;

    case 'y': // Difference between day numbers

        $datediff = date("z", $dateto) - date("z", $datefrom);
        break;

    case "d": // Number of full days

        $datediff = floor($difference / 86400);
        break;

    case "w": // Number of full weekdays

        $days_difference = floor($difference / 86400);
        $weeks_difference = floor($days_difference / 7); // Complete weeks
        $first_day = date("w", $datefrom);
        $days_remainder = floor($days_difference % 7);
        $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
        if ($odd_days > 7) { // Sunday
            $days_remainder--;
        }
        if ($odd_days > 6) { // Saturday
            $days_remainder--;
        }
        $datediff = ($weeks_difference * 5) + $days_remainder;
        break;

    case "ww": // Number of full weeks

        $datediff = floor($difference / 604800)+1;
        break;

    case "h": // Number of full hours

        $datediff = floor($difference / 3600);
        break;

    case "n": // Number of full minutes

        $datediff = floor($difference / 60);
        break;

    default: // Number of full seconds (default)

        $datediff = $difference;
        break;
    }

    return $datediff;

}
function curlInit($url,$data) //$data - var1=val1&var2=val2...
{
    //$op["sts"]="doneddd";
    try{
    $data=http_build_query($data);
    $ch = @curl_init();
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    //curl_setopt($ch,CURLOPT_POST,count($data));
    curl_setopt($ch,CURLOPT_TIMEOUT, '5');
    //curl_setopt($ch,CURLOPT_POST,false);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$data);  
    //echo CMSURL.$file.'?'.$data.' - ';
    curl_setopt($ch,CURLOPT_URL,$url); 
    $op=curl_exec($ch);
    if(curl_errno($ch)){
     $op["status"]="error";
        $op["msg"]=curl_errno($ch);
        $op=json_encode($op);   
    }
    curl_close($ch);
    }catch(Exception $e){
        $op["status"]="error";
        $op["msg"]="ERR!500";
        $op=json_encode($op);
    }

    return $op; 
}
function sendSMS($mobile,$msg)
{

$number="91".$mobile."@s.whatsapp.net";
$url = "https://crm.zendbird.com/api/v1/send-text?token=" . urlencode("eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiJSYTZWZVNSZVRCaU9CWHlIWEdMTHIyYVhsOHZFMkl5UyIsInJvbGUiOiJ1c2VyIiwiaWF0IjoxNzU1ODQ4MTM5fQ.VlPW8IG3O1NjMOCrrnJkHZtVwLWdT7RD7femNoy28zU") . "&instance_id=" . urlencode("eyJ1aWQiOiJSYTZWZVNSZVRCaU9CWHlIWEdMTHIyYVhsOHZFMkl5UyIsImNsaWVudF9pZCI6IlNFQ0xPQiBURUNITk9MT0dJRVMifQ==") . "&jid=" . urlencode($number) . "&msg=" . urlencode($msg);
try {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "Error: " . curl_error($ch);
    } 

    curl_close($ch);
} catch (Exception $ex) {
        echo "Exception: " . $ex->getMessage();
}

}
?>

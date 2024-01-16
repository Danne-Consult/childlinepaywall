<?php 
date_default_timezone_set("Africa/Nairobi");
header("Content-Type:application/json");

$content = file_get_contents('php://input');

$res = json_decode($content);

$resultcode = $res->Body->stkCallback->ResultCode;
$checkoutrequestID = $res->Body->stkCallback->CheckoutRequestID;
$transamount = $res->Body->stkCallback->CallbackMetadata->Item[0]->Value;
$transid = $res->Body->stkCallback->CallbackMetadata->Item[1]->Value;
$balance = $res->Body->stkCallback->CallbackMetadata->Item[2]->Value;
$transtime = $res->Body->stkCallback->CallbackMetadata->Item[3]->Value;
$phoneno = $res->Body->stkCallback->CallbackMetadata->Item[4]->Value;

$today = date("l jS F Y h:i:s A");

$rec = $today.' - '. $resultcode.', '.$checkoutrequestID.', '.$transid.', '.$transamount.', '.$transtime.', '.$phoneno.' \n';


function newval($fileval, $transamt){
    $newamount = $fileval + $transamt;

    return $newamount;
    
}

$file = fopen("mpesaamount.txt", "r") or die("Unable to open file!");
$newval = newval($file, $transamount);
fwrite($file, $newval);
fclose($file);

file_put_contents('transaction_log.txt', $rec, FILE_APPEND);
file_put_contents('log.txt', $content, FILE_APPEND);
?>

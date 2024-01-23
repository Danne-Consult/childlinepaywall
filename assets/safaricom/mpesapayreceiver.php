<?php 
date_default_timezone_set("Africa/Nairobi");
header("Content-Type:application/json");

$content1 = file_get_contents('php://input');

$x = fopen("donations/".$dontationid."-try.json", "a");
    fwrite($x,$content1);   
    fclose($x);


/*if(isset($_GET['ref'])){

    $dontationid = $_GET['ref'];
    $content = file_get_contents('php://input');

    $h = fopen("donations/".$dontationid."-payment.json", "a");
    fwrite($h,$content);   
    fclose($h);

    $res = json_decode($content);

    $resultcode = $res->Body->stkCallback->ResultCode;
    $checkoutrequestID = $res->Body->stkCallback->CheckoutRequestID;
    $transamount = $res->Body->stkCallback->CallbackMetadata->Item[0]->Value;
    $transid = $res->Body->stkCallback->CallbackMetadata->Item[1]->Value;
    $transtime = $res->Body->stkCallback->CallbackMetadata->Item[2]->Value;
    $phoneno = $res->Body->stkCallback->CallbackMetadata->Item[3]->Value;
    
    $today = date("l jS F Y h:i:s A");
    $rec = $today.' - '. $resultcode.', '.$checkoutrequestID.', '.$transid.', '.$transamount.', '.$transtime.', '.$phoneno.' \n';
    
    
    $filename = "mpesaamount.txt";
    $current_value = file_get_contents($filename);

    if (is_numeric($current_value)) {
        $new_value = intval($current_value) + $transamount;
        file_put_contents($filename, $new_value);
    
        echo "Value in text document updated successfully! - ".$new_value;
    } else {
        echo "Error: The value in the text document is not a valid number.";
    }
    
}*/
?>
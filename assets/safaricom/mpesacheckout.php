<?php 

header("Content-Type:application/json");
date_default_timezone_set("Africa/Nairobi");
require_once __DIR__ . '/config.php';

/*End  configurations*/

if(isset($_POST["xtelno"])){

    $rundomnum = $_POST["xrandomnum"];
    $donorname = $_POST["xname"];
    $donorphone = $_POST["xtelno"];
    $donoramount = $_POST["xdonation"];
    $donoremail = $_POST['xemail'];
    $donation = $_POST['xdonation'];
    
    $donorphone = (substr($donorphone, 0, 1) == "+") ? str_replace("+", "", $donorphone) : $donorphone;
    $donorphone = (substr($donorphone, 0, 1) == "0") ? preg_replace("/^0/", "254", $donorphone) : $donorphone;
    $donorphone = (substr($donorphone, 0, 1) == "7") ? "254{$donorphone}" : $donorphone;
    
    $trandesc = "1 Bob Hero";

    $curl_Tranfer = curl_init();
    curl_setopt($curl_Tranfer, CURLOPT_URL, $Token_URL);
    $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
    curl_setopt($curl_Tranfer, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
    curl_setopt($curl_Tranfer, CURLOPT_HEADER, false);
    curl_setopt($curl_Tranfer, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_Tranfer, CURLOPT_SSL_VERIFYPEER, false);
    $curl_Tranfer_response = curl_exec($curl_Tranfer);
    $token = json_decode($curl_Tranfer_response)->access_token;
    
    $curl_Tranfer2 = curl_init();
    curl_setopt($curl_Tranfer2, CURLOPT_URL, $OnlinePayment);
    curl_setopt($curl_Tranfer2, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer '.$token));

    $curl_Tranfer2_post_data = [
        'BusinessShortCode' => $Business_Code,
        'Password' => $password,
        'Timestamp' =>$Time_Stamp,
        'TransactionType' =>$Type_of_Transaction,
        'Amount' => $donoramount,
        'PartyA' => $donorphone,
        'PartyB' => $Business_Code,
        'PhoneNumber' => $donorphone,
        'CallBackURL' => $CallBackURL."?ref=".$rundomnum,
        'AccountReference' => $trandesc,
        'TransactionDesc' => $trandesc
    ];

    $data2_string = json_encode($curl_Tranfer2_post_data);
    curl_setopt($curl_Tranfer2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_Tranfer2, CURLOPT_POST, true);
    curl_setopt($curl_Tranfer2, CURLOPT_POSTFIELDS, $data2_string);
    curl_setopt($curl_Tranfer2, CURLOPT_HEADER, false);
    curl_setopt($curl_Tranfer2, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl_Tranfer2, CURLOPT_SSL_VERIFYHOST, 0);
    $curl_Tranfer2_response = json_decode(curl_exec($curl_Tranfer2));
    curl_close($curl_Tranfer2);
    
    var_dump($curl_Tranfer2_post_data);
    
    $result = $curl_Tranfer2_response->ResponseCode; 
    $requestid = $curl_Tranfer2_response->CheckoutRequestID;
    
    if($result === "0"){
        $payment = fopen("donations/".$rundomnum.".json", "a");
        fwrite($payment, json_encode($curl_Tranfer2_response)); 
        fclose($payment);
    }else{
        print_r($curl_Tranfer2_response->CustomerMessage);
    }
}else{
    print_r("Invalid telephone number provided");
}


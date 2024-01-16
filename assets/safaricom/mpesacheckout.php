<?php 

header("Content-Type:application/json");
date_default_timezone_set("Africa/Nairobi");

/*Call function with these configurations*/
$consumer_key = '3c3QceNnq2bXIm3vy466MdAxnAbR6cQP';
$consumer_secret = 'DObr8G3ZuWjeAB6A';
$Business_Code = '174379';
$Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
$Type_of_Transaction = 'CustomerPayBillOnline';
$Token_URL = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$OnlinePayment = 'https://sandbox.safaricom.co.ke/mpesa/b2b/v1/paymentrequest';
$CallBackURL = 'https://danneconsult.com/client/childlinepaywall/mpesapayreceiver.php';
$Time_Stamp = date("Ymdhis");
$password = base64_encode($Business_Code . $Passkey . $Time_Stamp);

/*End  configurations*/

    if(isset($_POST["mpesasubmit"])){

        if (!isset($_POST["xtelno"])) {
            header("location: ../../paywall.html?error=Please re-enter your number");
            exit();
        }
        
        $donorname = $_POST["xname"];
        $donorphone = $_POST["xtelno"];
        $donoramount = $_POST["xdonation"];
        $donoremail = $_POST['xemail'];
        $donation = $_POST['xdonation'];
        
        $donationref = "HERO ". $donorname;
        $tpltype = "1 Bob Hero";

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
        curl_setopt($curl_Tranfer2, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token));

        $curl_Tranfer2_post_data = [
            'BusinessShortCode' => $Business_Code,
            'Password' => $password,
            'Timestamp' =>$Time_Stamp,
            'TransactionType' =>$Type_of_Transaction,
            'Amount' => $donoramount,
            'PartyA' => $donorphone,
            'PartyB' => $Business_Code,
            'PhoneNumber' => $donorphone,
            'CallBackURL' => $CallBackURL,
            'AccountReference' => $donationref,
            'TransactionDesc' => $tpltype
        ];

        $data2_string = json_encode($curl_Tranfer2_post_data);

        curl_setopt($curl_Tranfer2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_Tranfer2, CURLOPT_POST, true);
        curl_setopt($curl_Tranfer2, CURLOPT_POSTFIELDS, $data2_string);
        curl_setopt($curl_Tranfer2, CURLOPT_HEADER, false);
        curl_setopt($curl_Tranfer2, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_Tranfer2, CURLOPT_SSL_VERIFYHOST, 0);
        $curl_Tranfer2_response = json_decode(curl_exec($curl_Tranfer2));

        $result = $curl_Tranfer2_response->ResponseCode; 
        $requestid = $curl_Tranfer2_response->CheckoutRequestID;
        
        if($result === "0"){
            echo $result ."/n" . $requestid; 

        }
        
    }


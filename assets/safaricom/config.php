<?php

    /*Call function with these configurations*/
    $consumer_key = '3c3QceNnq2bXIm3vy466MdAxnAbR6cQP';
    $consumer_secret = 'DObr8G3ZuWjeAB6A';
    $Business_Code = '174379';
    $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
    $Type_of_Transaction = 'CustomerPayBillOnline';
    $Token_URL = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $OnlinePayment = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $CallBackURL = 'https://0c98-41-90-67-30.ngrok-free.app/childlinepaywall/assets/safaricom/mpesapayreceiver.php';
    $Time_Stamp = date("Ymdhis");
    $password = base64_encode($Business_Code . $Passkey . $Time_Stamp);
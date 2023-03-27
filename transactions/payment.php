<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    require($_SERVER["DOCUMENT_ROOT"] . "/db_connect.php");
    $response = ["success" => true, "error" => ""];

    $phone_number = "254".htmlspecialchars($_POST["phone_number"]);
    $amount = htmlspecialchars($_POST["amount"]);
    $meter_number = htmlspecialchars($_POST["meter_number"]);

    $current_meter_


    $consumer_key = '4zoOGSweQY5hmA0TJ6rMAQd0P5qoHZ2D';
    $consumer_secret = 'QfcXyARBH6QkP0fQ';

    $Business_Code = '174379';
    $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
    $Type_of_Transaction = 'CustomerPayBillOnline';
    $Token_URL = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $OnlinePayment = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $CallBackURL = 'https://2974-154-159-237-136.in.ngrok.io/transactions/callback.php';
    $Time_Stamp = date("Ymdhis");
    $password = base64_encode($Business_Code . $Passkey . $Time_Stamp);

    $curl_request = curl_init();
    curl_setopt($curl_request, CURLOPT_URL, $Token_URL);
    $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
    curl_setopt($curl_request, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
    curl_setopt($curl_request, CURLOPT_HEADER, false);
    curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
    $curl_request_response = curl_exec($curl_request);

    $token = json_decode($curl_request_response)->access_token;

    $curl_Tranfer2 = curl_init();
    curl_setopt($curl_Tranfer2, CURLOPT_URL, $OnlinePayment);
    curl_setopt($curl_Tranfer2, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token));

    $curl_Tranfer2_post_data = [
        'BusinessShortCode' => $Business_Code,
        'Password' => $password,
        'Timestamp' => $Time_Stamp,
        'TransactionType' => $Type_of_Transaction,
        'Amount' => $amount,
        'PartyA' => $phone_number,
        'PartyB' => $Business_Code,
        'PhoneNumber' => $phone_number,
        'CallBackURL' => $CallBackURL,
        'AccountReference' => 'Remote Electricity',
        'TransactionDesc' => 'Test',
    ];

    $data2_string = json_encode($curl_Tranfer2_post_data);

    curl_setopt($curl_Tranfer2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_Tranfer2, CURLOPT_POST, true);
    curl_setopt($curl_Tranfer2, CURLOPT_POSTFIELDS, $data2_string);
    curl_setopt($curl_Tranfer2, CURLOPT_HEADER, false);
    curl_setopt($curl_Tranfer2, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl_Tranfer2, CURLOPT_SSL_VERIFYHOST, 0);
    $curl_Tranfer2_response = json_decode(curl_exec($curl_Tranfer2));

    echo json_encode($curl_Tranfer2_response, JSON_PRETTY_PRINT);
}
?>
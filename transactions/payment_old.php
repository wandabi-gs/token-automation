<?php
if (isset($_POST['submit_pay'])) {
    // STKPUSH
    date_default_timezone_set('Africa/Nairobi');

    $consumer_key = '4zoOGSweQY5hmA0TJ6rMAQd0P5qoHZ2D';
    $consumer_secret = 'QfcXyARBH6QkP0fQ';

    $Amount = $_POST['amount'];
    $BusinessShortCode = '174379';
    $Passkey = 'Uy15Ph8r34B3ssjhReuz4IfrG3Tv+AOyAvUfjGnZXBl3vk9/UsoEZt2fCFxVRrWfknXfHJkhrmyp8EZu6Uym9Unmk0fJ1pjVzPmhTRxR9Zt6xzYtWhxuk+mICKNYC+nujLrwmbpe92AGv1JWVCInaD3Hs0ro6CGqtJ7eCBr6J5wzjx94MK9GwlIua86M5ayX3PTrO2eOzZyeBiAPF+6tyof9ZeqKOZNA9l+JaTAqHgXD43Lpx/G3LW2kTyZOabBYayWqmfHiB42CCnELeaguYMgv3v8NqR5MrKy14VXW4OlrT9YaUIjJjxhcjVKgIazXd4eaT1Q+4mCVLIgARfvgBw==';


    $PartyA ="254".$_POST['phone_number'];
    $AccountReference = 'kplc token recharge';
    $TransactionDesc = 'test';

    $Timestamp = date('YmdHis');

    $Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

    $headers = ['Content-Type:application/json; charset=utf8'];

    $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

    $CallBackURL = 'https://2974-154-159-237-136.in.ngrok.io/transactions/callback.php';

    $curl = curl_init($access_token_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $result = json_decode($result);
    print_r($result);
    $access_token = $result->access_token;
    curl_close($curl);

    $stkheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $initiate_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader);

    $curl_post_data = array(
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $Amount,
        'PartyA' => $PartyA,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $PartyA,
        'CallBackURL' => $CallBackURL,
        'AccountReference' => $AccountReference,
        'TransactionDesc' => $TransactionDesc
    );

    $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);

    // // header("Location:../index.php");


    // $consumer_key = '4zoOGSweQY5hmA0TJ6rMAQd0P5qoHZ2D';
    // $consumer_secret = 'QfcXyARBH6QkP0fQ';
    // $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
    // $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    // // $curl_request = curl_init();
    // // curl_setopt($curl_request, CURLOPT_URL, $url);
    // // $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
    // // curl_setopt($curl_request, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
    // // curl_setopt($curl_request, CURLOPT_HEADER, false);
    // // curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
    // // curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
    // // $curl_request_response = curl_exec($curl_request);

    // // print_r(json_decode($curl_request_response));
    // // $token = json_decode($curl_request_response)->access_token;

    // $curl = curl_init($url);
    // curl_setopt($curl, CURLOPT_URL, false);
    // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // $result = curl_exec($curl);
    // $access_token = json_decode($result)->access_token;
    // print_r("Access : ".$access_token."\n :");

    // $shortcode = '888880';
    // $amount = htmlspecialchars($_POST["amount"]); // Replace with the actual amount to be transacted
    // $phone_number = htmlspecialchars($_POST["phone_number"]); // Replace with the customer's phone number
    // $reference_number = '123456'; // Replace with a unique reference number for the transaction
    // $account_number = htmlspecialchars($_POST["meter_number"]); // Replace with the customer's account number
    // $business_number = '888880';
    // $callback_url = 'https://example.com/callback.php'; // Replace with your actual callback URL
    // $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    // $curl = curl_init();
    // curl_setopt($curl, CURLOPT_URL, $url);
    // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization:Bearer ' . $access_token, 'Content-Type:application/json'));
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl, CURLOPT_POST, true);
    // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
    //     'BusinessShortCode' => $business_number,
    //     'Password' => base64_encode($business_number . 'your_passkey' . date('YmdHis')),
    //     'Timestamp' => date('YmdHis'),
    //     'TransactionType' => 'CustomerPayBillOnline',
    //     'Amount' => $amount,
    //     'PartyA' => $phone_number,
    //     'PartyB' => $business_number,
    //     'PhoneNumber' => $phone_number,
    //     'CallBackURL' => $callback_url,
    //     'AccountReference' => $account_number,
    //     'TransactionDesc' => 'Payment for goods and services'
    // )));
    // $result = curl_exec($curl);
    // print_r($result);
    // curl_close($curl);

}

?>
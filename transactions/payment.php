<?php
if (isset($_POST['submit_pay'])) {
    // STKPUSH
    date_default_timezone_set('Africa/Nairobi');

    # access token
    $consumerKey = 'G2UiWDRk9kXv7P4sqH11l85rXEjKatRw'; //Fill with your app Consumer Key
    $consumerSecret = 'gqEUucillqrGPzHx'; // Fill with your app Secret

    # define the variales
    # provide the following details, this part is found on your test credentials on the developer account
    $Amount = $_POST['amount'];
    $BusinessShortCode = '174379'; //sandbox
    $Passkey = 'Uy15Ph8r34B3ssjhReuz4IfrG3Tv+AOyAvUfjGnZXBl3vk9/UsoEZt2fCFxVRrWfknXfHJkhrmyp8EZu6Uym9Unmk0fJ1pjVzPmhTRxR9Zt6xzYtWhxuk+mICKNYC+nujLrwmbpe92AGv1JWVCInaD3Hs0ro6CGqtJ7eCBr6J5wzjx94MK9GwlIua86M5ayX3PTrO2eOzZyeBiAPF+6tyof9ZeqKOZNA9l+JaTAqHgXD43Lpx/G3LW2kTyZOabBYayWqmfHiB42CCnELeaguYMgv3v8NqR5MrKy14VXW4OlrT9YaUIjJjxhcjVKgIazXd4eaT1Q+4mCVLIgARfvgBw==';


    $PartyA = $_POST['phone_number']; // This is your phone number, 
    $AccountReference = 'kplc token recharge';
    $TransactionDesc = 'test';

    # Get the timestamp, format YYYYmmddhms -> 20181004151020
    $Timestamp = date('YmdHis');

    # Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
    $Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

    # header for access token
    $headers = ['Content-Type:application/json; charset=utf8'];

    # M-PESA endpoint urls
    $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

    # callback url
    $CallBackURL = './callback_url.php';

    $curl = curl_init($access_token_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $result = json_decode($result);
    $access_token = $result->access_token;
    curl_close($curl);

    # header for stk push
    $stkheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];

    # initiating the transaction
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $initiate_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

    $curl_post_data = array(
        //Fill in the request parameters with valid values
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $Amount,
        'PartyA' => $PartyA,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $PartyA,
        // 'CallBackURL' => $CallBackURL,
        'AccountReference' => $AccountReference,
        'TransactionDesc' => $TransactionDesc
    );

    $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);

    // header("Location:../index.php");
}

?>
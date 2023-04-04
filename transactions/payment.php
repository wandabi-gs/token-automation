<?php
require($_SERVER["DOCUMENT_ROOT"] . "/db_connect.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    $response = ["success" => true, "error" => ""];
    $user_id = $_SESSION['user']['id'];
    $phone_number = "254" . htmlspecialchars($_POST["phone_number"]);
    $amount = htmlspecialchars($_POST["amount"]);
    $meter_id = htmlspecialchars($_POST["meter_id"]);
    $meter_number = htmlspecialchars($_POST["meter_number"]);

    // $current_meter_


    $consumer_key = '4zoOGSweQY5hmA0TJ6rMAQd0P5qoHZ2D';
    $consumer_secret = 'QfcXyARBH6QkP0fQ';

    $Business_Code = '174379';
    $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
    $Type_of_Transaction = 'CustomerPayBillOnline';
    $Token_URL = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $OnlinePayment = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $CallBackURL = 'https://2974-154-159-237-136.in.ngrok.io/transactions/callback.php';
    // $CallBackURL = "http://callback.php";
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

    // echo json_encode($curl_Tranfer2_response, JSON_PRETTY_PRINT);
    $curl_Tranfer2_response_json = json_encode($curl_Tranfer2_response, JSON_PRETTY_PRINT);

    // echo $curl_Tranfer2_response_json;

    $transaction_id = generateTransactionId(30);



    // assume $conn is your database connection object






}



?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv=' X-UA-Compatible' content='IE=edge'>
    <meta name=' viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <script src="../assets/js/jquery-3.5.1.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/axios.min.js"></script>
</head>

<body>

    <?php
    if (strpos($curl_Tranfer2_response_json, '"ResponseCode": "0"') !== false) {
        // ResponseCode is 0, do something
        // record into the db
        // insert into the database
        // require($_SERVER["DOCUMENT_ROOT"] . "/db_connect.php");
        // echo ("transactionid= " . $transaction_id . "</br>");
        // echo ("amount= " . $amount . "</br>");
        // echo ("meter_id= " . $meter_id . "</br>");
        // echo ("user_id= " . $user_id . "</br>");
    
        // $newmeterid = getMeterId($meter_id, $conn);
        // echo $newmeterid;
    
        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        fwrite($myfile, "$transaction_id,$amount,$meter_id,$user_id,$phone_number\n");
        // fwrite($myfile, $amount);
        // fwrite($myfile, $meter_id);
        // fwrite($myfile, $user_id);
        fclose($myfile);
        header("Location : ./complete_transaction.php");
        ?>
        <div class="container">
            <div class="form-group">
                <span class="badge bg-success">Success</span>
                <button class="btn btn-primary btn-lg float-right" onclick="window.history.back();">Go Back</button>
                <script>location.replace("./complete.php")</script>
            </div>
        </div>
        <?php
    } else {
        // ResponseCode is not 0, do something else
        // echo "<script>alert('" . json_encode($curl_Tranfer2_response, JSON_PRETTY_PRINT) . "')</script>";
        // $response = "";
        // echo json_encode($curl_Tranfer2_response, JSON_PRETTY_PRINT);
        // echo $response;
        ?>
        <div class="container">
            <div class="form-group">
                <label for="input" class="text-danger">
                    <?php
                    if (json_encode($curl_Tranfer2_response, JSON_PRETTY_PRINT) == null) {
                        echo "connect to the internet";



                        # code...
                    } else {
                        echo json_encode($curl_Tranfer2_response, JSON_PRETTY_PRINT);
                        echo "  </br> " . " an error occured try again";
                    }

                    ?>
                </label><br>
                <button class="btn btn-primary btn-lg float-right" onclick="window.history.back();">Go Back</button>
            </div>
        </div>
        <?php

    }

    ?>
</body>

</html>
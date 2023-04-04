<?php
require($_SERVER["DOCUMENT_ROOT"] . "/db_connect.php");

$data = file_get_contents('php://input');
$decoded_data = json_decode($data);

if ($decoded_data->Body->stkCallback->ResultCode != 0) {
    // Transaction failed, do not register the log in the database
    echo "transaction failed";
} else {
    # code...
    // Transaction succeeded, register the log in the database
//     $merchant_request_id = $decoded_data->Body->stkCallback->MerchantRequestID;
//     $checkout_request_id = $decoded_data->Body->stkCallback->CheckoutRequestID;
//     $result_description = $decoded_data->Body->stkCallback->ResultDesc;

    //     $stmt = $conn->prepare("INSERT INTO transactions_records (merchant_request_id, status, result_description)
// VALUES (?, 'completed', ?)");
//     $stmt->bind_param("ss", $result_description, $merchant_request_id);
//     $stmt->execute();

    echo ("transactionid= " . $transaction_id . "</br>");
    echo ("amount= " . $amount . "</br>");
    echo ("meter_id= " . $meter_id . "</br>");
    echo ("user_id= " . $user_id . "</br>");

    $newmeterid = getMeterId($meter_id, $conn);
    echo $newmeterid;



}


?>
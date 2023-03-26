<?php
require($_SERVER["DOCUMENT_ROOT"] . "/db_connect.php");

$data = file_get_contents('php://input');
$decoded_data = json_decode($data);

if ($decoded_data->Body->stkCallback->ResultCode != 0) {
    // Transaction failed, do not register the log in the database
    return;
}

// Transaction succeeded, register the log in the database
$merchant_request_id = $decoded_data->Body->stkCallback->MerchantRequestID;
$checkout_request_id = $decoded_data->Body->stkCallback->CheckoutRequestID;
$result_description = $decoded_data->Body->stkCallback->ResultDesc;

$stmt = $conn->prepare("UPDATE transactions SET status = 'completed', result_description = ? WHERE merchant_request_id =
?");
$stmt->bind_param("ss", $result_description, $merchant_request_id);
$stmt->execute();
$stmt->close();
?>
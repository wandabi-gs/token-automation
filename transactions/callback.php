<?php
require($_SERVER["DOCUMENT_ROOT"] . "/db_connect.php");

$data = file_get_contents('php://input');
$decoded_data = json_decode($data);

// Check if the transaction was successful
if ($decoded_data->Body->stkCallback->ResultCode == 0) {
    $merchant_request_id = $decoded_data->Body->stkCallback->MerchantRequestID;
    $checkout_request_id = $decoded_data->Body->stkCallback->CheckoutRequestID;
    $result_description = $decoded_data->Body->stkCallback->ResultDesc;

    // Update the transaction status in the database
    $stmt = $conn->prepare("UPDATE transactions SET status = 'completed', result_description = ? WHERE merchant_request_id = ?");
    $stmt->bind_param("ss", $result_description, $merchant_request_id);
    $stmt->execute();
    $stmt->close();

    // Perform other necessary actions, such as sending a confirmation message to the customer
    // ...
}

?>
<?php
// require($_SERVER["DOCUMENT_ROOT"] . "/db_connect.php");
$conn = mysqli_connect("localhost", "lloyd", "1234", "token");

$file = fopen("newfile.txt", "r");

// Read a line from the file
$line = fgets($file);

// Explode the line by commas to get an array of values
$fields = explode(',', $line);

// $lines = explode("\n", $data);
// foreach ($lines as $line) {
// fwrite($myfile, "$transaction_id, $amount, $meter_id, $user_id\n");

$transaction_id = $fields[0];
$amount = $fields[1];
$meter_id = $fields[2];
$user_id = $fields[3];
$phone_number = trim($fields[4], " ");
$phone_number = "+" . $phone_number;
$phone_number = strval($phone_number);

// }

$meter_id_2 = strval($meter_id);
$meter_id_3 = trim($meter_id_2, " ");
$stmt2 = $conn->prepare("SELECT * FROM meter WHERE meter_id=?");
$stmt2->bind_param("s", $meter_id_3);
$stmt2->execute();

$result = $stmt2->get_result(); // get the mysqli result
$user = $result->fetch_assoc(); // fetch data 
echo $user['id'];
$stmt = $conn->prepare("INSERT INTO transaction (transaction_id, amount, meter_id , user_id) VALUES (?, ?,?, ?)");
$stmt->bind_param("siii", $transaction_id, $amount, $meter_id_3, $user_id);
$stmt->execute();

$curl = curl_init();
curl_setopt_array(
    $curl,

    array(
        CURLOPT_URL => 'https://api.mobitechtechnologies.com/sms/sendsms',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
      "mobile": "' . $phone_number . '",
      "response_type": "json",
      "sender_name": "23107",
      "service_id": 0,
      "message": "hey there Thank you for using his system test , no refund will be  provided ✌️"
  }',
        CURLOPT_HTTPHEADER => array(
            'h_api_key: 64284441ac3591da8e1e90ecfb8ee758631cb6e34b827c42947164e778828541',
            'Content-Type: application/json'
        ),
    )
);

$response = curl_exec($curl);


curl_close($curl);
if ($response) {
    echo 'Message sent successfully</br>';
    echo $phone_number;
} else {
    echo 'message not sent!';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="form-group">
            <span class="badge bg-success">Success</span>
            <button class="btn btn-primary btn-lg float-right" onclick="window.history.back();">Go Back</button>
            <script>
                alert('transaction successfull');
                // location.replace("./transactions.php");</script>
        </div>
    </div>

</body>

</html>
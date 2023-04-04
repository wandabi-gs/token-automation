<?php

# PHP example
$phone_number = "+254791958185";
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
    "message": "This is a message.\n\nRegards\nMobitech Technologies"
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

} else {
  echo 'message not sent!';
}

?>
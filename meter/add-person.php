<?php
session_start();
require($_SERVER["DOCUMENT_ROOT"] . "/db_connect.php");
$response = ["success" => true, "error" => ""];
if (is_authenticated()) {
    // $

    echo (json_encode($response));
}

?>
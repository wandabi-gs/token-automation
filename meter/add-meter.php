<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    require($_SERVER["DOCUMENT_ROOT"] . "/db_connect.php");
    $response = ["success" => true, "error" => ""];
    if (is_authenticated()) {
        $meter_number = htmlspecialchars($_POST["meter_number"]);
        $meter_type = htmlspecialchars($_POST["meter_type"]);
        $meterExistsQuery = $db_connect->query("SELECT meter_number FROM meter WHERE meter_number='{$meter_number}'");
        $meterExists = $meterExistsQuery->fetch(PDO::FETCH_ASSOC);

        if (empty($meterExists)) {
            try {
                $userQuery = $db_connect->query("SELECT id FROM user WHERE email='{$_SESSION["user"]["email"]}'");
                $meterUser = $userQuery->fetch(PDO::FETCH_ASSOC);

                $meter_uuid = generate_uuid($table = "meter", $uuid_field = "meter_id");

                if ($db_connect->exec("INSERT INTO meter(meter_id,meter_number,meter_type) VALUES('{$meter_uuid}','{$meter_number}','{$meter_type}')")) {
                    $inserted_meter_query = $db_connect->query("SELECT id FROM meter WHERE meter_number='{$meter_number}'");
                    $inserted_meter = $inserted_meter_query->fetch(PDO::FETCH_ASSOC);
                    $db_connect->exec("INSERT INTO user_meter(user_id,meter_id) VALUES('{$meterUser["id"]}','{$inserted_meter['id']}')");
                }
                $message = "Meter added successfully";
                $meterModalOpen = false;
            } catch (PDOException $pde) {
                $response["success"] = false;
                $response["error"] = "A problem occured please try again later" . $pde->getMessage();
            }
        } else {
            $response["success"] = false;
            $response["error"] = "This meter is already registered";
        }
        echo (json_encode($response));
    }
}
?>
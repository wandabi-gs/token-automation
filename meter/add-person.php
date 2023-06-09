<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    require($_SERVER["DOCUMENT_ROOT"] . "/db_connect.php");
    $response = ["success" => true, "error" => ""];
    if (is_authenticated()) {
        $email = htmlspecialchars($_POST["user_email"]);
        $meter_id = htmlspecialchars($_POST["meter_id"]);
        $user_exists = $db_connect->query("SELECT id FROM user WHERE email='{$email}'");
        if($user_exists->rowCount() === 0){
            $response["success"] = false;
            $response["error"] = "A user with the email is not registered";
        }else{
            $meter_exists = $db_connect->query("SELECT id FROM meter WHERE meter_id='{$meter_id}'");
            if($meter_exists->rowCount() === 0){
                $response["success"] = false;
                $response["error"] = "The specified meter is not registered";
            }else{
                $user = $user_exists->fetch(PDO::FETCH_ASSOC);
                $meter = $meter_exists->fetch(PDO::FETCH_ASSOC);

                $meter_user_exists = $db_connect->query("SELECT * FROM user_meter WHERE user_id='{$user["id"]}' AND meter_id='{$meter["id"]}'");
                if($meter_user_exists->rowCount()>0){
                    $response["success"] = false;
                    $response["error"] = "This user is already linked to this meter";
                }else{
                    try{
                        $db_connect->exec("INSERT INTO user_meter(user_id,meter_id) VALUES('{$user["id"]}','{$meter["id"]}')");
                    }catch(PDOException $pde){
                        $response["success"] = false;
                        $response["error"] = "An error occured, the user was not linked to this meter";
                    }
                }
            }
        }
        echo (json_encode($response));
    }
}
?>
<?php
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    require($_SERVER["DOCUMENT_ROOT"]."/db_connect.php");
    $response = ["success" => true,"error" => ""];
    $meter_id = htmlspecialchars($_POST["meter_id"]);

    $meter_query = $db_connect->query("SELECT meter_number FROM meter WHERE meter_id='{$meter_id}'");
    if($meter_query->rowCount()===0){
        $response["error"] = "The specified meter does not exist";
        $response["success"] = false;
    }else{
        try{
            $db_connect->exec("DELETE FROM meter WHERE meter_id='{$meter_id}'");
        }catch(PDOException $pde){
            $response["error"] = "An error occured, deletion not succesful";
            $response["success"] = false;
        }
    }

    echo(json_encode($response));
}
?>
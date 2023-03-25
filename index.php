<?php
require('./base/header.php');
?>

<div class="container bg-white shadow d-flex flex-row p-3">
    <div class="col-md-4">
        hello
        <?php ?>
    </div>
</div>

<?php

$metersQuery = $db_connect->query("SELECT meter.* FROM
meter INNER JOIN user_meter ON
meter.id=user_meter.meter_id INNER JOIN 
user ON user.id=user_meter.user_id WHERE 
user.email='{$_SESSION["user"]["email"]}'");
$meters = $metersQuery->fetchAll(PDO::FETCH_ASSOC);
foreach ($meters as &$meter) {
    $person_query = $db_connect->query("SELECT user.email,user.full_name FROM 
    user_meter INNER JOIN user ON user.id=user_meter.user_id WHERE user_meter.meter_id='{$meter['id']}'");
    $meter["users"] = $person_query->fetchAll(PDO::FETCH_ASSOC);
    // print_r($meter["users"]['email'] . $meter["meter_number"]);
}

// $values = array("Value 1", "Value 2", "Value 3");
// foreach ($values as $value) {
//     echo "<option value='$value'>$value</option>";
// }


include("./base/modals.php");


if (!is_authenticated()) {
    echo ("<script>window.location.replace('/auth/login.php');</script>");
}
require('./base/footer.php');
?>
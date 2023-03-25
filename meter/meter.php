<?php
require($_SERVER["DOCUMENT_ROOT"]."/base/header.php");
if(!isset($_GET["meter_id"])){
    echo('<script> window.location.replace("/meter/meters.php"); </script>');
}else{
    $meter_query = $db_connect->query("SELECT * FROM meter WHERE meter_id='{$_GET["meter_id"]}'");
    // $meter = $meter_query->
?>
    <div class="mx-2 bg-white shadow p-3">
    </div>
<?php
}
require($_SERVER["DOCUMENT_ROOT"]."/base/footer.php");
?>
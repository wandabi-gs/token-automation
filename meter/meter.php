<?php
require($_SERVER["DOCUMENT_ROOT"]."/base/header.php");
if(!isset($_GET["meter_id"])){
    echo('<script> window.location.replace("/meter/meters.php"); </script>');
}else{
    $meter_query = $db_connect->query("SELECT * FROM meter WHERE meter_id='{$_GET["meter_id"]}'");
    $meter = $meter_query->fetch(PDO::FETCH_ASSOC);

    $meter_person_query = $db_connect->query("SELECT user.* FROM user_meter INNER JOIN user ON user.id=user_meter.user_id WHERE user_meter.meter_id='{$meter['id']}' AND NOT user.id='{$_SESSION["user"]["id"]}'");
    $meter_person = $meter_person_query->fetchAll(PDO::FETCH_ASSOC);

    $transactions_query = $db_connect->query("SELECT transaction.*,user.email,user.full_name FROM transaction INNER JOIN user ON transaction.user_id=user.id WHERE transaction.meter_id='{$meter["id"]}'");
    $transactions = $transactions_query->fetchAll(PDO::FETCH_ASSOC);
?>
    <div class="mx-2 bg-white shadow p-3 row">
        <div class="col-lg-6 col-xs-11 pt-3">
            <div class="flex-column mx-2">
            <h5 class="mb-3">METER INFORMATION</h5>
            <hr>
            <div class="my-3">
                <span class="h6">METER NUMBER</span>
                <span class="ms-3">: <?php echo($meter["meter_number"]); ?></span>
            </div>
            <div class="my-3">
                <span class="h6">CURRENT TOKEN</span>
                <span class="ms-3">: <?php echo($meter["current_token"]); ?></span>
            </div>
            <div class="my-3">
                <span class="h6">LAST TOKEN</span>
                <span class="ms-3">: <?php echo($meter["last_token"]); ?></span>
            </div>
            <div class="mt-5">
                <h5>LINKED USERS</h5>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped table-hoverable">
                        <thead>
                            <th>FULL NAME</th><th>EMAIL</th><th>PHONE NUMBER</th><th>QUICK ACTIONS</th>
                        </thead>
                        <tbody>
                            <?php foreach($meter_person as $user){ ?>
                                <tr>
                                    <td><?php echo($user["full_name"]); ?></td>
                                    <td><?php echo($user["email"]); ?></td>
                                    <td><?php echo($user["phone_number"]); ?></td>
                                    <td><a href="JavaScript:void(0)" class="text-danger" onclick={UnlinkUser(<?php echo('"'.$user["id"].'"'); ?>)}>unlink user</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>

        <div class="col-lg-6 col-xs-11 pt-3">
            <div class="flex-column mx-2">
                <h5>Payment History</h5>
                <hr>
                <div class="table-responsive">
                    <table id="transactionsTable" class="table table-striped table-hoverable">
                        <thead>
                            <th>TRANSACTION ID</th><th>PAID BY</th><th>AMOUNT PAID</th><th>PAID ON</th>
                        </thead>
                        <tbody>
                            <?php foreach($transactions as $transaction){ ?>
                                <tr>
                                    <td><?php echo($transaction["transaction_id"]); ?></td>
                                    <td>
                                        <span><?php echo($transaction["full_name"]); ?></span> <br>
                                        <i><?php echo($transaction["email"]); ?></i>
                                    </td>
                                    <td><?php echo($transaction["amount"]); ?></td>
                                    <td><?php echo($transaction["created_at"]); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
}
require($_SERVER["DOCUMENT_ROOT"]."/base/footer.php");
?>
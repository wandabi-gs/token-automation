<?php
require('./base/header.php');

$transactionsQuery = $db_connect->query("SELECT transaction.* FROM transaction INNER JOIN meter ON transaction.meter_id=meter.id INNER JOIN user_meter ON meter.id=user_meter.meter_id INNER JOIN user on user_meter.user_id=user.id WHERE transaction.user_id='{$_SESSION["user"]["id"]}' ORDER BY transaction.created_at DESC LIMIT 5");
$transactions = $transactionsQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="mx-3 bg-white shadow d-flex flex-row p-3">
    <div class="col-xs-11 col-lg-6 pt-3">
        <div class="mx-3">
            <h5>Linked Meters</h5>
            <hr>
    <div class="my-3 p-2 bg-gray-400">
        <div class="d-flex flex-row justify-content-between">
            <button type="button" class="btn btn-success bg-green-800" data-bs-toggle="modal"
                data-bs-target="#addMeterModal">Add Meter</button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped" id="meters_table">
            <thead>
                <th>METER NUMBER</th>
                <th>METER TYPE</th>
                <th>REGISTERED ON</th>
                <th>CURRENT TOKEN</th>
            </thead>
            <tbody>
                <?php
                $index = 1;
                foreach ($meters as $meter) {
                    if($index <= 5){
                    ?>
                    <tr>
                        <td><?php echo ($meter["meter_number"]); ?></td>
                        <td><?php echo ($meter["meter_type"]); ?></td>
                        <td><?php echo ($meter["created_at"]); ?></td>
                        <td><?php echo ($meter["current_token"]); ?></td>
                    </tr>
                    <?php
                    $index += 1;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
        </div>
    </div>

    <div class="col-xs-11 col-lg-6 pt-3">
        <div class="mx-3">
            <h5>RECENT TRANSACTIONS</h5>
            <hr>
        <div class="table-responsive">
            <table class="table table-striped" id="transactionsTable">
                <thead>
                    <th>TRANSACTION ID</th>
                    <th>PAID ON</th>
                    <th>AMOUNT PAID</th>
                    <th>VAT (%)</th>
                </thead>
                <tbody>
                    <?php foreach($transactions as $transaction){ ?>
                        <tr>
                            <td><?php echo($transaction["transaction_id"]); ?></td>
                            <td><?php echo($transaction["created_at"]); ?></td>
                            <td><?php echo($transaction["amount"]); ?></td>
                            <td>16</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

<?php
if (!is_authenticated()) {
    echo ("<script>window.location.replace('/auth/login.php');</script>");
}
require('./base/footer.php');
?>
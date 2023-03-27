<?php
    require("../base/header.php");
    $transactionsQuery = $db_connect->query("SELECT transaction.* FROM transaction INNER JOIN meter ON transaction.meter_id=meter.id INNER JOIN user_meter ON meter.id=user_meter.meter_id INNER JOIN user on user_meter.user_id=user.id WHERE transaction.user_id='{$_SESSION["user"]["id"]}'");
    $transactions = $transactionsQuery->fetchAll(PDO::FETCH_ASSOC);
?>
    <div class="mx-3 bg-white shadow p-3 pt-0">
        <div class="my-3 p-2 d-flex flex-row bg-gray-400">
        </div>
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
<?php
    require("../base/footer.php");
?>
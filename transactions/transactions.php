<?php
    require("../base/header.php");
    $transactionsQuery = $db_connect->query("SELECT transaction.* FROM transaction INNER JOIN meter ON transaction.meter_id=meter.id INNER JOIN user_meter ON meter.id=user_meter.meter_id INNER JOIN user on user_meter.user_id=user.id WHERE user.email='{$_SESSION["user"]["email"]}'");
    $transactions = $transactionsQuery->fetchAll(PDO::FETCH_ASSOC);
?>
    <div class="container bg-white shadow p-3 pt-0">
        <div class="my-3 p-2 d-flex flex-row bg-gray-400">
        </div>
        <table class="table table-striped" id="transactionsTable">
            <thead>
                <th>NO</th>
                <th>PAID ON</th>
                <th>AMOUNT PAID</th>
                <th>VAT (%)</th>
                <th>TOKEN PRICE</th>
                <th>TOKEN AMOUNT</th>
                <th>TOTAL TOKEN</th>
            </thead>
            <tbody>
                <?php foreach($transactions as $transaction){ ?>
                    <tr>
                        <td><?php echo($transaction["transaction_id"]); ?></td>
                        <td><?php echo($transaction["created_at"]); ?></td>
                        <td><?php echo($transaction["amount"]); ?></td>
                        <td>16</td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function(){
            $("#transactionsTable").DataTable();
        })
    </script>
<?php
    require("../base/footer.php");
?>
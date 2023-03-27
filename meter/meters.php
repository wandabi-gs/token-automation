<?php
require($_SERVER["DOCUMENT_ROOT"]."/base/header.php");
?>
<div class="mx-3 bg-white shadow p-3 pt-0">
    <div class="my-3 p-2 bg-gray-400">
        <div class="d-flex flex-row justify-content-between">
            <button type="button" class="btn btn-success bg-green-800" data-bs-toggle="modal"
                data-bs-target="#addMeterModal">Add Meter</button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped" id="meters_table">
            <thead>
                <th>NO</th>
                <th>METER NUMBER</th>
                <th>USERS</th>
                <th>REGISTERED ON</th>
                <th>LAST TOKEN</th>
                <th>CURRENT TOKEN</th>
                <th>Quick Actions</th>
            </thead>
            <tbody>
                <?php
                $index = 1;
                foreach ($meters as $meter) {
                    ?>
                    <tr>
                        <td>
                            <?php echo ($index); ?>
                        </td>
                        <td>
                            <?php echo ($meter["meter_number"]); ?>
                        </td>
                        <td>
                            <?php foreach ($meter["users"] as $user) { ?>
                                <span class="h6 mb-2">
                                    <?php echo ($user["full_name"]); ?>
                                </span><br /><i>
                                    <?php echo ($user["email"]); ?>
                                </i><br />

                            <?php } ?>
                        </td>
                        <td>
                            <?php echo ($meter["created_at"]); ?>
                        </td>
                        <td>
                            <?php echo ($meter["meter_type"]); ?>
                        </td>
                        <td>
                            <?php echo ($meter["current_token"]); ?>
                        </td>
                        <td class="d-fle flex-row">
                            <a href="JavaScript:void(0)" onclick={DeleteMeter(<?php echo('"'.$meter["meter_id"].'"'); ?>)} class="mx-2 text-danger">Delete Meter</a>
                            <a href="/meter/meter.php?meter_id=<?php echo($meter["meter_id"]);?>" class="mx-2 text-secondary">View Meter</a>
                            <a href="JavaScript:void(0)" onclick={AddMeterPerson(<?php echo('"'.$meter["meter_id"].'"'); ?>)} class="mx-2 text-primary">Add Person</a>
                        </td>
                    </tr>
                    <?php
                    $index += 1;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
require($_SERVER["DOCUMENT_ROOT"]."/base/footer.php");
?>
    <div class="modal fade" id="addMeterModal">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="/meter/add-meter.php" method="post">
                <div class="modal-header">
                    <h4>Add Meter</h4>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-3 form-floating">
                        <input class="form-control" type="text" id="meter_number" value="<?php echo($saved_meter); ?>" name="meter_number" placeholder="" required/>
                        <label for="meter_number">Meter Number</label>
                        <div class="mt-1 text-danger">
                            <?php echo($meter_number_error); ?>
                        </div>
                    </div>

                    <div class="mt-3 form-floating">
                        <select name="meter_type" id="meter_type" class="form-select">
                            <option value="pre-paid">Pre Paid</option>
                            <option value="post-paid">Post Paid</option>
                        </select>
                        <label for="meter_type">Meter Type</label>
                        <div class="mt-1 text-danger">
                            <?php echo($meter_type_error); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button name="submit_meter" type="submit" class="btn btn-primary form-control">Add Meter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="addMeterPersonModal">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="/meter/add-person.php" method="post">
                <div class="modal-header">
                    <h4>Add Person</h4>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-3 form-floating">
                        <input class="form-control" type="email" id="user_email" value="<?php echo($saved_meter); ?>" name="user_email" placeholder="" required/>
                        <label for="user_email">User Email</label>
                        <div class="mt-1 text-danger">
                            <?php echo($user_email_error); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button name="submit_meter" type="submit" class="btn btn-primary form-control">Add Person</button>
                </div>
            </form>
        </div>
    </div>

    </body>
</html>
<?php 
    if(isset($meterModalOpen) && $meterModalOpen){
        echo('<script>$(document).ready(function(){$("#addMeterModal").modal("show");})</script>');
    } 
?>

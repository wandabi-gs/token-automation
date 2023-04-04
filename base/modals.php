<div class="modal fade" id="rechargeModal" tabindex="-1" role="dialog" aria-labelledby="rechargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rechargeModalLabel">Recharge Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="../transactions/payment.php">
                <div class="modal-body">
                    <!-- Input for phone number -->
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="number" class="form-control" id="phone_number" name="phone_number"
                            placeholder="Enter phone number : 2547123456"
                            value="<?php echo ($_SESSION["user"]["phone_number"]); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount"
                            required>
                    </div>
                    <!-- Drop-down selector for values from database -->
                    <div class="form-group">
                        <input type="text" value="<?php echo ($meter["meter_id"]); ?>" hidden name="meter_id">
                        <label for="value_from_db">select meter number</label>
                        <select class="form-control" id="value_from_db" name="meter_number" required>
                            <option value="" selected disabled>Select meter</option>
                            <?php foreach ($meters as $meter) { ?>
                                <option value="<?php echo ($meter["meter_number"]); ?>"> <?php echo ($meter["meter_type"] . " - " . $meter["meter_number"]); ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Button to submit the form -->
                    <button type="submit" class="btn btn-success" name="submit_pay">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addMeterModal">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" id="addMeterForm" action="/meter/add-meter.php">
            <div class="modal-header">
                <h4>Add Meter</h4>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="my-1 text-danger" id="add_meter_error"></div>
            <div class="modal-body">
                <div class="mt-3 form-floating">
                    <input class="form-control" type="text" id="meter_number" name="meter_number" placeholder=""
                        required />
                    <label for="meter_number">Meter Number</label>
                    <div class="mt-1 text-danger" id="meter_number_error">
                    </div>
                </div>

                <div class="mt-3 form-floating">
                    <select name="meter_type" id="meter_type" class="form-select">
                        <option value="pre-paid">Pre Paid</option>
                        <option value="post-paid">Post Paid</option>
                    </select>
                    <label for="meter_type">Meter Type</label>
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
        <form class="modal-content" action="/meter/add-person.php" id="addMeterPersonForm" method="post">
            <div class="modal-header">
                <h4>Add Person</h4>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="my-2">
                <span class="h6 ms-2">Meter Id : <span id="meter_persson_span_id"></span> </span>
            </div>
            <div id="add_meter_person_error" class="my-1 text-danger">
            </div>
            <div class="text-danger my-1 ps-2" id="add_meter_person_error"></div>
            <input name="meter_id" type="text" id="meter_person_id" hidden>
            <div class="modal-body">
                <div class="mt-3 form-floating">
                    <input class="form-control" type="email" id="user_email" name="user_email" placeholder=""
                        required />
                    <label for="user_email">User Email</label>
                </div>
            </div>
            <div class="modal-footer">
                <button name="submit_meter" type="submit" class="btn btn-primary form-control">Add Person</button>
            </div>
        </form>
    </div>
</div>
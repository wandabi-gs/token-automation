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
                            placeholder="Enter phone number : 2547123456" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount"
                            required>
                    </div>
                    <!-- Drop-down selector for values from database -->
                    <div class="form-group">
                        <label for="value_from_db">select meter number</label>
                        <select class="form-control" id="value_from_db" name="value_from_db" required>
                            <option value="" selected disabled>Select a value</option>
                            <?php
                            // $values = array("Value 1", "Value 2", "Value 3");
                            // foreach ($values as $value) {
                            //     echo "<option value='$value'>$value</option>";
                            // }
                            foreach ($meters as $meter) {
                                echo ("<option value='{$meter["meter_number"]}'>" . $meter["meter_number"] .
                                    "  " . $meter["meter_type"] . " </option>");
                            }
                            ?>
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
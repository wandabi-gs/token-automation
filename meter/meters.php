<?php
    require("../base/header.php");
    $metersQuery = $db_connect->query("SELECT meter.* FROM meter INNER JOIN user_meter ON meter.id=user_meter.meter_id INNER JOIN user ON user.id=user_meter.user_id WHERE user.email='{$_SESSION["user"]["email"]}'");
    $meters = $metersQuery->fetchAll(PDO::FETCH_ASSOC);
    foreach($meters as &$meter){
        $person_query = $db_connect->query("SELECT user.email,user.full_name FROM user_meter INNER JOIN user ON user.id=user_meter.user_id WHERE user_meter.meter_id='{$meter['id']}'");
        $meter["users"] = $person_query->fetchAll(PDO::FETCH_ASSOC);
        print_r($meter["users"]['email'].$meter["meter_number"]);
    }
    foreach($meters as $meter){
        echo("\n".$meter["meter_type"]);
    }
?>
    <div class="container bg-white shadow p-3 pt-0" id="prepaid_table">
        <div class="my-3 p-2 bg-gray-400">
            <div class="d-flex flex-row justify-content-between">
                <button type="button" class="btn btn-success bg-green-800" data-bs-toggle="modal" data-bs-target="#addMeterModal">Add Meter</button>
                <span class="h4">Pre Paid Meter(s)</span>
                <select>
                    <option>pre paid</option>
                    <option onclick="change_table('postpaid')">post paid</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
        <table class="table table-striped" id="pre_metersTable">
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
                    foreach($meters as $meter){
                        // if($meter["meter_type"] == "pre-paid"){
                ?>
                    <tr>
                        <td><?php echo($index); ?></td>
                        <td><?php echo($meter["meter_number"]); ?></td>
                        <td>
                        <?php foreach($meter["users"] as $user){ ?>
                            <span class="h6"><?php echo($user["full_name"]); ?></span>  - <i><?php echo($user["email"]); ?></i><br />
                        <?php } ?>
                        </td>
                        <td><?php echo($meter["created_at"]); ?></td>
                        <td><?php echo($meter["meter_type"]); ?></td>
                        <td><?php echo($meter["current_token"]); ?></td>
                        <td>
                            <a href="JavaScript:void(0)" class="mx-2 text-danger">Delete Meter</a>
                            <a href="JavaScript:void(0)" class="mx-2 text-primary">Add Person</a>
                        </td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        </div>
    </div>


    <div class="container bg-white shadow p-3 pt-0 hidden" id="postpaid_table">
        <div class="my-3 p-2 bg-gray-400">
            <div class="d-flex flex-row justify-content-between">
                <button type="button" class="btn btn-success bg-green-800" data-bs-toggle="modal" data-bs-target="#addMeterModal">Add Meter</button>
                <span class="h4">Post Paid Meter(s)</span>
                <select>
                    <option>post paid</option>
                    <option onclick="change_table('prepaid')">pre paid</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
        <table class="table table-striped" id="post_metersTable">
            <thead>
                <th>NO</th>
                <th>METER NUMBER</th>
                <th>REGISTERED ON</th>
                <th>LAST PAYMENT</th>
                <th>CURRENT BALANCE</th>
                <th>Quick Actions</th>
            </thead>
            <tbody>
                <?php
                    $index = 1;
                    foreach($meters as $meter){
                        if($meter["meter_type"] == "post-paid"){
                ?>
                    <tr>
                        <td><?php echo($index); ?></td>
                        <td><?php echo($meter["meter_number"]); ?></td>
                        <td><?php echo($meter["created_at"]); ?></td>
                        <td><?php echo($meter["last_token"]); ?></td>
                        <td><?php echo($meter["current_token"]); ?></td>
                    </tr>
                <?php
                    $index+=1;
                        }
                    }
                ?>
            </tbody>
        </table>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#pre_metersTable").DataTable();
            $("#post_metersTable").DataTable();
        });

        function change_table(type){
            if(type === "postpaid"){
                document.getElementById("prepaid_table").classList.add("hidden")
                document.getElementById("postpaid_table").classList.remove("hidden")
            }else{
                document.getElementById("postpaid_table").classList.add("hidden")
                document.getElementById("prepaid_table").classList.remove("hidden")
            }
        }
    </script>
<?php
    require("../base/footer.php");
?>
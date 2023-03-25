<script>
    
    function DeleteMeter(meter_id) {
        let formData = new FormData();
        formData.append("meter_id",meter_id);
        axios.post(
            "/meter/delete-meter.php",
            formData
        ).then(response => {
            if(response.data.success){
                alert("Meter has been deleted succesfully");
                window.location.reload();
            }else{
                alert(response.data.error);
            }
        })
    }

    function AddMeterPerson(meter_id){
        $(document).ready(function () {
            $("#meter_person_id").val(meter_id);
            $("#meter_persson_span_id").text(meter_id);
            $("#addMeterPersonModal").modal("show");
        })
    }

    $(document).ready(function () {
        $('#addMeterForm').on('submit', function (e) {
            e.preventDefault();
            const form = $('#addMeterForm');

            const formData = new FormData(form[0]);

            form.find(':input').each(function () {
                formData.append($(this).attr('name'), $(this).val());
            });

            axios.post(
                form.attr("action"),
                formData
            ).then(response => {
                if (response.data.success) {
                    $("#addMeterModal").modal("hide");
                    alert("Meter has been added succesfully");
                    window.location.reload()
                } else {
                    $("#add_meter_error").text(response.data.error);
                }
            });
        });

        $("#addMeterPersonForm").on("submit", function(e){
            e.preventDefault();
            const form = $('#addMeterPersonForm');

            const formData = new FormData(form[0]);

            form.find(':input').each(function () {
                formData.append($(this).attr('name'), $(this).val());
            });

            axios.post(
                form.attr("action"),
                formData
            ).then(response => {
                if (response.data.success) {
                    $("#addMeterPersonModal").modal("hide");
                    alert("User has been linked to the meter succesfully");
                    window.location.reload()
                } else {
                    $("#add_meter_person_error").text(response.data.error);
                }
            });
        })

        $("#meters_table").DataTable();
        $("#transactionsTable").DataTable();
    });
</script>
</body>

</html>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/base/modals.php");
if (isset($meterModalOpen) && $meterModalOpen) {
    echo ('<script>$(document).ready(function(){$("#addMeterModal").modal("show");})</script>');
}
?>
<?php
 require('./base/header.php');
?>

<div class="container bg-white shadow d-flex flex-row p-3">
    <div class="col-md-4">
        hello
    </div>
</div>

<?php

if(!is_authenticated()){
    echo("<script>window.location.replace('/auth/login.php');</script>");
}
 require('./base/footer.php');
?>
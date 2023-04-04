<?php
session_start();
require($_SERVER["DOCUMENT_ROOT"] . "/db_connect.php");

$meters_query = $db_connect->query("SELECT meter.*,user.* FROM meter JOIN
 user_meter ON meter.id = user_meter.meter_id JOIN user ON user_meter.user_id = '{$_SESSION["user"]["id"]}'");

// Create an array to store the meters and their associated users
$meters = array();

if ($meters_query->rowCount() > 0) {

    while ($row = $meters_query->fetch(PDO::FETCH_ASSOC)) {
        // If the meter doesn't already exist in the array, create an associative array for it
        if (!array_key_exists($row["meter_id"], $meters)) {
            $meters[$row["meter_id"]] = array(
                "meter_id" => $row["meter_id"],

                "meter_number" => $row["meter_number"],
                "meter_type" => $row["meter_type"],
                "current_token" => $row["current_token"],
                "last_token" => $row["last_token"],
                "created_at" => $row["created_at"],
                "users" => array()
            );
        }
        // Add the user to the meter's array of associated users
        $meters[$row["meter_id"]]["users"][] = array(
            "user_id" => $row["user_id"],
            "full_name" => $row["full_name"],
            "email" => $row["email"]
        );
    }
}


if (!is_authenticated()) {
    echo ("<script>window.location.replace('/auth/login.php');</script>");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">

    <script src="/assets/js/jquery-3.5.1.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/axios.min.js"></script>
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->

    <!-- jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> -->

    <!-- Bootstrap JavaScript -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->


    <style>
        input,
        button,
        textarea,
        select {
            box-shadow: none !important;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body class="bg-gray-200">
    <nav class="navbar navbar-dark navbar-expand-sm bg-primary mb-2">
        <div class="container-fluid">
            <button type="button" class="navbar-toggler shadow-none border-none text-white" data-bs-toggle="collapse"
                data-bs-target="#iturtlenavbar">
                <span class="navbar-toggler-icon border-none shadow-none"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="iturtlenavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/" class="nav-link text-white">Home</a>
                    </li>
                    <?php if (is_authenticated()) { ?>
                        <li class="nav-item">
                            <a href="/transactions/transactions.php" class="nav-link text-white">Transactions</a>
                        </li>
                        <li class="nav-item">
                            <a href="/meter/meters.php" class="nav-link text-white">Meters</a>
                        </li>
                        <li class="nav-item">
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#rechargeModal">Recharge</button>
                        </li>
                        <li class="nav-item">
                            <a href="/auth/logout.php" class="nav-link text-white">Logout</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a href="/auth/login.php" class="nav-link text-white">Login</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
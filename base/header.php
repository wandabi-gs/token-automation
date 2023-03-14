<?php
    session_start();
    require($_SERVER["DOCUMENT_ROOT"]."/db_connect.php");
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

    <style>
        input,button,textarea,select{
            box-shadow: none !important;
        }
        a{
            text-decoration: none;
        }
    </style>
</head>
<body class="bg-gray-200">
    <nav class="navbar navbar-dark navbar-expand-sm bg-primary mb-5">
        <div class="container-fluid">
            <button type="button" class="navbar-toggler shadow-none border-none text-white" data-bs-toggle="collapse" data-bs-target="#iturtlenavbar">
                <span class="navbar-toggler-icon border-none shadow-none"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="iturtlenavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/" class="nav-link text-white">Home</a>
                    </li>
                    <?php if(is_authenticated()){ ?>
                        <li class="nav-item">
                            <a href="/transactions/transactions.php" class="nav-link text-white">Transactions</a>
                        </li>
                        <li class="nav-item">
                            <a href="/meter/meters.php" class="nav-link text-white">Meters</a>
                        </li>
                        <li class="nav-item">
                            <a href="/auth/logout.php" class="nav-link text-white">Logout</a>
                        </li>
                    <?php }else{ ?>
                        <li class="nav-item">
                            <a href="/auth/login.php" class="nav-link text-white">Login</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
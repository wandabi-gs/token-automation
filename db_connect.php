<?php
$servername = "localhost";
$username = "lloyd";
$password = "1234";

try {
    $db_connect = new PDO("mysql:host=$servername;dbname=token", $username, $password);
    // set the PDO error mode to exception
    $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

function is_authenticated()
{
    if (empty($_SESSION["user"])) {
        return false;
    } else {
        return true;
    }
}

function generate_uuid($table, $uuid_field)
{
    global $db_connect;
    $uuid = "";
    while (true) {
        $uuid = vsprintf('%s%s-%s%s-%s%s-%s%s', str_split(bin2hex(random_bytes(16)), 4));
        $query_uuid_exists = $db_connect->query("SELECT {$uuid_field} FROM {$table} WHERE {$uuid_field}='{$uuid}'");
        if (empty($query_uuid_exists->fetch(PDO::FETCH_ASSOC))) {
            break;
        }
    }

    return $uuid;
}
?>
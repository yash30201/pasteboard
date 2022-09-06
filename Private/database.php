<?php
require_once('env.php');

function db_connect() {
    try {
        $connection = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (PDOException $err) {
        echo_pdo_error($err);
    }
}

function db_disconnect() {
    $connection = null;
}


function echo_pdo_error($err) {
    echo "Connection failed: " . $err->getMessage();
}

function confirm_result_set($sql, $err) {
    exit("<br />" . 'Database query failed for: ' . $sql . "<br /> Error messasge: " . $err->getMessage() . "<br />");
}
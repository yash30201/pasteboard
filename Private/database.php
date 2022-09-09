<?php

$dotenv = Dotenv\Dotenv::createImmutable(PROJECT_PATH);
$dotenv->load();

function db_connect()
{

    $instanceUnixSocket = $_ENV['INSTANCE_UNIX_SOCKET'];
    $db_name = $_ENV['SQL_DB_NAME'];
    $db_user = $_ENV['SQL_DB_USER'];
    $db_pass = $_ENV['SQL_DB_PASS'];
    $db_server = $_ENV['SQL_DB_SERVER'];
    if($instanceUnixSocket == 'local'){
        // This means we are running locally,
        // thus connecting using driver invocation
        $dsn = 'mysql:host=' . $db_server . ';dbname=' . $db_name;
    } else {
        // We are running in cloud run environment,
        // thus connecting using UNIX sockets
        $dsn = sprintf(
            'mysql:dbname=%s;unix_socket=%s',
            $db_name,
            $instanceUnixSocket
        );
    }


    try {
        $connection = new PDO($dsn, $db_user, $db_pass);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (TypeError $e) {
        throw new RuntimeException(
            sprintf(
                'Invalid or missing configuration! Make sure you have set ' .
                    '$username, $password, $dbName, ' .
                    'and $instanceUnixSocket (for UNIX socket mode). ' .
                    'The PHP error was %s',
                $e->getMessage()
            ),
            (int) $e->getCode(),
            $e
        );
    } catch (PDOException $err) {
        echo_pdo_error($err);
    }
}

function db_disconnect()
{
    $connection = null;
}


function echo_pdo_error($err)
{
    echo "Connection failed: " . $err->getMessage();
}

function confirm_result_set($sql, $err)
{
    exit("<br />" . 'Database query failed for: ' . $sql . "<br /> Error messasge: " . $err->getMessage() . "<br />");
}

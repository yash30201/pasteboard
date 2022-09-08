<?php
error_reporting(E_ALL ^ E_WARNING);
include_once('env.php');

function db_connect()
{
    // $instanceUnixSocket = '/cloudsql/yashsahu:asia-south1:pasteboard'; // e.g. '/cloudsql/project:region:instance'


    // If running in cloud run
    $instanceUnixSocket = getenv('INSTANCE_UNIX_SOCKET');
    $db_name = getenv('CLOUD_SQL_DB_NAME');
    $db_user = getenv('CLOUD_SQL_DB_USER');
    $db_pass = getenv('CLOUD_SQL_DB_PASS');

    // If running in local
    // $db_name = DB_NAME;
    // $db_user = DB_USER;
    // $db_pass = DB_PASS;
    // $db_server = DB_SERVER;

    // Connect using UNIX sockets
    $dsn = sprintf(
        'mysql:dbname=%s;unix_socket=%s',
        $db_name,
        $instanceUnixSocket
    );

    try {
        // $connection = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
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

<?php
require_once('env.php');

function db_connect()
{
    $instanceUnixSocket = '/cloudsql/yashsahu:asia-south1:pasteboard'; // e.g. '/cloudsql/project:region:instance'

    // Connect using UNIX sockets
    $dsn = sprintf(
        'mysql:dbname=%s;unix_socket=%s',
        DB_NAME,
        $instanceUnixSocket
    );

    try {
        // $connection = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $connection = new PDO($dsn, DB_USER, DB_PASS);
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

<?php
error_reporting(E_ALL);

$host = getenv('MARIADB_PORT_3306_TCP_ADDR');
$port = getenv('MARIADB_PORT_3306_TCP_PORT');

$dbh = new PDO('mysql:host='.$host.';port='.$port.';dbname=test', 'test', 'test');
echo $dbh->getAttribute( PDO::ATTR_DRIVER_NAME ) .' - '.$dbh->getAttribute(PDO::ATTR_CLIENT_VERSION). PHP_EOL;
$dbh->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );

$stmt = $dbh->query('SELECT *, floatField / intField AS calc FROM test_types', PDO::FETCH_ASSOC);
$row = $stmt->fetchAll();
var_dump($row);


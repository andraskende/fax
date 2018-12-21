<?php

$host = '...';
$dbName = '...';
$username = '...';
$password = '...';
$dbh = new PDO("mysql:host=".$host.";dbname=".$dbName, $username, $password);

$starddate = date('Y-m-d',  strtotime('-1 month'));

$sth = $dbh->prepare("DELETE FROM SystemEvents WHERE ReceivedAt < '" . $starddate ."'");
$results = $sth->execute();

$sth = $dbh->prepare("DELETE FROM xferfaxlogs WHERE timestamp < '" . $starddate ."'");
$results = $sth->execute();

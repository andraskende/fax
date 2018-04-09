<?php

header('Content-type: application/json');

$data = [];

$data['host'] = $_SERVER['HTTP_HOST'];

$out1 = array();
exec('uname -a', $out1);
$data['uname'] = print_r($out1[0], true);

$out2 = array();
exec('uptime', $out2);
$data['uptime'] = print_r($out2[0], true);

$faxstat = array();
exec('faxstat', $faxstat);

foreach ($faxstat as $key => $value) {
    $data['faxstat'][$key] = $value;
}

echo json_encode($data, JSON_PRETTY_PRINT);

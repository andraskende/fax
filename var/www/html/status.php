<?php

header('Content-type: application/json');

$data = [];

$data['host'] = $_SERVER['HTTP_HOST'];

$data['recvq'] =  (count(scandir('/var/spool/hylafax/recvq/')) - 2) . ' /var/spool/hylafax/recvq/';
$data['sendq'] =  (count(scandir('/var/spool/hylafax/sendq/')) - 2) . ' /var/spool/hylafax/sendq/';
$data['doneq'] =  (count(scandir('/var/spool/hylafax/doneq/')) - 2) . ' /var/spool/hylafax/doneq/';
$data['docq'] =  (count(scandir('/var/spool/hylafax/docq/')) - 2) . ' /var/spool/hylafax/docq/';
$data['log'] =  (count(scandir('/var/spool/hylafax/log/')) - 2) . ' /var/spool/hylafax/log/';

$out1 = array();
exec('uname -a', $out1);
$data['uname'] = print_r($out1[0], true);

$out2 = array();
exec('uptime', $out2);
$data['uptime'] = print_r($out2[0], true);

$out3 = array();
exec('date', $out3);
$data['date'] = print_r($out3[0], true);

$faxstat = array();
exec('faxstat', $faxstat);

foreach ($faxstat as $key => $value) {
    $data['faxstat'][$key] = $value;
}

echo json_encode($data, JSON_PRETTY_PRINT);

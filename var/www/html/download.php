<?php

// $file = preg_replace('/[^a-zA-Z0-9\._-]/', '', $_GET['file']);

$file = $_GET['file'];

$path = '/var/spool/hylafax/' . $file;

if (isset($file) && file_exists($path) ) {
    $size = filesize($path);
    $fp=fopen($path, 'rb');
    sleep(1);
    header('Pragma: private');
    header('Cache-control: private, must-revalidate');
    header('Content-type: application/octet-stream');
    header('Content-disposition: attachment; filename= ' . $file . '');
    header('Content-transfer-encoding: binary');
    header('Content-length: ' . $size . '');
    fpassthru($fp);
    fclose($fp);
    exit();
} else {
    echo 'No file with this name for download.';
}

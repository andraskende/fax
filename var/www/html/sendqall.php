<?php

$faxdirectory = '/var/spool/hylafax/sendq/';
$files = array_slice(scandir($faxdirectory), 2);

//print_r($files);

arsort($files);

foreach ($files as $file)
{
    $file = ltrim($file, 'q');
    echo "<a href='sendqdetail.php?id=" . $file . "'>" . $file . "</a><br />\r\n";
}

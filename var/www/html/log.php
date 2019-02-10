<?php

$faxdirectory = '/var/spool/hylafax/log/';
$files = array_slice(scandir($faxdirectory), 2);

arsort($files);

foreach ($files as $file)
{
    $file = ltrim($file, 'q');
    echo "<a href='logdetail.php?file=" . $file . "'>" . $file . "</a><br />\r\n";
}

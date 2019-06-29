<?php

$files = [];
$files1 = scandir('/faxtosend');

foreach($files1 as $file) {
    if(preg_match('/^[0-9]{11}/', $file)) {
        $files[] = $file;
    }
}

foreach ($files as $value) {

    // echo $value;
    // echo "\r\n";
    $faxfile = '/faxtosend/' . $value . '/done';
    echo $faxfile;
    echo "\r\n";

    if(is_dir($faxfile)) {
        echo $faxfile;
        rmdir($faxfile);
    }

    // if(!is_dir($faxfile)) {
    //     echo $faxfile;
    //     mkdir($faxfile);
    // }

}

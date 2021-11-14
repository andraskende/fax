<?php

$accounts = [];
$accounts1 = array_slice(scandir('/faxtosend'), 2);

foreach($accounts1 as $account1) {
    if(preg_match('/^[0-9]{11}/', $account1)) {
        $accounts[] = $account1;
    }
}

foreach ($accounts as $account) {

    $files = glob('/faxtosend/' . $account . '/*');
    $files =  preg_grep('/\.pdf$|\.tif$/i', $files);

    foreach ($files as $file) {

        echo basename($file);

        $fax = substr($account, 0, 11);

        $fs = filesize($file);


        $cmd = "sendfax -n -D -t 5 -T 15 -k 'now +2 days' -f amoreno@expressimagingservices.com -S 'EIS FAX' -i '" . $file . "' -d " . $fax . " '" . $file . "'";

        $response = system($cmd);

        if(!is_dir('/faxtosend/submitted/' . $account)) {
            @mkdir('/faxtosend/submitted/');
            @mkdir('/faxtosend/submitted/' . $account);
            @chmod('/faxtosend/submitted/' . $account, 0777);
        }

        rename($file, '/faxtosend/submitted/' . $account . '/' . basename($file));

        $data = date('Y-m-d H:i:s') . '|' . $fax . '|' . basename($file) . '|' . $fs . '|' . $account . "\r\n";
        $logfile = 'faxtosend-log-' . date('Ym') . '.txt';
        file_put_contents('/faxtosend/' .$logfile, $data, FILE_APPEND);

    }

}

<?php

if (!is_dir('/faxrequest/done/')) {
    mkdir('/faxrequest/done/', 0777);
    chmod('/faxrequest/done/', 0777);
}

$files = glob('/faxrequest/*.{pdf,tif}', GLOB_BRACE);
shuffle($files);
$files = array_slice($files, 0, 30);

foreach ($files as $file) {

    $fileName = basename($file);

    if(preg_match('/^[0-9]{11}-/', $fileName)) {

        $tmpfile = pathinfo($fileName, PATHINFO_FILENAME);

        $parts = preg_split('/[-]+/', $tmpfile, 3);

        $fax = $parts[0];

        $cmdstring = "sendfax -m -n -D -t 3 -T 12 -k 'now + 2 day' -S 'EIS FAX SERVER' -f pmeza@expressimagingservices.com -i '" . $file . "' -d " . $fax . " " . $file;

        $response = system($cmdstring);

        preg_match_all('/group id (.*)\) for host/', $response, $out);
        if(!empty($out[1][0])) {
            $output = $out[1][0];
        } else {
            $output = '';
        }

        rename($file, '/faxrequest/done/' . $fileName);

        $data = date('Y-m-d H:i:s') . '|' . $output . '|' . $fax . '|' . $fileName . '|' . $cmdstring . '|' .$response . "\r\n";
        $logfile = 'faxrequest-log-' . date('Ym') . '.txt';
        file_put_contents('/faxrequest/' .$logfile, $data, FILE_APPEND);

    }

}

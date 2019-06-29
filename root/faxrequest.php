<?php

$faxdirectory = '/faxrequest';
$faxdirectorydone = '/faxrequest/done';

$files = array_slice(scandir($faxdirectory), 2);

print_r($files);

if (!is_dir($faxdirectorydone)) {
    mkdir($faxdirectorydone, 0777);
    chmod($faxdirectorydone, 0777);
}

foreach ($files as $file) {

    if(preg_match('/^[0-9]{11}-/', $file)) {

        echo "\r\n";
        echo $file;
        echo "\r\n";

        $tmpfile = pathinfo($file, PATHINFO_FILENAME);

        $parts = preg_split("/[-]+/", $tmpfile, 3);

        $fax = $parts[0];

        $email = 'pmeza@expressimagingservices.com';

        $info = 'FAXREQUEST / ' . $tmpfile;

        $cmdstring = "sendfax -E -m -n -D -t 3 -T 12 -k 'now + 1 day' -S 'EIS FAX SERVER' -i '" . $info . "' -f " . $email . " -d " . $fax . " " . $faxdirectory . "/" . $file;
        echo $cmdstring;

        $response = system($cmdstring);

        preg_match_all('/group id (.*)\) for host/', $response, $out);
        if(!empty($out[1][0])) {
            $output = $out[1][0];
        } else {
            $output = '';
        }

        rename($faxdirectory . '/' . $file, $faxdirectorydone . '/' . $file);

        $data = date('Y-m-d H:i:s') . '|' . $output . '|' . $file . '|' . $fax . '|' . $email . '|' . $cmdstring . '|' . $output . '|' .$response . "\r\n";
        $logfile = 'faxrequest-fax-log-' . date('Ym') . '.txt';
        file_put_contents($faxdirectory . '/' .$logfile, $data, FILE_APPEND);

    }

}

echo "\r\n";

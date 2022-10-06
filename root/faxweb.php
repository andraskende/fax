<?php

if (!is_dir('/faxweb/done')) {
    mkdir('/faxweb/done', 0777);
    chmod('/faxweb/done', 0777);
}

$files = glob('/faxweb/*');
$files =  preg_grep('/\.pdf$|\.tif$/i', $files);

foreach ($files as $file) {

    $fileName = basename($file);

    echo $file . "\r\n";

    if(preg_match('/^[0-9]{11}-[a-zA-Z0-9]/', $fileName)) {

        $tmpfile = pathinfo($fileName, PATHINFO_FILENAME);

        $parts = preg_split('/[-]+/', $tmpfile, 3);

        $fax = $parts[0];
        $workorder = $parts[1];
        $email = $parts[2];

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $notification = '-D';

            $cmdstring = "sendfax -m -n -P 63 " . $notification . " -k 'now + 2 day' -S 'faxweb' -i '" . $file . "' -f " . $email . " -d " . $fax . " " . $file;
            echo $cmdstring;

            $response = system($cmdstring);

            preg_match_all('/group id (.*)\) for host/', $response, $out);
            if(!empty($out[1][0])) {
                $output = $out[1][0];
            } else {
                $output = '';
            }

            rename($file, '/faxweb/done/' . $fileName);

            $data = date('Y-m-d H:i:s') . '|' . $output . '|' . $file . '|' . $fax . '|' . $workorder. '|' . $email . '|' . $cmdstring . '|' . $output . '|' .$response . "\r\n";
            $logfile = 'faxweb-log-' . date('Ym') . '.txt';
            file_put_contents('/faxweb/' . $logfile, $data, FILE_APPEND);

        }

    }

}

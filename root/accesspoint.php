<?php

if (!is_dir('/accesspoint/done')) {
    mkdir('/accesspoint/done', 0777);
    chmod('/accesspoint/done', 0777);
}

$files = glob('/accesspoint/*.{pdf,tif}', GLOB_BRACE);
shuffle($files);

foreach ($files as $file) {

    $fileName = basename($file);

    if(preg_match('/^[0-9]{11}-[a-zA-Z0-9]/', $fileName)) {

        $tmpfile = pathinfo($fileName, PATHINFO_FILENAME);

        $parts = preg_split('/[-]+/', $tmpfile, 3);

        $fax = $parts[0];
        $workorder = $parts[1];
        $email = $parts[2];

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $nonotifications = [
                'tritonbg',
                'dempseyserves',
            ];

            $notification = '-D';
            foreach ($nonotifications as $nonotification) {
                if (strpos($email, $nonotification) !== false) {
                    $notification = '';
                }
            }

            $cmdstring = "sendfax -m -n -t 3 -P 63 -T 12 " . $notification . " -k 'now + 1 day' -S 'AP' -i '" . $file . "' -f " . $email . " -d " . $fax . " " . $file;
            echo $cmdstring;

            $response = system($cmdstring);

            preg_match_all('/group id (.*)\) for host/', $response, $out);
            if(!empty($out[1][0])) {
                $output = $out[1][0];
            } else {
                $output = '';
            }

            rename($file, '/accesspoint/done/' . $fileName);

            $data = date('Y-m-d H:i:s') . '|' . $output . '|' . $file . '|' . $fax . '|' . $workorder. '|' . $email . '|' . $cmdstring . '|' . $output . '|' .$response . "\r\n";
            $logfile = 'accesspoint-log-' . date('Ym') . '.txt';
            file_put_contents('/accesspoint/' . $logfile, $data, FILE_APPEND);

        }

    }

}

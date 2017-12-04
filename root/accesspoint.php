<?php

echo "\r\n";

$faxdirectory = '/accesspoint';
$faxdirectorydone = '/accesspoint/done';

$files = array_slice(scandir($faxdirectory), 2);

print_r($files);


if (!is_dir($faxdirectorydone)) {
    mkdir($faxdirectorydone, 0777);
    chmod($faxdirectorydone, 0777);
}

foreach ($files as $file) {

    if(preg_match('/^[0-9]{11}-[0-9]/', $file)) {

        echo "\r\n";
        echo $file;
        echo "\r\n";

        $tmpfile = pathinfo($file, PATHINFO_FILENAME);

        $parts = preg_split("/[-]+/", $tmpfile, 3);

        $fax = $parts[0];
        $workorder = $parts[1];
        $email = $parts[2];

        $info = 'ACCESSPOINT / ' . $workorder . ' / ' . $fax . ' / ' . $email . '';

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $nonotifications = array(
                'kende',
                'dempseyserves',
            );

            $notification = '-D';
            foreach ($nonotifications as $nonotification) {
                if (strpos($email, $nonotification) !== false) {
                    $notification = '';
                }
            }
            // −D Enable notification by electronic mail when the facsimile has been delivered. By default Hyla FAX will notify the submitter only if there is a problem with a job.

            $cmdstring = "sendfax -E -m -n -t 3 -T 12 " . $notification . " -k 'now + 1 day' -i '" . $info . "' -f " . $email . " -d " . $fax . " " . $faxdirectory . "/" . $file;
            echo $cmdstring;
            // die;

            $response = system($cmdstring);

            preg_match_all('/group id (.*)\) for host/', $response, $out);
            // print_r($out);
            if(!empty($out[1][0])) {
                $output = $out[1][0];
            } else {
                $output = '';
            }

            rename($faxdirectory . '/' . $file, $faxdirectorydone . '/' . $file);

            $data = date('Y-m-d H:i:s') . '|' . $output . '|' . $file . '|' . $fax . '|' . $workorder. '|' . $email . '|' . $cmdstring . '|' . $output . '|' .$response . "\r\n";
            file_put_contents($faxdirectory . '/logfile.txt', $data, FILE_APPEND);

        }

    }

}

echo "\r\n";

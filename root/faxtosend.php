<?php

$files = array();

if ($handle = opendir('/faxtosend/')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != '.' && $file != '..') {
            if(preg_match('/^[0-9]{11}/', $file)) {
                $files[] = $file;
            }
        }
    }
    closedir($handle);
}

// print_r($files);
// die;

foreach ($files as $value) {

    echo "\nDirectory: \n$value\n";

    if ($handle = opendir('/faxtosend/' . $value)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..' && $file != 'done') {

                $fax = substr($value, 0, 11);

                $fs = filesize('/faxtosend/' . $value . '/' . $file);

                echo "sendfax -E -n -D -k \"now + 2 days\" -f \"michael_dinio@ircopy.com\" -i ".$file." -d ".$fax." /faxtosend/".$value."/".$file."\n";

                system("sendfax -E -n -D -k \"now + 2 days\" -f \"michael_dinio@ircopy.com\" -i ".$file." -d ".$fax." /faxtosend/".$value."/".$file."");

                rename('/faxtosend/' . $value . '/' . $file, '/faxtosend/' . $value . '/done/' . $file);

                $c = explode('-', $value);
                $company = $c[1];

                $data = date('Y-m-d H:i:s') . '|' . $fax . '|' . $file . '|' . $fs . '|' . $company . '|' . $value . "\r\n";
                file_put_contents('/faxtosend/logfile.txt', $data, FILE_APPEND);

                //@mysql_connect("localhost", "root", "...");
                //@mysql_select_db("fax");
                //@mysql_query("INSERT INTO messages SET
                //filename='".$file."',
                //faxnumber='".$fax."',
                //company='".$company."',
                //filesize='".$fs."',
                //created='".$datenow."'
                //");

            }
        }
        closedir($handle);
    }

}

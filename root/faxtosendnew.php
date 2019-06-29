<?php

$files = [];
$files1 = scandir('/faxtosend');

foreach($files1 as $file) {
    if(preg_match('/^[0-9]{11}/', $file)) {
        $files[] = $file;
    }
}

foreach ($files as $value) {

    if ($handle = opendir('/faxtosend/' . $value)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..' && $file != 'done') {

                $fax = substr($value, 0, 11);

                $fs = filesize('/faxtosend/' . $value . '/' . $file);

                $info = 'FAXTOSEND/ ' . $file;

                $cmd = "sendfax -E -n -D -k 'now +2 days' -f amoreno@expressimagingservices.com -S 'EIS FAX' -i '" . $info . "' -d '" . $fax . "' /faxtosend/" . $value . "/" . $file . "";

                echo $cmd;

                $response = system($cmd);

                if(!is_dir('/faxtosend/submitted/' . $value)) {
                    @mkdir('/faxtosend/submitted/');
                    @mkdir('/faxtosend/submitted/' . $value);
                    @chmod('/faxtosend/submitted/' . $value, 0777);
                }

                rename('/faxtosend/' . $value . '/' . $file, '/faxtosend/submitted/' . $value . '/' . $file);

                $c = explode('-', $value);
                $company = $c[1];

                $data = date('Y-m-d H:i:s') . '|' . $fax . '|' . $file . '|' . $fs . '|' . $company . '|' . $value . "\r\n";
                $logfile = 'faxtosend-fax-log-' . date('Ym') . '.txt';
                file_put_contents('/faxtosend/' .$logfile, $data, FILE_APPEND);

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

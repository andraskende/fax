<?php

$faxdirectory = '/var/spool/hylafax/doneq/';

if(isset($_GET['term'])) {
    $term = $_GET['term'];
    $files = shell_exec("grep -l $term $faxdirectory*");
    $files = preg_split('/\s+/', trim($files));
} else {
    $term = null;
    $faxdirectory = '/var/spool/hylafax/doneq/';
    $files = array_slice(scandir($faxdirectory), 2);
    foreach ($files as $key => $value) {
        $files[$key] = $faxdirectory . $value;
    }
}

natcasesort($files);
$files = array_reverse($files);
$files = array_slice($files, 0, 1000);

?>

<!DOCTYPE html>
<html>
<head>
    <title>EIS</title>

    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/theme.bootstrap_4.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/css.css" />

    <script src="/js/jquery.tablesorter.min.js"></script>
    <script src="/js/jquery.tablesorter.widgets.min.js"></script>

    <script type="text/javascript">

        $(function() {
            $("#table").tablesorter({
                theme: "bootstrap",
                widgets: ["filter"]
            });
        });

    </script>

    <style type="text/css">
        .main {
            font-size: 95%;
        }
    </style>

</head>
<body>

<div class="content">

    <h1><?php echo $_SERVER['HTTP_HOST']; ?> send stats</h1>

    <form method="get" >
        <div class="row">
            <div class="col-3">
                <input name="term" class="form-control" value="<?php echo $term; ?>">
            </div>
            <div class="col-3">
                <button class="btn btn-primary">Search</button>
                <a href="stats.php" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <br />

    <table class="table table-striped table-bordered table-condensed table-sm table-hover tablesorter" id="table">
        <thead>
        <tr>
            <th>job / fax</th>
            <th>date</th>
            <th>kill date</th>
            <th>jobtag</th>
            <th>email</th>
            <th>number</th>
            <th>pages</th>
            <th>total dials / max dials</th>
            <th>total tries / max tries</th>
            <th>status</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($files as $file) : ?>
        <?php $c = file($file); ?>
        <?php $file = ltrim($file, "$faxdirectory*"); ?>
        <?php
            foreach ($c as $k => $v) {
                $value = substr($v, strpos($v, ':') + 1);
                $key = strtok($v, ':');
                $c[$key] = $value;
            }
            $rowclass = ($c['state'] != 7) ? 'bg-warning' : '';
            $doc = str_replace('0::' , '', $c['!postscript']);
        ?>
        <tr class="<?php echo $rowclass; ?>">
            <td>
                <a href="faxstat.php?id=<?php echo $file; ?>"><?php echo $file; ?></a>
                <br />
                <a href="download.php?file=<?php echo $doc; ?>"><?php echo $doc; ?></a>
            </td>
            <td><?php echo date('Y-m-d H:i:s', $c['tts']); ?></td>
            <td><?php echo date('Y-m-d H:i:s', $c['killtime']); ?></td>
            <td><small><?php echo $c['jobtag']; ?></small></td>
            <td><?php echo $c['mailaddr']; ?></td>
            <td><?php echo $c['number']; ?></td>
            <td><?php echo $c['npages']; ?></td>
            <td><?php echo $c['totdials']; ?> / <?php echo $c['maxdials']; ?></td>
            <td><?php echo $c['tottries']; ?> / <?php echo $c['maxtries']; ?></td>
            <td><?php echo $c['status']; ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>

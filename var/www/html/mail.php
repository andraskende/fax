<?php

$host = 'localhost';
$dbName = 'eis';
$username = 'root';
$password = '...';
$dbh = new PDO("mysql:host=".$host.";dbname=".$dbName, $username, $password);

$q = $_GET['q'];

$sth = $dbh->prepare("SELECT * FROM SystemEvents WHERE Message LIKE '%".$q."%' AND Message NOT LIKE '%daemon=MTA%' ORDER BY ReceivedAt DESC LIMIT 500");
$sth->execute();
$results = $sth->fetchAll(PDO::FETCH_ASSOC);
// print_r($results);

?>
<!DOCTYPE html>
<html>
<head>
    <title>EIS</title>

    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/css.css" />

    <script type="text/javascript">

        $(function() {
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

    <h1>sendmail stats</h1>

    <form method="get" >
    <div class="row">
        <div class="col-3">
            <input name="q" class="form-control" value="<?php echo $q; ?>">
        </div>
        <div class="col-3">
            <button class="btn btn-primary">Search</button>
            <a href="mail.php" class="btn btn-secondary">Reset</a>
        </div>
    </div>
    </form>

    <br />

    <table class="table table-striped table-bordered table-sm table-hover">
        <thead>
        <tr>
            <th>host</th>
            <th>date</th>
            <th>message</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $result) : ?>
        <tr>
            <td><?php echo $result['FromHost']; ?></td>
            <td><?php echo $result['ReceivedAt']; ?></td>
            <td><?php echo htmlspecialchars($result['Message']); ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>

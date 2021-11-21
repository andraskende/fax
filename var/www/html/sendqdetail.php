<html>

<body>

<h1><?php echo $_SERVER['HTTP_HOST']; ?></h1>

<a href="sendq.php">sendq</a> - <a href="sendqall.php">sendqall</a>

<br />

<pre>
<?php
if (!empty($_GET['id'])) {
    $job = (int) $_GET['id'];
    $file = file_get_contents('/var/spool/hylafax/sendq/q' . $job);
    print_r($file);
}
?>
</pre>

</body>

</html>
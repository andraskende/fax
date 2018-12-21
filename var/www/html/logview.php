<html>

<body>

<h1><?php echo $_SERVER['HTTP_HOST']; ?></h1>

<a href="log.php">fax jobs</a>

<br />

<pre>
<?php
if(!empty($_GET['file'])) {
$file = $_GET['file'];
$data = file_get_contents('/var/spool/hylafax/log/' . $file);
print_r($data);
}
?>
</pre>

</body>

</html>

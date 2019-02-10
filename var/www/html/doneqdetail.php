<html>

<body>

<h1><?php echo $_SERVER['HTTP_HOST']; ?></h1>

<a href="doneq.php">doneq</a> - <a href="doneqall.php">doneqall</a>

<br />

<pre>
<?php
if(!empty($_GET['id'])) {
$job = (integer) $_GET['id'];
$file = file_get_contents('/var/spool/hylafax/doneq/q' . $job);
print_r($file);
}
?>
</pre>

</body>

</html>

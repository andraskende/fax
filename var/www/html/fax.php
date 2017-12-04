<html>

<body>

<h3><?php echo $_SERVER['HTTP_HOST']; ?></h3>

<a href="stats.php" target="_blank">doneq stats</a>

<pre>
<?php
$out1 = array();
exec('lsb_release -a', $out1);
print_r($out1[1]);
?>

<?php
$out2 = array();
exec('uname -a', $out2);
print_r($out2[0]);
?>

<?php
$out3 = array();
exec('uptime', $out3);
print_r($out3[0]);
?>

<?php
$out4 = array();
exec('faxstat', $out4);
print_r($out4);
?>
</pre>

</body>

</html>

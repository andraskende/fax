<html>

<body>

<h3><?php echo $_SERVER['HTTP_HOST']; ?></h3>

<a href="doneq.php" target="_blank">doneq stats</a> -
<a href="sendq.php" target="_blank">sendq stats</a> -
<a href="log.php" target="_blank">log</a> -

<pre>
<?php
echo (count(scandir('/var/spool/hylafax/recvq/')) - 2) . ' /var/spool/hylafax/recvq/';
?>

<?php
echo (count(scandir('/var/spool/hylafax/sendq/')) - 2) . ' /var/spool/hylafax/sendq/';
?>

<?php
echo (count(scandir('/var/spool/hylafax/doneq/')) - 2) . ' /var/spool/hylafax/doneq/';
?>

<?php
echo (count(scandir('/var/spool/hylafax/docq/')) - 2) . ' /var/spool/hylafax/docq/';
?>

<?php
echo (count(scandir('/var/spool/hylafax/log/')) - 2) . ' /var/spool/hylafax/log/';
?>

<?php
$out1 = array();
exec('uname -a', $out1);
print_r($out1[0]);
?>

<?php
$out2 = array();
exec('uptime', $out2);
print_r($out2[0]);
?>

<?php
$out3 = array();
exec('faxstat', $out3);
print_r($out3);
?>
</pre>

</body>

</html>

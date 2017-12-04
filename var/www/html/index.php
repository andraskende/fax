<html>
<head>
<style>

body {
    padding: 10px;
    background: #CCC;
}

iframe {
    border: 1px #999 solid;
    background: #FFF;
}

</style>
</head>

<body>

<?php for($i = 1; $i <= 4; $i++) : ?>

<iframe height="300" width="100%" src="http://192.168.1.1<?php echo $i;?>/fax.php"></iframe>

<br />
<br />

<?php endfor; ?>



</body>

</html>

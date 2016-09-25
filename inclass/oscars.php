<!DOCTYPE html>
<html>
<head>
	<title>inclass1</title>
<body>
<p>hello
<?php
$filename = "oscars.txt";
$contents = file($filename);

foreach($contents as $line) {
    echo $line . "<br>";
}
?>
</p>
</body>
</html>

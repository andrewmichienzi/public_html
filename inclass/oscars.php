<!DOCTYPE html>
<html>
<head>
	<title>inclass1</title>
<body>
<p>
<?php
$filename = "oscars.txt";
$contents = file($filename);

$headings = ["Best Actor", "Best Picture", "Best Actress"];
foreach($contents as $line) {
	$line = trim($line);
	if(array_search($line, $heading)){
		echo "hello there";
		echo "<h3>". $line. "</h3>";
	}
	else if($line== null)
		echo "<br>";
	else
		echo "<p>".$line."</p>";

}
?>
</p>
</body>
</html>

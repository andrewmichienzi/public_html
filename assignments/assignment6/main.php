<!DOCTYPE html>
<html>
<head>
<title>Movies</title>
</head>
<script>
function getMovie(){
/*
	var urlGetMovie = 'http://ww.cis.gvsu.edu/~scrippsj/cs371/hw/hw07/getMovie.php?id=' + id;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if(this.readyState == 4 && this.status == 200) {
			document.getElementById("output").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", urlGetMovie, true);
	xmlhttp.send();*/
document.getElementById("output").innerHTML = "hello";
}

</script>

<?php
$urlGetTitles = 'http://www.cis.gvsu.edu/~scrippsj/cs371/hw/hw07/getTitles.php';
$urlGetMovie =  'http://www.cis.gvsu.edu/~scrippsj/cs371/hw/hw07/getMovie.php';

$id = $_REQUEST["movie"];

printMovieDropDown();
if($id)
{
	chooseMovie($id);
	return;
}

function printMovieDropDown()
{
	global $urlGetTitles;
	$json = getJsonData($urlGetTitles);

	$returnVal=' <h3>Movies:</h3> ';
	$returnVal.=' <p><form action="main.php" method="get"> ';
	$returnVal.=' <select name="movie"> ';
	
	$arraySize = sizeof($json);
	for($i = 0; $i < $arraySize;$i++)
	{
		$int = $i + 1;
		$returnVal.=' <option value="'.$int.'">'.$json[$i].'</option> ';
	}
	
	$returnVal .=' </select><br><br> ';
	$returnVal .=' <button type="submit">Submit</button> ';
	$returnVal .='</form></p>';

	echo $returnVal;
}
function chooseMovie($id)
{
	echo '<script>',
		'getMovie();',
		'</script>';
}

function getJsonData($url)
{	
	$data = file_get_contents($url);
	$json = json_decode($data, true);
	return $json;
}
?>
<body>
<p id="output"> </p>
</body>
</html>


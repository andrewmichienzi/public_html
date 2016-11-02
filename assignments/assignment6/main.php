<!DOCTYPE html>
<html>
<head>
<title>Movies</title>
</head>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
	function setOutput(id){
		var output = document.getElementById("output");
		var responseHTML;
		var urlGetMovie = 'http://www.cis.gvsu.edu/~scrippsj/cs371/hw/hw07/getMovie.php?id=' + id;
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
			if(this.readyState == 4 && this.status == 200) {
				//document.getElementById("output").innerHTML = this.responseText;
				var dummy = document.createElement( 'dummy' );
				dummy.innerHTML = this.response;
				output.innerHTML = dummy.innerText; //This gets the description
				var table = dummy.getElementsByTagName( "table" );
				output.innerHTML = table[0].outerHTML;	//This gets the table
				output.innerHTML = createTabs(dummy, output);
				$(" #tabs ").tabs();
			}
		};
		xmlhttp.open("GET", urlGetMovie, true);
		xmlhttp.send();
	}
	function createTabs(dummy, output)
	{
		var html = "<div id=\"tabs\"><ul>";
		html += "<li> <a href=\"#description\">Description</a> </li>";
		html += "<li> <a href=\"#cast\">Cast</a></li>";
		html += "</ul>";
		html += "<div id=\"description\">";
		html += dummy.innerText;
		html += "</div>";
		html += "<div id=\"cast\">";
		var table = dummy.getElementsByTagName( "table" );
		html += table[0].outerHTML;	//This gets the table
		html += "</div></div>";
		return html;
	}

</script>
<body>
<p id="dropdown">sup</p>
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
	$returnVal .='<p id="output"></p>';
	echo $returnVal;
}

function chooseMovie($id)
{
	global $urlGetMovie;
	$returnVal = '<script>setOutput('.$id.')</script>';
	echo $returnVal;
}

function getJsonData($url)
{	
	$data = file_get_contents($url);
	$json = json_decode($data, true);
	return $json;
}
?>
</body>
</html>


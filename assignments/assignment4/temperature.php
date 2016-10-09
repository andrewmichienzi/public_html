<?php
$year = $_REQUEST["year"];
$month = $_REQUEST["month"];
$type = $_REQUEST["type"];
$temp = $_REQUEST["temp"];
$filename = "temperatures.txt";
$content = file($filename);
$rValue = $type . $temp;
$total = 0;
$num = 0;
$tempToUse = 0;
if($type == "list")
	$rValue = "<table><tr><th>Month</th><th>Day</th><th>Year</th><th>Temp</th></tr>";
foreach($content as $line) {
	$pieces = explode(", ", $line);
	if ($pieces[3] == $year && ($pieces[1] == $month)){
		if($temp == "high")
			$tempToUse = $pieces[5];
		else if($temp == "low")
			$tempToUse = $pieces[6];
		else //$temp == "average"
			$tempToUse = $pieces[4];

		
		if($type == "average"){
			$total += $tempToUse;
			$num++;
		}
		else{ //$type == "list"
			$rValue .= "<tr><td>" . $pieces[1] . "</td><td>" . $pieces[2] . "</td><td>" . $pieces[3] . "</td><td>" . $tempToUse . "</td></tr>";
		}	
	}
	$lineNum++;
}

if($type == "average"){
	$averageTemp = $total / $num;
	$rValue = "Average temperature = " . $averageTemp;
}

else{
	$rValue .="</table>";
}
echo $rValue;
?>

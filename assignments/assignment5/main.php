<!DOCTYPE>
<html>
<head>
	<title>Assignment5</title>
</head>
<body>
		

<?php
$servername = "localhost";
$username = "michiena";
$password = "michiena6390";
$dbname = "michiena";


echo "hello there";
$conn = mysql_connect($servername, $username, $password);
if($conn->connection_error)
	die("Connection failed: " . $conn->connect_error);

mysql_select_db('michiena');
//createTable($conn);
insertTextField($conn);
/*
$sql = "Select * from Customer;";
	$retval = mysql_query($sql, $conn);
	if(! $retval )
	{
		die('could not get data ' . mysql_error());
	}
	
	//return $retval;
	//Read Result
	while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
	{
		echo "Customer Name :{$row['firstName']} <br> ";
	}
	echo"end";

*/
function insertTextField($conn){
	echo "insert Text Field<br>";

	$filename = "customers.txt";
	$contents = file($filename);
	echo $contents[1];
	$lineNumber = 0;
	$delim = ",";
	foreach ($contents as $line)
	{
		//echo "<p>".$line."</p>";
		if($lineNumber == 0)
		{
			$lineNumber++;
			continue;
		}
		$pieces = explode($delim, $line);
		
		$id = $pieces[0];
		$firstName = $pieces[1];
		$lastName = $pieces[2];
		$address = $pieces[3];
		$city = $pieces[4];
		$state = $pieces[5];
		$zip = $pieces[6];
		$creditCard = $pieces[7];
		$balance = $pieces[8];

		$sql = "INSERT INTO Customer (id, firstName, lastName, address, city, state, zip, creditCard, balance) VALUES ('".$id."', '".$firstName."', '".$lastName."', '".$address."', '".$city."', '".$state."', '".$zip."', '".$creditCard."', '".$balance."');";
		$retVal = mysql_query($sql, $conn);
		if(! $retVal){
			die('Could not get data ' . mysql_error()); 
		}
		$lineNumber++;
	} 	
}

?>
</body>
</html>

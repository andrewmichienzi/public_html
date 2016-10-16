<!DOCTYPE html>
<html>
<head>
	<title>Assignment5</title>
</head>
<body>
<div id="xml">
	<p> This is XML div </p>
</div>
		

<?php
$servername = "localhost";
$username = "michiena";
$password = "michiena6390";
$dbname = "michiena";


//echo "hello there";
$conn = mysql_connect($servername, $username, $password);
if($conn->connection_error)
	die("Connection failed: " . $conn->connect_error);

mysql_select_db('michiena');
createTable($conn);
insertTextField($conn);

$state = $_GET["state"];

echo $state;

$dom = new domDocument('1.0');
$dom->loadHTML($html);
$dom->preserveWhiteSpace = false;
$par = $dom->getElementById("xml");
if(! par)
{
	die('Element not found');	
}
echo "element found!";

$xml = createXML($conn, $state, $dom);
echo $xml;
function insertTextField($conn){
	//echo "insert Text Field<br>";

	$filename = "customers.txt";
	$contents = file($filename);
	//echo $contents[1];
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

function createTable($conn){
	$sql = "DROP TABLE Customer;";
	mysql_query($sql, $conn);
	$sql = "CREATE TABLE Customer (id INT NOT NULL, firstName varchar(25) NOT NULL, lastName varchar(25) NOT NULL, address int NOT NULL, city varchar(50) NOT NULL, state varchar(5) NOT NULL, zip int NOT NULL, creditCard int NOT NULL, balance decimal(18,2) NOT NULL);";
	$retval = mysql_query($sql, $conn);
	if(! $retval){
		die('Creating table issue' . mysql_error());
	}
}

function createXML($conn, $state, $dom)
{
	$sql = "SELECT * FROM Customer WHERE state = '".$state."';";
	$retval = mysql_query($sql, $conn);
	$root = $dom->createElement("Customers");
	$dom->appendChild($root);
	if(! $retval)
	{
		die('Trouble with select from state'.mysql_error());
	}
	while($row = mysql_fetch_assoc($retval))
	{
		$customer = $dom->createElement("Customer");
		$root->appendChild($customer);
		$id = $dom->createElement("id");
		$customer->appendChild($id);
		$idText = $dom->createTextNode($row["id"]);
		$id->appendChild($idText);
	}
	echo $dom->saveXML($dom->documentElement, LIBXML_NOEMPTYTAG);
}
?>


</body>
</html>

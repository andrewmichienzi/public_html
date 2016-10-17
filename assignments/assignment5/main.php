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

$dom = new domDocument('1.0');
$dom->formatOutput = true;


/*$par = $dom->getElementById("xml");
if(! par)
{
	die('Element not found');	
}
*/
$xml = createXML($conn, $state, $dom);
/*
$xmlDoc = new DOMDocument();
$xmlDoc->preserveWhiteSpace = false;
$xmlDoc->formatOutput = true;
$xmlDoc->loadXML( $xml );
echo $xmlDoc->saveXML();
*/

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
	$root = $dom->createElement("root");
	$dom->appendChild($root);
	if(! $retval)
	{
		die('Trouble with select from state'.mysql_error());
	}
	while($row = mysql_fetch_array($retval))
	{
		$customer = $dom->createElement("Customer");
		$root->appendChild($customer);
		$i = 0;
	/*	foreach($row as $element)
		{
			echo $element."<br>";
			$node = $dom->createElement(mysql_field_name($retval, $i));
			$customer->appendChild($node);
			$text = $dom->createTextNode($element);
			$node.appendChild($text);
			$i++;
		}
*/

		$id = $dom->createElement("id");
		$firstName = $dom->createElement("firstName");
		$lastName = $dom->createElement("lastName");
		$address = $dom->createElement("address");
		$city = $dom->createElement("city");
		$state = $dom->createElement("state");
		$zip = $dom->createElement("zip");
		$creditCard = $dom->createElement("creditCard");
		$balance = $dom->createElement("balance");
		$br = $dom->createElement("br");

		$customer->appendChild($id);
		$idText = $dom->createTextNode("ID: ".$row["id"]);
		$id->appendChild($idText);
		
		$customer->appendChild($br);	
		$br = $dom->createElement("br");

		$customer->appendChild($firstName);
		$firstNameText = $dom->createTextNode("First Name: ".$row["firstName"].", ");
		$firstName->appendChild($firstNameText);
		$customer->appendChild($br);	
		$br = $dom->createElement("br");

		$customer->appendChild($lastName);
		$lastNameText = $dom->createTextNode("Last Name: ".$row["lastName"]);
		$lastName->appendChild($lastNameText);

		$customer->appendChild($address);
		$addressText = $dom->createTextNode(trim("Address: ".$row["address"]));
		$address->appendChild($addressText);

		$customer->appendChild($city);
		$cityText = $dom->createTextNode("City: ".$row["city"]);
		$city->appendChild($cityText);
		$customer->appendChild($br);	
		$br = $dom->createElement("br");

		$customer->appendChild($state);
		$stateText = $dom->createTextNode("State: ".$row["state"]);
		$state->appendChild($stateText);
		$customer->appendChild($br);	
		$br = $dom->createElement("br");

		$customer->appendChild($zip);
		$zipText = $dom->createTextNode("State: ".$row["zip"]);
		$zip->appendChild($zipText);
		$customer->appendChild($br);	
		$br = $dom->createElement("br");

		$customer->appendChild($creditCard);
		$creditCardText = $dom->createTextNode("Credit Card: ".$row["creditCard"]);
		$creditCard->appendChild($creditCardText);
		$customer->appendChild($br);	
		$br = $dom->createElement("br");

		$customer->appendChild($balance);
		$balanceText = $dom->createTextNode("Balance: ".$row["balance"]);
		$balance->appendChild($balanceText);
		$customer->appendChild($br);	


		
/*

		$idText = $dom->createTextNode($row["id"]);
		$firstNameText = $dom->createTextNode($row["firstName");
		
		$id->appendChild($idText);
		$firstName->appendChild($firstNameText);
		
		$customer->appendChild($id);
		$customer->appendChild($firstName);

	/*
		$firstName = $dom->createElement("state");
		$customer->appendChild($firstName);
		$firstNameText = $dom->createTextNod($row[0]);
		$firstName->appendChild($firstNameText);
*/
	}
	$i = 0;
	foreach($root->childNodes as $customer){
		echo $dom->saveXML($customer);
		echo "<br><br>";
		$i++;
	}

}
?>



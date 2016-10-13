<!DOCTYPE>
<html>
<head>
	<title>assignmnet 5 php</title>
</head>
<body>
	<p>
		
	</p>
</head>

<?php
$servername = "localhost";
$username = "michiena";
$password = "michiena6390";
$dbname = "michiena";

echo "hello there";
$conn = mysql_connect($servername, $username, $password);
if($conn->connection_error)
	die("Connection failed: " . $conn->connect_error);
else
	echo "connection worked";

echo "hey";	
$sql = "SELECT * FROM Customer;";

mysql_select_db('michiena');
$retval = mysql_query($sql, $conn);
if(! $retval )
{
	die('could not get data ' . mysql_error());
}
while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
{
	echo "Customer Name :{$row['firstName']} <br> ";
}
echo"end";
$conn->close();	
?>

<?php
// Configuration
$dbhost = "localhost";
$dbuser = "michael";
$dbpass = "moldova";
$dbname = "chat";
$store_num = 10;
$display_num = 10;

// Script
error_reporting(E_ALL);

$dbconn = mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname,$dbconn);

foreach($_GET as $key => $value)
{
	$$key = mysql_real_escape_string($value, $dbconn);
}

$messages = mysql_query("SELECT description, type FROM statments WHERE statments.statmentId=$statmentId",$dbconn);

if(mysql_num_rows($messages) == 0) $status_code = 2;
else $status_code = 1;

echo "{";

echo '"status": "'.$status_code.'",';
echo '"time": "'.time().'"';
	
if($status_code == 1)
{
	while($message = mysql_fetch_assoc($messages))
	{
		$message['description'] = htmlspecialchars(stripslashes($message['description']));
		$rows[] = $message;
	}
	echo ', "statments":';
	echo json_encode($rows);
}
echo '}';
?>
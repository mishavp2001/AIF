<?php
// Configuration
$dbhost = "localhost";
$dbuser = "michael";
$dbpass = "moldova";
$dbname = "chat";
$store_num = 100;
$display_num = 100;

// Script
error_reporting(E_ALL);

$dbconn = mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname,$dbconn);

foreach($_GET as $key => $value)
{
	$$key = mysql_real_escape_string($value, $dbconn);
}

$statments = mysql_query("SELECT statmentId, user, statment, type
						 FROM statments
						 WHERE time>$time
						 and type like '$type'
						 ORDER BY statmentId ASC
						 LIMIT $count",$dbconn);
if(mysql_num_rows($statments) == 0) $status_code = 2;
else $status_code = 1;

echo "{";

echo '"status": "'.$status_code.'",';
echo '"time": "'.time().'"';
	
if($status_code == 1)
{
	while($statment = mysql_fetch_assoc($statments))
	{
		$statment['statment'] = htmlspecialchars(stripslashes($statment['statment']));
		$rows[] = $statment;
	
	}
	echo ',"statments":';
	echo json_encode($rows);
}
echo '}';
?>
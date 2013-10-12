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

$dbconn = mysql_connect($dbhost,$dbuser,$dbpass) or die ("Error connecting to mysql");
mysql_select_db($dbname,$dbconn);

foreach($_GET as $key => $value)
{
	$$key = mysql_real_escape_string($value, $dbconn);
}

if(@$action == "postmsg")
{
	
	mysql_query("INSERT INTO statments (`user`,`statment`, `description`, `time` )
				VALUES ('$user','$statment', '$description', ".time().")",$dbconn);
	
	$statmentId = mysql_insert_id(); 

	mysql_query("INSERT INTO debates (`statmentId`, `debateId`, `agree`, `time` )
				VALUES ('$statmentId','$debateId','$agree',".time().")",$dbconn);
	
}

$messages = mysql_query("SELECT user, statment, agree FROM debates, statments WHERE debates.time>$time and debates.statmentId=$statmentId and debates.statmentId=statments.statmentId LIMIT $display_num",$dbconn);

if(mysql_num_rows($messages) == 0) $status_code = 2;
else $status_code = 1;

echo "{";

echo '"status": "'.$status_code.'",';
echo '"time": "'.time().'"';
	
if($status_code == 1)
{
	while($message = mysql_fetch_assoc($messages))
	{
		$message['statment'] = htmlspecialchars(stripslashes($message['statment']));
		 $rows[] = $message;
	}
	echo ', "statments":';
	echo json_encode($rows);
}
echo '}';
?>
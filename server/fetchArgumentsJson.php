<?php
// Configuration
$dbhost = "localhost";
$dbuser = "michael";
$dbpass = "moldova";
$dbname = "chat";
$store_num = 10;
$display_num = 10;
$data = "";
$i=0;
// Script
error_reporting(E_ALL);

$dbconn = mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname,$dbconn);

foreach($_GET as $key => $value)
{
	$$key = mysql_real_escape_string($value, $dbconn);
}

$messages = mysql_query("SELECT debates.statmentId, user, statment, agree, type, weight, rate FROM debates, statments WHERE debates.time>$time and debates.debateId=$statmentId and debates.statmentId=statments.statmentId LIMIT $display_num",$dbconn);

if(mysql_num_rows($messages) == 0) $status_code = 2;
else $status_code = 1;

echo "{";

echo '"status": "'.$status_code.'",';
echo '"time": "'.time().'",';

echo '"data":[';
	
if($status_code == 1)
{
	while($row = mysql_fetch_assoc($messages)){
		$data ="";
		$data .= '
			{ 	"id": "'.$i.'",
				"user": "'.$row['user'].'",
				"statment": "'.$row['statment'].'",
				"rate": "'.$row['rate'].'",
				"weight": "'.$row['weight'].'",
				"type": "'.$row['type'].'",
				"statmentId": "'.$row['statmentId'].'"
			}';
		if ($i != mysql_num_rows($messages)-1) {
			$data .= ',';
		}
		echo $data;	
		$i++;
	}

	echo "]";
}
echo '}';
?>
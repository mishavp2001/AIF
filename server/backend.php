<?php
// Configuration
$dbhost = "localhost";
$dbuser = "michael";
$dbpass = "moldova";
$dbname = "chat";
$store_num = 10;
$display_num = 10;

// Script test 1111
error_reporting(E_ALL);

header("Content-type: text/xml");
header("Cache-Control: no-cache");

$dbconn = mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname,$dbconn);

foreach($_POST as $key => $value)
{
	$$key = mysql_real_escape_string($value, $dbconn);
}

if(@$action == "postmsg")
{
	mysql_query("INSERT INTO messages (`user`,`msg`, `agree`, `time` )
				VALUES ('$name','$message','$agree',".time().")",$dbconn);
	mysql_query("DELETE FROM messages WHERE id <= ".
				(mysql_insert_id($dbconn)-$store_num),$dbconn);
}

$messages = mysql_query("SELECT user,msg,agree
						 FROM messages
						 WHERE time>$time
						 ORDER BY id ASC
						 LIMIT $display_num",$dbconn);
if(mysql_num_rows($messages) == 0) $status_code = 2;
else $status_code = 1;

echo "<?xml version=\"1.0\"?>\n";
echo "<response>\n";
echo "\t<status>$status_code</status>\n";
echo "\t<time>".time()."</time>\n";
if($status_code == 1)
{
	while($message = mysql_fetch_array($messages))
	{
		$message['msg'] = htmlspecialchars(stripslashes($message['msg']));
		echo "\t<message>\n";
		echo "\t\t<author>$message[user]</author>\n";
		echo "\t\t<text>$message[msg]</text>\n";
		echo "\t\t<agree>$message[agree]</agree>\n";
		echo "\t</message>\n";
	}
}
echo "</response>";
?>
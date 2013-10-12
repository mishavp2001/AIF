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

if(@$action == "getNextStatmentId")
{
$messages = mysql_query("SELECT * FROM statments",$dbconn);
$nextID = mysql_num_rows($messages);

echo "{";
echo '"nextStatmentId": "'.$nextID.'"';
echo '}';


}
?>
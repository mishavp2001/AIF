

<?php
// Configuration
$dbhost = "localhost";
$dbuser = "michael";
$dbpass = "moldova";
$dbname = "chat";
$store_num = 10;
$display_num = 10;

$name = "misha";
$message = "test 32";


// Script
error_reporting(E_ALL);

$dbconn = mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname,$dbconn);

foreach($_POST as $key => $value)
{
	$$key = mysql_real_escape_string($value, $dbconn);
}
mysql_query("INSERT INTO messages (`user`,`msg`, `time` )
				VALUES ('$name','$message',".time().")",$dbconn);

?>

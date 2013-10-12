<?php
// Script
error_reporting(E_ALL);

$dbhost							= "localhost";
$dbuser							= "mvp";
$dbpass							= "moldova";
$dbname							= "af";

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Error connecting to mysql");
mysql_select_db($dbname) or die("Could not connect to MySQL");

?>
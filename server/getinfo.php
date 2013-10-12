<?php

// see if we have a GET variable 'id' set
$id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : 0;

// pretend this is a query to a database to fetch the wanted users.
$users[3] = array('name' => 'Dave', 'email' => 'dave@adeepersilence.be');
$users[4] = array('name' => 'Erik', 'email' => 'erik@bauffman.be');

// only if an ID was given and the key exists in the array, we continue
if(!empty($id) && key_exists($id, $users))
{
	// echo (not return) the wanted record from the users array
	echo json_encode($users[$id]);

}

?>
<?php
session_start();

require 'static_elements.php';

$db = new Database();
date_default_timezone_set('UTC');
$datecreated = date('m/d/Y h:i:s a', time());

if (!empty($_POST["friends"]))  $friendsids = $_POST["friends"];

foreach($friendsids as $friend)
{
	$temp1 = $db->prepare("INSERT INTO friends VALUES(:userid0,:userid1,0)");

	$temp1->bindValue(':userid0',$friend, SQLITE3_INTEGER);
	$temp1->bindValue(':userid1',$_SESSION['id'], SQLITE3_INTEGER);

	$temp1->execute();
	
	$temp1 = $db->prepare("INSERT INTO friends VALUES(:userid0,:userid1,0)");

	$temp1->bindValue(':userid1',$friend, SQLITE3_INTEGER);
	$temp1->bindValue(':userid0',$_SESSION['id'], SQLITE3_INTEGER);

	$temp1->execute();
	
	
	$usernotification="Hey there, ". $_SESSION['fullname']. " added you as a friend. You can see him in your friends category.";
			
	$temp = $db->prepare("INSERT INTO userupdates values(:message,:userid,:date)");
			
	$temp->bindValue(':userid',$friend, SQLITE3_INTEGER);
	$temp->bindValue(':message',$usernotification, SQLITE3_TEXT);
	$temp->bindValue(':date',$datecreated, SQLITE3_TEXT);
	
	$temp->execute();
}

echo json_encode(displayFriends());
?>
<?php
session_start();

require 'static_elements.php';

$db = new Database();
date_default_timezone_set('UTC');
$datecreated = date('m/d/Y h:i:s a', time());

if (!empty($_POST["friend"]))  $friendid = $_POST["friend"];

$temp = $db->prepare("DELETE FROM friends WHERE (userid0=:userid0 AND userid1=:userid1) OR (userid0=:userid1 AND userid1=:userid0)");

	$temp->bindValue(':userid0',$_SESSION['id'], SQLITE3_INTEGER);
	$temp->bindValue(':userid1',$friendid, SQLITE3_INTEGER);
		
$temp->execute();

$usernotification="Hey there, ". $_SESSION['fullname']. " decided you two need some space. He is no longer your friend.";
		
$temp = $db->prepare("INSERT INTO userupdates values(:message,:userid,:date)");
		
$temp->bindValue(':userid',$friendid, SQLITE3_INTEGER);
$temp->bindValue(':message',$usernotification, SQLITE3_TEXT);
$temp->bindValue(':date',$datecreated, SQLITE3_TEXT);

$temp->execute();

echo json_encode(displayFriends());
?>
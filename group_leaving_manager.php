<?php
session_start();

require 'dbconn.php';

$db = new Database();
date_default_timezone_set('UTC');
$datecreated = date('m/d/Y h:i:s a', time());

if (!empty($_POST["group"]))  $groupname = $_POST["group"];

$temp = $db->prepare("DELETE FROM groups WHERE userid=:userid AND groupname=:groupname");

	$temp->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
	$temp->bindValue(':groupname',$groupname, SQLITE3_TEXT);
		
$temp->execute();

$usernotification="You left the group ".$groupname.".";

$temp = $db->prepare("INSERT INTO userupdates values(:message,:userid,:date)");
		
$temp->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
$temp->bindValue(':message',$usernotification, SQLITE3_TEXT);
$temp->bindValue(':date',$datecreated, SQLITE3_TEXT);

$temp->execute();


$message='I left this group.';
			
$temp = $db->prepare("INSERT into updates values(:message,:groupname,:userid,:datecreated)");

$temp->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
$temp->bindValue(':groupname',$groupname, SQLITE3_TEXT);
$temp->bindValue(':message',$message, SQLITE3_TEXT);
$temp->bindValue(':datecreated',$datecreated, SQLITE3_TEXT);

$temp->execute();
?>
<?php
session_start();
require 'dbconn.php';
include 'group_updates_displayer.php';
include 'security.php';

		$db = new Database();
		$groupname='';
		$message='';
		
		date_default_timezone_set('UTC');
		$datecreated = date('m/d/Y h:i:s a', time());
		
		if (isset($_POST["groupname"]))  $groupname = prevent_XSS($_POST["groupname"]);
		if (isset($_POST["message"]))  $message = prevent_XSS($_POST["message"]);
		
		$temp = $db->prepare("INSERT into updates values(:message,:groupname,:userid,:datecreated)");
		
		$temp->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
		$temp->bindValue(':groupname',$groupname, SQLITE3_TEXT);
		$temp->bindValue(':message',$message, SQLITE3_TEXT);
		$temp->bindValue(':datecreated',$datecreated, SQLITE3_TEXT);

		$temp->execute();

 echo json_encode(displayUpdates($groupname));
 ?>
<?php
session_start();
require 'dbconn.php';
include 'group_updates_displayer.php';
include 'security.php';

		$db = new Database();
		$groupname='';
		$datecreated='';
		
		if (isset($_POST["groupname"]))  $groupname = prevent_XSS($_POST["groupname"]);
		if (isset($_POST["datecreated"]))  $datecreated = prevent_XSS($_POST["datecreated"]);
		
		$temp = $db->prepare("DELETE from updates where(userid='$_SESSION[id]' AND groupname=:groupname AND datecreated=:datecreated)");
		
		$temp->bindValue(':groupname',$groupname, SQLITE3_TEXT);
		$temp->bindValue(':datecreated',$datecreated, SQLITE3_TEXT);

		$temp->execute();

 echo json_encode(displayUpdates($groupname));
 ?>
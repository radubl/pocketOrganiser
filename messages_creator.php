<?php
session_start();

require 'static_elements.php';
require 'messages_functions.php';
require 'security.php';

$db = new Database();
date_default_timezone_set('UTC');
$datecreated = date('m/d/Y h:i:s a', time());

if (!empty($_POST["users"]))  $userids = $_POST["users"];
if (!empty($_POST["message"]))  $message = prevent_XSS($_POST["message"]);

$prettymessage1="<span class='checkbox-form' style='background-color:#cccdce; word-wrap: break-word; margin:10px; float:left; width:500px; font-size:20px;'>".$message."</span><br><br>";
$prettymessage2="<span class='checkbox-form' style='text-align:right; word-wrap: break-word; margin:10px; float:right; width:500px; font-size:20px;'>".$message."</span><br><br>";

foreach($userids as $friend)
{
	$temp1 = $db->prepare("INSERT INTO messages VALUES(:userid0,:userid1,:message)");

	$temp1->bindValue(':userid0',$friend, SQLITE3_INTEGER);
	$temp1->bindValue(':userid1',$_SESSION['id'], SQLITE3_INTEGER);
	$temp1->bindValue(':message',$prettymessage1, SQLITE3_TEXT);

	$temp1->execute();
	
	$temp1 = $db->prepare("INSERT INTO messages VALUES(:userid0,:userid1,:message)");

	$temp1->bindValue(':userid1',$friend, SQLITE3_INTEGER);
	$temp1->bindValue(':userid0',$_SESSION['id'], SQLITE3_INTEGER);
	$temp1->bindValue(':message',$prettymessage2, SQLITE3_TEXT);

	$temp1->execute();
	
	
	$usernotification="Hey there, ". $_SESSION['fullname']. " sent you a message. You can see it in your messages category.";
			
	$temp = $db->prepare("INSERT INTO userupdates values(:message,:userid,:date)");
			
	$temp->bindValue(':userid',$friend, SQLITE3_INTEGER);
	$temp->bindValue(':message',$usernotification, SQLITE3_TEXT);
	$temp->bindValue(':date',$datecreated, SQLITE3_TEXT);
	
	$temp->execute();
}

echo json_encode(displayMessagesMenu());
?>
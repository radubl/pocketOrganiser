<?php
session_start();

require 'static_elements.php';
require 'security.php';
require 'messages_functions.php';

$db = new Database();
date_default_timezone_set('UTC');
$datecreated = date('m/d/Y h:i:s a', time());
$message='';

if (!empty($_POST["user"]))  $userid = intval($_POST["user"]);
if (!empty($_POST["message"]))  $message = prevent_XSS($_POST["message"]);

if($message!='')
{
	$prettymessage1="<span class='checkbox-form' style='background-color:#cccdce; word-wrap: break-word; margin:10px; float:left; width:500px; font-size:20px;'>".$message."</span><br><br>";
	$prettymessage2="<span class='checkbox-form' style='text-align:right; word-wrap: break-word; margin:10px; float:right; width:500px; font-size:20px;'>".$message."</span><br><br>";

	$temp1 = $db->prepare("SELECT * from messages where userid0=:userid0 AND userid1=:userid1");

	$temp1->bindValue(':userid0',$userid, SQLITE3_INTEGER);
	$temp1->bindValue(':userid1',$_SESSION['id'], SQLITE3_INTEGER);

	$messagearray=$temp1->execute();

	while($msgrow=$messagearray->fetchArray()){

	$prettymessage1.=$msgrow['feed'];

	}

	$temp1 = $db->prepare("UPDATE messages set feed=:message where userid0=:userid0 and userid1=:userid1");

	$temp1->bindValue(':userid0',$userid, SQLITE3_INTEGER);
	$temp1->bindValue(':userid1',$_SESSION['id'], SQLITE3_INTEGER);
	$temp1->bindValue(':message',$prettymessage1, SQLITE3_TEXT);

	$temp1->execute();


	$temp1 = $db->prepare("SELECT * from messages where userid0=:userid0 AND userid1=:userid1");

	$temp1->bindValue(':userid1',$userid, SQLITE3_INTEGER);
	$temp1->bindValue(':userid0',$_SESSION['id'], SQLITE3_INTEGER);

	$messagearray=$temp1->execute();

	while($msgrow=$messagearray->fetchArray()){

	$prettymessage2.=$msgrow['feed'];

	}

	$temp1 = $db->prepare("UPDATE messages set feed=:message where userid0=:userid0 and userid1=:userid1");

	$temp1->bindValue(':userid1',$userid, SQLITE3_INTEGER);
	$temp1->bindValue(':userid0',$_SESSION['id'], SQLITE3_INTEGER);
	$temp1->bindValue(':message',$prettymessage2, SQLITE3_TEXT);

	$temp1->execute();

	//Send a notification to the recipient!

	$usernotification="Hey there, ". $_SESSION['fullname']. " sent you a message. You can see it in your messages category.";
			
	$temp = $db->prepare("INSERT INTO userupdates values(:message,:userid,:date)");
			
	$temp->bindValue(':userid',$userid, SQLITE3_INTEGER);
	$temp->bindValue(':message',$usernotification, SQLITE3_TEXT);
	$temp->bindValue(':date',$datecreated, SQLITE3_TEXT);

	$temp->execute();
}
// if($message=='') return json_encode('true');
// else
echo json_encode(displayMessagePage($userid));
?>
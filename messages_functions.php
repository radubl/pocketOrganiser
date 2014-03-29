<?php

function displayMessagePage($userid){

$db = new Database();
$output="<textarea id='updates' name='postings' rows='1' cols='100' style='margin-left:100px; width:500px;'>Write something here.</textarea>
<span id='shy' onClick='submitMessage(&#39;".$userid."&#39;)' 
 								style=' height: 35px; width:90px; font-size:15px; padding:7px; margin: 2px 0px 0px 10px;'>Update</span>"
 								;

$temp1 = $db->prepare("SELECT * FROM messages where userid0=:userid0 AND userid1=:userid1");

$temp1->bindValue(':userid0',$_SESSION["id"], SQLITE3_INTEGER);
$temp1->bindValue(':userid1',$userid, SQLITE3_INTEGER);

$feed=$temp1->execute();

while(($row = $feed->fetchArray())) {

$output.=$row['feed'];

}

return $output;
}

function displayMessagesMenu(){

$output=' <div style="font-size:30px; color:#575858; padding:10px; padding-top:20px;">Current messages</div>';

$db= new Database();

$temp = $db->prepare("SELECT * FROM messages inner join users on users.userid=messages.userid1 WHERE messages.userid0=:userid");

$temp->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);

$messages=$temp->execute();

$temp_friend='';

while(($userrow = $messages->fetchArray()))
{
$message=$userrow['feed'];
if($temp_friend!=$userrow['userid'])
{
	$temp_friend=$userrow['userid'];
	$output.="<span class='messagers' onClick='showMessages(&#39;".$temp_friend."&#39;)' id='msg".$temp_friend."'>".$userrow['fullname']."</span><br>";
}
else
{
	$temp = $db->prepare("DELETE FROM messages WHERE (userid0=:userid0 AND userid1=:userid1) OR (userid0=:userid1 AND userid1=:userid0)");

		$temp->bindValue(':userid0',$_SESSION['id'], SQLITE3_INTEGER);
		$temp->bindValue(':userid1',$temp_friend, SQLITE3_INTEGER);
		
	$temp->execute();

	$temp1 = $db->prepare("INSERT INTO messages VALUES(:userid0,:userid1,'')");

		$temp1->bindValue(':userid0',$temp_friend, SQLITE3_INTEGER);
		$temp1->bindValue(':userid1',$_SESSION['id'], SQLITE3_INTEGER);

	$temp1->execute();
}
$temp_friend=$userrow['userid'];
}
$output.="<span id='shy' onClick='backToNewMessage()' 
 	style=' height: 35px; width:150px; font-size:15px; padding:7px; margin: 2px 0px 0px 10px;'>New Message</span>";
return $output;

}



?>

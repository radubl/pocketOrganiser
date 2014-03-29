<?php

function getGroups($group){

$form ='<div style="height:1px;"></div>
	<div style="float:right; border-left: 1px solid #cccdce; background-color:white; ">'. displayGroupUsers($group).
	'<div id="shy" onClick="leaveGroup(&#39;'.$group.'&#39;)"  
	style=" font-size:15px; margin-left:15px; margin-top:15px; width:150px;">Leave This Group</div></div>';
		
return $form;


}

function displayGroupUsers($groupname){

$output='<div style="font-size:30px; color:#575858; padding:10px; padding-top:20px; ">Current Members</div>';

$db= new Database();

$temp = $db->prepare("SELECT * FROM users inner join groups on users.userid=groups.userid WHERE groups.groupname=:groupname ORDER BY userid");

$temp->bindValue(':groupname',$groupname, SQLITE3_TEXT);

$friends=$temp->execute();

$temp_friend='';

while(($userrow = $friends->fetchArray()))
{

if($temp_friend!=$userrow['userid'])
	$output.='<span class="friends" style="color:'.$userrow['usercolor'].';">'.$userrow['fullname'].'</span><br>';
else
{
	$temp = $db->prepare("DELETE FROM groups WHERE userid=:userid AND groupname=:groupname");

		$temp->bindValue(':userid',$temp_friend, SQLITE3_INTEGER);
		$temp->bindValue(':groupname',$groupname, SQLITE3_TEXT);
		
	$temp->execute();

	$temp1 = $db->prepare("INSERT INTO groups VALUES(:groupname,:userid,:description)");

		$temp1->bindValue(':userid',$temp_friend, SQLITE3_INTEGER);
		$temp1->bindValue(':groupname',$groupname, SQLITE3_TEXT);
		$temp1->bindValue(':description',$userrow['description'], SQLITE3_TEXT);

	$temp1->execute();

}
$temp_friend=$userrow['userid'];
}

return $output;

}
?>

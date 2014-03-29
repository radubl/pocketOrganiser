<?php

function getDates(){
$output='';
$i=0;
for($i=0;$i<31;$i++)
{
	date_default_timezone_set('Europe/London');
	
	$rawdate = new DateTime(date('m/d/Y ', time()));
	$modifier='P'.$i.'D';
	$rawdate->add(new DateInterval($modifier));
	$actualdate=$rawdate->format('m/d/Y ');
	$outputdate=$rawdate->format('dS') . " of " . $rawdate->format('F');
	
	$output.='<option value="'. $actualdate .'">'.$outputdate.'</option>';
}
return $output;
}

function getHours(){
$output='';
$i=0;
for($i=0;$i<24;$i++)
{
	$hour=' '.$i.':00';
	$output.='<option value="'. $hour .'">'.$hour.'</option>';
}
return $output;
}

function getCategories(){

$db = new Database();
$output='<option value="Existing">(Choose Existing)</option>';
$temp='';

$temp1 = $db->prepare("SELECT * FROM categories inner join lists on lists.category=categories.category where (lists.userid=:userid) ORDER BY lists.category");

$temp1->bindValue(':userid',$_SESSION[id], SQLITE3_INTEGER);

$categories=$temp1->execute();


while(($catrow = $categories->fetchArray())) {

	if($temp!=$catrow['category'])
	{
		$temp=$catrow['category'];
		
		$output.='<option value="'. $catrow['category'] .'">'.$catrow['category'].'</option>';

	}
}

return $output;
}

function getListsNames(){

$db = new Database();
$output='<option value="Existing">(Choose Existing)</option>';

$temp1 = $db->prepare("SELECT * FROM lists inner join listitems on lists.listid=listitems.listid where lists.userid=:userid AND listitems.completed=0 AND
	      listitems.userid=:userid order by lists.listid");

$temp1->bindValue(':userid',$_SESSION["id"], SQLITE3_INTEGER);

$lists=$temp1->execute();

$temp='';

while(($listrow = $lists->fetchArray())) {

      if($temp!=$listrow['listname'])
      
		$output.='<option value="'. $listrow['listname'] .'">'.$listrow['listname'].'</option>';

      $temp = $listrow['listname'];
      
}
return $output;
}


function getGroupNames(){

$db = new Database();
$output='<option value="Existing">(Choose Existing)</option>';

$temp1 = $db->prepare("SELECT * FROM groups where userid=:userid");

$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);

$groups=$temp1->execute();

while(($grouprow = $groups->fetchArray())) {
	$output.='<option value="'. $grouprow['groupname'] .'">'.$grouprow['groupname'].'</option>';
}
return $output;
}

function displayFriendsToAdd(){
$form = "
			<div class = 'checkbox-item'>Select Friends to add:</div><br><br>";
			
			$db= new Database();

			$temp = $db->prepare("SELECT * FROM friends inner join users on users.userid=friends.userid1 where userid0=:userid");

			$temp->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);

			$userfriends=$temp->execute();
			$newuserid=0;
			
			while(($userrow = $userfriends->fetchArray())) 
				if($userrow['userid']!=$_SESSION['id'])
					{	
						$newuserid++;
						$form .="<span class='friends-items'><input type='checkbox' class='regular-checkbox' value='" .$userrow['userid'] ."' name='groupUsers[]'>
						<span class='checkbox-item'>" .$userrow['fullname'] ." </span></span>";
					}
					
			if($newuserid==0) $form = "<span style='color:red;  class = 'list-title';'>You have no friends.</span>";
echo $form; 
}

function getMembersSplit($groupname){
$output='';

$db= new Database();

$temp = $db->prepare("SELECT * FROM users inner join groups on users.userid=groups.userid WHERE groups.groupname=:groupname ORDER BY userid");

$temp->bindValue(':groupname',$groupname, SQLITE3_TEXT);

$friends=$temp->execute();

$temp_friend='';

while(($userrow = $friends->fetchArray()))
{

if($temp_friend!=$userrow['userid'])
	$output.='<span class="friends">'.$userrow['fullname'].'</span>'
	. "<input class='percentage' style='margin-top:10px; width:50px; float:left;' value='0'><br>";
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

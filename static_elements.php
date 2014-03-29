<?php

require 'dbconn.php';


function getHeader($title){

$header = "<div style='background-color:#023480; height:80px;'>
		<a href='dashboard.php'><span id='login'>".$_SESSION['fullname']."</span></a>
		<a href='profile.php'><span id='profile'></span></a>
		<a href='messages.php'><span id='messages'></span></a>
		<a href='friends.php'><span id='friends'></span></a>
		<a href='logout_manager.php'><span id='logout'></Span></a>
		<div id='title' style='width:500px;'>
			".$title."
		</div>";
return $header;
}

function getHeaderBottom(){

$header=" <a href='dashboard.php'><div id='ex3'>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ToDoMe, The Mighty Application.
		<div id='logo'>
			<img src='logo3.png' alt='Smiley face' height='110' width='115'>
		</div>
	</div></a>".

'<div id=header-bottom>
				<a href="group_manager.php"><div class="menu-item">
				<div class="menu-head"> Manage Groups </div>
				<div class="menu-desc"> create & delete groups </div>
				</div></a>
				
				<a href="list_manager.php"><div class="menu-item">
				 <div class="menu-head"> Manage Lists </div>
				<div class="menu-desc"> add & remove lists </div>
				</div></a>				
	</div>';
return $header;
}
function getSideMenu($modifier){
$modifier = "'".$modifier."'";
$menu = "
<div style=".$modifier. " id='side-menu-container'> 
		
	<ul class='side-menu-container' style='list-style-type: none;'><br>
	
			<span class='fix'></span>
			
		<div id='hider_wrapper2'>
			<div id='go_over2'><li class='side-menu-item' id='2' >&nbsp;Bill<br>Splitter</li></div>
				<div id='hideable2' >
					<ul class='lower-side-menu-container' style='list-style-type: none;'>"
					. getGroupsMenu() ."
					</ul>	
				</div>
		</div>	
	

	
		<br>
		
		<div id='hider_wrapper'>
			<div id='go_over'><li class='side-menu-item' id='1' >To-Do <br>Lister</li></div>
				<div id='hideable' >
					<ul class='lower-side-menu-container' style='list-style-type: none;'>"
					. getCategoriesMenu() ."
					</ul>	
				</div>
		</div>
	</ul>
		
</div>";


return $menu;

}

function getCategoriesMenu(){
	$output='';

	$db = new Database();

	$temp = $db->prepare("SELECT * FROM categories inner join lists on lists.category=categories.category where (lists.userid=:userid) ORDER BY lists.category");

	$temp->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);

 	$cats = $temp->execute();

	while(($catrow = $cats->fetchArray())) {
	
		if($temp!=$catrow['category'])
		{
			$temp=$catrow['category'];
			
			if(strlen($temp)>9)
			{
				$temp=substr($temp,0,9). '-<br>' . substr($temp,9);
			}
			$output.='<a href="lists.php?category='.$catrow['category'].'"><li class=lesser-menu-item >'.$temp.'</li></a></span>';
		}
	}
	return $output;
}

function getGroupsMenu(){
	$output='';

	$db = new Database();

	$temp = $db->prepare("SELECT * FROM groups where userid=:userid ORDER BY groupname");

	$temp->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);

 	$groups = $temp->execute();

	while(($groupsrow = $groups->fetchArray())) {
	
		if($temp!=$groupsrow['groupname'])
		{
			$temp=$groupsrow['groupname'];
			
			if(strlen($temp)>9)
			{
				$temp=substr($temp,0,9). '-<br>' . substr($temp,9);
			}
			$output.='<a href="groups.php?group='.$groupsrow['groupname'].'">
			<li class=lesser-menu-item >'.$groupsrow['groupname'].'</li></a></span>';
		}
	}
	return $output;
}

function displayFriends(){

$output=' <div style="font-size:30px; color:#575858; padding:10px; padding-top:20px;">Current friends</div>';

$db= new Database();

$temp = $db->prepare("SELECT * FROM friends inner join users on users.userid=friends.userid1 WHERE friends.userid0=:userid ORDER BY friends.userid1");

$temp->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);

$friends=$temp->execute();

$temp_friend='';

while(($userrow = $friends->fetchArray()))
{

$oldbalance=$userrow['balance'];

if($temp_friend!=$userrow['userid'])

	$output.="<span class='delete_friends' onclick='deleteFriend(&#39;".$userrow['userid']."&#39;)'></span>
	<span class='friends'>".$userrow['fullname']."</span><br>";
else
{
	$temp = $db->prepare("DELETE FROM friends WHERE (userid0=:userid0 AND userid1=:userid1) OR (userid0=:userid1 AND userid1=:userid0)");

		$temp->bindValue(':userid0',$_SESSION['id'], SQLITE3_INTEGER);
		$temp->bindValue(':userid1',$temp_friend, SQLITE3_INTEGER);
		
	$temp->execute();

	$temp1 = $db->prepare("INSERT INTO friends VALUES(:userid0,:userid1,'$oldbalance')");

		$temp1->bindValue(':userid0',$temp_friend, SQLITE3_INTEGER);
		$temp1->bindValue(':userid1',$_SESSION['id'], SQLITE3_INTEGER);

	$temp1->execute();
	
	$temp1 = $db->prepare("INSERT INTO friends VALUES(:userid0,:userid1,'$oldbalance')");

		$temp1->bindValue(':userid1',$temp_friend, SQLITE3_INTEGER);
		$temp1->bindValue(':userid0',$_SESSION['id'], SQLITE3_INTEGER);

	$temp1->execute();
}
$temp_friend=$userrow['userid'];
}

return $output;

}
?>
<?php 
session_start();

require 'dbconn.php';
require 'security.php';

$newfullname="ersfdhfdjddgsgdfsgfsdfgdsfsss";


if (isset($_POST["fullname"]))
				if (!empty($_POST["fullname"]))  $newfullname = prevent_XSS($_POST["fullname"]);
				
		$db = new Database();
		
		$form='';
		
		$uniqueusername=true;
		$newuserid=0;
			
		if(!($newfullname=="ersfdhfdjddgsgdfsgfsdfgdsfsss"))
		{
			$form .= "<form method='post' id='group-form' style='float:left; width: 710px; margin:20px 0px 0px 100px;'>
			<div class = 'list-title'>Select the names of your friends:<br><br>";
			
			$db= new Database();

			$temp = $db->prepare("SELECT * FROM users where fullname LIKE :fullname");

			$temp->bindValue(':fullname','%'.$newfullname.'%', SQLITE3_TEXT);

			$userfriends=$temp->execute();
			
			while(($userrow = $userfriends->fetchArray())) 
				if($userrow['userid']!=$_SESSION['id'])
					{	
						$newuserid++;
						$form .="<input type='checkbox' class='regular-checkbox' value='" .$userrow['userid'] ."' name='friends[]'>
						<span class='checkbox-item'>" .$userrow['fullname'] ." </span> <br>";
					}
					
			if($newuserid!=0)$form .="<div id='shy' style='margin-left:10px;' onclick='addFriends()' >Add</div></form> ";
			else $form = "<br><br><br><br><br><br><span style='color:red;  font-family:'Varela Round';'>No users found.</span>";
		}
echo json_encode($form);
?>
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
			$form .= "<form method='post' id='group-form' style='float:left; position:relative; width: 600px; margin:20px 0px 0px 100px;'>
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
			
			$form .="<textarea id='firstmessage' class='reg' style='position:relative; height:50px; margin-top:20px; left:0px; width:500px; resize:none; color:#cccdce;' 
			name='items' rows='10' cols='100'>Write something here</textarea>";
			
			if($newuserid!=0)$form .="<div id='shy' style='margin-left:10px;' onclick='addMessage()' >Send</div></form> ";
			
			else $form = "<form method='post' id='group-form' style='float:left; width: 710px; margin:20px 0px 0px 100px;'>
			<div class = 'list-title' style='font-size:20px; color:red;'>No users found.</div></form>";
		}
echo json_encode($form);
?>
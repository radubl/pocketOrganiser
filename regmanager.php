<?php
session_start();
		require 'security.php';

 		if(isset($_SESSION['id']))
 		{
			session_destroy();
			header("Location:index.php");
		}
		
		require 'dbconn.php';

		date_default_timezone_set('UTC');

		$db = new Database();
		$newfullname="";
		$newusername="61636135351735274313";
		$newpassword="";
		$newpassword2="";
		$newemail="";
		$date='';
		$encrypted='';
		$salt='';
		$encrypted_password='';
		$message = '';
		
		$uniqueemail=true;
		$uniqueusername=true;
		$newuserid=0;
		
		if (isset($_POST["fullname"]))  $newfullname = prevent_XSS($_POST["fullname"]);
		if (isset($_POST["username"]))  $newusername = prevent_XSS($_POST["username"]);
		if (isset($_POST["password"]))  $newpassword = prevent_XSS($_POST["password"]);
		if (isset($_POST["password2"]))  $newpassword2 = prevent_XSS($_POST["password2"]);
		if (isset($_POST["email"]))  $newemail = prevent_XSS($_POST["email"]);
		
		($userids=$db->query("SELECT * FROM users"));
		
		while(($userrow = $userids->fetchArray())) 
		{	
			if($userrow['email']==$newemail)
			{ 
				$uniqueemail=false; 
				$message =  "Email already in use.";
				}
			if($userrow['username']==$newusername)
			{
				$uniqueusername=false;
				$message =  "Username already in use.";
			}
			$newuserid=$userrow['userid'];
		}
		
		if(isset($_POST["fullname"]))
 		if($uniqueusername && $newusername!="61636135351735274313" && $newfullname!="" && $newemail !="" && $uniqueemail)
 		{
			$newuserid++;
			$date = date('m/d/Y h:i:s a', time());
			
			if($newpassword==$newpassword2) 
			{
				$encrypted = sha1($newpassword);
				$salt = sha1(time());
				$encrypted_password = sha1($salt."--".$newpassword);
							
				$temp1 = $db->prepare("INSERT INTO users VALUES(:userid,:fullname,:username,:epassword,:salt,:email,:date)");
				
				$temp1->bindValue(':userid',$newuserid, SQLITE3_INTEGER);
				$temp1->bindValue(':fullname',$newfullname, SQLITE3_TEXT);
				$temp1->bindValue(':username',$newusername, SQLITE3_TEXT);
				$temp1->bindValue(':epassword',$encrypted_password, SQLITE3_TEXT);
				$temp1->bindValue(':salt',$salt, SQLITE3_TEXT);
				$temp1->bindValue(':email',$newemail, SQLITE3_TEXT);
				$temp1->bindValue(':date',$date, SQLITE3_TEXT);

				$temp1->execute();

				$_SESSION['fullname'] = $newfullname;
				$_SESSION['id'] = $newuserid;
				$_SESSION['username'] = $newusername;
				
				$usernotification = "Welcome to a better world!<br><br>Click on Manage Lists to add a new list. <br>You can
				create a new group if you have some friends.";
				
				$temp = $db->prepare("INSERT INTO userupdates values(:message,:userid,:date)");
					
				$temp->bindValue(':userid',$newuserid, SQLITE3_INTEGER);
				$temp->bindValue(':message',$usernotification, SQLITE3_TEXT);
				$temp->bindValue(':date',$date, SQLITE3_TEXT);
					
				$temp->execute();
			}
			else $message = "<span style='color:red; font-family:'Varela Round';'>Passwords do not match.</span>";
		}
 
 		echo json_encode($message);


?>
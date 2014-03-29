<?php 
		require 'security.php';
		
		$db = new Database();
		$newfullname="";
		$newusername="61636135351735274313";
		$newpassword="";
		$oldpassword="xvgzcfds21";
		$newpassword2="";
		$newemail="";
		$date='';
		$encrypted='';
		$salt='';
		$encrypted_password='';
		
		$uniqueusername=true;
		$newuserid=0;
		
		if (!empty($_POST["fullname"]))  $newfullname = prevent_XSS($_POST["fullname"]);
		if (!empty($_POST["username"]))  $newusername = prevent_XSS($_POST["username"]);
		if (!empty($_POST["oldpassword"]))  $oldpassword = prevent_XSS($_POST["oldpassword"]);
		if (!empty($_POST["newpassword"]))  $newpassword = prevent_XSS($_POST["newpassword"]);
		if (!empty($_POST["newpassword2"]))  $newpassword2 = prevent_XSS($_POST["newpassword2"]);
		if (!empty($_POST["email"]))  $newemail = prevent_XSS($_POST["email"]);
		
		($userids=$db->query("SELECT * FROM users"));
		
		while(($userrow = $userids->fetchArray())) 
		{	
			if($userrow['username']==$newusername) $uniqueusername=false;
		}

		$temp1 = $db->prepare("SELECT * FROM users WHERE (userid=:userid)");

		$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_TEXT);

		$rawuseridrow=$temp1->execute();

		while(($useridrow = $rawuseridrow->fetchArray())) 
		{
			$salt = $useridrow['salt'];
			
			if (!empty($_POST["oldpassword"]) && isset($_POST["oldpassword"]) )
			if(sha1($salt."--".$oldpassword)==$useridrow['hashedpassword'])
			{	
				if (!empty($_POST["newpassword"]))
					if($newpassword==$newpassword2) 
					{
						$encrypted = sha1($newpassword);
						$salt = sha1(time());
						$encrypted_password = sha1($salt."--".$newpassword);
						
						$temp1 = $db->prepare("Update users SET hashedpassword=:epassword, salt=:salt WHERE userid=:userid)");
				
						$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
						$temp1->bindValue(':epassword',$encrypted_password, SQLITE3_TEXT);
						$temp1->bindValue(':salt',$salt, SQLITE3_TEXT);

						$temp1->execute();
						

						echo "<span style='color:green; font-family:'Varela Round';'>Updated password.</span>";
					}
					else echo "<span style='color:red; font-family:'Varela Round';'>New passwords do not match.</span>";
				
				if (!empty($_POST["fullname"]))
				{

					
					$temp1 = $db->prepare("Update users SET fullname=:fullname WHERE userid=:userid");
				
						$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
						$temp1->bindValue(':fullname',$newfullname, SQLITE3_TEXT);

					$temp1->execute();
					
					
					$_SESSION['fullname'] = $newfullname;
					echo "<span style='color:green; font-family:'Varela Round';'>Updated Full Name.</span>";
				}
				
				if (!empty($_POST["username"]))
					if($uniqueusername)
					{
						$_SESSION['username'] = $newusername;

						
						$temp1 = $db->prepare("Update users SET username=:username WHERE userid=:userid");
				
							$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
							$temp1->bindValue(':username',$newusername, SQLITE3_TEXT);

						$temp1->execute();
						echo "<span style='color:green; font-family:'Varela Round';'>Updated username.</span>";
					}
					else echo "<span style='color:red; font-family:'Varela Round';'>Username already in use.</span>";
					
				if (!empty($_POST["email"]))
				{
					
					$temp1 = $db->prepare("Update users SET email=:email WHERE userid=:userid");
				
						$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
						$temp1->bindValue(':email',$newemail, SQLITE3_TEXT);

					$temp1->execute();
						
					echo "<span style='color:green; font-family:'Varela Round';'>Updated email.</span>";
				}
			}
			else echo "<span style='color:red;  font-family:'Varela Round';'>Old password typed wrong.</span>";
			//else echo "<span style='color:red; font-family:'Varela Round';'>Old password field empty.</span>";
			
// 			echo sha1($salt."--".$oldpassword);
// 			echo $useridrow['hashedpassword'];
// 			print_r($_SESSION); 
		
		}
?>
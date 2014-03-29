<?php
		session_start();
		require 'security.php';
		require 'dbconn.php';

		$db = new Database();

		$newusername="61636135351735274313";
		$newpassword="";
		
		if (isset($_POST["username"]))  $newusername = prevent_XSS($_POST["username"]);
		if (isset($_POST["password"]))  $newpassword = prevent_XSS($_POST["password"]);

		$temp1 = $db->prepare("SELECT * FROM users WHERE (username=:username)");

		$temp1->bindValue(':username',$newusername, SQLITE3_TEXT);

		$userids=$temp1->execute();

		if (isset($_POST["username"]))
			if(isset($_POST["password"]))
		
			while(($userrow = $userids->fetchArray())) 
			{	
				$encrypted = sha1($newpassword);
				$salt = $userrow['salt'];
				$encrypted_password = sha1($salt."--".$newpassword);
				
				if($userrow['hashedpassword']==$encrypted_password) 
				{
					header('location:dashboard.php');
					$_SESSION['fullname'] = $userrow['fullname'];
					$_SESSION['id'] = $userrow['userid'];
					$_SESSION['username'] = $userrow['username'];
				}else
					header('location:index.php');
				
			}
?>
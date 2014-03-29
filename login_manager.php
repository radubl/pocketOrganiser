<?php
		session_start();
		require 'security.php';
		require 'dbconn.php';

		$db = new Database();

		$newusername="";
		$newpassword="";
		$loginsuccess=false;
		
		if (isset($_POST["username"]))  $newusername = prevent_XSS($_POST["username"]);
		if (isset($_POST["password"]))  $newpassword = prevent_XSS($_POST["password"]);

		$temp1 = $db->prepare("SELECT * FROM users WHERE (username=:username)");

		$temp1->bindValue(':username',$newusername, SQLITE3_TEXT);

		$userids=$temp1->execute();

		if (!empty($_POST["username"]))
			if(!empty($_POST["password"]))
		
			while(($userrow = $userids->fetchArray())) 
			{	
				$encrypted = sha1($newpassword);
				$salt = $userrow['salt'];
				$encrypted_password = sha1($salt."--".$newpassword);
				
				if($userrow['hashedpassword']==$encrypted_password) 
				{
				    	$loginsuccess = true;
					
					$_SESSION['fullname'] = $userrow['fullname'];
					$_SESSION['id'] = $userrow['userid'];
					$_SESSION['username'] = $userrow['username'];
				}
			}
		if($loginsuccess)
			header('location:dashboard.php');
		else 
		    	header('location:index.php');
?>
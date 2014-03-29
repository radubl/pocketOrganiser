<?php
session_start();
		require 'dbconn.php';
		require 'security.php';
		require 'groupcolors.php';
		
		$db = new Database();
		$colorsarray = array("DarkMagenta  ","Chocolate","Coral ","Crimson","DarkBlue","DarkGreen","DarkRed","DeepPink ","LightSeaGreen","OrangeRed","Tomato");
		shuffle($colorsarray);
		
		$newGroupName='';
		$oldGroupName='';
		$description='';
		$groupUsers=array( 0 => '');
		$validGroup=true;
		$newgroupid=0;
		date_default_timezone_set('UTC');
		$datecreated = date('m/d/Y h:i:s a', time());
		$k=0;
		
		if (isset($_POST["groupname"]))  $newGroupName = prevent_XSS($_POST["groupname"]);
		if (isset($_POST["DropGroupNames"]))  $oldGroupName = $_POST["DropGroupNames"];
		if (isset($_POST["description"] ) && !empty($_POST["description"]))  $description = prevent_XSS($_POST["description"]);
		if (isset($_POST["groupUsers"] ) && !empty($_POST["groupUsers"]))  $groupUsers = $_POST["groupUsers"];
		
		$temp1 = $db->prepare("SELECT * FROM groups WHERE (userid=:userid)");

		$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);

		$groupnames=$temp1->execute();
		
		while($names=$groupnames->fetchArray())
		{
			if($description=='' && $names['description']!='') $description = $names['description'];
			if($names['groupname']==$newGroupName){ $validGroup=false; break; }
			$newgroupid=$names['groupid'];
		}
		
		$string = $newGroupName;
		$string = preg_replace('/\s+/', '', $string);
		
		if($groupUsers[0]!='')						// no users selected
		{
			if($oldGroupName!="Existing")					// user has chosen an existing group 
			{	
				foreach($groupUsers as $user)
				{
					$temp1 = $db->prepare("INSERT into groups VALUES(:groupid, :groupname,:userid,:description,:color)");
					
					$temp1->bindValue(':groupid',$newgroupid, SQLITE3_INTEGER);
					$temp1->bindValue(':userid',$user, SQLITE3_INTEGER);
					$temp1->bindValue(':groupname',$oldGroupName, SQLITE3_TEXT);
					$temp1->bindValue(':description',$description, SQLITE3_TEXT);
					$temp1->bindValue(':color',$colorsarray[$k], SQLITE3_TEXT);
					
					$temp1->execute();
					
					$usernotification="Hey there, <span style='color:".$colorsarray[0].";'>". $_SESSION['fullname']. "</span> added you to the group ".$newGroupName.".";
					
					$temp = $db->prepare("INSERT INTO userupdates values(:message,:userid,:date)");
							
					$temp->bindValue(':userid',$user, SQLITE3_INTEGER);
					$temp->bindValue(':message',$usernotification, SQLITE3_TEXT);
					$temp->bindValue(':date',$datecreated, SQLITE3_TEXT);

					$temp->execute();
					
					$k++;
					if($k>10) $k=0;
				}
			}
			else								// user creates a new group
				if($string!='' && $validGroup)		// new group name is set or exists
					{	
						$temp1 = $db->prepare("INSERT into groups VALUES(:groupid, :groupname,:userid,:description,:color)");
					
						$temp1->bindValue(':groupid',$newgroupid, SQLITE3_INTEGER);

						$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
						$temp1->bindValue(':groupname',$newGroupName, SQLITE3_TEXT);
						$temp1->bindValue(':description',$description, SQLITE3_TEXT);
						$temp1->bindValue(':color',$colorsarray[$k], SQLITE3_TEXT);
						
						$temp1->execute();
						$k++;
						
						foreach($groupUsers as $user)
						{
						
							$temp1 = $db->prepare("INSERT into groups VALUES(:groupid, :groupname,:userid,:description,:color)");
					
							$temp1->bindValue(':groupid',$newgroupid, SQLITE3_INTEGER);

							$temp1->bindValue(':userid',$user, SQLITE3_INTEGER);
							$temp1->bindValue(':groupname',$newGroupName, SQLITE3_TEXT);
							$temp1->bindValue(':description',$description, SQLITE3_TEXT);
							$temp1->bindValue(':color',$colorsarray[$k], SQLITE3_TEXT);
							
							$temp1->execute();
							
							$usernotification="Hey there, <span style='color:".$colorsarray[0].";'>". $_SESSION['fullname']. "</span> added you to the group ".$newGroupName.". Check for new friends.";
		
							$temp = $db->prepare("INSERT INTO userupdates values(:message,:userid,:date)");
									
							$temp->bindValue(':userid',$user, SQLITE3_INTEGER);
							$temp->bindValue(':message',$usernotification, SQLITE3_TEXT);
							$temp->bindValue(':date',$datecreated, SQLITE3_TEXT);

							$temp->execute();
							$k++;
							if($k>10) $k=0;
						}
					}
				else echo " <span style='color:red; padding-left:10px; font-family:'Varela Round'; '>Invalid Group name or Group already exists.</span>";
				
		//make all the users friends with eachother.
		$i=0;
		$j=0;
		
		for($i=0;$i<count($groupUsers)-1;$i++)
			for($j=$i+1;$j<count($groupUsers);$j++)
			{
			
			$temp1 = $db->prepare("INSERT INTO friends VALUES(:userid0,:userid1,0)");

			$temp1->bindValue(':userid0',$groupUsers[$i], SQLITE3_INTEGER);
			$temp1->bindValue(':userid1',$groupUsers[$j], SQLITE3_INTEGER);

			$temp1->execute();
			
			$temp1 = $db->prepare("INSERT INTO friends VALUES(:userid0,:userid1,0)");

			$temp1->bindValue(':userid0',$groupUsers[$j], SQLITE3_INTEGER);
			$temp1->bindValue(':userid1',$groupUsers[$i], SQLITE3_INTEGER);

			$temp1->execute();

			}
			
		}
		else echo "<span style='color:red; padding-left:10px; font-family:'Varela Round'; '>The Group has no users.</span>";
		
	header('location:group_manager.php');
	
 	print_r($groupUsers);
 	print_r(count($groupUsers));
?>
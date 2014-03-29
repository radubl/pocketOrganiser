<?php

	
function displayUpdates($groupname){

	$db = new Database();
	$output="<div style='width:700px; float:left; margin:80px 0px 0px 250px;><span class='list-title' style='font-size:20px;'>";
	
	$temp = $db->prepare("SELECT * from updates inner join users on users.userid=updates.userid inner join groups on groups.userid=users.userid
			and groups.groupname=updates.groupname where updates.groupname=:groupname order by updates.datecreated DESC");
	
	$temp->bindValue(':groupname',$groupname, SQLITE3_TEXT);

	$updates=$temp->execute();
	
	while($uprow=$updates->fetchArray())
	{
		$output.="<span class='list-title' style='font-size:20px; color:" .$uprow['usercolor'].";'>".$uprow['fullname'].":</span>";
		
		if($uprow['userid']==$_SESSION['id'])
			$output.="<span style=' float:right; padding-top:10px;' class='delete_friends' 
			onClick='deleteUpdate(&#39;".$groupname."&#39;,&#39;".$uprow['datecreated']."&#39;)'></span>";
			
		$output.="<span class='checkbox-form' style='word-wrap: break-word; margin:10px; float:left; width:600px; font-size:20px;'>".$uprow['message']."</span><br><br>";
	}
	
	$output.="</div><div style='clear:both; height:800px;'></div>";
	
	return $output;
}

?>
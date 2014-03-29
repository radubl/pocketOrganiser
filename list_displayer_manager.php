<?php

function getLists($category){


$db = new Database();

$temp1 = $db->prepare("select * from listitems inner join lists on listitems.listid=lists.listid WHERE 
				(lists.userid=:userid AND listitems.userid=:userid AND lists.category='$category' AND listitems.completed=0) ORDER BY duedate,listname");

$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);

$listids=$temp1->execute();
	
$form="";
$temp_listid='';
$formname=0;

while(($listrow = $listids->fetchArray())) 
{									//for every list of the user
	
	if($temp_listid != $listrow['listid'])
	{
		if($temp_listid !='')
		{
			$formname--;
			$form .= $finalduedate . "</span></div>" .$listcontent . "<br> <input type='checkbox' name='all' onclick='checkAll(this,&#39;$formname&#39;)' class='regular-checkbox'> 
			<span class='checkbox-item' style='color:black;'> Check All. </span> <br> <br>
			<textarea class='freshitem' name='".$temp_listid."d!nj#$&hds".$_SESSION['id']."d!nj#$&hds".$category."' rows='1' cols='100' style='margin:0px;'>Quick add a new item.</textarea>
			<div class = 'list-title' style='float:right;'>".$interval."</div></form> ";
			$formname++;
		}
		
		$form .="<form action='submitlists.php'  method='post' 
			class='checkbox-form' style='padding-top:53px;' name='$formname'><div class = 'list-title'>"  
		.$listrow['listname']."<span style='float:right;'>";
		
		date_default_timezone_set('UTC');
		$listcontent="";
		$finalduedate = $listrow['duedate'] ;
		
		$date = new DateTime($finalduedate);
		
		$finalduedate=$date->format('dS') . " of " . $date->format('F , h:00 a');
		
		$todate = date('m/d/Y h:i:s ', time());
		$dt = new DateTime($todate);
		
		$interval = date_diff($dt,$date)->format('%R%a');

		$days = intval($interval);

		if($interval=='-0') $interval = 'due Today';
		elseif($days<0)
			if($days==-1)
				$interval = abs($days).' day overdue';
			else  $interval = abs($days).' days overdue';
		elseif($days==1) 
				$interval = abs($days).' day left';
		elseif($days==0)  
			$interval = 'due Today';
		else  
			$interval =abs($days).' days left';
		
		if($days<3) $interval = '<span style="color:red;">' . $interval . '</span>';
		
		$listcontent .="<input type='checkbox' class='regular-checkbox' name='checkeditems[]' value='"
				.$listrow['itemcontent'].
				"' > <span class='checkbox-item'>" .$listrow['itemcontent'] ." </span> <br><br>";
		
		$temp_listid = $listrow['listid'];
		$formname++;
	}
	
	else 
	{
		if($finalduedate<$listrow['duedate']) $finalduedate = $listrow['duedate'] ;
		
		$listcontent .="<input type='checkbox' class='regular-checkbox' name='checkeditems[]' value='"
				.$listrow['itemcontent'].
				"' > <span class='checkbox-item'>" .$listrow['itemcontent'] ." </span> <br><br>";
	}

}
$formname--;
if($form=="")
	$form ="<br><br><br><div class = 'list-title' style='padding-left:250px; height:1000px;'> You have no lists added.<br><br> Click Manage Lists for further instructions</div>";

else 
	$form .=$finalduedate . "</span></div>" .$listcontent . "<br> <input type='checkbox' name='all' onclick='checkAll(this,&#39;$formname&#39;)' class='regular-checkbox'> 
	
	<span class='checkbox-item' style='color:black;'> Check All. </span> <br> <br>
	<textarea class='freshitem' name='".$temp_listid."d!nj#$&hds".$_SESSION['id']."d!nj#$&hds".$category."' rows='1' cols='100' style='margin:0px;' >Quick add a new item.</textarea>
	<div class = 'list-title' style='float:right;'>".$interval."</div></form> 
	
	<div style='clear:both; height:20px;'></div>
	
	<div style='margin-left:350px;'>
			<div id='shy' style='margin-ldeft:10px;' onclick='submitAll(&#39;".$category."&#39;)'>Update Lists
	</div>
		
		<div id='shy' onclick='backToTop()' style='margin-left:100px;'>
			Back to Top
		</div>
	<div style='clear:both; height:1px;'></div>
		";
return $form;
}
?>

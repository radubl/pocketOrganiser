<?php

/**
 * The functions that the dashboard page uses:
 *	getUserUpdates() fetches the updates from the database in a cronological order and displays them. Also, it records the last view of the dashboard page and sorts the updates into Old and New
 *	displayBalance() gets the balances of all the friends of our current user and sums all of them in order to get a general balance, also, it sepparates the positive and negative balances
 *		so they would be displayed into 2 categories: monies owed to and who owes money to you. You can pay those you owe to via ajax by simply clicking on their name.
 */

date_default_timezone_set('UTC');

function getUserUpdates(){

$db = new Database();
$freshoutput='<div style="margin:0px 200px 0px 270px; position:relative;"><span class="list-title">So this is what happend lately</span><br>';
$oldoutput='<div style="margin:0px 200px 0px 270px; position:relative;"><div class="list-title">Old stuff</div>';

$temp1 = $db->prepare("SELECT * FROM userupdates inner join users on users.userid=userupdates.userid
				where users.userid=:userid order by userupdates.datecreated DESC");

$temp1->bindValue(':userid',$_SESSION["id"], SQLITE3_INTEGER);

$updates=$temp1->execute();

$countnew=0;
$countold=0;
$freshoutputbody='';
$oldoutputbody='';
while(($updaterow = $updates->fetchArray())) {
		
$datecreated = new DateTime($updaterow['datecreated']);
$datelastvisit = new DateTime($updaterow['datejoined']);
		
$datecreatedpretty=$datecreated->format('dS') . " of " . $datecreated->format('F , h:i a');

	if($datelastvisit<$datecreated)
	{
		$freshoutputbody.="<span class='checkbox-form' style='word-wrap: break-word; margin:20px 0px 0px 0px; float:left; width:500px; font-size:17px;'>".$updaterow['message']."
		 <br><span style='float:right; color:#A10303; padding-top:10px;'> ". $datecreatedpretty ."</span></span><br><br>";
		$countnew++;
     }
      else
      {
		$oldoutputbody.="<span class='checkbox-form' style='word-wrap: break-word; margin:20px 0px 0px 0px; float:left; width:500px; font-size:17px;'>".$updaterow['message']."
		 <br><span style='float:right; color:#A10303; padding-top:10px;'> ". $datecreatedpretty ."</span></span><br><br>";
		$countold++;
	}
}

$date = date('m/d/Y h:i:s a', time());

$temp1 = $db->prepare("Update users SET datejoined=:date WHERE userid=:userid");
				
$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
$temp1->bindValue(':date',$date, SQLITE3_TEXT);

$temp1->execute();

if($countnew==0) 
	{$freshoutputbody=''; $freshoutput=''; }
elseif($countold==0)
	{$oldoutputbody=''; $oldoutput=''; }
else
	$oldoutput='<div style="margin:0px 200px 0px 0px; position:relative;"><div class="list-title" style="padding-top:200px;">Old stuff</div>';
	
$freshoutput.=$freshoutputbody;
$oldoutput.=$oldoutputbody.'</div>';
return $freshoutput.$oldoutput;
}

function displayBalance(){

$output=' <div style="font-size:30px; color:#575858; padding:10px; padding-top:20px;">Balance: <span style="color:#BF0D0D; padding:0px; float:right;">  &#163; ';

$db= new Database();

$temp = $db->prepare("SELECT * FROM friends inner join users on users.userid=friends.userid1 WHERE friends.userid0=:userid ORDER BY friends.userid1");

$temp->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);

$friends=$temp->execute();

$balance_rows='';
$friendsrowsplus='<div style="font-size:20px; color:#575858; padding:10px; padding-top:20px;">Collect From: <span style="color:black; padding:0px; float:right;">Amount</span></div>';
$friendsrowsminus = '<div style="font-size:20px; color:#575858; padding:10px; padding-top:20px;">Pay To: <span style="color:black; padding:0px; float:right;">Amount</span></div>
				<div id="fuck_this"></div>';
$total_balance=0;

$temp_friend='';

$i=0;

$j=0;

while(($userrow = $friends->fetchArray()))
{
if($userrow['balance']==0) continue;

if($temp_friend!=$userrow['userid'])
{
	$solobalance = number_format((float)$userrow['balance'], 2, '.', '');

	$total_balance+=$solobalance;
	if($solobalance>0)
	{
		$i++;
		$friendsrowsplus.="<span class='friends' style='width:50px;'>".$userrow['fullname']." : 
		<span class='friends' style='color:#023480; padding:0px; padding-right:10px; float:right;'> &#163; ".$solobalance." </span></span><br>";
	}
	else
	{
		$friendsrowsminus.="<div class='pay_indiv' id='pay_indiv".$userrow['userid']."' onClick='payIndividual(&#39;".$userrow['userid']."&#39;)' ><span class='friends' style='width:50px;'>".$userrow['fullname']." : 
		<span class='friends' style='color:#023480; padding:0px; padding-right:10px; float:right;'> &#163; ".abs($solobalance)." </span></div>
		</span><br>";
		$j++;
	}
}	
else
{
	$temp = $db->prepare("DELETE FROM friends WHERE (userid0=:userid0 AND userid1=:userid1) OR (userid0=:userid1 AND userid1=:userid0)");

		$temp->bindValue(':userid0',$_SESSION['id'], SQLITE3_INTEGER);
		$temp->bindValue(':userid1',$temp_friend, SQLITE3_INTEGER);
		
	$temp->execute();

	$temp1 = $db->prepare("INSERT INTO friends VALUES(:userid0,:userid1,0)");

		$temp1->bindValue(':userid0',$temp_friend, SQLITE3_INTEGER);
		$temp1->bindValue(':userid1',$_SESSION['id'], SQLITE3_INTEGER);

	$temp1->execute();
	
	$temp1 = $db->prepare("INSERT INTO friends VALUES(:userid0,:userid1,0)");

		$temp1->bindValue(':userid1',$temp_friend, SQLITE3_INTEGER);
		$temp1->bindValue(':userid0',$_SESSION['id'], SQLITE3_INTEGER);

	$temp1->execute();
}
$temp_friend=$userrow['userid'];
}
if($i==0) $friendsrowsplus ='';
if($j==0) $friendsrowsminus ='';
if($friendsrowsminus == $friendsrowsplus)
{
	$output = '';
}
else
{
	$output.= $total_balance. '</span></div>';
	$output.=$friendsrowsplus.$friendsrowsminus;
}

return $output;

}

?>

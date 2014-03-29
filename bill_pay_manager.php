<?php
session_start();

/**
 * This script deals with the payment of an old bill, that has not been paid at the moment of its creation.
 * Via ajax, it gets the bill ID, fetches it from the database, deals with the splitting and the updates for the users.
 *
 */

include 'dbconn.php';
include 'security.php';
include 'group_updates_displayer.php';

		$db = new Database();
		$billid=0;
		$amount=0;
		$billname='';
		$groupname='';
		$description='';
		$duedate='';
		$splitmode='';
		$bill ='';
		
		date_default_timezone_set('UTC');
		$datecreated = date('m/d/Y h:i:s a', time());
		
		if (isset($_POST["billid"]))  $billid = prevent_XSS($_POST["billid"]);


		$temp1 = $db->prepare("SELECT * FROM bills where billid=:billid");
		
		$temp1->bindValue(':billid',$billid, SQLITE3_INTEGER);

		$bills=$temp1->execute();
		
		while(($billrow = $bills->fetchArray())) 
		{	
		$groupname=$billrow['groupname'];
		
		$bill = '<br><br> <span class="list-title" style="font-size:20px;">Bill Name: </span>' . $billrow['billname']. '<br><br><span class="list-title" style="font-size:20px;"> Amount: </span>&#163;'.$billrow['amount'].'<br><br><span class="list-title" style="font-size:20px;">Description: </span>'.$billrow['description'];

			$message='Hey, I managed to pay one of our old bills. Each one of you should receive a notification
				and have your balance updated.'.$bill;
				
				$splitmode=$billrow['splitmode'];
				$splitmode=rtrim($splitmode, "/");
				
				$splitarray=explode('/',$splitmode);
				$i=0;
				
				$temp = $db->prepare("SELECT * FROM groups inner join users on users.userid=groups.userid 
				WHERE groups.groupname=:groupname ORDER BY groups.userid");

				$temp->bindValue(':groupname',$billrow['groupname'], SQLITE3_TEXT);

				$friends=$temp->execute();
				
				while($usersrow = $friends->fetchArray())
				{
					if($_SESSION['id']!=$usersrow['userid'])
					{
					//Update balance in friends.
					$temp3 = $db->prepare("Select balance from friends where userid0='$_SESSION[id]' AND userid1='$usersrow[userid]'");
					
					$rawnewbalance=$temp3->execute();
					
					while($newbalancearray=$rawnewbalance->fetchArray()){
					
						$newbalance=floatval($newbalancearray['balance']);
					}
					
					$amountpaid=$splitarray[$i]/100*$billrow['amount'];
					$amountpaidpretty = number_format((float)$amountpaid, 2, '.', '');
					
					$newbalance=$newbalance+$amountpaid;
					$newbalance2=-$newbalance;
					
					//user0 takes money from user1
					$db->exec("Update friends set balance='$newbalance' where userid0='$_SESSION[id]' AND userid1='$usersrow[userid]'");
					$db->exec("Update friends set balance='$newbalance2' where userid1='$_SESSION[id]' AND userid0='$usersrow[userid]'");
					
					//Set Notifications for individual users:
					
					$usernotification = 'You paid &#163; '.$amountpaidpretty.'for '.$usersrow['fullname'].' ( '.$billrow['billname']." )";
					$usernotification2= $_SESSION['fullname']. 'paid for you &#163; '.$amountpaidpretty.' ( '.$billrow['billname']." )";
					
					$temp = $db->prepare("INSERT INTO userupdates values(:message,:userid,:date)");
					
					$temp->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
					$temp->bindValue(':message',$usernotification, SQLITE3_TEXT);
					$temp->bindValue(':date',$datecreated, SQLITE3_TEXT);
					
					$temp->execute();
					
					$temp = $db->prepare("INSERT INTO userupdates values(:message,:userid,:date)");
					
					$temp->bindValue(':userid',$usersrow['userid'], SQLITE3_INTEGER);
					$temp->bindValue(':message',$usernotification2, SQLITE3_TEXT);
					$temp->bindValue(':date',$datecreated, SQLITE3_TEXT);
					
					$temp->execute();
					
					}
					$i++;
				}

			$temp = $db->prepare("INSERT into updates values(:message,:groupname,:userid,:datecreated)");
		
			$temp->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
			$temp->bindValue(':groupname',$groupname, SQLITE3_TEXT);
			$temp->bindValue(':message',$message, SQLITE3_TEXT);
			$temp->bindValue(':datecreated',$datecreated, SQLITE3_TEXT);

			$temp->execute();
			
			$temp = $db->prepare("DELETE from updates where(groupname=:groupname AND datecreated=:datecreated)");
		
			$temp->bindValue(':groupname',$billrow['groupname'], SQLITE3_TEXT);
			$temp->bindValue(':datecreated',$billrow['datecreated'], SQLITE3_TEXT);

			$temp->execute();
}
		
	echo json_encode(displayUpdates($groupname));
?>
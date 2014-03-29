<?php
session_start();

/**
 * This is the script that handles the addition of a PAID bill. It gets its variables through ajax.
 * Firstly it creates the bill by inserting a new field in the Bill table.
 * Then it splits the bill to all the users in the group the will was posted, following the pattern provided via ajax. This pattern is a string of the percentages all the group members should pay.
 * It updates the Friends table, changing the balances accordingly for all the users
 * Finally, it posts in the Individul Updates and Group Updates tables information about the paid bill.
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
		$currentusercolor='';
		
		date_default_timezone_set('UTC');
		$datecreated = date('m/d/Y h:i:s a', time());
		
		if (isset($_POST["duedate1"]))  $duedate = prevent_XSS($_POST["duedate1"] . $_POST["duedate2"]);
		if (isset($_POST["amount"]))  $amount = prevent_XSS($_POST["amount"]);
		if (isset($_POST["billname"]))  $billname = prevent_XSS($_POST["billname"]);
		if (isset($_POST["group"]))  $groupname = prevent_XSS($_POST["group"]);
		if (isset($_POST["description"]))  $description = prevent_XSS($_POST["description"]);
		if (isset($_POST["splitmode"]))  $splitmode = prevent_XSS($_POST["splitmode"]);


		$temp1 = $db->prepare("SELECT * FROM bills");

		$bills=$temp1->execute();
		
		while(($listrow = $bills->fetchArray())) 
		{	
			$billid++;
		}

		if($billname!="" && $groupname!="" && $amount!=0)
		{
			$billid++;

			$temp1 = $db->prepare("INSERT INTO bills VALUES(:billid,:billname,:groupname,:splitmode,:amount,:duedate, '$datecreated', :description)");

			$temp1->bindValue(':billname',$billname, SQLITE3_TEXT);
			$temp1->bindValue(':splitmode',$splitmode, SQLITE3_TEXT);
			$temp1->bindValue(':duedate',$duedate, SQLITE3_TEXT);
			$temp1->bindValue(':groupname',$groupname, SQLITE3_TEXT);
			$temp1->bindValue(':description',$description, SQLITE3_TEXT);
			$temp1->bindValue(':billid',$billid, SQLITE3_INTEGER);
			$temp1->bindValue(':amount',$amount, SQLITE3_INTEGER);

			$temp1->execute();
			
			//now add the notifications for groups:
			
			$bill = '<br><br> <span class="list-title" style="font-size:20px;">Bill Name: </span>' . $billname. '<br><br><span class="list-title" style="font-size:20px;"> Amount: </span>&#163;'.$amount.'<br><br><span class="list-title" style="font-size:20px;">Description: </span>'.$description;
			
			if($duedate=='paid')
			{
				$message='Hey, There is a new bill that I paid. Each one of you should receive a notification
				and have your balance updated.'.$bill;
				
				$splitmode=rtrim($splitmode, "/");
				
				$splitarray=explode('/',$splitmode);
				$i=0;

				$temp = $db->prepare("SELECT * FROM groups where groupname=:groupname AND userid=:userid ORDER BY userid");

				$temp->bindValue(':groupname',$groupname, SQLITE3_TEXT);
				$temp->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);

				$friends=$temp->execute();
				
				while(($usersrow = $friends->fetchArray())) 
				{
					$currentusercolor=$usersrow['usercolor'];
				}
				$temp = $db->prepare("SELECT * FROM groups inner join users on users.userid=groups.userid 
				WHERE groups.groupname=:groupname ORDER BY groups.userid");

				$temp->bindValue(':groupname',$groupname, SQLITE3_TEXT);

				$friends=$temp->execute();
				
				while(($usersrow = $friends->fetchArray())) 
				{
					if($_SESSION['id']!=$usersrow['userid'])
					{
					//Update balance in friends.
					$temp3 = $db->prepare("Select balance from friends where userid0='$_SESSION[id]' AND userid1='$usersrow[userid]'");
					
					$rawnewbalance=$temp3->execute();
					
					while($newbalancearray=$rawnewbalance->fetchArray()){
					
						$newbalance=floatval($newbalancearray['balance']);
					}
					
					$amountpaid=$splitarray[$i]/100*$amount;
					$amountpaidpretty = number_format((float)$amountpaid, 2, '.', '');
					
					$newbalance=$newbalance+$amountpaid;
					$newbalance2=-$newbalance;
					
					//user0 takes money from user1
					$db->exec("Update friends set balance='$newbalance' where userid0='$_SESSION[id]' AND userid1='$usersrow[userid]'");
					$db->exec("Update friends set balance='$newbalance2' where userid1='$_SESSION[id]' AND userid0='$usersrow[userid]'");
					
					//Set Notifications for individual users:
					
					$usernotification = 'You paid &#163; '.$amountpaidpretty.' for <span style="color:'.$usersrow['usercolor'].';">'.$usersrow['fullname'].'</span> ('.$billname.")";
					$usernotification2= '<span style="color:'.$currentusercolor.';">'.$_SESSION['fullname']. '</span> paid for you &#163; '.$amountpaidpretty.' ('.$billname.")";
					
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
					
					$mail_message = "Hey there, ".$_SESSION['fullname']. " paid for you ? ".$amountpaidpretty." for the bill ".$billname.".";
					
					mail($usersrow['userid'],"New Bill: ". $billname, $mail_message);
					}
					$i++;
				}
			}
			else
				$message='Hey, There is a new bill that needs to be paid until <x style="color:red;">'.$duedate.'</x>.Each one of you should be able to pay it.'.$bill.'<br><span id="shy" style="" onclick="payBill(&#39;'.$billid.'&#39;)"> Pay it.</span>';
			
			$temp = $db->prepare("INSERT into updates values(:message,:groupname,:userid,:datecreated)");
		
			$temp->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
			$temp->bindValue(':groupname',$groupname, SQLITE3_TEXT);
			$temp->bindValue(':message',$message, SQLITE3_TEXT);
			$temp->bindValue(':datecreated',$datecreated, SQLITE3_TEXT);

			$temp->execute();

			//Individual updates for users:
		
}
	echo json_encode(displayUpdates($groupname));
?>
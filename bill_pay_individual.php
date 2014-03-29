<?php
session_start();
include 'dbconn.php';
include 'security.php';

		$db = new Database();
		$billid=0;
		$amount=0;
		$userid='';
		
		date_default_timezone_set('UTC');
		$datecreated = date('m/d/Y h:i:s a', time());
		
		if (isset($_POST["amount"]))  $amount = prevent_XSS($_POST["amount"]);
		if (isset($_POST["userid"]))  $userid = prevent_XSS($_POST["userid"]);

		$temp1 = $db->prepare("SELECT * FROM users inner join friends on users.userid = friends.userid0 where friends.userid0=:userid0
		AND friends.userid1 = :userid1");
		
		$temp1->bindValue(':userid0',$userid, SQLITE3_INTEGER);
		$temp1->bindValue(':userid1',$_SESSION['id'], SQLITE3_INTEGER);

		$bills=$temp1->execute();
		
		while(($userrow = $bills->fetchArray())) 
		{
		$newbalance = $userrow['balance'] - $amount;
		$newbalance2 = -$newbalance;
		
		$db->exec("Update friends set balance='$newbalance2' where userid0='$_SESSION[id]' AND userid1='$userid'");
		$db->exec("Update friends set balance='$newbalance' where userid1='$_SESSION[id]' AND userid0='$userid'");
		
		$usernotification= $_SESSION['fullname']. ' paid for you &#163; '.$amount;
		
		$temp = $db->prepare("INSERT INTO userupdates values(:message,:userid,:date)");
		
		$temp->bindValue(':userid',$userid, SQLITE3_INTEGER);
		$temp->bindValue(':message',$usernotification, SQLITE3_TEXT);
		$temp->bindValue(':date',$datecreated, SQLITE3_TEXT);
		
		$temp->execute();
					
		}
?>
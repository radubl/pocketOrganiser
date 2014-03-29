<?php
session_start();
include 'dbconn.php';
include 'security.php';
include 'list_displayer_manager.php';

		$db = new Database();
		$listid='';
		$listcategory='';
		$item='';
		$userid='';
		$isnewlist='';
		$newlistid=0;
		$newlistduedate='';
		$uniquelist=true;
		
		if (isset($_POST["duedate1"]))  $newlistduedate = prevent_XSS($_POST["duedate1"]) . '00:00';
		if (isset($_POST["duedate2"]))  $newlistduedate = prevent_XSS($_POST["duedate1"] . $_POST["duedate2"]);
		if (isset($_POST["listid"]))  $listid = prevent_XSS($_POST["listid"]);
		if (isset($_POST["isnewlist"]))  $isnewlist = prevent_XSS($_POST["isnewlist"]);
		if (isset($_POST["listname"]))  $newlistname = prevent_XSS($_POST["listname"]);
		if (isset($_POST["listcategory"]))  $listcategory = prevent_XSS($_POST["listcategory"]);
		if (isset($_POST["item"]))  $item = prevent_XSS($_POST["item"]);
		if (isset($_POST["userid"]))  $userid = prevent_XSS($_POST["userid"]);

		if($isnewlist=='')
		{
			$temp1 = $db->prepare("INSERT INTO listitems VALUES(:element,:userid,:listid, 0)");

			$temp1->bindValue(':element',$item, SQLITE3_TEXT);
			$temp1->bindValue(':userid',$userid, SQLITE3_INTEGER);
			$temp1->bindValue(':listid',$listid, SQLITE3_INTEGER);

			$temp1->execute();
		}
		else
		{
			
			$user = explode('.',$item); 

			$temp1 = $db->prepare("SELECT * FROM lists WHERE (userid=:userid)");

			$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);

			$listids=$temp1->execute();
		
		while(($listrow = $listids->fetchArray())) 
		{	
			if($listrow['listname']==$newlistname && $listcategory==$listrow['category'] ){ $uniquelist=false; break; }
			
			$newlistid=$listrow['listid'];
		}
		
			if($uniquelist) 
				if($newlistname!="" && $listcategory!="")
				{
					$newlistid++;

							$temp1 = $db->prepare("INSERT INTO lists VALUES(:userid,:listid,:listname,:listcategory, 'ok', '$newlistduedate')");

							$temp1->bindValue(':listname',$newlistname, SQLITE3_TEXT);
							$temp1->bindValue(':listcategory',$listcategory, SQLITE3_TEXT);
							$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
							$temp1->bindValue(':listid',$newlistid, SQLITE3_INTEGER);

							$temp1->execute();

					foreach($user as $element)
						if($element!="")
							{
							$element = preg_replace('/^.?$\n/m', '', $element);
							$element = ucfirst (  $element."." );

							$temp1 = $db->prepare("INSERT INTO listitems VALUES(:element,:userid,:listid, 0)");

							$temp1->bindValue(':element',$element, SQLITE3_TEXT);
							$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
							$temp1->bindValue(':listid',$newlistid, SQLITE3_INTEGER);

							$temp1->execute();

			}
			}
		}
	echo json_encode(getLists($listcategory));
?>
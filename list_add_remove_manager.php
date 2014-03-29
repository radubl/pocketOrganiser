<?php

		$db = new Database();
		$oldlistid='';
		$oldlistname='';
		$oldlistcategory='';
		$newlistname="";
		$newlistduedate="";
		$newlistcategory="";
		$newlistitems="";
		$uniquelist=true;
		$adder=false;
		$user=array();
		$newlistid=0;
		$timestamp='';
		
		if (isset($_POST["listname"]))  $newlistname = prevent_XSS($_POST["listname"]);
		if (isset($_POST["DropListNames"]))  $oldlistname = prevent_XSS($_POST["DropListNames"]);
		if (isset($_POST["DropCategories"]))  $oldlistcategory = prevent_XSS($_POST["DropCategories"]);
		
		if (isset($_POST["duedate1"]))  $newlistduedate = prevent_XSS($_POST["duedate1"]) . '00:00';
		if (isset($_POST["duedate2"]))  $newlistduedate = prevent_XSS($_POST["duedate1"] . $_POST["duedate2"]);
		if (isset($_POST["category"]))  $newlistcategory = prevent_XSS($_POST["category"]);
		
		if($oldlistcategory!="Existing" && $newlistcategory=='') $newlistcategory=$oldlistcategory;
		elseif($newlistcategory!='') 
		{

		$temp1 = $db->prepare("INSERT INTO categories VALUES(:category, '')");

		$temp1->bindValue(':category',$newlistcategory, SQLITE3_TEXT);

		$temp1->execute();

		}
		
		if (isset($_POST["items"])) 
		{ 
			$newlistitems = prevent_XSS($_POST['items']).'.';
			
			$user = explode('.',$newlistitems); 
		}

			$temp1 = $db->prepare("SELECT * FROM lists WHERE (userid=:userid)");

			$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);

			$listids=$temp1->execute();
		
		while(($listrow = $listids->fetchArray())) 
		{	
			if($listrow['listname']==$newlistname && $listrow['category']==$newlistcategory ) $uniquelist=false;
			
			if($listrow['listname']==$oldlistname && $listrow['category']==$newlistcategory ) $oldlistid=$listrow['listid'];
			
			$newlistid=$listrow['listid'];
		}
		
		if($oldlistname=="Existing")
			if($uniquelist) 
				if($newlistname!="" && $newlistcategory!="" && isset($_POST["category"]) && isset($_POST["listname"]))
				{
					$newlistid++;

							$temp1 = $db->prepare("INSERT INTO lists VALUES(:userid,:listid,:listname,:listcategory, 'ok', '$newlistduedate')");

							$temp1->bindValue(':listname',$newlistname, SQLITE3_TEXT);
							$temp1->bindValue(':listcategory',$newlistcategory, SQLITE3_TEXT);
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
					echo "<span style='color:green; padding-left:10px; font-family:'Varela Round'; '>Created new list.</span>";
				} else{}
			else	echo "<span style='color:red; padding-left:10px; font-family:'Varela Round'; '>List already exists.</span>";
		else
		if($oldlistid!='')
			{
				foreach($user as $element)
					if($element!="")
						{
						$adder=true;
						$element = ucfirst (  $element."." );
							$temp1 = $db->prepare("INSERT INTO listitems VALUES(:element,:userid,:listid, 0)");

							$temp1->bindValue(':element',$element, SQLITE3_TEXT);
							$temp1->bindValue(':userid',$_SESSION['id'], SQLITE3_INTEGER);
							$temp1->bindValue(':listid',$oldlistid, SQLITE3_INTEGER);

							$temp1->execute();
						}
				if($adder)echo "<span style='color:green; padding-left:10px; font-family:'Varela Round'; '>Added items to ".$oldlistname.".</span>";
			}
// 	print_r($_SESSION);
?>
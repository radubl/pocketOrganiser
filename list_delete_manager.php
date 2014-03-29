<?php
	
		$db = new Database();
		$oldlistname='';
		$oldlistcategory='';
		
		if (isset($_POST["DeleteList"]))  $oldlistname = prevent_XSS($_POST["DeleteList"]);
		if (isset($_POST["DeleteCategory"]))  $oldlistcategory = prevent_XSS($_POST["DeleteCategory"]);

		
		if($oldlistname!="Existing" && $oldlistname!="" ){

			$temp = $db->prepare("DELETE from lists WHERE listname=:listname");

			$temp->bindValue(':listname',$oldlistname, SQLITE3_TEXT);

			$temp->execute();

			echo "<span style='color:green; padding-left:10px; font-family:'Varela Round'; '>Deleted ".$oldlistname.".</span>";
			}
		
		if($oldlistcategory!="Existing" && $oldlistcategory!="" ){

			$temp = $db->prepare("DELETE from lists WHERE category=:category");

			$temp->bindValue(':category',$oldlistcategory, SQLITE3_TEXT);

			$temp->execute();

			$temp2 = $db->prepare("DELETE from categories WHERE category=:category");

			$temp2->bindValue(':category',$oldlistcategory, SQLITE3_TEXT);

			$temp2->execute();

			echo "<span style='color:green; padding-left:10px; font-family:'Varela Round'; '>Deleted ".$oldlistcategory.".</span>";
			}
?>
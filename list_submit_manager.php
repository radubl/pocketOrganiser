<?php
session_start();

include 'list_displayer_manager.php';
require 'dbconn.php';

$db = new Database();
$items = $_POST['ids'];
$cat=$_POST['category'];

foreach($items as $element)
{
	$temp1=$db->prepare("Update listitems SET completed=1 WHERE (userid=:userid AND itemcontent=:itemcontent)");
	
	$temp1->bindValue(':userid',$_SESSION['id'],SQLITE3_INTEGER);

	$temp1->bindValue(':itemcontent',$element, SQLITE3_TEXT);
	
	$temp1->execute();
}

echo json_encode(getLists($cat));

?>



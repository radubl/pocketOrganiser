<?php
session_start();

include 'list_displayer_manager.php';
require "static_elements.php";

$ml = new Category($_GET['category']);
$ml->displaybody();

class Category{
	private $body;
	private $lists;
	
	function __construct($newtitle) {
		$this->lists = getLists($newtitle); 
		$this->body="<!DOCTYPE html>
				<html>
				<head>
				<meta http-equiv='Content-type' content='text/html;charset=UTF-8' />
				<title>" .$newtitle. "</title>
				<link rel='stylesheet' type='text/css' href='index.css'>
				<script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js' /></script>
				<script type='text/javascript' src='jscode.js'></script>
				</head>

				<body>
				<div id='main-wrapper' >
				". getHeader($newtitle) ."
				</div>
					". getHeaderBottom() ."
					
					<div style='height:8px;'></div>
					<div id='body-wrapper'> 
						    
							". getSideMenu('position: absolute; width:130px;  ')
							 ."<span id='list-container'>". $this->lists."</span>
							 
						<div style='clear:both; height:200px;'></div>
					
					
					</div>
				</div>

				</body>
				</html>";
		
	}
	
	function displaybody() {
	if(isset($_SESSION['id']))
		echo $this->body;
	else
	header("Location:../index.php");
		
	}
}
?>
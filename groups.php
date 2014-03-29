<?php
session_start();

/**
 *	The Group class creates a pattern for all the groups created in the application.
 *
 *
 */


include 'group_displayer_manager.php';
require "static_elements.php";
include "dropdownfunctions.php";
include 'group_updates_displayer.php';

$ml = new Group($_GET['group']);
$ml->displaybody();


class Group{
	private $body;
	private $groups='';
	
	function __construct($newtitle) {
		$this->groups = getGroups($newtitle); 
		$this->body="<!DOCTYPE html>
				<html>
				<head>
				<meta http-equiv='Content-type' content='text/html;charset=UTF-8' />
				<title>" .$newtitle. "</title>
				<link rel='stylesheet' type='text/css' href='index.css'>
				<script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js' /></script>
				<script type='text/javascript' src='jscode.js'></script>
				<script type='text/javascript' src='group_functions.js'></script>
				</head>

				<body>
					<div id='main-wrapper' >
						". getHeader($newtitle) ."</div>
						
						". getHeaderBottom() ."
					
						<div id='body-wrapper'>
							
							". getSideMenu('position: absolute; width:130px;') ."
							
							".$this->groups."
							
							<form style='padding-top:20px;'>
								<textarea id='updates' name='postings' rows='1' cols='100'>Write something for the group users.</textarea>
 								<span id='shy' onClick='submitMessage(&#39;".$newtitle."&#39;)' 
 								style=' height: 35px; width:90px; font-size:15px; padding:7px; margin: 2px 0px 0px 10px;'>Update</span>
								<span id='shy' onClick='getBillForm()' 
								style=' height: 35px; width:90px; font-size:15px; padding:7px; margin: 2px 0px 0px 10px;'>New Bill</span>
							</form>
							
							<div id='formbox'>

							
							<form class='checkbox-form' id='bill-form' method='POST'>
								<span class='checkbox-item'> Bill Name:</span> <input class='reg' style='left:220px; width:300px;' type='text' name='billname'>
								<br><br> 
								
								<span class='checkbox-item'> Amount:</span> <input class='reg' style='left:220px; width:300px;' type='text' name='amount'>
								<br><br> 
								
								<input type='radio' id='norm' name='group1' value='Normal' checked><span class='checkbox-item'>Normal Split.</span> <br>
								<input type='radio' id='prop' name='group1' value='Proportional' ><span class='checkbox-item'>Proportional Split.</span> 
								<br><br>
								
								<div id='propsplit' style ='position:relative;'>
								".getMembersSplit($newtitle)."
								</div>
								<br>
								<span  style='padding-left:10px;'>
								<input type='checkbox' id='payforit' class='regular-checkbox'> <span class='checkbox-item'>I'm not paying for it.</span> <br><br>
								</span>
								
								<div id='duedatediv'>
									<span class='checkbox-item'> Due Date:</span>
									
									<select class='reg' style='left:220px; width:190px;' type='text' name='billduedate1'>
										". getDates() ."
									</select> 
									
									<select class='reg' style='left:420px; float:left; width:100px;' type='text' name='billduedate2'>
										".  getHours() ." 
									</select><br><br>
								</div>
								
								<span class='checkbox-item'>Bill details:</span><br><br> 
								
								<textarea id='billdetails' class='reg' style='left:20px; height:100px; width:500px; resize:none;' rows='10' cols='100'></textarea><br>
								
								<div style='clear:both; '></div>
								<br><br><br><br><br>
								
								<div id='shy' style='margin-left:10px;' onClick='submit_bill_and_slideup(&#39;".$newtitle."&#39;)' >Create</div>
								<div id='shy' style='margin-left:10px;' onClick='cancel_and_slideup()' >Cancel</div></form>
							</div>
							
							<div id='dataflow'>
							".  displayUpdates($newtitle) ."
							<div>
							
							

						</div>
					</div>

				</body>
				</html>";
		
	}
	
function displaybody() {
	if(isset($_SESSION['id']))
		echo $this->body;
	else
	header("Location:index.php");
		
	}
}
?>
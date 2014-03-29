<?php session_start();
if(!isset($_SESSION['id']))
	header("Location:index.php");?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv='Content-type' content='text/html;charset=UTF-8' />
<title>Manage Lists</title>
<link rel='stylesheet' type='text/css' href='index.css'>

<?php require "static_elements.php"; require 'security.php' ?>
<?php require "dropdownfunctions.php"; ?> 
<script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js' /></script>
<script type='text/javascript' src='jscode.js'></script>
<script type='text/javascript' src='formhandler.js'></script>
</head>

  </body>
  
  
	<div id='main-wrapper' >
   
		<?php echo getHeader("Manage Groups"); ?>
	  
	</div>

	<?php echo getHeaderBottom(); ?>
	
	
      <div id='body-wrapper'>

		<?php echo getSideMenu(''); ?>
		
		<div class='list-title' style='padding-left:265px; padding-top:23px;'>Create a new group, or add members to an existing one:</div>
		
		<form action='group_add_remove_manager.php' id='group-form' style='position:relative;' method='POST'>
			<span class='checkbox-item'> Group Name:</span>
			<input class='reg' style='left:220px; width:300px;' type='text' name='groupname'>
			
			<select class='reg' style='left:550px; float:left; width:250px;' type='text' name='DropGroupNames'>
				<?php echo getGroupNames(); ?> 
			</select><br><br>  <br>
			
			<?php echo displayFriendsToAdd(); ?>
			<br><br>
			<div style='clear:both; height:30px;'></div>
			<span class='checkbox-item'> Group Description:</span><br><br> 
			<textarea class='reg' style='left:20px; height:100px; width:500px; resize:none;' name='description' rows='10' cols='100'></textarea><br>
			<div style='clear:both; '></div>
			<br>

			<br><br><br>
			
			<input id='shy' style='margin-left:10px;' type='submit' value='Create'>
		</form>
		
		<div style='clear:both; height:30px;'></div>
		
		
		
		<div style='clear:both; height:200px;'></div>
		
	  
      </div>
    </div>

    </body>
</html>


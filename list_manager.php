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
   
		<?php echo getHeader("Manage Lists"); ?>
	  
	</div>
	
	<?php echo getHeaderBottom(); ?>
	
	
      <div id='body-wrapper'>

		<?php echo getSideMenu(''); ?>
		
		<div class='list-title' style='padding-left:265px; padding-top:23px;'> Create a new List or add items to an existing one. </div>
		
		<form class='checkbox-form' id='list-form' style='display:initial; margin:0px; margin-left: 110px; width:800px; position:relative;' method='POST'>
			<span class='checkbox-item'> List Name:</span> <input class='reg' style='left:220px; width:300px;' type='text' name='listname'>
			
			<select class='reg' style='left:550px; float:left; width:250px;' type='text' name='DropListNames'>
				<?php echo getListsNames(); ?> 
			</select><br><br> 
			
			<span class='checkbox-item'> Due Date:</span>
			
			<select class='reg' style='left:220px; width:190px;' type='text' name='duedate1'>
				<?php echo getDates(); ?> 
			</select> 
			
			<select class='reg' style='left:420px; float:left; width:100px;' type='text' name='duedate2'>
				<?php echo getHours(); ?> 
			</select><br><br>
			
			<span class='checkbox-item'> Category:</span> <input class='reg' style='left:220px; width:300px;' type='text' name='category'>
			
			<select class='reg' style='left:550px; float:left; width:250px;' type='text' name='DropCategories'>
				<?php echo getCategories(); ?> 
			</select><br><br>
			
			<span class='checkbox-item'> List Items (sepparated by dot):</span><br><br> 
			<textarea class='reg' style='left:20px; width:500px; resize:none;' name='items' rows='10' cols='100'></textarea><br>
			<div style='clear:both; '></div>
			<br><br><br><br><br><br><br><br><br><br><br>
			
			<?php require "list_add_remove_manager.php"; ?>
			
			<br>
			
			<input id='shy' style='margin-left:10px;' type='submit' value='Create'>
		</form>
		
		<div style='clear:both; height:30px;'></div>
		
		<div class='list-title' style='padding-left:265px; padding-top:23px;'> Delete a List or a Category. </div>
		<form class='checkbox-form' style=' margin-left:265px; width:800px; position:relative;' method='POST'>
			<span class='checkbox-item'> List Name:</span> 
			
			<select class='reg' style='left:550px; float:left; width:250px;' type='text' name='DeleteList'>
				<?php echo getListsNames(); ?> 
			</select><br><br> 

			<span class='checkbox-item'> Category:</span> 
			
			<select class='reg' style='left:550px; float:left; width:250px;' type='text' name='DeleteCategory'>
				<?php echo getCategories(); ?> 
			</select><br><br>
			
			<?php require "list_delete_manager.php"; ?>
			
			<br>
			
			<input id='shy' style='margin-left:10px;' type='submit' value='Delete'>
		</form>
		
		<div style='clear:both; height:200px;'></div>
		
	  
      </div>
    </div>

    </body>
</html>
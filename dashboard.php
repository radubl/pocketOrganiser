<?php session_start();
if(!isset($_SESSION['id']))
	header("Location:index.php");?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<title>Dashboard</title>
<link rel="stylesheet" type="text/css" href="index.css">
<?php require "static_elements.php" ?>
<?php require "dashboard_functions.php" ?>
<script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js' /></script>
<script type='text/javascript' src='jscode.js'></script>
</head>

  <body >
    <div id="main-wrapper" >
    
	<?php echo getHeader("Dashboard"); ?>
		
	  
	</div>
	
	<?php echo getHeaderBottom(); ?>
	
      <div style='height:8px;'></div>
      <div id="body-wrapper">
		
		<div style="float:right; width: 340px; border-left: 1px solid #cccdce; background-color:white; " id='df'>
			<?php echo displayBalance(); ?>
		</div>
		
		<?php echo getSideMenu(''); echo getUserUpdates();?>	
		
		<div style="padding-top:30px; position:relative; float:left;"></div>
		
		<div style="height:300px; width:300px;"></div>
		
		<div style='clear:both; height:300px;'></div>
	
	  
      </div>
    

    </body>
</html>
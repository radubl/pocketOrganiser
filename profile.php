<?php
session_start();
if(!isset($_SESSION['id']))
	header("Location:index.php");?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<title>My Profile</title>
<link rel="stylesheet" type="text/css" href="index.css">
<?php require "static_elements.php" ?>
<script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js' /></script>
<script type='text/javascript' src='jscode.js'></script>
<script type='text/javascript' src='formhandler.js'></script>
</head>

  <body >
    <div id="main-wrapper" >
    
	<?php echo getHeader("My Profile"); ?>
		
	  
	</div>

	<?php echo getHeaderBottom(); ?>
	
	
      <div id="body-wrapper">
		
		<?php echo getSideMenu(''); ?>
		
		<div style="font-size:30px; margin-left: 270px; color:#575858; padding-top:25px;">Update your profile details.</div>
		
		<div style="padding-top:30px; position:relative; float:left;">
		
			<form action="profile.php" style="margin-left: 110px;" method="post">
				
				<span class="checkbox-item"> Update Name: </span>		 <input  class="reg" name="fullname" type="text"> 		<br><br>
				<span class="checkbox-item"> Choose new username:</span> 	 <input  class="reg" name="username" type="text"> 		<br><br>
				<span class="checkbox-item"> Old password:</span> 	 	<input class="reg" name="oldpassword" type="password"			><br><br>
				<span class="checkbox-item"> Choose new password:</span> 	 <input class="reg" name="newpassword" type="password"		><br><br>
				<span class="checkbox-item"> Repeat new password: </span>	 <input class="reg" name="newpassword2" type="password"		><br><br>
				<span class="checkbox-item"> Update Email adress:   </span>	 <input class="reg" name="email"	type="email"			><br><br>
				<span  style="padding-left:10px;">
				<input type="checkbox" class="regular-checkbox"> <span class="checkbox-item">Receive our newsletter?</span> <br><br>
				<?php require 'profilemanager.php'?>
				<input id='shy' style='margin-left:10px;' type='submit' value='Update Details'>
				</span>
			
			</form>
		</div>
		
		<div style="float:left; height:300px; width:300px;"></div>
		
		<div style='clear:both; height:300px;'></div>
	
	  
      </div>
    </div>

    </body>
</html>
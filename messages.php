<?php
session_start();
if(!isset($_SESSION["id"]))
	header("Location:index.php");?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<title>Messages</title>
<link rel="stylesheet" type="text/css" href="index.css">
<?php require "static_elements.php"; ?>
<?php require "messages_functions.php"; ?>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js" /></script>
<script type="text/javascript" src="jscode.js"></script>
<script type="text/javascript" src="messages_functions.js"></script>

</head>

  <body>
    <div id="main-wrapper" >
    
	<?php echo getHeader("Messages"); ?>
		
	</div>
	
	<?php echo getHeaderBottom(); ?>
	
      <div id="body-wrapper">
		
		<?php echo getSideMenu(""); ?>
		<div style="width:20px; height:1px; margin-top: 8px;"></div>
		<div style="float:right; border-left: 1px solid #cccdce; background-color:white; positsion:absolute; " id="df">
			<?php echo displayMessagesMenu(); ?>
		</div>

		<div id="messagebody">
			<div style="margin:20px 0px 0px 150px;">
				<div style="font-size:30px; color:#575858; padding-top:25px;">Start a new conversation</div>
				
				<div style="padding-top:30px; ">
				
					<form action="messages_manager.php" style="margin-left: 110px;" method="post">
						
						<span class="checkbox-item"> Name: </span> <input style="left:600px;" class="reg" 
						onkeyup="displayMatchedFriends()" name="fullname" type="text"> <br><br>
					
						<span  style="padding-left:10px;">
						
						</span>
					
					</form>
				</div>
				
			</div>
			
			<div id="fb" style="padding-top:0px;"></div>
		</div>
		<div style="clear:both; height:400px;"></div>
	  
      </div>
    </div>

    </body>
</html>
<!DOCTYPE html>
 <html>
  <head>
    <meta charset=UTF-8 />
    <title>ToDoMe Generator</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="text.css">
    <script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js' /></script>
    <script type='text/javascript' src='jscode.js'></script>
    <script type='text/javascript' src='formhandler.js'></script>
  </head>

    <body>
    <div id="main-wrapper" >
	<div style="background-color:#023480; height:80px;">

	  <div id="title">
	      Welcome to Pocket Organiser!
	  </div>

	  
	  <div style="float:right; padding:12px; padding-right:20px;">

	    <form action='login_manager.php' id='loginform' method='post'>
	    
		<div style="font-size:24px; float:left; padding-right :5px; color:white; text-align:right;">
			Already a member?
		</div>
		
	    <input class="onblue" id="username" type="text" name="username" value="username">
	    <div style="height:5px"> </div>
	    <div style="float:right;">
	    <input id="loginButton" class="onblue" type="submit" value="Login" >
	    <input class="onblue" id="password" type="password" name="password" value="password">
	    </div>
	    </form>

	  </div>
	  

	  
      </div>

      <div id="body-wrapper">
		<div style="height:20px;"></div>
		<div id="logo">
			<img src="logo3.png" alt="Smiley face" height="100" width="110">
		</div>

		<div id="subtitle">
			A small to-do App for you and your friends.<br><br>  
		</div>
		
		<div class="checkbox-item" style='width:1000px; padding-left:55px;'>
			We provide services such as group management and organisation, <b>bill splitting</b> possibilities, settling arguments through <b>instant group or private messaging</b> or making
			<b>To-Do Lists</b> for you and your friends.<br><br>  
		</div>
		
		
		<div class="checkbox-item" style='width:1000px; padding-left:55px;'>
			Therefore,  
		</div>
		
		<form class="checkbox-form" style="border-style:none; float:none; padding-left:55px; margin-left:0px; padding-top:30px;">

			<input type="checkbox" class="regular-checkbox" checked> <span class="checkbox-item"> You don't know your stuff? </span> <br>
			<input type="checkbox" class="regular-checkbox" checked> <span class="checkbox-item"> You want to be tidier and more organised?</span> <br>
			<input type="checkbox" class="regular-checkbox" checked> <strike><span class="checkbox-item"> You want to hack NASA?</span></strike> <br>
			<input type="checkbox" class="regular-checkbox" checked> <span class="checkbox-item"> We can help you.</span> <br>
			<input type="checkbox" id='register_checkbox' class="regular-checkbox"> <span class="checkbox-item"> Register! </span> <br>
		</form>
	     <br><br>
	     <div style="width:55px; height:132px; float:left;"></div>
	     <a href="register.php"><span id="shy" >Don't be shy.</span></a>
		

		<br><br><br><br><br>  <br>
		<div style="padding-left:55px;">(*web-design cliche 101: for every button, invert colors when hovering)</div>

	<!--      <br><br><br><br><br><br><br><br><br>-->
	      <br><br><br><br><br><br><br><br><br><br><br><br><br>
	  
      </div>
    </div>
    </body>

</html>
<html>
  <head>
    <title>Registration</title>
    <meta content="UTF-8">
    <link rel="stylesheet" type="text/css" href="index.css">
    <script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js' /></script>
    <script type='text/javascript' src='jscode.js'></script>
    <script type='text/javascript' src='formhandler.js'></script>
    <script type='text/javascript' src='registercode.js'></script>
  </head>
	
    <body>
    <div id="main-wrapper" >
	<div style="background-color:#023480; height:80px;">

	  <div id="title" style="width:1200px;">
	      Thank you for joining!
	  </div>
	</div>
	
	<div id="title" style="width:1200px; color:#023480; font-size:30px;">
	       though you should be thanking us, damn marketing.
	</div>
	
      <div id="body-wrapper" style="padding-top:100px;">
      
		<div style="padding-left:90px; position:relative;">

			<form  method='POST' id='reg-form' action='register.php'>
			
			<span class="checkbox-item"> Name: </span> <input  class="reg" name="fullname" type="text"> <br><br>
			<span class="checkbox-item"> Choose username:</span> <input  class="reg" name="username" type="text"> <br><br>
			<span class="checkbox-item"> Choose password:</span> <input class="reg" name="password" type="password"><br><br>
			<span class="checkbox-item"> Repeat password: </span><input class="reg" name="password2" type="password"><br><br>
			<span class="checkbox-item"> Email adress:   </span> <input class="reg" name="email" type="email"><br><br>
			<span  style="padding-left:10px;">
			<input type="checkbox" class="regular-checkbox"> <span class="checkbox-item">Receive our newsletter?</span> <br><br>
			</span>
			
			<input id='shy' style='margin-left:10px;' type='submit' value='Continue'>
			</form>
		</div>
		
		 <br><br><br><br><br>
		 <div style="padding-left:100px;">(to an unraveling world that has "never" been seen on the web before.)</div>
		<br><br>
      </div>
    

    </body>
  </html>
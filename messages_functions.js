var glob_message='';
glob_friend_id='';
var glob_innerhtmlfriends='<div style="margin:20px 0px 0px 150px;"><div style="font-size:30px; color:#575858; padding-top:25px;">Start a new conversation</div><div style="padding-top:30px; "><form action="messages_manager.php" style="margin-left: 110px;" method="post"><span class="checkbox-item"> Name: </span> <input style="left:600px;" class="reg" onkeyup="displayMatchedFriends()" name="fullname" type="text"> <br><br><span  style="padding-left:10px;"></span></form></div></div><div id="fb" style="padding-top:0px;"></div>';
var myVar;
var glob_wid=38;

function showMessages(friendid){

glob_friend_id=friendid;
window.clearInterval(myVar);

$.post('messages_adder.php', {
	'user' : friendid,
	'message' : '',
	}, function(data) {
		$(document).ready(function() {
			var json_object = JSON.parse(data);
			document.getElementById("messagebody").innerHTML = json_object;
			myVar=setInterval(function(){myTimer(glob_friend_id)},4000);
		});
	});
	
}

function submitMessage(friendid){

	var message=glob_message;

	glob_friend_id=friendid;
	
$.post('messages_adder.php', {
	'user' : friendid,
	'message' : message,
	}, function(data) {
		$(document).ready(function() {
			var json_object = JSON.parse(data);
			document.getElementById("messagebody").innerHTML = json_object;
			
		});
	});
	
}

function displayMatchedFriends(){
	
	var ids = $('[name=fullname]').val();
	
	$.post('messages_manager.php', {
	'fullname' : ids,
	}, function(data) {
		$(document).ready(function() {
			var json_object = JSON.parse(data);
			document.getElementById("fb").innerHTML = json_object;
			
		});
	});
    
}

function addMessage(){
    
    var array = $('.regular-checkbox:checked').map(function(){
        return $(this).val();
    }).toArray();
    
    var message=$('#firstmessage').val();

    $.post('messages_creator.php', {
      'users' : array,
	'message' : message,
    }, function(data) {
	    $(document).ready(function(){
		var json_object = JSON.parse(data);
		document.getElementById("df").innerHTML = json_object;
		});
	 });
}

function backToNewMessage(){
	document.getElementById("messagebody").innerHTML = glob_innerhtmlfriends;
	window.clearInterval(myVar);
}

$(document).on("focus",'#updates', function(){
	$("#updates").val("");
	$("#updates").css("color", "black");
	window.clearInterval(myVar);
});
$(document).on("keypress",'#updates', function(e){
	if(e.which == 13) {
		glob_wid+=19;
		glob_message+=$('#updates').val()+"<br>";
		$("#updates").css("height", glob_wid+"px");
	}
});
$(document).on("blur",'#updates', function(){
	glob_message=$('#updates').val();
	$("#updates").val("Write something here.");
	$("#updates").css("color", "#cccdce").css("height", "38px");;
	glob_wid=38;
	window.clearInterval(myVar);
	myVar=setInterval(function(){myTimer(glob_friend_id)},4000);
});

$(document).on("focus",'#firstmessage', function(){
	$("#firstmessage").val("");
	$("#firstmessage").css("color", "black");
	window.clearInterval(myVar);
});

function myTimer(friendid)
{
$.post('messages_adder.php', {
	'user' : friendid,
	'message' : '',
	}, function(data) {
		$(document).ready(function() {
			var json_object = JSON.parse(data);
			document.getElementById("messagebody").innerHTML = json_object;
			
		});
	});
}
window.onbeforeunload = function () {
	window.clearInterval(myVar);
}
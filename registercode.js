
$(document).ready(function() {
    
$('#reg-form').submit(function() {									//registration
var message='';

if($('[name="password"]').val().length<1)
	message='Choose a valid password!';
else
	if($('[name="password"]').val()!=$('[name="password2"]').val())
		message='Passwords do not match.';

if($('[name="email"]').val().length<1)
	message='Please give us your email so we can spam the shit out of you';
if($('[name="email"]').val().length>50)
	message='Our hamsters cannot comprehend the length of your email!';
	
if($('[name="fullname"]').val().length<1)
	message='Choose a valid Full Name!';
if($('[name="fullname"]').val().length>20)
	message='Our hamsters cannot comprehend the length of your fullname!';
	
if($('[name="username"]').val().length<1)
	message='Choose a valid username!';
if($('[name="username"]').val().length>25)
	message='Our hamsters cannot comprehend the length of your username!';

if(message=='')
{
$.post('regmanager.php', {
				'fullname' : $('[name="fullname"]').val(),
				'username' : $('[name="username"]').val(),
				'password' : $('[name="password"]').val(),
				'password2': $('[name="password2"]').val(),
				'email': $('[name="email"]').val()
				}, function(data) {
				var json_object = JSON.parse(data);
				
				if(json_object=='')
					window.location = 'dashboard.php';
				else
				    alert(json_object);
	});
}
else
	alert(message);

return false;
	});

});
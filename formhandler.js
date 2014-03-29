

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
	return true;

alert(message);
return false;
	});

$('#list-form').submit(function() {									//list-manager

var msg='';

if($('[name="items"]').val().length<1)
	msg='Put some items in there!';

if($('[name="category"]').val().length<1 && $('[name="DropCategories"]').val()=="Existing")
	msg='Select a category!';
if($('[name="category"]').val().length>15)
	msg='Our hamsters cannot comprehend the length of your category!';
	
if($('[name="listname"]').val().length<1 && $('[name="DropListNames"]').val()=="Existing")
	msg='Choose a valid List Name!';
if($('[name="listname"]').val().length>25)
	msg='Our hamsters cannot comprehend the length of your List Name!';

if(msg=='')
	return true;

alert(msg);
return false;
	});


$('#group-form').submit(function() {									//group-manager

var msg='';
	
if($('[name="groupname"]').val().length<1 && $('[name="DropGroupNames"]').val()=="Existing")
	msg='Choose a valid Group Name!';
if($('[name="groupname"]').val().length>25)
	msg='Our hamsters cannot comprehend the length of your Group Name!';

if(msg=='')
	return true;

alert(msg);
return false;
	});
});







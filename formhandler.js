/**
 *
 *	Handles the forms submitted 
 	Checkes for empty fields and imposes limitations on length of user inputs accordingly
 *
 */


$(document).ready(function() {
    
$('#register_checkbox').click(function(){
    document.location.href = 'register.php';
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







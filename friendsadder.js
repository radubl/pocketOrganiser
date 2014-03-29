
function displayMatchedFriends(){
	
	var ids = $('[name=fullname]').val();
	
	$.post('friends_manager.php', {
	'fullname' : ids,
	}, function(data) {
		$(document).ready(function() {
			var json_object = JSON.parse(data);
			document.getElementById("fb").innerHTML = json_object;
			
		});
	});
    
}

function addFriends(){
    
    var array = $('.regular-checkbox:checked').map(function(){
        return $(this).val();
    }).toArray();

    $.post('friends_adder.php', {
      'friends' : array,
    }, function(data) {
	    $(document).ready(function() {
		var json_object = JSON.parse(data);
		document.getElementById("df").innerHTML = json_object;
		});
	 });
}

function deleteFriend(friend){
   
    $.post('friends_deleter.php', {
      'friend' : friend,
    }, function(data) {
	    $(document).ready(function() {
		var json_object = JSON.parse(data);
		document.getElementById("df").innerHTML = json_object;
		});
	 });
}
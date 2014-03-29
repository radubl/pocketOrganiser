var glob_message='';
var glob_lastFocus = '';
var x=300;
var glob_wid=38;
var glob_checked=1;
var glob_checked2=1;

function leaveGroup(group){
	
	var answer = confirm ("Are you sure?");
	if(answer){
		$.post('group_leaving_manager.php', {
		'group' : group,
		}, function(data) {
				document.location.href = 'dashboard.php';
		});
	}
}

function submitMessage(group){
	var message=glob_message;
	if(group=='rgdg') alert('no');
	glob_message='';
	if(message!='Write something for the group users.' && message.replace(/\s/g, "")!="")
		$.post('group_updates_manager.php', {
		'message' : message,
		'groupname' : group
	}, function(data) {
		
		var json_object = JSON.parse(data);
		document.getElementById("dataflow").innerHTML = json_object;
		
		});
}

function deleteUpdate(groupname,datecreated){
	
		$.post('group_updates_deleter.php', {
		'groupname' : groupname,
		'datecreated' : datecreated,
	}) .success(function(data) {
		var json_object = JSON.parse(data);
		document.getElementById("dataflow").innerHTML = json_object;
		
		});
}

$(document).ready(function() {

$(document).on("click",'#payforit', function(){
	if(glob_checked==1){
		$('#duedatediv').slideDown();
		glob_checked=0;
	}
	else{
		$('#duedatediv').slideUp();
		glob_checked=1;
	}
});

$(document).on("click",'#prop', function(){

		$('#propsplit').slideDown();

	
});
$(document).on("click",'#norm', function(){
		$('#propsplit').slideUp();

	
});

$(document).on("focus",'#updates', function(){
	$("#updates").val("");
	$("#updates").css("color", "black");
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
	$("#updates").val("Write something for the group users.");
	$("#updates").css("color", "#cccdce").css("height", "38px");;
	glob_wid=38;
});

});

function getBillForm() {
	$(document).ready(function() {
		$('#bill-form').slideDown();
		$('#bill-form').focus();
	});
	
}
function cancel_and_slideup(){
$(document).ready(function() {
		$('#bill-form').slideUp();

});
}

function submit_bill_and_slideup(group){
	
	if($('[name="billname"]').val()=='' || $('#billdetails').val()=='')
	{
		alert("We kind of require the fields not to be empty, just so, for the whole purpose of this application");
		return false;
	}
	if(isNaN(parseFloat($('[name="amount"]').val())))
	{
		alert("Please let the amount be a number.");
		return false;
	} 
	var newbillname = $('[name="billname"]').val();
	var details = $('#billdetails').val();
	var amount = parseFloat($('[name="amount"]').val());
	
	if(glob_checked==0)
	{
		var newduedate1 = $('[name="billduedate1"]').val();
		var newduedate2 = $('[name="billduedate2"]').val();
	}
	else
	{
		var newduedate1 = 'paid';
		var newduedate2 = '';
	}
	
	var splitmode='';

		var percentages = $('.percentage');
		var sum100=0;
		
		for( var i =0;i<percentages.length;i++)
		{
			if($('#prop:checked').length!=0)
			{	
			sum100 += parseFloat(percentages[i].value);
			splitmode += percentages[i].value + '/';
			}
			else
			{	
			sum100 += 100/percentages.length;
			splitmode += 100/percentages.length + '/';
			}
		}

		if(sum100<99 || sum100>101)
		{
			alert("The amounts you entered in each box do not sum up to 100.");
			return false;
		}
	
	$.post('bill_add_item_ajax.php', {
	'billname' : newbillname,
	'group' : group,
	'description' : details,
	'duedate1' : newduedate1,
	'duedate2' : newduedate2,
	'amount' : amount,
	'splitmode' : splitmode,
	}, function(data) {
		
	var json_object = JSON.parse(data);
	document.getElementById("dataflow").innerHTML = json_object;

	
	$(document).ready(function() {
		$('#bill-form').slideUp();

}	);
	
	});
					
}

function payBill(billid){
	
		$.post('bill_pay_manager.php', {
		'billid' : billid,
		}) .success(function(data) {
		var json_object = JSON.parse(data);
		document.getElementById("dataflow").innerHTML = json_object;
		
		});
}


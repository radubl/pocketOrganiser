var glob_message='';
var glob_lastFocus = '';
var x=300;
var glob_adder_limiter=-1;
var glob_adding_div="<span></span>";

function checkAll(bx, formname) 
{
	var cbs = document.forms[formname].getElementsByTagName("input");

	for(var i=0; i < cbs.length; i++) 
		{
			if(cbs[i].type == "checkbox")
				{
					cbs[i].checked = bx.checked;
				}
		}
}

function submitAll(cats){
    
    var array = $('.regular-checkbox:checked').map(function(){
        return $(this).val();
    }).toArray();

    $.post('list_submit_manager.php', {
      'category' : cats,
      'ids' : array
    }, function(data) {
		var json_object = JSON.parse(data);
		document.getElementById("list-container").innerHTML = json_object;
		$(document).ready(function() { 
			var body = $("html, body");
			body.animate({scrollTop:0}, '500', 'swing', function() { 
			});
		});
    });
}
function backToTop(){
	$(document).ready(function() { 
	var body = $("html, body");
	body.animate({scrollTop:0}, '500', 'swing', function() { 
	});
});
	
}

function payIndividual(userid){
	var amount=prompt("Please enter the amount you want to pay");
	
	while(isNaN(parseFloat(amount)))
	{
		amount=prompt("Please let the amount be a number.");
	} 
	
	$.post('bill_pay_individual.php', {
				'amount' : amount,
				'userid' : userid,
				}, function(data) {
				//alert(values[0]+values[2]+item);
				//location.reload();
		});

}

$(document).ready(function() {
$(document).on("blur",'.freshitem', function(){
	$(".freshitem").val("Quick add a new item.");
	$(".freshitem").css("color", "#cccdce").css("height", "38px");;
});

$(document).on("focus",'.freshitem', function(){
	$(".freshitem").val("");
	$(".freshitem").css("color", "black");
});

$("#username").on("focus", function(){			//For index-login page
	$("#username").val("");

});
$("#username").on("click", function(event){			
	$("#username").val("");
	$("#username").css("color", "black");
});

$("#password").on("focus", function(){			//For index-password page
	$("#password").val("");

});
$("#password").on("click", function(event){			
	$("#password").val("");
	$("#password").css("color", "black");
});


$("#go_over").mouseover( function(){
		$("#hideable").slideDown(x);
	})

$("#hider_wrapper").mouseleave( function(){
		$("#hideable").slideUp(x);
	});

$("#hider_wrapper").hover(function(){
$("#1.side-menu-item").css("background-color","#023480").css( "color","white").css( "width","150px").css( "border-color","#023480");
	},function(){
$("#1.side-menu-item").css("background-color","white").css( "color","#023480").css( "width","95px");
});

	$("#go_over2").mouseover( function(){
			$("#hideable2").slideDown(x);
		})

	$("#hider_wrapper2").mouseleave( function(){
			$("#hideable2").slideUp(x);
		});


	$("#hider_wrapper2").hover(function(){
		$("#2.side-menu-item").css("background-color","#023480").css( "color","white").css( "width","150px").css( "border-color","#023480");
			},function(){
		$("#2.side-menu-item").css("background-color","white").css( "color","#023480").css( "width","95px");
		});
	
$(document).on("keypress",'.freshitem', function(e){
	if(e.which == 13) 
		var AwesomeArray = $('textarea');
		var i = 0;
		for(i=0;i<AwesomeArray.length;i++)
		{
			if(AwesomeArray[i].value!='')		
			{
				var values = AwesomeArray[i].name.split('d!nj#$&hds');
				if (AwesomeArray[i].value.match(/[/.]?/g)) 
					var item = AwesomeArray[i].value;
				else  var item = AwesomeArray[i].value + '.';
				
				$('.freshitem').val("");
				
				$.post('list_additem_ajax.php', {
				'listid' : values[0],
				'listcategory' : values[2],
				'item' : item,
				'userid' : values[1],
				}, function(data) {
				//alert(values[0]+values[2]+item);
				var json_object = JSON.parse(data);
				document.getElementById("list-container").innerHTML = json_object;
				$('.freshitem').focus();
				});
			}
		}
    });

});
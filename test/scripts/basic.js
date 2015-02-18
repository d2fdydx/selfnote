$(document).ready(function(){
	
	init();

});

function init(){
	$( ".Critical").click(function(){
		
		event.preventDefault();
		var target = $(this ).attr("value");
		$( "#dialog-confirm" ).dialog({
		  resizable: false,
		  height: 200,
		  modal: true,
		  buttons: {
			Confirm: function() {
			
				$( this ).dialog( "close" );
				$.post( "", {'Control': 'user' , 'Action':'delete' ,'id': target},function(data){
					
					$("#main").html(data);
					init();
				}).fail(function(){
					alert("fail");
				});
				//alert ("sent");
			},
			Cancel: function() {
			  $( this ).dialog( "close" );
			}
		  }
		});
		
	});
	


}
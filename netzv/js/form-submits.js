$(document).ready(function(){
	// Formulär som ska hämtas och skickas till en specifik php-fil.
	$("form.SubmitFormAjax").on("submit",function( eventForm ){
		eventForm.preventDefault();
		
		var formInputValues = $(this).serialize();
		$.ajax({
				type: 'POST',
				url: '/netzv/js/ajax_calls_form_submits.php?',
				data: formInputValues,
				dataType: 'json',
				beforeSend:function(){
					// this is where we append a loading image
					$("#ajaxLoadModal").show();
				},
				success:function(data){
					// successful request; do something with the data
					$("#ajaxLoadModal").hide();
					// Ifall return-svaret på php-data-variablen inte är success så visas errors här.
					if( !data.success ){
						var alertMsg="";
						
						if(alertMsg.length)
							alert( alertMsg );
					}
					else{
						if( typeof data.newCvId != "undefined" ){
							window.location.replace( "./?userID=" + data.loggedInUser + "&cvID=" + data.newCvId );
						}
						if( data.addWork == true || data.addEdu == true )
						{
							if( data.addWork == true){
								var idOfDiv="#workXpDivList";
							}
							else if( data.addEdu == true){
								var idOfDiv="#eduDivList";
							}
							$( idOfDiv ).prepend( data.ajaxContent );
						}
					}
				},
				error:function(data){
					$("#ajaxLoadModal").hide();
					console.log(data)
				}
		});
	});
	
	// Hitta profiler-sökformulär.
	$("form.SubmitFormSearchUsers").on("submit",function( eventForm ){
		eventForm.preventDefault();
		// alert("Hej! DU söker på profiler ser jag");
		
		var formInputValues = $(this).serialize();
		$.ajax({
				type: 'POST',
				url: '/netzv/js/ajax_calls_form_submits.php?',
				data: formInputValues,
				dataType: 'json',
				beforeSend:function(){
					// this is where we append a loading image
					$("#ajaxLoadModal").show();
				},
				success:function(data){
					// successful request; do something with the data
					$("#ajaxLoadModal").hide();
					// Ifall return-svaret på php-data-variablen inte är success så visas errors här.
					if( !data.success ){
						var alertMsg="";
						
						if( alertMsg.length )
							alert( alertMsg );
					}
					else{
						// alert(data.searchReturnRows);
						if( data.searchReturnRows )
							$( "#userResults" ).html( data.searchReturnRows );
					}
				},
				error:function(data){
					$("#ajaxLoadModal").hide();
					console.log(data)
				}
		});
	});
});
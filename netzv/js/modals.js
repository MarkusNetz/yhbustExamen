$( document ).ready(function() {
	// Göm och visa modal
	if( $(".w3-modal").length ){
		$(".w3-modal").hide();
	}
	
	// New CV -modal
	if( $("#newCvModalTrigger") && $("#newCvModalTrigger").val() == 1 ){
		$("#newCvModal").show();
	}
	
	
	// Show modals for work/edu
	$(".modalShow").bind("click",function(e){
		e.preventDefault();
		$("#"+$( this ).attr("data-modal-type")).show();
	});
	
	$(".modalClose").bind("click",function(e){
		e.preventDefault();
		$("#"+$( this ).attr("data-modal-type")).hide();
	});
});
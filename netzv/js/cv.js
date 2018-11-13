$( document ).ready(function() {
	// När checkboxar på sidan CV ändras så ska denna reagera.
	$("input[type='checkbox']").change( function(){
		if($(this).attr("data-checkToggleInput") ==1 ){
			var attr_row_id=$(this).attr("data-rowId");
			if ( $( this ).prop( "checked" ) ){
				$("#end_date_" + attr_row_id).prop("disabled", true);
				$("#end_date_" + attr_row_id).prop("required", false);
				$( this ).prop("required", true);
			}
			else{
				$("#end_date_" + attr_row_id).prop("disabled", false);
				$("#end_date_" + attr_row_id).prop("required", true);
				$( this ).prop("required", false);
			}
		}
	});

});

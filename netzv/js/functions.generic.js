function copyToClipboard( elem )
{
		/* Get the text field */
		var copyText = document.getElementById( elem );

		/* Select the text field */
		copyText.select();

		/* Copy the text inside the text field */
		document.execCommand("copy");

		/* Alert the copied text */
		// alert("Copied the text: " + copyText.value);
}


// Function for getting the fb-response status "connected". Then we should trigger the "login" for the page so the system acts upon this connected-status.
function loginStartFbProcessing(fbResponseCallback)
{
	fbOauthData = "fb_uid=" + fbResponseCallback.id + "&fb_firstname=" + fbResponseCallback.first_name + "&fb_lastname=" + fbResponseCallback.last_name + "&fb_pri_mail=" + fbResponseCallback.email + "&process=fbProcessingOauth";
	$.ajax({
			type: 'POST',
			url: '/netzv/js/oauth_serverside_ajax_calls.php',
			data: fbOauthData,
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
					// Successful response on ajax call.
					location.replace("https://netzarna.eu/netzv/profile/");
				}
			},
			error:function(data){
				$("#ajaxLoadModal").hide();
				console.log(data)
			}
	});
}
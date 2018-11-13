$( document ).ready(function() {
	
	//Kopiera shortlink vid klick på shortlink-presentationen.
	$( ".copyShortLink" ).click(function(){
		var elem = $(this).attr("id");
		
		copyToClipboard( elem );
	});
	
	$(".skillsList").on("click","a.removeSkill",function(event){
		event.preventDefault();
		
		$.post("/netzv/js/post_calls.php",
		{
			event: "removeUserSkill",
			skillID: $(this).attr("data-skillId")
		},
		function(data, status){
			if(status == "success")
			{
				$(".skillsList").html(data );
			}
		});
	});
	
	$("#addSkillBtn").on("click",function(){
		var enteredVal=$("#addUserSkill").val();
		
		if( $("#skills_list option").filter(function(){
			return this.value === enteredVal;
		}).length){
			var skillExistsFromTemplate=true;
			// alert("Clicked a new skill to add." + enteredVal + ". It exists in datalist.");
			// This if now only matches the existing items. If no items are matched, the entry should be added to table and then be able to be reused by other users :)
			// The users will contribute to the total backlog of items possible to add as skills.
			
		}
		else
			var skillExistsFromTemplate=false;
		
		$.post("/netzv/js/post_calls.php", 
		{
			event: "addUserSkill",
			skillName: enteredVal,
			skillTemplate: skillExistsFromTemplate
		},
		function(data, status){
			if(status == "success")
			{
				alert(data)
				splitData=data.split("%%");
				$("#addUserSkill").val("");
				$(".skillsList").html(splitData[0]);
				$("#skills_list").html(splitData[1]);
			}
		});
	
	});
	
	$("#oauth-fb_login-btn").on("click", function(){
		FB.login(function(response) {
			// handle the response
			if (response.status === 'connected') {
				initAPI();
			}
			else if (response.status === 'not_authorized') {
				statusChangeCallback(response, "redirOnRegistered");
			}
	},{scope: 'email', return_scopes: true});
		
	});
	
	$("#oauth-fb_reg-btn").on("click", function(){
		FB.login(function(response) {
			// handle the response
			if (response.status === 'connected') {
				if( response.email != "undefined" )
					initAPI();
				else
				$("#fb-message-box").text("För att kunna registrera dig behövs en e-postadress från din facebook-profil.")
				
			}
			else if (response.status === 'not_authorized') {
				$("#fb-message-box").text("Du behöver godkänna netzarna web services för att kunna registrera med facebook.")
			}
	},{scope: 'email', return_scopes: true});
		
	});
	
	// $("#custom-registration").hide();
	$("#toggle-custom-registration").on("click", function(){
		$("#custom-registration").toggle();
	});
});
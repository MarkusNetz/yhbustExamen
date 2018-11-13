// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response, reg_stat="") {
	console.log('statusChangeCallback');
	console.log(response);
	// The response object is returned with a status field that lets the
	// app know the current login status of the person.
	// Full docs on the response object can be found in the documentation
	// for FB.getLoginStatus().
	if (response.status === 'connected') {
		// Logged into your app and Facebook.
		
		// testAPI();
		if(reg_stat == "redirOnRegistered" ){
			initAPI();
		}
	} else {
		// The person is not logged into your app or we are unable to tell.
		// document.getElementById('status').innerHTML = 'Please log ' +
		// 'into this app.';
	}
}

// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});
}

window.fbAsyncInit = function() {
	FB.init({
	appId      : '2077280685881658',
	cookie     : true,  // enable cookies to allow the server to access 
						// the session
	xfbml      : true,  // parse social plugins on this page
	version    : 'v2.8' // use graph api version 2.8
	});

	// Now that we've initialized the JavaScript SDK, we call 
	// FB.getLoginStatus().  This function gets the state of the
	// person visiting this page and can return one of three states to
	// the callback you provide.  They can be:
	//
	// 1. Logged into your app ('connected')
	// 2. Logged into Facebook, but not your app ('not_authorized')
	// 3. Not logged into Facebook and can't tell if they are logged into
	//    your app or not.
	//
	// These three cases are handled in the callback function.

	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});

};

// Load the SDK asynchronously
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = 'https://connect.facebook.net/sv_SE/sdk.js#xfbml=1&version=v3.1&appId=2077280685881658&autoLogAppEvents=1';
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function testAPI()
{
	console.log('Welcome!  Fetching your information.... ');
	FB.api(
		'/me',
		function(response){
			console.log( 'Successfully logged in, ' + response.name + '!');
		});
}
function initAPI()
{
	FB.api('/me?fields=id,first_name,last_name,email', 	function(response){
											// Insert your code here
											
											// alert("ID: " + response.id +"\nName: " + response.name + "\nPrimary e-mail: " + response.email);
											
											// I now need to check the returned data with db-info. If the id from response.id does not exist inside the table t_user_has_facebook.fb_id then it should be added to that table.
											// Will make an ajax call that takes care of that check.
											// IT should check for matching email in t_user_has_login.login and if there is a match the user is logged in.
											// Today the logged in session for the page is tightly connected with the custom mail, pass procedure.
											
											loginStartFbProcessing(response);
										}
	);
}
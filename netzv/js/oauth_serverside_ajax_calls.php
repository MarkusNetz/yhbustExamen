<?php
$top_level="../../";
$sub_top_level=$top_level."netzv/";

require ($top_level . "ini/settings.php");

$data=$errors=null;
if(isset($_POST['process']) ){
	// include "../". $folder_inc ."function.oauth_functions.php";
	
	if( $_POST['process'] == "fbProcessingOauth"){
		if( $loggedInUser != null)
			echo "Hej, användaren är redan inloggad enligt systemet.";
		else
		{
			// Kolla att de grundläggande infon finns för att spara ner till fb.
			if(isset($_POST['process'],$_POST['fb_uid'],$_POST['fb_pri_mail']))
			{
				// Vi måste först kolla ifall det finns en användare i tabellen t_user_has_facebook
				$sqlSelectFbConnectedRow = "select fb_email, id_user FROM t_user_has_facebook uhf WHERE uhf.fb_email = :param_user_login AND uhf.fb_id = :param_fb_id";
				$dbConn->query( $sqlSelectFbConnectedRow );
				$dbConn->bind(":param_user_login", $_POST['fb_pri_mail'] );  // Bind "$email" to parameter.
				$dbConn->bind(":param_fb_id", $_POST['fb_uid']);  // Bind "$email" to parameter.
				$dbConn->single();   // Execute the prepared query and return the first row of result.
				
				// Om ingen användare finns i t_user_has_facebook med denna fb_id eller fb_email.
				// då ska vi lägga till dem i t_user_has_facebook och sedan kolla vidare om användarkonto finns. Om det inte finns så är detta en nyregistrering och då skapas ett användarkonto.
				include $sub_top_level . $folder_inc ."functions.generic.php"; // Contains the addUserToApp-function.
				if($dbConn->rowCount() == 0)
				{
					// User row was not found.
					// Add user-account to db and connect it to the user.
					
					// Either create a user, and connect it to the logged in fb-user OR
					// connect an existing app-user with the logged in fb-user.
					
					//This part will create an fb-account and link it to an existing app-user.
					// This login-table is automatically filled with correct information if a user has registered "the old fashion way".
					// Which means I do not have to check for the "id_user" in t_users-table.
					$sqlGetUser = "SELECT id_user FROM t_user_has_login WHERE login = :param_user_login_mail";
					$dbConn->query( $sqlGetUser );
					$dbConn->bind(":param_user_login_mail", $_POST['fb_pri_mail']);  // Bind "$email" to parameter.
					$row=$dbConn->single();
					
					$userInfo=array( $_POST['fb_uid'], $_POST['fb_firstname'], $_POST['fb_lastname'], $_POST['fb_pri_mail']);
					if($dbConn->rowCount() == 1)
					{
						// Användarkonto finns som matchar samma epost. Då är det fb-konto som saknas, skapa det och koppla till användar-id.
						$statusOfFunctionInvoked = addUserAccountFromOAuth($userInfo, $dbConn, $row['id_user'] );
						
					}
					elseif($dbConn->rowCount() == 0){
						// Användarkonto saknas som matchar denna fb-auth. Då ska vi skapa användarkonto, och skapa fb-tablerow.
						$statusOfFunctionInvoked = addUserAccountFromOAuth( $userInfo, $dbConn );
						
					}
					if($statusOfFunctionInvoked == true )
						include $sub_top_level . $folder_inc ."process_login.php";
				}
				// The fb-connected user has an account in our fb-table and we continue with loging in.
				elseif($dbConn->rowCount() == 1)
				{
					// Användaren är inloggad på appen via facebook-konto, men inte inloggad i vår app, men fb har autentiserat sessionen.
					include $sub_top_level . $folder_inc ."process_login.php";
					
				}
			}
		}
	}

	// Avgör om ett call gick bra eller ej, sett ur ett serverside-perspektiv. Det kan fortfarande gå dåligt vid js-bearbetning efteråt.	
	if ( ! empty($errors)) {
        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

		// if there are no errors return a message

		// show a message of success and provide a true success variable
		$data['success'] = true;
		$data['message'] = 'Success!';
    }
	
	// Skriv ut data som returneras som svar.
	echo json_encode($data);
}
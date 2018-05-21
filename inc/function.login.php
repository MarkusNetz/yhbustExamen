<?
// -----
// Säker sessionsstart
// -----
function sec_session_start()
{
    $session_name = 'netzarna_session_id';   // Set a custom session name
    $secure = SECURE; // Denna hämtas från db-config som har en konstant som heter SECURE. Där sätts värdet.
    
	// This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
	// each client should remember their session id for EXACTLY 1 hour
	$lifetimesec=3600*24*3;
	ini_set('session.gc_maxlifetime', $lifetimesec);
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($lifetimesec,
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
	
	// Sets the session name to the one set above.
	session_name($session_name);
	session_start();            // Start the PHP session 
	session_regenerate_id(true);    // regenerated the session, delete the old one. 
}
// SLUT - säker sessionsstart.

// ----
// Inloggningsfunktion
// ----
function login($email, $password, $db_conn) {
    // Using prepared statements means that SQL injection is not possible.
	$LoginSQL="SELECT user_id, FROM t_user_has_login WHERE login = ?";
    if ($LoginStmt = $db_conn->prepare($LoginSQL)){ 
        $LoginStmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $LoginStmt->execute();    // Execute the prepared query.
        $LoginStmt->store_result();
 
        // get variables from result.
        $LoginStmt->bind_result($user_id, $username, $db_password, $eogid, $passtype);
        $LoginStmt->fetch();
		$passtype=strtolower($passtype);
		
		// Kontrollera passtype
		if( $passtype === "ok" || $passtype === "once")
		{
			if ($LoginStmt->num_rows == 1)
			{
				// If the user exists we check if the account is locked
				// from too many login attempts 
				if ( checkbrute( $user_id, $db_conn) == true)
				{
					// Account is locked 
					// Send an email to user saying their account is locked

					// Spara ner 'blockerad' i loginförsöken.
					// Detta kommer ske varje gång någon försöker logga in, medan kontot redan har fått mer än 5 felförsök med sitt lösenord.
					// vid checkbrute-funktion så kollas alla scode som är av typen pwderr de senaste 2 timmarna.
					$loginMsg="blk";
					$clientIP=$_SERVER['REMOTE_ADDR'];
					$hostname=gethostbyaddr($clientIP);

					$db_conn->query("INSERT INTO FccLogin (uid, logintime,scode,ipaddress,hostname)
													VALUES ('$user_id', NOW(),'$loginMsg','$clientIP','$hostname')");

					// Vi sätter också passtype som blockerad i FccUser.
					$db_conn->query("UPDATE FccUser SET passtype='blocked' WHERE uid='$user_id'");

					return false;
				}
				else
				{
					// Check if the password in the database matches
					// the password the user submitted. (hashed 128 character)
					if ( password_verify($password, $db_password) ) //password_verify is php-standard: http://php.net/manual/en/function.password-verify.php och time-safe 
					{
						// Get the user-agent string of the user.
						$user_browser = $_SERVER['HTTP_USER_AGENT'];
						// XSS protection as we might print this value
						$user_id = preg_replace("/[^0-9]+/", "", $user_id);
						$_SESSION['user_id'] = $user_id;
						// XSS protection as we might print this value
						$username = preg_replace("/[^a-öA-Ö\s]+/", "", $username);
						$_SESSION['username'] = $username;
						$_SESSION['eogid'] = $eogid;
						if( !empty($eogname) )
							$_SESSION['eogname'] = $eogname;
-						$_SESSION['login_string'] = hash('sha512', $db_password . $user_browser);
						// Login successful.
						$loginMsg="ok";
						$clientIP=$_SERVER['REMOTE_ADDR'];
						$hostname=gethostbyaddr($clientIP);

						$db_conn->query("INSERT INTO FccLogin (uid, logintime,scode,ipaddress,hostname)
											VALUES ('$user_id', NOW(),'$loginMsg','$clientIP','$hostname')");
						
						// Lösenordsbyte eventuellt aktuellt.
						$_SESSION['pswChange']=0;
						if($passtype == "once")
							$_SESSION['pswChange']=1;
						
						// Check avslutad, resultatet är godkänt.
						return true;
					}
					else
					{
						// Password is not correct
						// We record this attempt in the database.
						$clientIP = $_SERVER['REMOTE_ADDR'];
						$loginMsg = "pwderr";
						$hostname = gethostbyaddr($clientIP);

						$db_conn->query("INSERT INTO FccLogin (uid, logintime,scode,ipaddress,hostname)
											VALUES ('$user_id', NOW(),'$loginMsg','$clientIP','$hostname')");
						return false;
					}
				}
			}
			else
			{
				// No user exists.
				$loginMsg = "noauth";
				$clientIP=$_SERVER['REMOTE_ADDR'];
				$hostname=gethostbyaddr($clientIP);
				// Spara ner inloggningsförsök med uid = 0 för okänd som obehörig.
				$db_conn->query("INSERT INTO FccLogin (uid, logintime,scode,ipaddress,hostname) VALUES (0, NOW(),'$loginMsg','$clientIP','$hostname')");
				return false;
			}
		}
		elseif($passtype === "blocked"){
				// Kod för meddelande att ens konto är blockerat.
				return false; // Tillfällig return.
		}
		elseif($passtype=="null"){
				// Kod för att meddela att lösenord saknas.
				return false; // Tillfällig return.
		}
		else{
			return false;
		}
    }
	else
		return false;
}
// SLUT - inloggning

// ----
// Kontroll av brute force.
// ----
function checkbrute($user_id, $mysqli) {
	// Get timestamp of current time 
	$now = time();
	
    // All login attempts are counted from the past 30 seconds. 
    $valid_attempts = date("Y-m-d H:i:s",($now - (30)));

	if ($stmt = $mysqli->prepare("SELECT logintime FROM FccLogin WHERE uid = ? AND logintime > ? AND scode = 'pwderr'"))
	{
        $stmt->bind_param('is', $user_id, $valid_attempts);
 
        // Execute the prepared query.
        $stmt->execute();
        $stmt->store_result();
 
        // If there have been more than (FccGlobalSetting.bad-password-attempt) failed logins.
        if ($stmt->num_rows > $GSbpa){
            return true;
		}
		else{
			return false;
		}
	}
}
// SLUT - brute force.


// ----
// Funktion för kontroll att man är inloggad
// ----
function login_check($mysqli) {
    // Check if all session variables are set 
	if ( isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string']) ){
		$user_id = $_SESSION['user_id'];
		$login_string = $_SESSION['login_string'];
		$username = $_SESSION['username'];
 
		// Get the user-agent string of the user.
		$user_browser = $_SERVER['HTTP_USER_AGENT'];
 
		if ($stmt = $mysqli->prepare( "SELECT pass FROM FccUser WHERE uid = ? LIMIT 1" ) ){
			// Bind "$user_id" to parameter. 
			$stmt->bind_param('i', $user_id);
			$stmt->execute();   // Execute the prepared query.
			$stmt->store_result();

			if ($stmt->num_rows == 1){
				// If the user exists get variables from result.
				$stmt->bind_result($db_password);
				$stmt->fetch();
				$login_check = hash('sha512', $db_password . $user_browser);

				if ( hash_equals($login_string, $login_check)) // Time-safe for hashes. From PHP 5.6.0
				{
					// Logged In!!!! 
					return true;
				} else {
					// Not logged in 
					return false;
				}
			} else {
				// Not logged in 
				return false;
			}
		} else {
			// Not logged in 
			return false;
		}
	} else {
		// Not logged in 
		return false;
	}
}
// SLUT.

// Escape URL.
function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $PhpSelf
        return '';
    } else {
        return $url;
    }
}

<?php
define("bitly_access_token","4e2be341a78b55e59a66adeeb63ef6aaa665a15a");
function make_bitly_url($url,$accessToken,$format = 'json',$history=1,$version = '2.0.1',$domain="bit.ly")
{
	//create the URL
	$bitly = 'https://api-ssl.bitly.com/v3/shorten?access_token='.$accessToken.'&longUrl='. urlencode($url) .'&domain='. $domain .'&history='.$history;
	
	//get the url
	//could also use cURL here
	$response = @file_get_contents($bitly);
	if ($response == false){
		return false; /* or something else */
	}
	
	//parse depending on desired format
	if(strtolower($format) == 'json')
	{
		$json = @json_decode($response,true);
		$bitly_db_id = save_bitly_shortlink_db($response, $format, $GLOBALS['dbConn']);
		if( $bitly_db_id != false){
			return $bitly_db_id;
		}
		
		// return $json['data']['url']; 
			// I do not need to return the Json-url because I have formatted it into a relational data structure into the rdbms-table.
	}
	else //xml
	{
		$xml = simplexml_load_string($response);
		return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
	}
}

function save_bitly_shortlink_db($response,$format, $pdo){
	$pdo->beginTransaction();
	if(strtolower($format) == "json")
	{
		$json = @json_decode($response,true);
		$sqlInsShortLink="INSERT INTO t_shortlinks(shorturl, longurl, global_hash, hash, new_hash) VALUES(:param_shorturl, :param_longurl, :param_global_hash, :param_hash, :param_new_hash)";
		$pdo->query( $sqlInsShortLink );
		$pdo->bind( ":param_shorturl", $json['data']['url'] );
		$pdo->bind( ":param_longurl", $json['data']['long_url'] );
		$pdo->bind( ":param_global_hash", $json['data']['global_hash'] );
		$pdo->bind( ":param_hash", $json['data']['hash'] );
		$pdo->bind( ":param_new_hash", $json['data']['new_hash'] );
	}
	elseif(strtolower($format) == 'txt'){
		$sqlInsShortLink="INSERT INTO t_shortlinks(shorturl) VALUES(:param_shorturl)";
		$pdo->query( $sqlInsShortLink );
		$pdo->bind( ":param_shorturl", $json['data']['url'] );
	}
	
	// Execute the statement that has been built from above.
	if( $pdo->execute() == true){
		$db_shortlink_id = $pdo->lastInsertId();
		$pdo->endTransaction();
		return $db_shortlink_id;
	}
	else
		$pdo->cancelTransaction();
	return false;
}

/* usage */
// ORIGINAL $short = make_bitly_url('https://davidwalsh.name','davidwalshblog','R_96acc320c5c423e4f5192e006ff24980','json');
// $short = make_bitly_url('https://netzarna.eu/netzv/cv/?userID=1&cvID=2',bitly_access_token,'json');
// echo 'The short URL is:  '.$short;
<?php
class LoggedInUser{
	public $displayName;
	public $displayWorkTitle;
	public $displayMail;
	public $displayNumber;
	protected $infoRegistered;
	protected $infoLastLogin;
	protected $userId;
	
	// Constructor
	function __construct($pdoDbConn){
		$this -> setUserId( $_SESSION['user_id'] );
		$this -> UserInformation( $pdoDbConn );
	}
	
	// Languages
	public function setUserId($value){
		$this -> userId = $value;
	}
	public function getUserId(){
		return $this -> userId;
	}
	
	public function setDisplayName($name_user){
		$this -> displayName = $name_user;
	}
	public function getDisplayName(){
		return $this -> displayName;
	}
	public function setDisplayWorkTitle($value){
		$this -> displayWorkTitle = $value;
	}
	public function getDisplayWorkTitle(){
		return $this -> displayWorkTitle;
	}
	public function setDisplayMail($value){
		$this -> displayMail = $value;
	}
	public function getDisplayMail(){
		return $this -> displayMail;
	}
	protected function setInfoRegistered($value){
		$this -> infoRegistered=$value;
	}
	protected function getInfoRegistered(){
		return $this -> infoRegistered;
	}
	
	protected function UserInformation($pdoDbConn){
		$sqlGetUserInfo="SELECT CONCAT(name_first, ' ', name_last) fullName, name_first, name_last, registered FROM t_users WHERE id_user = :param_id_user";
		$pdoDbConn -> query( $sqlGetUserInfo );
		$pdoDbConn -> bind( ':param_id_user', $this -> getUserId() );
		$userInfoRow = $pdoDbConn -> single();
		if($userInfoRow == true){
			$this -> setDisplayName($userInfoRow['fullName']);
			$this -> setDisplayMail($userInfoRow['fullName']);
			$this -> setInfoRegistered($userInfoRow['registered']);
		}
	}
}
<?php
class LoggedInUser implements iMyCurriculums
{
	public $displayName;
	public $displayWorkTitle;
	public $displayMail;
	public $displayNumber;
	public $firstName;
	public $lastName;
	
	protected $infoRegistered;
	protected $infoLastLogin;
	protected $userId;
	protected $listOfCvs;
	protected $careerText;
	protected $professionalText;
	
	// Constructor
	function __construct( $pdoDbConn ){
		$this -> setUserId( $_SESSION['user_id'] );
		$this -> UserInformation( $pdoDbConn );
		$this -> MyCurriculums( $pdoDbConn );
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
	
	protected function setListOfCvs($value){
		$this -> listOfCvs=$value;
	}
	public function getListOfCvs(){
		return $this -> listOfCvs;
	}
	
	protected function setProfileCareer($value){
		$this -> careerText=$value;
	}
	public function getProfileCareer(){
		return $this -> careerText;
	}
	protected function setProfileProfessional($value){
		$this -> professionalText=$value;
	}
	public function getProfileProfessional(){
		return $this -> professionalText;
	}
	
	protected function UserInformation($pdoDbConn){
		$sqlGetUserInfo="SELECT name_first, name_last, registered, presentation, career_text, professional_text FROM t_users JOIN t_user_profiles up USING(id_user) WHERE id_user = :param_id_user";
		$pdoDbConn -> query( $sqlGetUserInfo );
		$pdoDbConn -> bind( ':param_id_user', $this -> getUserId() );
		$userInfoRow = $pdoDbConn -> single();
		if($pdoDbConn->rowCount() == 1){
			$this -> setDisplayName($userInfoRow['name_first']." ".$userInfoRow['name_last']);
			$this -> firstName = $userInfoRow['name_first'];
			$this -> lastName = $userInfoRow['name_last'];
			$this -> setInfoRegistered($userInfoRow['registered']);
			$this -> setProfileCareer($userInfoRow['career_text']);
			$this -> setProfileProfessional($userInfoRow['professional_text']);
		}
		else{
			// Wrong number of profiles returned.
		}
	}
	
	// Use this method to list the blocks of clickable CVs in Profile-page.
	public function MyCurriculums( $pdoDbConn ){
		$colorArr=array(1=>"khaki", 2=>"deep-orange", 3=>"amber", 4=>"blue-gray");
		$r=1;
		$cvList=null;
		$sqlGetCvRows="SELECT * FROM t_user_has_cv c WHERE c.id_user = :param_id_user";
		$pdoDbConn->query($sqlGetCvRows);
		$pdoDbConn->bind(":param_id_user", $this->getUserId());
		$resultCvRows=$pdoDbConn->resultSet();
		foreach($resultCvRows as $cvRow){
			if($r==count($colorArr))
				$r=1;
			$cvList.=
				"<div class='w3-quarter w3-card w3-".$colorArr[$r]." w3-padding-16' style='min-height:10em;'>"
					."<h3>". $cvRow['name'] ."</h3>"
					."<p>". $cvRow['description'] ."</p>"
					."<a class='w3-button w3-white w3-hover-blue' href='../cv/?userID=". $this->getUserId() ."&cvID=".$cvRow['id_cv']."'>Visa CV</a>"
				."</div>";
			$r++;
		}
		
		$this->setListOfCvs( $cvList );
	}
}



class RequestedProfile implements iMyCurriculums
{
	public $displayName;
	public $displayWorkTitle;
	public $displayMail;
	public $displayNumber;
	public $wrongProfile="false";
	protected $infoRegistered;
	protected $infoLastLogin;
	protected $userId;
	protected $listOfCvs;
	protected $careerText;
	protected $professionalText;
	
	// Constructor
	function __construct($sentUserId, $pdoDbConn){
		$this -> setUserId( $sentUserId );
		$this -> UserInformation( $pdoDbConn );
		$this -> MyCurriculums( $pdoDbConn );
	}
	
	// Languages
	public function setUserId( $value ){
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
	
	protected function setListOfCvs($value){
		$this -> listOfCvs=$value;
	}
	public function getListOfCvs(){
		return $this -> listOfCvs;
	}
	
	protected function setProfileCareer($value){
		$this -> careerText=$value;
	}
	public function getProfileCareer(){
		return $this -> careerText;
	}
	protected function setProfileProfessional($value){
		$this -> professionalText=$value;
	}
	public function getProfileProfessional(){
		return $this -> professionalText;
	}
	
	protected function UserInformation($pdoDbConn){
		$sqlGetUserInfo="SELECT name_first, name_last, registered, presentation, career_text, professional_text FROM t_users JOIN t_user_profiles up USING(id_user) WHERE id_user = :param_id_user";
		$pdoDbConn -> query( $sqlGetUserInfo );
		$pdoDbConn -> bind( ':param_id_user', $this -> getUserId() );
		$userInfoRow = $pdoDbConn -> single();
		if($pdoDbConn->rowCount() == 1){
			$this -> setDisplayName($userInfoRow['name_first']." ".$userInfoRow['name_last']);
			$this -> setInfoRegistered($userInfoRow['registered']);
			$this -> setProfileCareer($userInfoRow['career_text']);
			$this -> setProfileProfessional($userInfoRow['professional_text']);
		}
		else{
			// Wrong number of profiles returned.
			$this->wrongProfile="true";
		}
	}
	
	// Use this method to list the blocks of clickable CVs in Profile-page.
	public function MyCurriculums( $pdoDbConn ){
		$colorArr=array(1=>"khaki", 2=>"deep-orange", 3=>"amber", 4=>"blue-gray");
		$r=1;
		$cvList=null;
		$sqlGetCvRows="SELECT * FROM t_user_has_cv c WHERE c.id_user = :param_id_user";
		$pdoDbConn->query($sqlGetCvRows);
		$pdoDbConn->bind(":param_id_user", $this->getUserId());
		$resultCvRows=$pdoDbConn->resultSet();
		foreach($resultCvRows as $cvRow){
			if($r==count($colorArr))
				$r=1;
			$cvList.=
				"<div class='w3-quarter w3-card w3-".$colorArr[$r]." w3-padding-16' style='min-height:10em;'>"
					."<h3>". $cvRow['name'] ."</h3>"
					."<p>". $cvRow['description'] ."</p>"
					."<a class='w3-button w3-white w3-hover-blue' href='../cv/?userID=". $this->getUserId() ."&cvID=".$cvRow['id_cv']."'>Visa CV</a>"
				."</div>";
			$r++;
		}
		
		$this->setListOfCvs( $cvList );
	}
	
}
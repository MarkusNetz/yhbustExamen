<?php
class user{
	protected $user_Id;
	public $displayName;
	public $displayWorkTitle;
	public $displayMail;
	public $displayNumber;
	
	// Constructor
	function __construct($con_userId){
		$this -> setUserId($con_userId);
		// $this -> setDisplayName("Arbetslivserfarenhet");
		// $this -> setDisplayWorkTitle("Utbildning & kurser");
		// $this -> setDisplayMail("Färdigheter & intressen");
		// $this -> setDisplayNumber("Språkkunskaper");
	}
	
	// Languages
	public function setUserId($userId){
		$this -> user_Id = $userId;
	}
	public function getUserId(){
		return $this -> user_Id;
	}
	
	public function setDisplayName($name_user){
		$this -> displayName = $name_user;
	}
	public function getDisplayName(){
		return $this -> displayName;
	}
	public function setDisplayWorkTitle($name_user){
		$this -> displayWorkTitle = $name_user;
	}
	public function getDisplayWorkTitle(){
		return $this -> displayWorkTitle;
	}
	public function setDisplayMail($name_user){
		$this -> displayMail = $name_user;
	}
	public function getDisplayMail(){
		return $this -> displayMail;
	}
	// public function setDisplayMail($name_user){
		// $this -> displayMail = $name_user;
	// }
	// public function getDisplayMail(){
		// return $this -> displayMail;
	// }
	
	public function getEducationsList($db){
		$sqlSelectEducations="SELECT id_education, DATE_FORMAT(start_date, '%b %Y') start_date, IF(end_date = '9999-12-31', 'Pågående', IF(end_date >= CURDATE(), 'Pågående', DATE_FORMAT(end_date,'%b %Y') ) ) end_date, school, education_title, education_description FROM t_cv_educations edu WHERE edu.id_cv = :id_cv ORDER BY start_date DESC, end_date DESC";
		$db -> query($sqlSelectEducations);
		$db -> bind(':id_cv', $this -> getCvId());
		$rowsEducations = $db -> resultSet();
		$list="";
		foreach($rowsEducations as $educations){
			$list.=
				"<div class='w3-container'>"
					."<h5 class='w3-opacity'><b>". $educations['education_title']." / ". $educations['school']."</b></h5>"
					."<h6 class='w3-text-teal'>"
						."<i class='fa fa-calendar fa-fw w3-margin-right'></i>"
						.ucfirst($educations['start_date']) . " - "  . ( $educations['end_date'] != "Nuvarande" ? ucfirst($educations['end_date']) : "<span class='w3-tag w3-teal w3-round'>". $educations['end_date'] ."</span>" )
					."</h6>"
					."<p>". $educations['education_description']."</p>"
					."<hr />"
				."</div>";
		}
		return $list;
	}
}
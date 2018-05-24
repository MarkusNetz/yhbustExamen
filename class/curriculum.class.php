<?php
class curriculum{
	public $headerWork;
	public $headerEducation;
	
	function __construct(){
		$this -> setHeaderWork("Arbetslivserfarenhet");
		$this -> setHeaderEducation("Utbildning & kurser");
	}
	public function setHeaderWork($newHeaderWork){
		$this -> headerWork = $newHeaderWork;
	}
	public function getHeaderWork(){
		return $this -> headerWork;
	}
	public function setHeaderEducation($newHeaderEducation){
		$this -> headerEducation = $newHeaderEducation;
	}
	public function getHeaderEducation(){
		return $this -> headerEducation;
	}
	
	public function getEducationsList(){
	}
	
	public function getWorkExperiencesList(){
	}
}

?>
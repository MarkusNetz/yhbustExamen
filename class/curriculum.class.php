<?php
class curriculum {
	public $headerWork;
	public $headerEducation;
	public $headerSkills;
	public $headerLanguages;
	protected $cvID;
	protected $sqlSelectSkills;
	// Constructor
	function __construct(){
		$this -> setHeaderWork("Arbetslivserfarenhet");
		$this -> setHeaderEducation("Utbildning & kurser");
		$this -> setHeaderSkills("Färdigheter & intressen");
		$this -> setHeaderLanguages("Språkkunskaper");
		$this -> setCvId(filter_input(INPUT_GET, "cvID") );
	}
	public function setCvId( $newCvId ){
		$this -> cvID = $newCvId;
	}
	public function getCvId(){
		return $this -> cvID;
	}
	
	// Languages
	public function setHeaderLanguages($newHeaderLanguages){
		$this -> headerLanguages = $newHeaderLanguages;
	}
	public function getHeaderLanguages(){
		return $this -> headerLanguages;
	}
	
	// Work experiences
	public function setHeaderWork($newHeaderWork){
		$this -> headerWork = $newHeaderWork;
	}
	public function getHeaderWork(){
		return $this -> headerWork;
	}
	
	// Educations
	public function setHeaderEducation($newHeaderEducation){
		$this -> headerEducation = $newHeaderEducation;
	}
	
	// Skills
	public function getHeaderSkills(){
		return $this -> headerSkills;
	}
	public function setHeaderSkills($newHeaderSkills){
		$this -> headerSkills = $newHeaderSkills;
	}
	public function getHeaderEducation(){
		return $this -> headerEducation;
	}
	
	public function getEducationsList($db){
		$sqlSelectEducations="SELECT id_education, start_date, DATE_FORMAT(start_date, '%b %Y') start_date_name, end_date, IF(end_date = '9999-12-31', 'Pågående', IF(end_date >= CURDATE(), 'Pågående', DATE_FORMAT(end_date,'%b %Y') ) ) end_date_name, school, education_title, education_description FROM t_cv_educations edu WHERE edu.id_cv = :id_cv ORDER BY start_date DESC, end_date DESC";
		$db -> query($sqlSelectEducations);
		$db -> bind(':id_cv', $this -> getCvId());
		$rowsEducations = $db -> resultSet();
		$list="";
		$listAddEmptyInput="";
		$i=0;
		foreach($rowsEducations as $educations){
			$i++;
			if(isset($_GET['edit']) && $_GET['edit']=="edu"){
				if($i==1)
				$listAddEmptyInput.=
					"<div class='w3-container'>"
						."<h5>"
							."<input type='text' name='edu_title' value='' placeholder='Utbildning, inriktning' />"
							." / "
							."<input type='text' name='edu_school' value='' placeholder='Utbildare, skola' />"
						."</h5>"
						."<h6 class='w3-text-teal'>"
							."<i class='fa fa-calendar fa-fw w3-margin-right'></i>"
							. "<input type='date' name='start_date' value='' />"
							." - "
							."<input type='date' name='end_date' value='' /> "
						."</h6>"
						."<p><input type='text' name='education_description' value='' style='width:100%;' placeholder='Beskrivning av utbildningen.' /></p>"
						."<hr />"
					."</div>";
				$list.=
					"<div class='w3-container'>"
						."<h5>"
							."<input type='text' name='edu_title_" . $educations['id_education'] . "' value='" . $educations['education_title'] . "' placeholder='Utbildning, inriktning' />"
							." / "
							."<input type='text' name='edu_school_" . $educations['id_education'] . "' value='" . $educations['school'] . "' placeholder='Utbildare, skola' />"
						."</h5>"
						."<h6 class='w3-text-teal'>"
							."<i class='fa fa-calendar fa-fw w3-margin-right'></i>"
							. "<input type='date' name='start_date_" . $educations['id_education'] . "' value='" . $educations['start_date'] . "' />"
							." - "
							."<input type='date' name='end_date_" . $educations['id_education'] . "' value='".$educations['end_date']."' /> "
						."</h6>"
						."<p><input type='text' name='education_description_".$educations['id_education']."' value='". $educations['education_description']."' style='width:100%;' placeholder='Beskrivning av utbildningen.' /></p>"
						."<hr />"
					."</div>";
			}
			else{
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
		}
		$list .=  $listAddEmptyInput;
		return $list;
	}
	
	// List all work experiences.
	public function getWorkExperiencesList($db){
		$sqlSelectWorkXP="SELECT id_work_experience, start_date, DATE_FORMAT(start_date, '%b %Y') start_date_name, end_date, IF(end_date = '9999-12-31', 'Nuvarande', DATE_FORMAT(end_date, '%b %Y')) end_date_name, employer, work_title, work_description FROM t_cv_work_experience we WHERE we.id_cv = :id_cv ORDER BY end_date DESC";
		$db -> query($sqlSelectWorkXP);
		$db -> bind(':id_cv', $this -> getCvId());
		$rowsWorkXP = $db -> resultSet();
		$list="";
		$listAddEmptyInput="";
		$i=0;
		foreach($rowsWorkXP as $work){
			$i++;
			if(isset($_GET['edit']) && $_GET['edit']=="work"){
				if($i==1)
					$listAddEmptyInput.=
					"<div class='w3-container'>"
						."<h5>"
							."<input type='text' name='work_title' value='' placeholder='Jobbtitel' />"
							." / "
							."<input type='text' name='work_employer' value='' placeholder='Arbetsgivare' />"
						."</h5>"
						."<h6 class='w3-text-teal'>"
							."<i class='fa fa-calendar fa-fw w3-margin-right'></i>"
							. "<input type='date' name='start_date' value='' />"
							." - "
							."<input type='date' name='end_date' value='' /> "
							."<input type='checkbox' id='current_work' name='current_work' value='" .( $work['end_date_name'] == "Nuvarande" ? "1' checked='checked'" : "0'" ) ." /> <label for='current_work_".$work['id_work_experience']."'>nuvarande.</label>"
						."</h6>"
						."<p><input type='text' name='work_description_".$work['id_work_experience']."' value='' style='width:100%;' placeholder='Beskrivning av arbetsuppgifter.' /></p>"
						."<hr />"
					."</div>";
				$list.=
					"<div class='w3-container'>"
						."<h5>"
							."<input type='text' name='work_title_".$work['id_work_experience']."' value='". $work['work_title']."' placeholder='Jobbtitel' />"
							." / "
							."<input type='text' name='work_employer_".$work['id_work_experience']."' value='". $work['employer']."' placeholder='Arbetsgivare' />"
						."</h5>"
						."<h6 class='w3-text-teal'>"
							."<i class='fa fa-calendar fa-fw w3-margin-right'></i>"
							. "<input type='date' name='start_date_".$work['id_work_experience']."' value='" . $work['start_date'] . "' />"
							." - "
							."<input type='date' name='end_date_" . $work['id_work_experience'] . "' value='".$work['end_date']."' /> "
							."<input type='checkbox' id='current_work_".$work['id_work_experience']."' name='current_work_".$work['id_work_experience']."' value='" . ( $work['end_date_name'] == "Nuvarande" ? "1' checked='checked'" : "0'" ) ." /> <label for='current_work_".$work['id_work_experience']."'>nuvarande.</label>"
						."</h6>"
						."<p><input type='text' name='work_description_".$work['id_work_experience']."' value='". $work['work_description']."' style='width:100%;' placeholder='Beskrivning av arbetsuppgifter.' /></p>"
						."<hr />"
					."</div>";
			}
			else{
				$list.=
					"<div class='w3-container'>"
						."<h5 class='w3-opacity'><b>". $work['work_title']." / ". $work['employer']."</b></h5>"
						."<h6 class='w3-text-teal'>"
							."<i class='fa fa-calendar fa-fw w3-margin-right'></i>"
							.ucfirst($work['start_date_name']) . " - "  . ( $work['end_date_name'] != "Nuvarande" ? ucfirst($work['end_date_name']) : "<span class='w3-tag w3-teal w3-round'>". $work['end_date_name'] ."</span>" )
						."</h6>"
						."<p>". $work['work_description']."</p>"
						."<hr />"
					."</div>";
			}
		}
		$list.=$listAddEmptyInput;
		return $list;
	}
	
	public function getSkillsList($db){
		$sqlSelectSkills="SELECT id_skill, skill, skill_level FROM t_cv_skills ski WHERE ski.id_cv = :id_cv ORDER BY skill DESC, skill_level DESC";
		$db -> query($sqlSelectSkills);
		$db -> bind(':id_cv', $this -> getCvId());
		$rowsSkills = $db -> resultSet();
		$list="";
		foreach($rowsSkills as $skill){
			
				
			$list.=
				"<p>" . $skill['skill'] . " </p>"
				."<div class='w3-light-grey w3-round-xlarge w3-small'>"
					."<div class='w3-container w3-center w3-round-xlarge w3-teal' style='width:". $skill['skill_level'] ."%'>". $skill['skill_level'] ."</div>"
				."</div>";
		}
		return $list;
	}
	
	public function getLangugesList($db){
		$sqlSelectLang="SELECT id_cv_linguistic, language_name_local, language_level FROM t_cv_linguistics ling JOIN t_languages lang USING(id_language) WHERE ling.id_cv = :id_cv";
		$db -> query($sqlSelectLang);
		$db -> bind(':id_cv', $this -> getCvId());
		$rowsLangs = $db -> resultSet();
		$list="";
		foreach($rowsLangs as $lang){
			$list.=
				"<p>" . $lang['language_name_local'] . "</p>"
				."<div class='w3-light-grey w3-round-xlarge'>"
					."<div class='w3-round-xlarge w3-teal' style='height:24px;width:" . $lang['language_level'] . "%'></div>"
				."</div>";
		}
		return $list;
	}
}
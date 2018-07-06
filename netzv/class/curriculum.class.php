<?php
class curriculum {
	public $headerWork;
	public $headerEducation;
	public $headerSkills;
	public $headerLanguages;
	protected $cvID;
	protected $cvUserID;
	protected $sqlSelectSkills;
	protected $displayNameBanner;
	protected $displayLocationBanner;
	protected $displayMailBanner;
	protected $displayPhoneBanner;
	protected $displayWorkTitleBanner;
	protected $displayAvatarDirectory;
	protected $displayAvatarFile;
	
	// Constructor
	function __construct($userIdRequest, $cvIdRequest, $pdoDbConn){
		$this -> setHeaderWork("Arbetslivserfarenhet");
		$this -> setHeaderEducation("Utbildning & kurser");
		$this -> setHeaderSkills("Färdigheter & intressen");
		$this -> setHeaderLanguages("Språkkunskaper");
		$this -> setCvUserID( $userIdRequest );
		$this -> setCvId( $cvIdRequest );
		$this -> cvUserInfo($pdoDbConn);
	}
	
	public function cvUserInfo( $pdoDbConn ){
		$sqlGetCvUserInfo=
			"SELECT uhc.avatar_file_name, uhc.avatar_directory, u.name_first, u.name_last, uhci.contact privatePhone, uhci2.contact mail, we.work_title, at.type, locs.name street, uha.street_number, uha.street_letter, locc.city
			FROM t_users u
				JOIN t_user_has_cv uhc ON u.id_user = uhc.id_user
				JOIN t_user_has_address uha ON u.id_user = uha.id_user
				JOIN t_address_types at ON at.id_address_type = uha.id_address_type
				JOIN t_loc_streets locs ON locs.id_street = uha.id_street
				JOIN t_cv_work_experience we ON we.id_cv = uhc.id_cv
				JOIN t_user_has_contact_info uhci ON uhci.id_user = u.id_user
				JOIN t_contact_types ct ON ct.id_contact_type = uhci.id_contact_type
				JOIN t_loc_cities locc ON locc.id_city = uha.id_city
				JOIN t_user_has_contact_info uhci2 ON uhci2.id_user = u.id_user
				JOIN t_contact_types ct2 ON ct2.id_contact_type = uhci2.id_contact_type
			WHERE u.id_user = :param_id_user
				AND at.type = 'home'
				AND ct.name = 'Mobilnummer'
				AND ct2.name = 'mail'
			GROUP BY u.id_user;";
		$pdoDbConn->query($sqlGetCvUserInfo);
		$pdoDbConn->bind(":param_id_user", $this->getCvUserID());
		$cvUserPresentation=$pdoDbConn->single();
		$this->setDisplayNameBanner($cvUserPresentation['name_first'] ." ". $cvUserPresentation['name_last']); 
		$this->setDisplayWorkTitleBanner($cvUserPresentation['work_title']); 
		$this->setDisplayPhoneBanner($cvUserPresentation['privatePhone']); 
		$this->setDisplayLocationBanner($cvUserPresentation['street'] ." ". $cvUserPresentation['street_number'] .(!empty($cvUserPresentation['street_letter']) ? " " . $cvUserPresentation['street_letter'] : "") .", ". $cvUserPresentation['city']); 
		$this->setDisplayMailBanner($cvUserPresentation['mail']); 
		$this->setDisplayAvatarDirectory($cvUserPresentation['avatar_directory']); 
		$this->setDisplayAvatarFile($cvUserPresentation['avatar_file_name']); 
	}
	
	public function setDisplayAvatarFile( $value ){
		$this -> displayAvatarFile = $value;
	}
	public function getDisplayAvatarFile(){
		return $this -> displayAvatarFile;
	}
	public function setDisplayAvatarDirectory( $value ){
		$this -> displayAvatarDirectory = $value;
	}
	public function getDisplayAvatarDirectory(){
		return $this -> displayAvatarDirectory;
	}
	
	public function setDisplayWorkTitleBanner( $value ){
		$this -> displayWorkTitleBanner = $value;
	}
	public function getDisplayWorkTitleBanner(){
		return $this -> displayWorkTitleBanner;
	}
	
	public function setDisplayPhoneBanner( $value ){
		$this -> displayPhoneBanner = $value;
	}
	public function getDisplayPhoneBanner(){
		return $this -> displayPhoneBanner;
	}
	
	
	public function setDisplayLocationBanner( $value ){
		$this -> displayLocationBanner = $value;
	}
	public function getDisplayLocationBanner(){
		return $this -> displayLocationBanner;
	}
	
	public function setDisplayMailBanner( $value ){
		$this -> displayMailBanner = $value;
	}
	public function getDisplayMailBanner(){
		return $this -> displayMailBanner;
	}
	public function setDisplayNameBanner( $value ){
		$this -> displayNameBanner = $value;
	}
	public function getDisplayNameBanner(){
		return $this -> displayNameBanner;
	}
	
	public function setCvId( $newCvId ){
		$this -> cvID = $newCvId;
	}
	public function getCvId(){
		return $this -> cvID;
	}
	
	public function setCvUserID( $value ){
		$this -> cvUserID = $value;
	}
	public function getCvUserID(){
		return $this -> cvUserID;
	}
	
	// Languages
	public function setHeaderLanguages($newHeaderLanguages){
		$this -> headerLanguages = $newHeaderLanguages;
	}
	public function getHeaderLanguages(){
		return $this -> headerLanguages;
	}
	
	// Skills
	public function getHeaderSkills(){
		return $this -> headerSkills;
	}
	public function setHeaderSkills($newHeaderSkills){
		$this -> headerSkills = $newHeaderSkills;
	}
	
	// Educations
	public function setHeaderEducation($newHeaderEducation){
		$this -> headerEducation = $newHeaderEducation;
	}
	public function getHeaderEducation(){
		return $this -> headerEducation;
	}
	public function getEducationsList($db, $objProps){
		$sqlSelectEducations="SELECT edu_time, id_education, start_date, DATE_FORMAT(start_date, '%b %Y') start_date_name, end_date, IF(end_date = '9999-12-31', 'Pågående', IF(end_date >= CURDATE(), 'Pågående', DATE_FORMAT(end_date,'%b %Y') ) ) end_date_name, school, education_title, education_description FROM t_cv_educations edu WHERE edu.id_cv = :id_cv ORDER BY start_date DESC, end_date DESC";
		
		$db -> query($sqlSelectEducations);
		$db -> bind(':id_cv', $this -> getCvId());
		$rowsEducations = $db -> resultSet();
		$list="";
		$listAddEmptyInput="";
		if(isset($_GET['add']) && $_GET['add']=="edu"){
			$listAddEmptyInput.=
					"<div class='w3-container w3-card w3-pale-yellow w3-margin-bottom w3-margin-top w3-padding-bottom'>"
						."<input type='hidden' value='addEdu' name='submitType' />"
						."<div class='w3-row w3-margin-bottom w3-margin-top'>"
							."<input class='w3-input w3-border w3-mobile w3-third' type='text' name='edu_title' id='edu_title' placeholder='Utbildning, inriktning' required='required' />"
							."<input class='w3-input w3-border w3-mobile w3-third' type='text' name='edu_school' id='edu_school' placeholder='Utbildare, skola' required='required' />"
							."<input class='w3-input w3-border w3-mobile w3-third' type='text' name='edu_time' id='edu_time' placeholder='Helfart, distans halvfart etc.' />"
						."</div>"
						
						."<div class='w3-row'>"
							."<div class='w3-third'>"
								."<label class='w3-hide-medium w3-hide-large' for='start_date'>Start</label>"
								. "<input class='w3-border w3-mobile' type='date' name='start_date' id='start_date' required='required' />"
								."<label class='w3-hide-small fa fa-calendar fa-fw w3-margin-right' for='start_date'></label>"
							."</div>"
							
							."<div class='w3-third'>"
								."<label class='w3-hide-medium w3-hide-large' for='end_date'>Slut</label>"
								."<input class='w3-border w3-mobile' type='date' name='end_date' id='end_date' />"
								."<label class='w3-hide-small fa fa-calendar fa-fw w3-margin-right' for='end_date'></label>"
							."</div>"
						."</div>"
						
						."<div class='w3-mobile w3-margin-bottom w3-margin-top'>"
							."<textarea placeholder='Din beskrivning av utbildningen och dess innehåll av kurser och moment.' required='required' class='w3-input w3-border' name='education_description' id='education_description' style='resize:none;'></textarea>"
						."</div>"
					."</div>";
		}
		$i=0;
		foreach($rowsEducations as $educations){
			$i++;
			$id_edu=$educations['id_education'];
			// lista alla rader i redigeringsläge för utbildningar.
			if(isset($_GET['edit']) && $_GET['edit']=="edu"){
				$disable_end_date=$end_date_value="";
				$end_date_value=$educations['end_date'];
				if( $end_date_value == "9999-12-31"){
					$end_date_value="";
				}
				
				$list.=
					"<div class='w3-container w3-card w3-pale-green w3-margin-bottom w3-margin-top w3-padding-bottom'>"
						."<input type='hidden' value='". $id_edu ."' name='row_edu_id[]' id='row_edu_id' />"
						
						."<div class='w3-row w3-margin-bottom w3-margin-top'>"
							."<input class='w3-input w3-border w3-mobile w3-third' type='text' name='edu_title_".$id_edu."' id='edu_title_".$id_edu."' value='". $educations['education_title']."' placeholder='Utbildning, inriktning' required='required' />"
							."<input class='w3-input w3-border w3-mobile w3-third' type='text' name='edu_school_".$id_edu."' id='edu_school_".$id_edu."' value='". $educations['school']."' placeholder='Utbildare, skola' required='required' />"
							."<input class='w3-input w3-border w3-mobile w3-third' type='text' name='edu_time_".$id_edu."' id='edu_time_".$id_edu."' value='". $educations['edu_time']."' placeholder='Helfart, distans halvfart etc.' />"
						."</div>"
						
						."<div class='w3-row'>"
							."<div class='w3-third'>"
								."<label class='w3-hide-medium w3-hide-large' for='start_date_".$id_edu."'>Start</label>"
								. "<input class='w3-border w3-mobile' type='date' name='start_date_".$id_edu."' id='start_date_".$id_edu."' value='" . $educations['start_date'] . "' required='required' />"
								."<label class='w3-hide-small fa fa-calendar fa-fw w3-margin-right' for='start_date_".$id_edu."'></label>"
							."</div>"
							
							."<div class='w3-third'>"
								."<label class='w3-hide-medium w3-hide-large' for='end_date_".$id_edu."'>Slut</label>"
								."<input class='w3-border w3-mobile' type='date' name='end_date_". $id_edu ."' id='end_date_".$id_edu."' value='".$end_date_value."' />"
								."<label class='w3-hide-small fa fa-calendar fa-fw w3-margin-right' for='end_date_".$id_edu."'></label>"
							."</div>"
						."</div>"
						
						."<div class='w3-mobile w3-margin-bottom w3-margin-top'>"
							."<textarea placeholder='Din beskrivning av utbildningen och dess innehåll av kurser och moment.' required='required' class='w3-input w3-border' name='education_description_". $id_edu ."' id='education_description_". $id_edu."' style='resize:none;'>".(!empty($educations['education_description']) ? $educations['education_description'] : "") ."</textarea>"
						."</div>"
					."</div>";
			}
			else{
				$list.=
					"<div class='w3-container'>"
						
						."<div class='w3-row'>"
							
							."<div class='m10 l10 w3-hide-small'>"
								."<h5 class='w3-opacity'><b>". $educations['education_title']." / ". $educations['school']."</b></h5>"
							."</div>"
							
							."<div class='w3-mobile w3-hide-medium w3-hide-large'>"
								."<h5 class='w3-opacity'><b>". $educations['education_title']." / ". $educations['school']."</b></h5>"
							."</div>"
							
							."<div class='m2 l2 w3-hide-small'>"
								."<a href='./?userID=1&cvID=1&action=delete&actionID=". $id_edu ."&actionDelete=edu' class='w3-button w3-circle w3-right w3-white' type='submit' name='delete_edu'><i class='fa fa-trash-alt'></i></a>
							</div>"
							
						."</div>"
						
						."<h6 class='w3-text-teal' style='width:80%>"
							."<i class='fa fa-calendar fa-fw w3-margin-right'></i>"
							.ucfirst($educations['start_date']) . " - "  . ( $educations['end_date_name'] != "Pågående" ? $educations['end_date'] : "<span class='w3-tag w3-teal w3-round'>". $educations['end_date_name'] ."</span>" )
						."</h6>"
						
						."<p>". $educations['education_description']."</p>"
						
						."<div class='w3-mobile w3-hide-medium w3-hide-large'>"
							."<a href='./?userID=1&cvID=1&action=delete&actionID=". $id_edu ."&actionDelete=edu' class='". $objProps->getBtnDeleteSmallScreen() ."' type='submit' name='delete_edu'><i class='fa fa-trash-alt'></i></a>"
						."</div>"
						
						."<hr />"
					."</div>";
			}
		}
		// If in edit mode we add the submit-type here, not in the loop, since it spawns x number of hidden inputs.... Lesson learned.
		if(isset($_GET['edit']) && $_GET['edit']=="edu")
			$list.="<input type='hidden' value='saveEdu' name='submitType' />";
		
		// the $i-variable is made to start at 0 and increase by one at the beginning of every loop when listing work XP already in the database.
		$list.="<input type='hidden' value='". $i ."' name='rowCountEdu' id='rowCountEdu' />";
		
		// If we are in add-mode then we show that part in the returned form. The empty input is only filled with values if "add" is the current $_GET-variable.
		if( !empty( $listAddEmptyInput ))
			$list=$listAddEmptyInput . $list;
		
		return $list;
	}
	
	// List all work experiences.
	
	// Work experiences
	public function setHeaderWork($newHeaderWork){
		$this -> headerWork = $newHeaderWork;
	}
	public function getHeaderWork(){
		return $this -> headerWork;
	}
	
	public function getWorkExperiencesList($db, $objProps){
		$sqlSelectWorkXP="SELECT id_work_experience, work_time, start_date, DATE_FORMAT(start_date, '%b %Y') start_date_name, end_date, IF(end_date = '9999-12-31', 'Nuvarande', DATE_FORMAT(end_date, '%b %Y')) end_date_name, employer, work_title, work_description FROM t_cv_work_experience we WHERE we.id_cv = :id_cv ORDER BY end_date DESC";
		$db -> query($sqlSelectWorkXP);
		$db -> bind(':id_cv', $this -> getCvId());
		$rowsWorkXP = $db -> resultSet();
		$list="";
		$listAddEmptyInput="";
		// Nytt tomt formulär för inmatning av arbetserfarenhet.
		if(isset($_GET['add']) && $_GET['add']=="work"){
			$listAddEmptyInput.=
					"<div class='w3-container w3-card w3-pale-yellow w3-margin-bottom w3-margin-top'>"
						."<h3 class='w3-text-teal'>Ny arbetserfarenhet</h3>"
						."<input type='hidden' value='addWork' name='submitType' />"
						."<div class='w3-row w3-margin-bottom w3-margin-top'>"
							."<input class='w3-input w3-border w3-third' type='text' name='work_title' id='work_title' placeholder='Jobbtitel' required='required' />"
							."<input class='w3-input w3-border w3-mobile w3-third' type='text' name='work_employer' value='' placeholder='Arbetsgivare' required='required' />"
							."<input class='w3-input w3-border w3-mobile w3-third ' type='text' name='work_time' id='work_time' placeholder='Heltid, deltid, projekt..' required='required' />"
						."</div>"
						
						."<div class='w3-row'>"
							."<div class='w3-mobile w3-third'>"
								."<label class='w3-hide-medium w3-hide-large' for='start_date'>Start</label>"
								. "<input class='w3-border w3-mobile' type='date' name='start_date' id='start_date' value='' required='required' />"
								."<label class='w3-hide-small fa fa-calendar fa-fw w3-margin-right' for='start_date'></label>"
							."</div>"
							
							."<div class='w3-mobile w3-third'>"
								."<label class='w3-hide-medium w3-hide-large' for='end_date'>Slut</label>"
								."<input class='w3-border w3-mobile' type='date' name='end_date' id='end_date' value='' />"
								."<label class='w3-hide-small fa fa-calendar fa-fw w3-margin-right' for='end_date'></label>"
							."</div>"
							
							."<div class='w3-mobile w3-third'>"
								."<input class='w3-check w3-border' type='checkbox' id='current_work' name='current_work' value='' /> "
								."<label for='current_work'>nuvarande jobb</label>"
							."</div>"
						."</div>"
						
						."<div class='w3-row w3-margin-bottom w3-margin-top'>"
							."<div class='w3-block'>"
								."<textarea required='required' placeholder='Din beskrivning av arbetet.' class='w3-input w3-border' name='work_description' style='resize:none; height:5em;'></textarea>"
							."</div>"
						."</div>"
					."</div>";
		}
		$i=0;
		foreach($rowsWorkXP as $work){
			$i++;
			$id_workXp=$work['id_work_experience'];
			// lista alla rader i redigeringsläge för arbetserfarenhet.
			if(isset($_GET['edit']) && $_GET['edit']=="work"){
				$disable_end_date=$end_date_value="";
				$checkbox_current_work=" value='0'";
				if( $work['end_date_name'] == "Nuvarande"){
					$checkbox_current_work=" value='1' checked='checked' required='required'";
					$disable_end_date=" disabled='disabled'";
				}
				else
					$end_date_value=$work['end_date'];
				$list.=
					"<div class='w3-container w3-card w3-pale-green w3-margin-bottom w3-margin-top w3-padding-bottom'>"
						."<input type='hidden' value='". $id_workXp ."' name='row_work_id[]' id='row_work_id' />"
						."<div class='w3-row w3-margin-bottom w3-margin-top'>"
							."<input class='w3-input w3-border w3-mobile w3-third' type='text' name='work_title_". $id_workXp ."' id='work_title_". $id_workXp ."' value='". $work['work_title'] ."' placeholder='Jobbtitel' required='required' />"
							."<input class='w3-input w3-border w3-mobile w3-third' type='text' name='work_employer_". $id_workXp ."' id='work_employer_". $id_workXp ."' value='". $work['employer'] ."' placeholder='Arbetsgivare' required='required' />"
							."<input class='w3-input w3-border w3-mobile w3-third' type='text' name='work_time_". $id_workXp ."' id='work_time_". $id_workXp ."' value='". $work['work_time'] ."' placeholder='Heltid, deltid, projektanställning, etc.' />"
						."</div>"
						
						."<div class='w3-row'>"
							."<div class='w3-third'>"
								."<label class='w3-hide-medium w3-hide-large' for='start_date_".$id_workXp."'>Start</label>"
								. "<input class='w3-border w3-mobile' type='date' name='start_date_".$id_workXp."' id='start_date_".$id_workXp."' value='" . $work['start_date'] . "' required='required' />"
								."<label class='w3-hide-small fa fa-calendar fa-fw w3-margin-right' for='start_date_".$id_workXp."'></label>"
							."</div>"
							
							."<div class='w3-third'>"
								."<label class='w3-hide-medium w3-hide-large' for='end_date_".$id_workXp."'>Slut</label>"
								."<input".$disable_end_date." class='w3-border w3-mobile' type='date' name='end_date_". $id_workXp ."' id='end_date_".$id_workXp."' value='".$end_date_value."' />"
								."<label class='w3-hide-small fa fa-calendar fa-fw w3-margin-right' for='end_date_".$id_workXp."'></label>"
							."</div>"
							
							."<div class='w3-third'>"
								."<input data-checkToggleInput='1' data-rowId='".$id_workXp."' class='w3-check w3-border' type='checkbox' id='current_work_". $id_workXp ."' name='current_work_". $id_workXp ."' ".$checkbox_current_work." /> "
								."<label for='current_work_". $id_workXp ."'>nuvarande jobb</label>"
							."</div>"
						."</div>"
							
						."<div class='w3-mobile w3-margin-bottom w3-margin-top'>"
							."<textarea placeholder='Din beskrivning av arbetet.' required='required' class='w3-input w3-border' name='work_description_". $id_workXp ."' id='work_description_". $id_workXp."' style='resize:none;'>".(!empty($work['work_description']) ? $work['work_description'] : "") ."</textarea>"
						."</div>"
					."</div>";
			}
			// Lista alla befintliga rader om arbetserfarenhet.
			else{
				$list.=
					"<div class='w3-container'>"
						
						."<div class='w3-row'>"
						
							."<div class='w3-col m10 l10 w3-hide-small'>"
								."<h5 class='w3-opacity'><b>". $work['work_title'] ." / ". $work['employer']."</b> ". $work['work_time']."</h5>"
							."</div>"
							
							."<div class='w3-mobile w3-hide-medium w3-hide-large'>"
								."<h5 class='w3-opacity'><b>". $work['work_title'] ." / ". $work['employer']."</b> ". $work['work_time']."</h5>"
							."</div>"
							
							."<div class='m2 l2 w3-hide-small'>"
								."<a href='./?userID=1&cvID=1&action=delete&actionID=". $id_workXp ."&actionDelete=work' class='". $objProps->getBtnDeleteNonSmallScreen() ."' type='submit' name='delete_edu'><i class='fa fa-trash-alt'></i></a>"
							."</div>"
							
						."</div>"
						
						."<h6 class='w3-text-teal'>"
							."<i class='fa fa-calendar fa-fw w3-margin-right'></i>"
							.ucfirst($work['start_date_name']) . " - "  . ( $work['end_date_name'] != "Nuvarande" ? ucfirst($work['end_date_name']) : "<span class='w3-tag w3-teal w3-round'>". $work['end_date_name'] ."</span>" )
						."</h6>"
						
						."<p>". $work['work_description']."</p>"
						
						."<div class='w3-mobile w3-hide-medium w3-hide-large'>"
							."<a href='./?userID=1&cvID=1&action=delete&actionID=". $id_workXp ."&actionDelete=work' class='". $objProps->getBtnDeleteSmallScreen() ."' type='submit' name='delete_edu'><i class='fa fa-trash-alt'></i></a>"
						."</div>"
						
						."<hr />"
					."</div>";
			}
		}
		// If in edit mode we add the submit-type here, not in the loop, since it spawns x number of hidden inputs.... Lesson learned.
		if(isset($_GET['edit']) && $_GET['edit']=="work")
			$list.="<input type='hidden' value='saveWork' name='submitType' />";
		
		// the $i-variable is made to start at 0 and increase by one at the beginning of every loop when listing work XP already in the database.
		$list.="<input type='hidden' value='". $i ."' name='rowCountWorkXP' id='rowCountWorkXP' />";
		
		// If we are in add-mode then we show that part in the returned form. The empty input is only filled with values if "add" is the current $_GET-variable.
		if( !empty( $listAddEmptyInput ))
			$list=$listAddEmptyInput . $list;
		
		return $list; // Returns the list with work experience, either in display, edit or add mode.
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
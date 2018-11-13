<div id="cvSkillsModal" class="w3-modal">
	<div class="w3-modal-content">
		<div class="w3-container w3-blue">
			<h2 class="w3-panel">Hantera färdigheter och intressen i <?php echo (isset($myCurriculum) ? $myCurriculum->getDisplayCvName() : "");?></h2>
			<form id='formCv' class='SubmitFormAjax' method="post" action="./?userID=<?php echo (isset($loggedInUser) ? $loggedInUser->getUserId() : "" ); ?>&newCv=add">
				<input type='hidden' name='event' value='formCvCreateSubmit' />
				<div class="w3-row-padding w3-mobile">
					<div class="w3-third">
					<h3>Välj färdighet</h3>
					</div>
					<div class="w3-twothird">
						<p><input type="text" class="w3-large w3-input" name="beginCvName" id="beginCvName" /></p>
					</div>
				</div>
				
				<div class="w3-row-padding w3-mobile">
					<div class="w3-third">
					<h3>Beskriv din kunskapsnivå</h3>
					</div>
					<div class="w3-twothird">
						<p><textarea type="text" class="w3-large w3-input" name="beginCvDesc" id="beginCvDesc" style="height:5em"></textarea></p>
					</div>
				</div>
			
				<div class="w3-row-padding w3-mobile w3-padding">
					<button type="submit" class="w3-btn w3-round w3-white">Fortsätt</button>
				</div>
			</form>
		</div>
	</div>
</div>
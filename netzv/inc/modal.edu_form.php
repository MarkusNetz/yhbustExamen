<div id="modal-edu-form" class="w3-modal">
	<div class="w3-modal-content w3-animate-top">
		<div class="w3-container w3-card w3-padding">
			<h3 class="w3-text-teal">Ny utbildning</h3>
			<form id="addEduItem" class="SubmitFormAjax" type="post" action="">
				
				<input type="hidden" value="addEdu" name="submitType" />
				<input type="hidden" value="formEduSubmit" name="event" />
				<input type="hidden" value="1" name="modalForm" />
				<input type="hidden" value="<?php echo (isset($_GETcvID) ? $_GETcvID : "");?>" name="getCvId" />
			
				<div class="w3-row w3-margin-bottom w3-margin-top">
					<input class="w3-input w3-border w3-mobile" type="text" name="edu_title" id="edu_title" placeholder="Utbildning, inriktning" required="required" />
				</div>
				
				<div class="w3-row w3-margin-bottom w3-margin-top">
					<input class="w3-input w3-border w3-mobile" type="text" name="edu_school" id="edu_school" placeholder="Utbildare, skola" required="required" />
				</div>
				
				<div class="w3-row w3-margin-bottom w3-margin-top">
					<input class="w3-input w3-border w3-mobile" type="text" name="edu_time" id="edu_time" placeholder="Helfart, distans, halvfart etc." />
				</div>
				
				<div class="w3-row">
					<div class="w3-third">
						<label class="w3-hide-medium w3-hide-large" for="start_date">Start</label>
						<input class="w3-border w3-mobile" type="date" name="start_date" id="start_date" required="required" />
						<label class="w3-hide-small fa fa-calendar fa-fw w3-margin-right" for="start_date"></label>
					</div>
					
					<div class="w3-third">
						<label class="w3-hide-medium w3-hide-large" for="end_date">Slut</label>
						<input class="w3-border w3-mobile" type="date" name="end_date" id="end_date" />
						<label class="w3-hide-small fa fa-calendar fa-fw w3-margin-right" for="end_date"></label>
					</div>
				</div>
				
				<div class="w3-mobile w3-margin-bottom w3-margin-top">
					<textarea placeholder="Din beskrivning av utbildningen och dess innehåll av kurser och moment." required="required" class="w3-input w3-border" name="education_description" id="education_description" style="resize:none;"></textarea>
				</div>
				
				<a href="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>" class="w3-button w3-display-topright w3-red modalClose" data-modal-type="modal-edu-form">&times;</a>
				
				<button type="submit" name="submitting" class="w3-half w3-button w3-blue w3-hover-indigo w3-border w3-border-brown w3-hover-border-black" value="formEdu">Spara</button>
				
				<input type="hidden" name="submitAction" value="updEdu" />
				
			</form>
		</div>
	</div>
</div>
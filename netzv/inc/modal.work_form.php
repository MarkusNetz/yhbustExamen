<div id="modal-work-form" class="w3-modal">
	<div class="w3-modal-content w3-animate-top">
		<div class="w3-container w3-card w3-padding">
			<h3 class="w3-text-teal">Ny arbetserfarenhet</h3>
			<form id="addWorkItem" class="SubmitFormAjax" type="post" action="./">
				
				<input type="hidden" value="addWork" name="submitType" />
				<input type="hidden" value="formWorkSubmit" name="event" />
				<input type="hidden" value="1" name="modalForm" />
				<input type="hidden" value="<?php echo (isset($_GETcvID) ? $_GETcvID : "");?>" name="getCvId" />
				
				<div class="w3-row w3-margin-bottom w3-margin-top">
					<input class="w3-input w3-border w3-mobile" type="text" name="work_title" id="work_title" placeholder="Jobbtitel" required="required" />
				</div>
				
				<div class="w3-row w3-margin-bottom w3-margin-top">
					<input class="w3-input w3-border w3-mobile" type="text" name="work_employer" value="" placeholder="Arbetsgivare" required="required" />
				</div>
				
				<div class="w3-row w3-margin-bottom w3-margin-top">
					<input class="w3-input w3-border w3-mobile" type="text" name="work_time" id="work_time" placeholder="Heltid, deltid, projekt.." required="required" />
				</div>
				
				<div class="w3-row">	
					<div class="w3-mobile w3-third">
						<label class="w3-hide-medium w3-hide-large" for="start_date">Start</label>
						<input class="w3-border w3-mobile" type="date" name="start_date" id="start_date" value="" required="required" />
						<label class="w3-hide-small fa fa-calendar fa-fw w3-margin-right" for="start_date"></label>
					</div>
					
					<div class="w3-mobile w3-third">
						<label class="w3-hide-medium w3-hide-large" for="end_date">Slut</label>
						<input class="w3-border w3-mobile" type="date" name="end_date" id="end_date" value="" />
						<label class="w3-hide-small fa fa-calendar fa-fw w3-margin-right" for="end_date"></label>
					</div>
					
					<div class="w3-mobile w3-third">
						<input class="w3-check w3-border" type="checkbox" id="current_work" name="current_work" value="" />
						<label for="current_work">nuvarande jobb</label>
					</div>
					
				</div>
				
				<div class="w3-row w3-margin-bottom w3-margin-top">
					<div class="w3-block">
						<textarea required="required" placeholder="Din beskrivning av arbetet." class="w3-input w3-border" name="work_description" style="resize:none; height:5em;"></textarea>
					</div>
				</div>
				
				<a href="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>" class="w3-button w3-display-topright w3-red modalClose" data-modal-type="modal-work-form">
					&times;
				</a>
				<input type="submit" name="submitting" class="w3-half w3-button w3-blue w3-hover-indigo w3-border w3-border-brown w3-hover-border-black" value="Spara" />
			
			</form>
		</div>
	</div>
</div>
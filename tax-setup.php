						
                        
		<form id = "tax-setup" method="post" class = "form">
			<h2>New Tax Setup</h2>
			<div class = "row form-group">
				<label for="company_name">Company Name</label>
				<input type = "text"
				required data-pristine-required-message="Please enter a company name"
				id = "company_name" name = "company_name" />
			</div>
			<div class = "row form-group">
				<label for = "ein">EIN:</label>
				<input type = "password"
				required data-pristine-required-message="Please enter a EIN Number"
				id = "ein" name = "ein" />
			</div>

			<div class = "row form-group">
				<label for = "ownership_type">Ownership Type :</label>
				<select
				data-default-val="select"
				required data-pristine-required-message="Please enter a ownership type"
				id = "ownership_type" name = "ownership_type" class = "required">
					<option value = "select">Select Ownership</option>
					<option value = "sole_proprietor">Sole proprietor</option>
					<option value = "partnership">Partnership (not LLC)</option>
					<option value = "single_member_llc">Single member LLC</option>
					<option value = "s-corporation">S-Corporation</option>
					<option value = "Limited Liability Company">Limited Liability Company</option>
			</select>
			</div>
			<br />
			<h3>Mailing Address</h3>
			<hr />
			<div class = "row form-group">
				<label for="mailing_address">Address</label>
				<input type = "text"
				required data-pristine-required-message="Please enter a mailing address"
				id = "mailing_address" name = "mailing_address" />
			</div>
			<div class = "row form-group">
				<label for="mailing_city">City</label>
				<input type = "text"
				required data-pristine-required-message="Please enter a mailing City"
				id = "mailing_city" name = "mailing_city" />
			</div>
			<div class = "row form-group">
				<label for="mailing_state">State</label>
				<select
				required data-pristine-required-message="Please enter a mailing State"
				data-default-val = "na"
				id = "mailing_state" name = "mailing_state" class = "states required">
			</select>
			</div>
			<div class = "row form-group">
				<label for="mailing_zip">Zip</label>
				<input type = "text"
				required data-pristine-required-message="Please enter a mailing Zip"
				id = "mailing_zip" name = "mailing_zip" />
			</div>
			<br />

			<h3>Physical Address</h3>
			<hr />
			<div class = "row form-group">
				<label for="physical_address">Address</label>
				<input type = "text"
				required data-pristine-required-message="Please enter a phycial address"
				id = "physical_address" name = "physical_address" />
			</div>
			<div class = "row form-group">
				<label for="physical_city">City</label>
				<input type = "text"
				required data-pristine-required-message="Please enter a phycial City"
				id = "physical_city" name = "physical_city" />
			</div>
			<div class = "row form-group">
				<label for="physical_state">State</label>
				<select
				data-default-val="na"
				required data-pristine-required-message="Please enter a phycial State"
				id = "physical_state" name = "physical_state" class = "states required">
			</select>
			</div>
			<div class = "row form-group">
				<label for="physical_zip">Zip</label>
				<input type = "text"
				required data-pristine-required-message="Please enter a phycial Zip"
				id = "physical_zip" name = "physical_zip" />
			</div>		
			<br />
			<h3>Banking Information</h3>
			<hr />
			<p>Banking information used to make tax deposits online; Please include a copy of a voided check below</p>
			<div class = "row form-group">
				<label for = "bank_name">Bank Name :</label>
				<input type = "text"
				required data-pristine-required-message="Please enter a bank name"
				id = "bank_name" name = "bank_name" />
			</div>
			<div class = "row form-group">
				<label for = "routing_number">Routing Number :</label>
				<input type = "password"
				required data-pristine-required-message="Please enter a routing number"
				id = "routing_number" name = "routing_number" />
			</div>
			<div class = "row form-group">
				<label for = "account_number">Accouunt Number :</label>
				<input type = "password"
				required data-pristine-required-message="Please enter an account number"
				id = "accout_number" name = "account_number" />
			</div>

			<br />
			<h3>Responsible  Parties</h3>
			<hr />

			<div class = "resp-party-wrap org" data-index = "1">
				<p class = "respparty">Responsibile Party 1 </p>
				<hr />
				<div class = "row form-group">
					<label for = "party_name">Party Name :</label>
					<input type = "text"
					required data-pristine-required-message="Please Enter Party Name"
					id = "party_name_1" name = "party_name_1" class = "party_name" />
				</div>
				<div class = "row form-group">
					<label for = "ssn">SSN or FEIN :</label>
					<input type = "Password"
					required data-pristine-required-message="Please Enter SSN or FEIN Number"
					id = "ssn_1" name = "ssn_1" class = "ssn" />
				</div>
			</div>
			<div class = "row form-group">
				<button id = "new-party" data-max = "5">
					 Add A New Party
				</button>
			</div>
			<hr />
			<input type = "hidden" name="isvalid" id = "isvalid" />
			<button id = "goback" onclick="history.back(-1);">Go Back</button>
			<button id = "tax-submit">Submit</button>
			<?php 
	




			if ($_POST['isvalid']=='iamvalid') {
				$message = 'Dearest Becky <br />';
				$ignorearr = ['isvalid', 'csrfpId'];
				foreach ($_POST as $key=>$post) {
					if (!in_array($key, $ignorearr)) {
						$message = $message . $key . ': ' . $post . '<br />';
					}
				}
				$to = 'becky@simplifyprofessionalservices.com';
				//$to = 'kevinbollman@gmail.com';
				$subject = 'New Tax Setup';
								
				$headers = array('Content-Type: text/html; charset=UTF-8',
							'From:SecureUpload <secureupload@simplifyprofessionalservices.com>');
				if (wp_mail( $to, $subject, $message, $headers )) {
					?> 
						You form was uploaded successfully
					<?php
				}

			}

			?>

		</form>
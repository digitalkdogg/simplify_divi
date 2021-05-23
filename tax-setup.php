						
                        
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
			<h4>Mailing Address</h4>
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

			<h4>Physical Address</h4>
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
			<h4>Banking Information</h4>
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
			<h4>Responsible  Parties</h4>
			<hr />
			<div class = "row form-group">
				<label for = "responsible_parties">Number Responsible Parties :</label>
				<select
				data-default-val="select"
				required data-pristine-required-message="Please enter a number for responsible parties"
				id = "responsible_parties" name = "responsible_parties" class = "required" >
					<option value = "select">Select Responsible Parties</option>
					<option value = "1">1</option>
					<option value = "2">2</option>
					<option value = "3">3</option>
					<option value = "4">4</option>
					<option value = "5">5</option>
				</select>
			</div>
			<input type = "hidden" name="isvalid" id = "isvalid" />
			<button id = "new-tax-submit">Submit</button>
		</form>
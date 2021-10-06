<?php

/*
Template Name: Secure Upload - New Tax Setup
*/

get_header();

if( !session_id() )
      session_start();


$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

<div id="main-content">
<script src="<?php echo get_stylesheet_directory_uri();?>/libs/jQuery.js" type = "text/javascript"></script>
<link rel = "stylesheet" href ="<?php echo get_stylesheet_directory_uri();?>/libs/flatpicker.css" />
<script src = "<?php echo get_stylesheet_directory_uri();?>/libs/flatpicker.js"></script>

<script src = "<?php echo get_stylesheet_directory_uri();?>/libs/pristine.js"></script>

<script src = "<?php echo get_stylesheet_directory_uri();?>/libs/crypto-core.js"></script>
<script src = "<?php echo get_stylesheet_directory_uri();?>/libs/crypto-md5.js"></script>

<link rel = "stylesheet" href = "<?php echo get_stylesheet_directory_uri(); ?>/secure-upload.css" />
<link rel = "stylesheet" href = "<?php echo get_stylesheet_directory_uri(); ?>/../../../wp-includes/css/dashicons.min.css" />


<?php if ( ! $is_page_builder_used ) : ?>

	<div class="container">
		<div id="content-area" class="clearfix">

<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( ! $is_page_builder_used ) : ?>
				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_featured_image';
					$titletext = get_the_title();
					$alttext = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
					$thumbnail = get_thumbnail( $width, $height, $classtext, $alttext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb )
						print_thumbnail( $thumb, $thumbnail["use_timthumb"], $alttext, $width, $height );
				?>

				<?php endif; ?>

					<div class="entry-content" id = "secure-upload-page">

					<?php
						the_content();

						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
					?>


<form id = "tax-setup"
			 method="post"
			 class = "form <?php if ($_POST['isvalid']=='iamvalid') {echo "has-post"; }?>"
			 enctype="multipart/form-data">

			<h2>Payroll Tax Setup Information Form</h2>
			<p>* indicates required field</p>
			<input type = "hidden" name = "data-id" id = "data-id" value = "<?php echo get_hash_string(); ?>" />
			<div class = "row form-group">
				<label for="company_name">* Company Name :</label>
				<input type = "text"
				required data-pristine-required-message="Please enter a company name"
				id = "company_name" name = "company_name" />
			</div>
			<div class = "row form-group">
				<label for = "ein">* EIN :</label>
				<input type = "text" autocomplete="off" class = "password"
				required data-pristine-required-message="Please enter a EIN Number"
				id = "ein" name = "ein" />
			</div>
			<div class = "row form-group">
                <label for="email_name">* E-mail : </label>
				<input type = "email" id = "email_name" name = "email_name" required data-pristine-required-message="Please enter a email" />

            </div>

			<div class = "row form-group">
				<label for = "ownership_type">* Ownership Type :</label>
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
			<div class = "row form-group">
				<label for = "desc" class = "translate-y-35">* Description of Business Activity :</label>
				<textarea id = "desc" name = "desc" cols = "45" rows = "5"
				 required data-pristine-required-message="Please enter a Description of Business Activity"></textarea>
			</div>
			<br />
			<h3>Mailing Address</h3>
			<hr />
			<div class = "row form-group">
				<label for="mailing_address">* Address :</label>
				<input type = "text"
				required data-pristine-required-message="Please enter a mailing address"
				id = "mailing_address" name = "mailing_address" class = "address" data-phys="physical_address" />
			</div>
			<div class = "row form-group">
				<label for="mailing_city">* City :</label>
				<input type = "text"
				required data-pristine-required-message="Please enter a mailing City"
				id = "mailing_city" name = "mailing_city" class = "address" data-phys="physical_city"/>
			</div>
			<div class = "row form-group">
				<label for="mailing_state">* State </label>
				<select
				required data-pristine-required-message="Please enter a mailing State"
				data-default-val = "na"
				id = "mailing_state" name = "mailing_state" class = "states required address" data-phys="physical_state">
			</select>
			</div>
			<div class = "row form-group">
				<label for="mailing_zip">* Zip : </label>
				<input type = "text"
				required data-pristine-required-message="Please enter a mailing Zip"
				id = "mailing_zip" name = "mailing_zip" class = "address" data-phys="physical_zip"/>
			</div>
			<br />

			<h3>Physical Address</h3>
			<hr />
			<div class = "row">
			<span class = "inline-check"> 
				 <input type = "checkbox" id = "sameasdelivery" />
				 Same as delivery address
				</span>
			</div>
			<div class = "row form-group">
				<label for="physical_address">* Address : </label>
				<input type = "text"
				required data-pristine-required-message="Please enter a phycial address"
				id = "physical_address" name = "physical_address" />
			</div>
			<div class = "row form-group">
				<label for="physical_city">* City :</label>
				<input type = "text"
				required data-pristine-required-message="Please enter a physical City"
				id = "physical_city" name = "physical_city" />
			</div>
			<div class = "row form-group">
				<label for="physical_state">* State : </label>
				<select
				data-default-val="na"
				required data-pristine-required-message="Please enter a phycial State"
				id = "physical_state" name = "physical_state" class = "states required">
			</select>
			</div>
			<div class = "row form-group">
				<label for="physical_zip">* Zip : </label>
				<input type = "text"
				required data-pristine-required-message="Please enter a phycial Zip"
				id = "physical_zip" name = "physical_zip" />
			</div>
			<br />
			<h3>Banking Information</h3>
			<hr />
			<p>Banking information used to make tax deposits online; Please include a copy of a voided check below</p>
			<div class = "row form-group">
				<label for = "bank_name">* Bank Name :</label>
				<input type = "text"
				required data-pristine-required-message="Please enter a bank name"
				id = "bank_name" name = "bank_name" />
			</div>
			<div class = "row form-group">
				<label for = "routing_number">* Routing Number :</label>
				<input type = "type" class = "password" autocomplete="off"
				required data-pristine-required-message="Please enter a routing number"
				id = "routing_number" name = "routing_number" />
			</div>
			<div class = "row form-group">
				<label for = "account_number">* Accouunt Number:</label>
				<input type = "text" class = "password" autocomplete="off"
				required data-pristine-required-message="Please enter an account number"
				id = "accout_number" name = "account_number" />
			</div>
			<div class = "row form-group">
				<label for="file">* File : </label><input type="file" id="file" name="file" class = "file" />
				<span class = "file-info"></span>
				<div class = "pristine-error" style = "display:none;"></div>
			</div>

			<br />
			<h3>Responsible  Parties</h3>
			<hr />

			<div class = "resp-party-wrap org" data-index = "1">
				<p class = "respparty">* Responsibile Party 1 : </p>
				<hr />
				<div class = "row form-group">
					<label for = "party_name">* Party Name :</label>
					<input type = "text"
					required data-pristine-required-message="Please Enter Party Name"
					id = "party_name_1" name = "party_name_1" class = "party_name" />
				</div>
				<div class = "row form-group">
					<label for = "ssn">* SSN or FEIN :</label>
					<input type = "text" class = "password" autocomplete="off"
					required data-pristine-required-message="Please Enter SSN or FEIN Number"
					id = "ssn_1" name = "ssn_1" class = "ssn" />
				</div>
				<div class = "row form-group">
					<label for = "title">* Title :</label>
					<input type = "text"
					required data-pristine-required-message="Please Enter Title"
					id = "title_1" name = "title_1" class = "title" />
				</div>
				<div class = "row form-group">
					<label for = " Phone number">Phone Number :</label>
					<input type = "text" placeholder="555-555-5555"
					id = "phone_1" name = "phone_1" class = "phone" />
				</div>
				<div class = "row form-group">
					<label for = " Email">Email :</label>
					<input type = "text" placeholder="johnsmith@someplace.com"
					id = "email_1" name = "email_1" class = "email" />
				</div>
				<div class = "row form-group">
					<label for="resp_address">Address</label>
					<input type = "text"
					id = "resp_address_1" name = "resp_address_1" class = "resp_address"/>
				</div>
				<div class = "row form-group">
					<label for="resp_city">City</label>
					<input type = "text"
					id = "resp_city_1" name = "resp_city_1" class = "resp_city" />
				</div>
				<div class = "row form-group">
					<label for="resp_state">State</label>
					<select
					data-default-val="na"
					id = "resp_state_1" name = "resp_state_1" class = "states resp_state">
				</select>
				</div>
				<div class = "row form-group">
					<label for="resp_zip">Zip</label>
					<input type = "text"
					id = "resp_zip_1" name = "resp_zip_1" class = "resp_zip"/>
				</div>
				<div class = "row form-group">
					<label for="resp_birth_date">Birth Date</label>
					<input type = "text"
					id = "resp_birth_date_1" name = "resp_birth_date_1" class = "resp_birth_date date"/>
				</div>
			</div>
			<div class = "row form-group">
				<button id = "new-party" data-max = "5">
					 Add A New Party
				</button>
			</div>

			<hr />
			<div class = "row form-group checkbox">
			<h4>Terms and Service</h4>
			<p> It is understood that the above information is and must be kept confidential.  Simplify Professional Services shall limit the disclosure of the confidential information to completion of forms for the sole purpose of setting up payroll accounts and payment processes.  </p>
			<label for="terms" style = "background:transparent; color:black; width:auto; ">Check to agree : </label>
			<input type = "checkbox" id = "terms" name = "terms" required data-pristine-required-message="Please Agree to the terms and service statement" />
			</div>

			<input type = "hidden" name="isvalid" id = "isvalid" />
			
            <?php 
                if (get_post_custom_values('go_back_page')!=null) {
                    echo "<a href = '". get_post_custom_values('go_back_page')[0] ."'>";
                    echo "<div id = 'goback' class = 'goback'>Go Back!</div>";
                    echo "</a>";
                }
                
            ?>


			<button id = "tax-submit">Submit</button>
			<?php





			if ($_POST['isvalid']=='iamvalid') {

					$message = 'Dearest Becky <br />';
					$ignorearr = ['isvalid', 'csrfpId', 'data-id'];
					foreach ($_POST as $key=>$post) {
						if (!in_array($key, $ignorearr)) {
							$message = $message . $key . ': ' . $post . '<br />';
						}
					}

					if(isset($_FILES['file'])){
		

					$data = prep_attatchment($_FILES['file']);

					if(empty($data['errors'])==true  ) {

						if (md5($_POST['data-id'])) {

							$data['file_name'] = str_replace(' ', '_', $data['file_name']);

							if (move_uploaded_file($data['file_tmp'],get_template_directory() . "/../../../uploads/". substr($_POST['data-id'], -7) . '--' . $data['file_name'])==true) {

								$message =  $message .'<br />Link :' . WP_CONTENT_URL . '/../uploads/' . substr($_POST['data-id'], -7) . '--' . $data['file_name'];

								if (send_to_email(get_post_custom_values('send_to_email'), $message) ) {
											
								?> 
								<div id = "status">
									<div style="color:#47a9aa;">
										<span class="dashicons dashicons-smiley"></span>
										<p class = "margin-20"></p><p class="margin-20">
											<?php echo $data['file_name']; ?> was uploaded succesful.  We will be in touch shortly!
										</p>     
										<div class = "close btn">Okay I Got It!</div>                                      
									</div>
								</div>

								<?php

								} else {
								?>
								<div id = "status">
									<div style = "color:red;">
										<span style = "font-size:3em;">Oh No!</span>
										<p class = "margin-20">
											<p>It looks like there was an problem processing your request</p> 
											<p>Please try your submission again</p>
											<div class = "close btn">Okay I Got It!</div>
										</p>
									</div>
								</div>
							<?php
							}
						} else {
							?>
							<div id = "status">
								<div style = "color:red;">
									<span style = "font-size:3em;">Oh No!</span>
									<p class = "margin-20">
										<p>It looks like there was an problem processing your request</p> 
										<p>Please try your submission again</p>
										<div class = "close btn">Okay I Got It!</div>
									</p>
								</div>
							</div>
							<?php
						}
								  

						}
					} else {
						?>
							<div id = "status">
								<div style = "color:red;">
									<span style = "font-size:3em;">Oh No!</span>
									<p class = "margin-20">
										<p>It looks like there was an problem processing your request</p> 
										<p>Please try your submission again</p>
										<div class = "close btn">Okay I Got It!</div>
									</p>
								</div>
							</div>
							<?php

					}

						
					} 
				}


							?>

		</form>


					</div> <!-- .entry-content -->

				<?php
					if ( ! $is_page_builder_used && comments_open() && 'on' === et_get_option( 'divi_show_pagescomments', 'false' ) ) comments_template( '', true );
				?>

				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>

<?php if ( ! $is_page_builder_used ) : ?>

			</div> <!-- #left-area -->

		</div> <!-- #content-area -->
	</div> <!-- .container -->

<?php endif; ?>

</div> <!-- #main-content -->

<?php

get_footer();

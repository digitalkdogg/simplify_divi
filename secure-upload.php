<?php

/*
Template Name: Secure Upload Form
*/

get_header();

if( !session_id() )
      session_start();


$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

<div id="main-content">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="https://pristine.js.org/dist/pristine.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/core.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>

<link rel = "stylesheet" href = "<?php echo get_stylesheet_directory_uri(); ?>/secure-upload.css" />


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
					<div id = "left-side">
					<?php
						the_content();

						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
					?>
					</div>
					<div id = "right-side">
					
						<form id = "direct-deposit" class = "form" method="post" enctype="multipart/form-data" >
							<h4>Direct Deposit Authorization Form</h4>
							<p>This document must be signed by employees and/or vendors requesting automatic deposit of
paychecks/checks and retained on file by the employer. Please attach a voided check for the account to
help verify their account numbers and bank routing numbers.</p>
							<br />

							<div class = "row form-group">
								<label for="employee_name">Employee Name</label>
								<input type = "text" 
								required data-pristine-required-message="Please enter a name" 
								id = "employee_name" name = "employee_name" />
							</div>
							
							<div class = "row form-group checkbox">
								<label>Account Type</label>
								<label for="checking" style = "background:transparent; color:black; width:auto; ">Checking : </label>
								<input type = "checkbox" id = "checking" name = "checking" />
								<div class = "mobile-block"></div>
								<label for="savings" style = "background:transparent; color:black; width:auto;">Savings : </label>
								 <input type = "checkbox" 
								id = "savings" name = "savings" /> 
								
								<br />
							
							</div>

							<div class = "row form-group">
								<label for="routing_number" class = "width-auto-desktop">Bank Routing Number</label>
								<input type = "password" 
								required data-pristine-required-message="Please enter a routing number" 
								id = "routing_number" name = "routing_number" />
							</div>
							<div class = "row form-group">
								<label for="account_number" class = "width-auto-desktop">Bank Account Number</label>
								<input type = "password" 
								required data-pristine-required-message="Please enter a routing number" 
								id = "account_name" name = "account_number" />
							</div>
							<div class = "row form-group">
								<label for="file">File </label><input type="file" id="checkimg" name="checkimg" class = "file" />
								<span class = "file-info"></span>
								<div class = "pristine-error" style = "display:none;"></div>
							</div>
							<div class = "row form-group checkbox">
							<h4>Terms and Service</h4>
							<p>This authorizes Simplify Professional Services, to send credit entries (and appropriate debit and adjustment entries),
electronically or by any other commercially accepted method, to my (our) account(s) indicated below
and to other accounts I (we) identify in the future (the “Account”). This authorizes the financial
institution holding the Account to post all such entries. I agree that the ACH transactions authorized
herein shall comply with all applicable U.S. Law. This authorization will be in effect until the Company
receives a written termination notice from myself and has a reasonable opportunity to act on it.</p>
							<label for="terms" style = "background:transparent; color:black; width:auto; ">Check to agree : </label>
							<input type = "checkbox" id = "terms" name = "terms" required data-pristine-required-message="Please Agree to the terms and service statement" />
							</div>


							<input type = "hidden" name="isvalid" id = "isvalid" />
							<button id = "direct-deposit-submit">Submit</button>

							<div id = "status">
							<?php
							
							if ($_POST['isvalid']=='iamvalid') {
							

								if ($_POST) {
									var_dump('i made it here');
									var_dump($_POST);
									var_dump($_FILES);
									if(isset($_FILES['file'])){

									
										$errors= array();
										$file_name = $_FILES['file']['name'];
										$file_size =$_FILES['file']['size'];
										$file_tmp =$_FILES['file']['tmp_name'];
										$file_type=$_FILES['file']['type'];
										$file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
						
										$extensions= array("jpeg","jpg","png","gif" );
									
										if(in_array($file_ext,$extensions)=== false){
											$errors[]="extension not allowed, please choose a JPEG or PNG file.";
										}
									
										if($file_size > 200097152){
											$errors[]='File size must be less than 200 MB';
										}
										if(empty($errors)==true){
											$to = 'becky@simplifyprofessionalservices.com';
								 			//$to = 'kevinbollman@gmail.com';
								 			$subject = 'Direct Deposit Submission';
								 			$message = 'Here is the direct deposit info : <br /> <br />
								 			Employee Name : ' . $_POST['employee_name'] . 
								 			'<br />Checking : ' . $_POST['checking'] . 
								 			'<br />Savings : ' . $_POST['savings'] . 
								 			'<br />Routing No :'. $_POST['routing_number']  . 
								 			'<br />Account No : ' . $_POST['account_number'] .
								 			'<br />Check Image : ';
											 
											$headers = array('Content-Type: text/html; charset=UTF-8','From:SecureUpload <secureupload@simplifyprofessionalservices.com>');
								 			if (wp_mail( $to, $subject, $message, $headers )) {
									 		?> 
										 		You form was uploaded successfully
									 		<?php
								 			}
										}
									}
								}
						
								

							}

							?>
							</div>


						</form>



						<form id = "new-employee" class = "form" method="post" >
							<div class = "row form-group">
								<label for="employee_name">Employee Name</label>
								<input type = "text" 
								required data-pristine-required-message="Please enter a name" 
								id = "employee_name" name = "employee_name" />
							</div>

							<div class = "row form-group">
								<label for="email_name">Email Address</label>
								<input type = "email" 
								required data-pristine-required-message="Please enter a email address" 
								id = "email_name" name = "email_name" />
							</div>
							
							<div class = "row form-group">
								<label for="start_date">Start Date</label>
								<input type = "text" 
								class="date"
								required data-pristine-required-message="Please enter a start date" 
								id = "start_date" name = "start_date" />
							</div>


							<div class = "row form-group">
								<label for="pay">Rate Pay or Salary </label>
								<input type = "text" 
								required data-pristine-required-message="Please enter a rate pay or salary" 
								id = "pay" name = "pay" />
							</div>

							<div class = "row form-group">
								<label for="benefits">Benefits </label>
								<input type = "text" 
								required data-pristine-required-message="Please enter something for the benefits" 
								id = "benefits" name = "beneftis" />
							</div>
							
							<br />
							<input type = "hidden" name="isvalid" id = "isvalid" />
							<button id = "new-employee-submit">Submit</button>
							<button id = "new-employee-print">Print As PDF</button>
							<div id = "status">
							<?php
							
							if ($_POST['isvalid']=='iamvalid') {
							
						
								$to = 'becky@simplifyprofessionalservices.com';
								//$to = 'kevinbollman@gmail.com';
								$subject = 'New Employee Submission';
								$message = 'Here is the new employee info : <br /> <br />
								Employee Name : ' . $_POST['employee_name'] . 
								'<br />Email Address : ' . $_POST['email_name'] . 
								'<br />Start Date : ' . $_POST['start_date'] . 
								'<br />Salary :'. $_POST['pay']  . 
								'<br />benefits : ' . $_POST['beneftis'];
								//	$message = 'Dearest Becky!<br /><br /> There is a new submission<br /><br /> From : ' . $_POST['person_name'] . '<br />Email : ' . $_POST['email'] . '<br />Link :' . WP_CONTENT_URL . '/../uploads/' . substr($_POST['data-id'], -7) . '--' . $file_name;
											
								$headers = array('Content-Type: text/html; charset=UTF-8','From:SecureUpload <secureupload@simplifyprofessionalservices.com>');
								if (wp_mail( $to, $subject, $message, $headers )) {
									?> 
										You form was uploaded successfully
									<?php
								}

							}

							?>
							</div>
						</form>

						<form id = "secure-form" 
							method="post" 
							enctype="multipart/form-data"
							class = "form">
							<h2>Upoload Your Documents</h2>

							<!--<div id = "main-form" class = "form"> -->
								<input type = "hidden" name = "data-id" id = "data-id" value = "<?php echo get_hash_string(); ?>" />
								<div class = "row form-group">
									<label for="person_name">Name</label>
									<input type = "text" required data-pristine-required-message="Please enter a name" id = "person_name" name = "person_name" />
								</div>
								<div class = "row form-group">
									<label for="company">Company</label>
									<input type = "text" id = "company" name = "company" required data-pristine-required-message="Please enter a company" />
								</div>
								<div class = "row form-group">
									<label for="email">Email</label>
									<input type = "email" id = "email" name = "email" required data-pristine-required-message="Please enter a email" />

								</div>
								<div class = "row form-group">
									<label for="file">File </label><input type="file" id="file" name="file" class = "file" />
									<span class = "file-info"></span>
									<div class = "pristine-error" style = "display:none;"></div>
								</div>
								<br />
								<button id="submit-secure-file">Submit</button>
								<div id = "status">
								<?php 
								if ($_POST) {
									if(isset($_FILES['file'])){
										$errors= array();
										$file_name = $_FILES['file']['name'];
										$file_size =$_FILES['file']['size'];
										$file_tmp =$_FILES['file']['tmp_name'];
										$file_type=$_FILES['file']['type'];
										$file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
						
										$extensions= array("jpeg","jpg","png","gif", "svg", "pdf", "doc", "docx", "csv" );
									
										if(in_array($file_ext,$extensions)=== false){
											$errors[]="extension not allowed, please choose a JPEG or PNG file.";
										}
									
										if($file_size > 200097152){
											$errors[]='File size must be less than 200 MB';
										}
										if(empty($errors)==true){
											if (md5($_POST['data-id'])) {
									
												$file_name = str_replace(' ', '_', $file_name);
							
												if (move_uploaded_file($file_tmp,get_template_directory() . "/../../../uploads/". substr($_POST['data-id'], -7) . '--' . $file_name)==true) { 
												?>
													<div style = "color:#47a9aa;">
														<?php echo $file_name; ?> was uploaded succesful
													</div>
												<?php
										
												$to = 'becky@simplifyprofessionalservices.com';
												// $to = 'kevinbollman@gmail.com';
												$subject = 'Secure Upload Submission';
												$message = 'Dearest Becky!<br /><br /> There is a new submission<br /><br /> From : ' . $_POST['person_name'] . '<br />Email : ' . $_POST['email'] . '<br />Link :' . WP_CONTENT_URL . '/../uploads/' . substr($_POST['data-id'], -7) . '--' . $file_name;
															
												$headers = array('Content-Type: text/html; charset=UTF-8','From:SecureUpload <secureupload@simplifyprofessionalservices.com>');
												wp_mail( $to, $subject, $message, $headers );
												//  mail($to, $subject, $message, $headers);
											} else { ?>
												<div style = "color:red;">
													There was an issue uploading your file please try again
												</div>
											<?php
											}
										} else { ?>
											<div style = "color:red;">
												There was an issue uploading your file
											</div>
										<?php
										}
									} else { ?>
										<div style = "color:red;">
										
											<?php echo $errors[0]; ?>
										</div>
									<?php
									}
								}   
									
							}


							?>		
							</div> <!-- end status -->				
							
						
						</form>
					</div> <!-- end right side -->
					
					
					
                    
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

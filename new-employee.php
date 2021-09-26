<?php

/*
Template Name: Secure Upload - New Employee
*/

get_header();

if( !session_id() )
     // session_start();


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

					<div class="entry-content new-employee" id = "secure-upload-page">

					<?php
						the_content();

						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
					?>
                    <form id = "new-employee" class = "form" method="post" >
                    <h2>New Employee Form</h2>
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
                            <label for="rate">Unit Of Pay:</label>
                            <select
                                    data-default-val="select"
                                    required data-pristine-required-message="Please enter a rate of pay"
                                    id = "rate" name = "rate" class = "required">
                                        <option value = "Hourly" >Hourly</option>
                                        <option value = "Yearly" selected>Yearly</option>
                                </select>
                        </div>

                        <div class = "row form-group">
                            <label for="benefits">Benefits </label>
                            <input type = "text"
                            required data-pristine-required-message="Please enter something for the benefits"
                            id = "benefits" name = "beneftis" />
                        </div>
                        <div class = "row note">
                        Remember to submit a W4, AR W4 and Direct Deposit form (if applicable)
                        </div>

                        <br />
                        <input type = "hidden" name="isvalid" id = "isvalid" />
                        <?php 
                            if (get_post_custom_values('go_back_page')!=null) {
                                echo "<a href = '". get_post_custom_values('go_back_page')[0] ."'>";
                                echo "<div id = 'goback' class = 'goback'>Go Back!</div>";
                                echo "</a>";
                            }
                            
                        ?>

                        <button id = "new-employee-submit">Submit</button>
                        <div id = "status">
                        <?php

                        if ($_POST['isvalid']=='iamvalid') {

                            if (send_to_email(get_post_custom_values('send_to_email')) ) {
                             ?>
                                    You form was uploaded successfully
                                    <p>Do you need to upload a document for this employee</p>
                                    <p><a href = 'https://simplifyprofessionalservices.com/sps/upload-form/'>
                                    <div class = "btn">Upload Documents</div></a></p>
                            <?php
                            } else {
                            ?>
                                We are not able to submit the form at this time
                            <?php 
                            }

                        }

                        ?>
                        </div>
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

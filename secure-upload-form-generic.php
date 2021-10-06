<?php

/*
Template Name: Secure Upload Form - Generic
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

                <form id = "secure-form"
                    method="post"
                    enctype="multipart/form-data"
                    class = "form">
                    <h2>Upoload Your Documents</h2>

                    <!--<div id = "main-form" class = "form"> -->
                        <input type = "hidden" name = "data-id" id = "data-id" value = "<?php echo get_hash_string(); ?>" />
                        <div class = "row form-group">
                            <label for="person_name">* Name :</label>
                            <input type = "text" required data-pristine-required-message="Please enter a name" id = "person_name" name = "person_name" />
                        </div>
                        <div class = "row form-group">
                            <label for="company">* Company :</label>
                            <input type = "text" id = "company" name = "company" required data-pristine-required-message="Please enter a company" />
                        </div>
                        <div class = "row form-group">
                            <label for="email_name">* E-mail :</label>
                            <input type = "email" id = "email_name" name = "email_name" required data-pristine-required-message="Please enter a email" />

                        </div>
                        <div class = "row form-group">
                            <label for="file">* File : </label><input type="file" id="file" name="file" class = "file" />
                            <span class = "file-info"></span>
                            <div class = "pristine-error" style = "display:none;"></div>
                        </div>
                        <br />


                            <button id = "goback" class = "goback">Go Back</button>
                        <button id="submit-secure-file">Submit</button>

                    <?php
                    if ($_POST) {
                        if(isset($_FILES['file'])){
                            $data = prep_attatchment($_FILES['file']);
                                if(empty($data['errors'])==true){
                                    if (md5($_POST['data-id'])) {
                                        $data['file_name'] = str_replace(' ', '_', $data['file_name']);

                                           if (move_uploaded_file($data['file_tmp'],get_template_directory() . "/../../../uploads/". substr($_POST['data-id'], -7) . '--' . $data['file_name'])==true) {
                                                $message = 'Dearest Becky!<br /><br /> There is a new submission<br /><br /> From : ' . $_POST['person_name'] . '<br />Email : ' . $_POST['email'] . '<br />Link :' . WP_CONTENT_URL . '/../uploads/' . substr($_POST['data-id'], -7) . '--' . $data['file_name'];
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

                                            } else { ?>
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

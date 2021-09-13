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


                            <button id = "goback" class = "goback">Go Back</button>
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

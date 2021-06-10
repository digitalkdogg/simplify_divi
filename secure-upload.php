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
<script src="<?php echo get_stylesheet_directory_uri();?>/libs/jQuery.js" type = "text/javascript"></script>
<link rel = "stylesheet" href ="<?php echo get_stylesheet_directory_uri();?>/libs/flatpicker.css" />
<script src = "<?php echo get_stylesheet_directory_uri();?>/libs/flatpicker.js"></script>

<script src = "<?php echo get_stylesheet_directory_uri();?>/libs/pristine.js"></script>

<script src = "<?php echo get_stylesheet_directory_uri();?>/libs/crypto-core.js"></script>
<script src = "<?php echo get_stylesheet_directory_uri();?>/libs/crypto-md5.js"></script>

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

						<?php get_template_part( 'direct-deposit' );   ?>

						<?php get_template_part( 'new-employee' ); ?>

						<?php get_template_part('tax-setup'); ?>

						<?php get_template_part('secure-upload-form'); ?>	

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

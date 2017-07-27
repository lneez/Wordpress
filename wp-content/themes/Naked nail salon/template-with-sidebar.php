<?php
/*
Template Name: With Sidebar
*/
?>

<?php get_header();?>

<?php while (have_posts()) : the_post(); ?>

<?php $page_id = get_the_ID();
$lsvr_sidebar_settings_meta = get_post_meta( $page_id, '_lsvr_sidebar_settings_meta', true );
$sidebar_pos = is_array( $lsvr_sidebar_settings_meta ) && array_key_exists( 'pos', $lsvr_sidebar_settings_meta ) ? $lsvr_sidebar_settings_meta['pos'] : 'right';
$sidebar_mobilepos = is_array( $lsvr_sidebar_settings_meta ) && array_key_exists( 'mobilepos', $lsvr_sidebar_settings_meta ) ? $lsvr_sidebar_settings_meta['mobilepos'] : 'bottom';
?>

<!-- CORE : begin -->
<div id="core" <?php post_class(); ?>
	<?php if ( has_post_thumbnail() ) : ?>
		<?php $image_data = lsvr_get_image_data( get_post_thumbnail_id( get_the_ID() ) ); ?>
		<?php echo ' style="background-image: url(' . $image_data['full'] . ');"'; ?>
	<?php endif; ?>>

	<!-- PAGE HEADER : begin -->
	<div id="page-header">
		<div class="container">
			<h1 class="m-secondary-font"><?php the_title(); ?></h1>
			<?php get_template_part( 'title', 'breadcrumb' ); ?>
		</div>
	</div>
	<!-- PAGE HEADER : begin -->

	<div class="container">
		<div class="row">

			<?php if ( $sidebar_mobilepos === 'top' ) : ?>
			<div class="col-md-4
				<?php if ( $sidebar_pos === 'right' ) { echo ' col-md-push-8'; } ?>">

				<?php // SIDEBAR
				get_sidebar(); // load sidebar.php ?>

			</div>
			<?php endif; ?>

			<div class="col-md-8
				<?php if ( $sidebar_pos === 'left' && $sidebar_mobilepos === 'bottom' ) { echo ' col-md-push-4'; } ?>
				<?php if ( $sidebar_pos === 'right' && $sidebar_mobilepos === 'top' ) { echo ' col-md-pull-4'; } ?>">

				<!-- PAGE CONTENT : begin -->
				<div id="page-content">
					<div class="various-content">
						<?php the_content(); ?>
					</div>
				</div>
				<!-- PAGE CONTENT : end -->

			</div>

			<?php if ( $sidebar_mobilepos === 'bottom' ) : ?>
			<div class="col-md-4
				<?php if ( $sidebar_pos === 'left' ) { echo ' col-md-pull-8'; } ?>">

				<?php // SIDEBAR
				get_sidebar(); // load sidebar.php ?>

			</div>
			<?php endif; ?>

		</div>
	</div>

</div>
<!-- CORE : end -->

<?php endwhile; ?>

<?php get_footer(); ?>
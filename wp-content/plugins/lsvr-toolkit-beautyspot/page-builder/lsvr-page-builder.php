<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {

/* -----------------------------------------------------------------------------

    INIT

----------------------------------------------------------------------------- */

	// LOAD CSS
	if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) ) {
		if ( ! function_exists( 'lsvr_load_page_builder_files' ) ) {
			function lsvr_load_page_builder_files() {
				wp_register_style( 'page-builder', plugins_url( 'lsvr-toolkit-beautyspot' ) . '/library/css/page-builder.css', false );
				wp_enqueue_style( 'page-builder' );
			}
		}
		add_action( 'admin_enqueue_scripts', 'lsvr_load_page_builder_files' );
	}

	// SET AS THEME
	add_action( 'vc_before_init', 'lsvr_vc_init' );
	if ( ! function_exists( 'lsvr_vc_init' ) ) {
		function lsvr_vc_init() {
			vc_set_as_theme();
		}
	}

	// SET DEFAULT POST TYPES FOR VC
	vc_set_default_editor_post_types( array( 'page', 'lsvrservice' ) );


/* -----------------------------------------------------------------------------

    ELEMENTS

----------------------------------------------------------------------------- */

	if ( ! function_exists( 'lsvr_vc_register_shortcodes' ) ) {
		function lsvr_vc_register_shortcodes() {

			// ACCORDION
			require_once( 'elements/accordion.php' );

			// ALERT MESSAGE
			require_once( 'elements/alert-message.php' );

			// ARTICLES
			require_once( 'elements/articles.php' );

			// BUTTON
			require_once( 'elements/button.php' );

			// CAROUSEL
			require_once( 'elements/carousel.php' );

			// CTA
			require_once( 'elements/cta.php' );

			// DIVIDER
			require_once( 'elements/divider.php' );

			// GALLERY
			require_once( 'elements/gallery.php' );

			// GOOGLE MAP
			require_once( 'elements/gmap.php' );

			// ICON BLOCK
			require_once( 'elements/icon-block.php' );

			// IMAGE
			require_once( 'elements/image.php' );

			// PRICING TABLE
			require_once( 'elements/pricing-table.php' );

			// PROGRESS BAR
			require_once( 'elements/progress-bar.php' );

			// ROW
			require_once( 'elements/row.php' );

			// SERVICE
			require_once( 'elements/service.php' );

			// SLIDER
			require_once( 'elements/slider.php' );

			// TABS
			require_once( 'elements/tabs.php' );

			// TEAM MEMBER
			require_once( 'elements/team-member.php' );

			// TESTIMONIAL
			require_once( 'elements/testimonial.php' );

			// TEXT BLOCK
			require_once( 'elements/text-block.php' );

		}
	}
	add_action( 'vc_before_init', 'lsvr_vc_register_shortcodes' );

} ?>
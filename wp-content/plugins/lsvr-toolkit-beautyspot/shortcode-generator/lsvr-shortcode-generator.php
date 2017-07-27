<?php

/* -----------------------------------------------------------------------------

    GENERATOR CONFIG

----------------------------------------------------------------------------- */

if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/themes.php?page=aq-page-builder' ) ) {

    /* -------------------------------------------------------------------------
        CREATE SHORTCODES DATA
    ------------------------------------------------------------------------- */

    function lsvr_sg_generate_data() {

		global $shortcode_tags;

		// create list of shortcode function names
		$shortcodes_list = array();
		foreach ( $shortcode_tags as $key => $val ){
			if ( is_string( $val ) && substr( $val, 0, 5 ) === 'lsvr_' && function_exists( $val ) ) {
				array_push( $shortcodes_list, $val );
			}
		}
		$shortcodes_list = array_unique( $shortcodes_list );

		// join list to single array of generated params
		$shortcodes_list_generated = array();
		foreach ( $shortcodes_list as $val ) {
			if ( function_exists( $val ) && is_array( call_user_func( $val, false, false, true ) ) ) {
				$shortcodes_list_generated = array_merge( $shortcodes_list_generated, call_user_func( $val, false, false, true ) );
			}
		}

		// print JSON
		if ( is_array( $shortcodes_list_generated ) && count( $shortcodes_list_generated ) > 0 ) {
			ksort( $shortcodes_list_generated );
			echo '<script type="text/javascript">var lsvr_sg_shortcodes = ' . json_encode( $shortcodes_list_generated ) . '</script>';
		}

		// text vars to translate
		$lsvr_labels = '<var style="display: none;" id="lsvr-var-sg-title">' . __( 'Shortcode Generator', 'lsvrtoolkit' ) . '</var>';
		$lsvr_labels .= '<var style="display: none;" id="lsvr-var-sg-choose-sc">' . __( 'Choose shortcode from the list', 'lsvrtoolkit' ) . '</var>';
		$lsvr_labels .= '<var style="display: none;" id="lsvr-var-sg-add-sc">' . __( 'Add Shortcode', 'lsvrtoolkit' ) . '</var>';
		$lsvr_labels .= '<var style="display: none;" id="lsvr-var-sg-select-images">' . __( 'Select Images', 'lsvrtoolkit' ) . '</var>';
		echo $lsvr_labels;

    }
    add_filter( 'admin_footer', 'lsvr_sg_generate_data' );

    /* -------------------------------------------------------------------------
        LOAD CSS & JS
    ------------------------------------------------------------------------- */

    function lsvr_load_shortcode_generator_files() {

        wp_register_style( 'font-awesome', plugins_url( 'lsvr-toolkit-beautyspot' ) . '/library/css/font-awesome.min.css', false );
        wp_enqueue_style( 'font-awesome' );
        wp_register_style( 'shortcode-generator', plugins_url( 'lsvr-toolkit-beautyspot' ) . '/library/css/shortcode-generator.css', false );
        wp_enqueue_style( 'shortcode-generator' );
        wp_register_script( 'shortcode-generator', plugins_url( 'lsvr-toolkit-beautyspot' ) . '/library/js/shortcode-generator.js', array('jquery') );
        wp_enqueue_script( 'shortcode-generator' );

    }
    add_action( 'admin_enqueue_scripts', 'lsvr_load_shortcode_generator_files' );

    /* -------------------------------------------------------------------------
        ADD BUTTON TO EDITOR
    ------------------------------------------------------------------------- */

	// see lsvr-functions.php

}


/* -----------------------------------------------------------------------------

    INCLUDE SHORTCODES

----------------------------------------------------------------------------- */

    // ACCORDION
    require_once( 'shortcodes/accordion.php' );

    // ALERT MESSAGE
    require_once( 'shortcodes/alert-message.php' );

    // ARTICLES
    require_once( 'shortcodes/articles.php' );

    // BUTTON
    require_once( 'shortcodes/button.php' );

	// BUTTON (Visual Composer)
    require_once( 'shortcodes/button_vc.php' );

    // CAROUSEL
    require_once( 'shortcodes/carousel.php' );

    // CONTAINER
    require_once( 'shortcodes/container.php' );

    // CTA
    require_once( 'shortcodes/cta.php' );

    // CUSTOM OBJECT
    require_once( 'shortcodes/custom-object.php' );

    // DIVIDER
    require_once( 'shortcodes/divider.php' );

    // GALLERY
    require_once( 'shortcodes/gallery.php' );

	// GALLERY (Visual Composer)
    require_once( 'shortcodes/gallery_vc.php' );

	// GOOGLE MAP
    require_once( 'shortcodes/gmap.php' );

    // GRID
    require_once( 'shortcodes/grid.php' );

    // ICON
    require_once( 'shortcodes/icon.php' );

    // ICON BLOCK
    require_once( 'shortcodes/icon-block.php' );

    // IMAGE
    require_once( 'shortcodes/image.php' );

	// IMAGE (Visual Composer)
    require_once( 'shortcodes/image_vc.php' );

    // LEAD
    require_once( 'shortcodes/lead.php' );

    // LIST
    require_once( 'shortcodes/list.php' );

    // PRICING TABLE
    require_once( 'shortcodes/pricing-table.php' );

    // PROGRESS BAR
    require_once( 'shortcodes/progress-bar.php' );

    // SERVICE
    require_once( 'shortcodes/service.php' );

    // SECTION
    require_once( 'shortcodes/section.php' );

    // SLIDER
    require_once( 'shortcodes/slider.php' );

    // TABS
    require_once( 'shortcodes/tabs.php' );

    // TEAM MEMBER
    require_once( 'shortcodes/team-member.php' );

    // TESTIMONIAL
    require_once( 'shortcodes/testimonial.php' );

	// VIDEO
	require_once( 'shortcodes/video.php' );

?>
<?php

if ( class_exists( 'AQ_Page_Builder' ) ) {

/* -----------------------------------------------------------------------------

    INIT

----------------------------------------------------------------------------- */

    define( 'AQPB_CUSTOM_DIR', plugin_dir_path( __FILE__ ) );
    define( 'AQPB_CUSTOM_URI', plugins_url( '', __FILE__ ) );

    $theme = wp_get_theme();
    $theme_version = $theme->Version;

    function lsvr_legacy_page_builder_assets() {

        global $theme_version;

        // jHtmlArea WYSIWYG editor
        // http://jhtmlarea.codeplex.com/
        wp_register_style( 'legacy-htmlarea', plugins_url( 'lsvr-toolkit-beautyspot' ) . '/legacy/library/htmlarea/jHtmlArea.css', false, $theme_version );
        wp_enqueue_style( 'legacy-htmlarea' );
        wp_register_style( 'legacy-htmlarea-colorpicker', plugins_url( 'lsvr-toolkit-beautyspot' ) . '/legacy/library/htmlarea/jHtmlArea.ColorPickerMenu.css', false, $theme_version );
        wp_enqueue_style( 'legacy-htmlarea-colorpicker' );
        wp_register_script( 'legacy-htmlarea', plugins_url( 'lsvr-toolkit-beautyspot' ) . '/legacy/library/htmlarea/jHtmlArea.0.7.5.js', array('jquery'), $theme_version );
        wp_enqueue_script( 'legacy-htmlarea' );
        wp_register_script( 'legacy-htmlarea-colorpicker', plugins_url( 'lsvr-toolkit-beautyspot' ) . '/legacy/library/htmlarea/jHtmlArea.colorpickermenu.0.7.0.min.js', array('jquery'), $theme_version );
        wp_enqueue_script( 'legacy-htmlarea-colorpicker' );

        // Custom CSS & JS
        wp_register_style( 'legacy-lsvr-page-builder', plugins_url( 'lsvr-toolkit-beautyspot' ) . '/legacy/library/css/page-builder.css', false, $theme_version );
        wp_enqueue_style( 'legacy-lsvr-page-builder' );
        wp_register_script( 'legacy-lsvr-page-builder', plugins_url( 'lsvr-toolkit-beautyspot' ) . '/legacy/library/js/page-builder.js', array('jquery'), $theme_version, true );
        wp_enqueue_script( 'legacy-lsvr-page-builder' );

    }
    if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/themes.php?page=aq-page-builder' ) ) {
        add_action( 'admin_enqueue_scripts', 'lsvr_legacy_page_builder_assets' );
    }


/* -----------------------------------------------------------------------------

    CUSTOM BLOCK CLASS

----------------------------------------------------------------------------- */

    if ( ! class_exists( 'lsvr_block' ) ) {
    	class lsvr_block extends AQ_Block {

         	function before_block( $instance ) {
                $block_offset = array_key_exists( 'block_offset', $instance ) && intval( $instance[ 'block_offset' ] ) > 0 ? ' col-md-offset-' .  $instance[ 'block_offset' ] : '';
                if ( is_array( $instance ) && array_key_exists( 'size', $instance ) && $instance[ 'size' ] !== 'span12' ) {
					$col_class = str_replace( 'span', 'col-md-', $instance[ 'size' ] );
                    echo '<div class="' . $col_class . $block_offset . '">';
                }
         	}

         	function after_block($instance) {
                if ( is_array( $instance ) && array_key_exists( 'size', $instance ) && $instance[ 'size' ] !== 'span12' ) {
                    echo '</div>';
                }
         	}

        }
    }


/* -----------------------------------------------------------------------------

    CUSTOM FIELDS

----------------------------------------------------------------------------- */

	function lsvr_field_editor( $field_id, $block_id, $text ) {
        $html = '<script type="text/javascript"> /* jQuery(document).ready( function(){ lsvr_init_editor_fields(); } ); */ </script>';
        $html .= '<div class="lsvr-field-editor"><textarea id="' . $block_id . '_' . $field_id . '" name="aq_blocks[' . $block_id . '][' . $field_id . ']" cols="50" rows="15">' . $text . '</textarea></div>';
        return $html;
	}

	function lsvr_field_editor_tabs( $tab_content_id, $tab_content_name, $tab_content_html ) {
        $html = '<script type="text/javascript"> /* jQuery(document).ready( function(){ lsvr_init_editor_fields(); } ); */ </script>';
        $html .= '<div class="lsvr-field-editor"><textarea id="' . $tab_content_id . '" name="' . $tab_content_name . '" cols="50" rows="15">' . $tab_content_html . '</textarea></div>';
        return $html;
	}

	function lsvr_field_color_picker_tabs( $tab_content_id, $tab_content_name, $color, $default = '' ) {
        $html = '<script type="text/javascript"> /* jQuery(document).ready( function(){ lsvr_create_colorpicker_field(); } ); */ </script>';
		$html .= '<div class="aqpb-color-picker">';
			$html .= '<input type="text" id="' . $tab_content_id . '" class="input-color-picker" value="'. $color .'" name="' . $tab_content_name . '" data-default-color="'. $default .'"/>';
		$html .= '</div>';
		return $html;
	}

	function lsvr_field_upload_tabs( $tab_content_id, $tab_content_name, $tab_content_value, $tab_content_id_hidden, $tab_content_name_hidden, $tab_content_value_hidden, $media_type = 'image' ) {
        $html = '<script type="text/javascript"> /* jQuery(document).ready( function(){ lsvr_init_editor_fields(); } ); */ </script>';
		$html .= $tab_content_value !== '' ? '<img class="screenshot" src="' . $tab_content_value . '" width="300">' : '';
		$html .= '<input type="hidden" id="' . $tab_content_id_hidden . '" class="image-id" value="' . $tab_content_value_hidden . '" name="' . $tab_content_name_hidden . '">';
		$html .= '<input type="text" id="' . $tab_content_id . '" class="input-full input-upload image-url" value="' . $tab_content_value . '" name="' . $tab_content_name . '">';
		$html .= '<a href="#" class="aq_upload_button button" rel="' . $media_type . '">Upload</a><p></p>';
        return $html;
	}

	function lsvr_field_editor_output( $output ) {
        $html = html_entity_decode( $output );
        return do_shortcode( lsvr_shortcodes_content_filter( wpautop( $html ) ) );
	}


/* -----------------------------------------------------------------------------

    REGISTER CUSTOM BLOCKS

----------------------------------------------------------------------------- */

    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    // ALERT
    require_once( AQPB_CUSTOM_DIR . 'blocks/alert-message.php' );
    aq_register_block( 'lsvr_alert_block' );

    // ARTICLES
    require_once( AQPB_CUSTOM_DIR . 'blocks/articles.php' );
    aq_register_block( 'lsvr_articles_block' );

    // CAROUSEL
    require_once( AQPB_CUSTOM_DIR . 'blocks/carousel.php' );
    aq_register_block( 'lsvr_carousel_block' );

    // CTA
    require_once( AQPB_CUSTOM_DIR . 'blocks/cta.php' );
    aq_register_block( 'lsvr_cta_block' );

    // DIVIDER
    require_once( AQPB_CUSTOM_DIR . 'blocks/divider.php' );
    aq_register_block( 'lsvr_divider_block' );

    // GALLERY
    require_once( AQPB_CUSTOM_DIR . 'blocks/gallery.php' );
    aq_register_block( 'lsvr_gallery_block' );

    // LIST
    require_once( AQPB_CUSTOM_DIR . 'blocks/list.php' );
    aq_register_block( 'lsvr_list_block' );

    // PRICING TABLE
    require_once( AQPB_CUSTOM_DIR . 'blocks/pricing-table.php' );
    aq_register_block( 'lsvr_pricing_table_block' );

    // ROW
    require_once( AQPB_CUSTOM_DIR . 'blocks/row.php' );
    aq_register_block( 'lsvr_row_block' );

    // SECTION
    require_once( AQPB_CUSTOM_DIR . 'blocks/section.php' );
    aq_register_block( 'lsvr_section_block' );

    // FEATURE
    require_once( AQPB_CUSTOM_DIR . 'blocks/service.php' );
    aq_register_block( 'lsvr_service_block' );

    // SLIDER
	require_once( AQPB_CUSTOM_DIR . 'blocks/slider.php' );
	aq_register_block( 'lsvr_slider_block' );

    // TABS & ACCORDION
    require_once( AQPB_CUSTOM_DIR . 'blocks/tabs.php' );
    aq_register_block( 'lsvr_tabs_block' );

    // TEAM MEMBER
    require_once( AQPB_CUSTOM_DIR . 'blocks/team-member.php' );
    aq_register_block( 'lsvr_team_member_block' );

    // TESTIMONIAL
    require_once( AQPB_CUSTOM_DIR . 'blocks/testimonial.php' );
    aq_register_block( 'lsvr_testimonial_block' );

    // TEXT
    require_once( AQPB_CUSTOM_DIR . 'blocks/text.php' );
    aq_register_block( 'lsvr_text_block' );

    // VIDEO
    require_once( AQPB_CUSTOM_DIR . 'blocks/video.php' );
    aq_register_block( 'lsvr_video_block' );


/* -----------------------------------------------------------------------------

    UNREGISTER DEFAULT BLOCKS AND CSS/JS

----------------------------------------------------------------------------- */

    add_action( 'init', 'lsvr_shortcodes_content_filter_aqpb_unregister_defaults' );
    function lsvr_shortcodes_content_filter_aqpb_unregister_defaults() {

        // remove ajax action of default Tabs block
        global $aq_registered_blocks;
		$aq_tabs_class = $aq_registered_blocks['aq_tabs_block'];
        remove_action( 'wp_ajax_aq_block_tab_add_new', array( $aq_tabs_class, 'add_tab' ) );

        // unregister default blocks, styles and scripts
        aq_unregister_block( 'aq_text_block' );
        aq_unregister_block( 'aq_alert_block' );
        aq_unregister_block( 'aq_clear_block' );
        aq_unregister_block( 'aq_widgets_block' );
        aq_unregister_block( 'aq_column_block' );
        aq_unregister_block( 'aq_tabs_block' );
        wp_deregister_style( 'aqpb-view-css' );
        wp_dequeue_script( 'aqpb-view-js' );

    }

}
?>
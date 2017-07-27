<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Carousel', 'lsvr-toolkit' ),
	'description' => __( 'Used to divide similar elements into multiple slides', 'lsvr-toolkit' ),
    'base' => 'lsvr_carousel',
	'icon' => 'lsvr-vc-ico fa fa-arrows-h',
    'as_parent' => array( 'only' => 'lsvr_carousel_item,lsvr_service,lsvr_testimonial,lsvr_image' ),
    'content_element' => true,
    'show_settings_on_create' => true,
	'js_view' => 'VcColumnView',
    'params' => array(
		array(
			'param_name' => 'wrap_in_container',
            'type' => 'checkbox',
            'heading' => __( 'Wrap content in Container', 'lsvr-toolkit' ),
			'description' => __( 'Useful if you are using this element in Fullsize template. Enable only if this element is not already nested in another element which is wrapped in Container (e.g. Row).', 'lsvr-toolkit' ),
			'value' => array( __( 'Wrap', 'lsvrtheme' ) => 'yes' ),
        ),
		array(
			'param_name' => 'transparent_bg',
            'type' => 'checkbox',
            'heading' => __( 'Transparent Background', 'lsvr-toolkit' ),
			'value' => array( __( 'Enable', 'lsvrtheme' ) => 'yes' ),
        ),
        array(
			'param_name' => 'bg_color',
            'type' => 'textfield',
            'heading' => __( 'Background Color', 'lsvr-toolkit' ),
			'description' => __( 'For example "#323232". "Transparent Background" must be disabled for this option to work.', 'lsvr-toolkit' ),
        ),
        array(
			'param_name' => 'items_per_slide',
            'type' => 'dropdown',
			'heading' => __( 'Items Per Slide', 'lsvr-toolkit' ),
			'value' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ),
        ),
        array(
			'param_name' => 'items_per_slide_desktop',
            'type' => 'dropdown',
			'heading' => __( 'Items Per Slide Under 1200px', 'lsvr-toolkit' ),
			'value' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ),
        ),
        array(
			'param_name' => 'items_per_slide_smalldesktop',
            'type' => 'dropdown',
			'heading' => __( 'Items Per Slide Under 992px', 'lsvr-toolkit' ),
			'value' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ),
        ),
        array(
			'param_name' => 'items_per_slide_tablet',
            'type' => 'dropdown',
			'heading' => __( 'Items Per Slide Under 768px', 'lsvr-toolkit' ),
			'value' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ),
        ),
        array(
			'param_name' => 'items_per_slide_mobile',
            'type' => 'dropdown',
			'heading' => __( 'Items Per Slide Under 481px', 'lsvr-toolkit' ),
			'value' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ),
        ),
        array(
			'param_name' => 'autoplay',
            'type' => 'dropdown',
			'heading' => __( 'Autoplay Speed', 'lsvr-toolkit' ),
			'description' => __( 'In seconds. Set to 0 to disable', 'lsvr-toolkit' ),
			'value' => array( '0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8,
			'9' => 9, '10' => 10, '11' => 11, '12' => 12, '13' => 13, '14' => 14, '15' => 15, '16' => 16, '17' => 17, '18' => 18, '19' => 19, '20' => 20 ),
        ),
        array(
			'param_name' => 'inview_anim',
            'type' => 'dropdown',
            'heading' => __( 'InView Animation', 'lsvr-toolkit' ),
			'description' => __( 'This animation will fire when element appears in the user\'s viewport.', 'lsvr-toolkit' ),
			'value' => $lsvr_inview_animations_vc,
        ),
        array(
			'param_name' => 'custom_class',
            'type' => 'textfield',
            'heading' => __( 'Extra class name', 'lsvr-toolkit' ),
			'description' => __( 'It can be used for applying custom CSS.', 'lsvr-toolkit' ),
        ),
    ),
));
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Lsvr_Carousel extends WPBakeryShortCodesContainer {}
}

// CAROUSEL ITEM
vc_map( array(
    'name' => __( 'Carousel Item', 'lsvr-toolkit' ),
    'base' => 'lsvr_carousel_item',
	'icon' => 'lsvr-vc-ico fa fa-angle-right',
    'content_element' => true,
	'as_child' => array( 'only' => 'lsvr_carousel' ),
    'show_settings_on_create' => true,
	'params' => array(
		array(
			'param_name' => 'content',
            'type' => 'textarea_html',
            'heading' => __( 'Content', 'lsvr-toolkit' ),
        ),
    ),
));
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Lsvr_Carousel_Item extends WPBakeryShortCode {}
}

?>
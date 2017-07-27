<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Accordion', 'lsvr-toolkit' ),
    'base' => 'lsvr_accordion',
	'icon' => 'lsvr-vc-ico fa fa-bars',
    'as_parent' => array( 'only' => 'lsvr_accordion_item' ),
    'content_element' => true,
    'show_settings_on_create' => true,
	'js_view' => 'VcColumnView',
    'params' => array(
        array(
			'param_name' => 'toggle',
            'type' => 'checkbox',
            'heading' => __( 'Toggle', 'lsvr-toolkit' ),
			'description' => __( 'This accordion will behave as a toggle if enabled.', 'lsvr-toolkit' ),
			'value' => array( __( 'Enable', 'lsvrtheme' ) => 'yes' ),
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
	class WPBakeryShortCode_Lsvr_Accordion extends WPBakeryShortCodesContainer {}
}

// ACCORDION ITEM
vc_map( array(
    'name' => __( 'Accordion Item', 'lsvr-toolkit' ),
    'base' => 'lsvr_accordion_item',
	'icon' => 'lsvr-vc-ico fa fa-angle-right',
    'content_element' => true,
	'as_child' => array( 'only' => 'lsvr_accordion' ),
    'show_settings_on_create' => true,
    'params' => array(
        array(
			'param_name' => 'title',
            'type' => 'textfield',
            'heading' => __( 'Title', 'lsvr-toolkit' ),
			'holder' => 'div'
        ),
		array(
			'param_name' => 'content',
            'type' => 'textarea_html',
            'heading' => __( 'Text', 'lsvr-toolkit' ),
        ),
        array(
			'param_name' => 'price',
            'type' => 'textfield',
            'heading' => __( 'Price Info', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'oldprice',
            'type' => 'textfield',
            'heading' => __( 'Old Price Info', 'lsvr-toolkit' ),
        ),
        array(
			'param_name' => 'state',
            'type' => 'checkbox',
            'heading' => __( 'Open by default', 'lsvr-toolkit' ),
			'value' => array( __( 'Enable', 'lsvrtheme' ) => 'opened' ),
        ),
    ),
));
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Lsvr_Accordion_Item extends WPBakeryShortCode {}
}

?>
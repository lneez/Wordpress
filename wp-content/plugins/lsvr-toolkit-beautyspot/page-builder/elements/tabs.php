<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Tabs', 'lsvr-toolkit' ),
	'description' => __( 'Tabbed content', 'lsvr-toolkit' ),
    'base' => 'lsvr_tabs',
	'icon' => 'lsvr-vc-ico fa fa-folder-o',
    'as_parent' => array( 'only' => 'lsvr_tab_item' ),
    'content_element' => true,
    'show_settings_on_create' => false,
	'js_view' => 'VcColumnView',
    'params' => array(
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
	class WPBakeryShortCode_Lsvr_Tabs extends WPBakeryShortCodesContainer {}
}

// TAB ITEM
vc_map( array(
    'name' => __( 'Tab Item', 'lsvr-toolkit' ),
    'base' => 'lsvr_tab_item',
	'icon' => 'lsvr-vc-ico fa fa-angle-right',
    'content_element' => true,
	'as_child' => array( 'only' => 'lsvr_tabs' ),
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
    ),
));
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Lsvr_Tab_Item extends WPBakeryShortCode {}
}

?>
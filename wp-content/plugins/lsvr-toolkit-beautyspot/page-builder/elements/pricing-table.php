<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Pricing Table', 'lsvr-toolkit' ),
    'base' => 'lsvr_pricing_table',
	'icon' => 'lsvr-vc-ico fa fa-usd',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'title',
            'type' => 'textfield',
            'heading' => __( 'Title', 'lsvr-toolkit' ),
			'holder' => 'div'
        ),
		array(
			'param_name' => 'price',
            'type' => 'textfield',
            'heading' => __( 'Price', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'price_description',
            'type' => 'textfield',
            'heading' => __( 'Price Description', 'lsvr-toolkit' ),
			'description' => __( 'It will be displayed under price', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'content',
            'type' => 'textarea_html',
            'heading' => __( 'Content', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'button_label',
            'type' => 'textfield',
            'heading' => __( 'Button Label', 'lsvr-toolkit' ),
			'description' => __( 'Leave blank to hide', 'lsvr-toolkit' ),
        ),
        array(
			'param_name' => 'button_link',
            'type' => 'textfield',
            'heading' => __( 'Button Link', 'lsvr-toolkit' ),
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

?>
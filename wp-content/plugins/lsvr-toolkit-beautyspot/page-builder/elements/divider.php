<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Divider', 'lsvr-toolkit' ),
	'description' => __( 'Horizontal separator line', 'lsvr-toolkit' ),
    'base' => 'lsvr_divider',
	'icon' => 'lsvr-vc-ico fa fa-minus',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
        array(
			'param_name' => 'whitespace_size',
            'type' => 'dropdown',
            'heading' => __( 'Whitespace size', 'lsvr-toolkit' ),
			'description' => __( 'Determines the top and bottom margins.', 'lsvr-toolkit' ),
			'value' => array( __( 'Default', 'lsvr-toolkit' ) => 'm-small', __( 'Small', 'lsvr-toolkit' ) => 'm-x-small', __( 'Medium', 'lsvr-toolkit' ) => 'm-medium', __( 'Large', 'lsvr-toolkit' ) => 'm-large' ),
        ),
        array(
			'param_name' => 'transparent',
            'type' => 'checkbox',
            'heading' => __( 'Transparent', 'lsvr-toolkit' ),
			'value' => array( __( 'Yes', 'lsvr-toolkit' ) => 'yes' ),
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
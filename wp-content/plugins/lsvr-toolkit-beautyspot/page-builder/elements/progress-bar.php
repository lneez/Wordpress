<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Progress Bar', 'lsvr-toolkit' ),
	'description' => __( 'Animated progress bar', 'lsvr-toolkit' ),
    'base' => 'lsvr_progressbar',
	'icon' => 'lsvr-vc-ico fa fa-bar-chart',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'label',
            'type' => 'textfield',
            'heading' => __( 'Title', 'lsvr-toolkit' ),
			'holder' => 'div'
        ),
        array(
			'param_name' => 'percentage',
            'type' => 'dropdown',
            'heading' => __( 'Percentage', 'lsvr-toolkit' ),
			'value' => array( '0' => 0, '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40, '45' => 45, '50' => 50, '55' => 55, '60' => 60, '65' => 65, '70' => 70, '75' => 75, '80' => 80, '85' => 85, '90' => 90, '95' => 95, '100' => 100 ),
        ),
        array(
			'param_name' => 'color',
            'type' => 'dropdown',
            'heading' => __( 'Color', 'lsvr-toolkit' ),
			'value' => array( __( 'Color 1', 'lsvr-toolkit' ) => 'm-color-1', __( 'Color 2', 'lsvr-toolkit' ) => 'm-color-2', __( 'Color 3', 'lsvr-toolkit' ) => 'm-color-3' ),
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
<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Button', 'lsvr-toolkit' ),
    'base' => 'lsvr_button_vc',
	'icon' => 'lsvr-vc-ico fa fa-hand-o-up',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'text',
            'type' => 'textfield',
            'heading' => __( 'Text', 'lsvr-toolkit' ),
			'holder' => 'div'
        ),
        array(
			'param_name' => 'link',
            'type' => 'textfield',
            'heading' => __( 'Link', 'lsvr-toolkit' ),
        ),
        array(
			'param_name' => 'target',
            'type' => 'dropdown',
            'heading' => __( 'Link target', 'lsvr-toolkit' ),
			'value' => array( __( 'Default', 'lsvr-toolkit' ) => 'default', __( 'New Tab', 'lsvr-toolkit'  ) => 'blank' ),
        ),
        array(
			'param_name' => 'size',
            'type' => 'dropdown',
            'heading' => __( 'Size', 'lsvr-toolkit' ),
			'value' => array( __( 'Default', 'lsvr-toolkit' ) => 'm-default', __( 'Medium', 'lsvr-toolkit' ) => 'm-medium', __( 'Big', 'lsvr-toolkit' ) => 'm-big' ),
        ),
        array(
			'param_name' => 'icon',
            'type' => 'textfield',
            'heading' => __( 'Icon', 'lsvr-toolkit' ),
			'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvr-toolkit' ),
        ),
        array(
			'param_name' => 'color',
            'type' => 'dropdown',
            'heading' => __( 'Color', 'lsvr-toolkit' ),
			'value' => array( __( 'Color 1', 'lsvr-toolkit' ) => 'm-color-1', __( 'Color 2', 'lsvr-toolkit' ) => 'm-color-2', __( 'Color 3', 'lsvr-toolkit' ) => 'm-color-3' ),
        ),
        array(
			'param_name' => 'style',
            'type' => 'dropdown',
            'heading' => __( 'Style', 'lsvr-toolkit' ),
			'value' => array( __( 'Default', 'lsvr-toolkit' ) => 'default', __( 'Outline', 'lsvr-toolkit' ) => 'm-type-2' ),
        ),
		array(
			'param_name' => 'section_button',
            'type' => 'checkbox',
            'heading' => __( 'Use as section button', 'lsvr-toolkit' ),
			'description' => __( 'Button have to be placed immediately after Heading 2. It will be aligned to right and moved up to match heading vertical position.', 'lsvr-toolkit' ),
			'value' => array( __( 'Yes', 'lsvr-toolkit' ) => 'yes' )
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
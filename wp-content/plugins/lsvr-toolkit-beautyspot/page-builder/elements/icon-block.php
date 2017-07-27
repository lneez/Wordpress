<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Icon Block', 'lsvr-toolkit' ),
	'description' => __( 'Small text block with icon and title', 'lsvr-toolkit' ),
    'base' => 'lsvr_icon_block',
	'icon' => 'lsvr-vc-ico fa fa-heart-o',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'icon',
            'type' => 'textfield',
            'heading' => __( 'Icon', 'lsvr-toolkit' ),
			'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'content',
            'type' => 'textarea_html',
            'heading' => __( 'Text', 'lsvr-toolkit' ),
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
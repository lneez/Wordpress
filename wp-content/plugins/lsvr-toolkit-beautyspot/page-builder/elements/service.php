<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtheme' ),
    'name' => __( 'Service', 'lsvrtoolkit' ),
	'description' => __( 'Text block with image and title', 'lsvrtoolkit' ),
    'base' => 'lsvr_service',
	'icon' => 'lsvr-vc-ico fa fa-suitcase',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'image',
            'type' => 'attach_image',
            'heading' => __( 'Image', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'image_size',
            'type' => 'textfield',
            'heading' => __( 'Size of Image', 'lsvr-toolkit' ),
			'description' => __( 'You can specify which image size will be used, e.g. "large" or "full". Sizes can be defined under <strong>Settings / Media</strong>. Leave blank to use a "medium" size.', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'image_rounded',
            'type' => 'checkbox',
            'heading' => __( 'Rounded Image', 'lsvr-toolkit' ),
			'description' => __( 'If you enable this, make sure that your uploaded image has square aspect ratio (1:1), for example 300x300px.', 'lsvr-toolkit' ),
			'value' => array( __( 'Enable', 'lsvrtheme' ) => 'yes' ),
        ),
        array(
			'param_name' => 'title',
            'type' => 'textfield',
            'heading' => __( 'Title', 'lsvr-toolkit' ),
			'holder' => 'div'
        ),
        array(
			'param_name' => 'link',
            'type' => 'textfield',
            'heading' => __( 'Title link', 'lsvr-toolkit' ),
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
            'heading' => __( 'Extra class name', 'lsvrtoolkit' ),
			'description' => __( 'It can be used for applying custom CSS.', 'lsvrtoolkit' ),
        ),
    ),
));

?>
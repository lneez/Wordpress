<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Image', 'lsvr-toolkit' ),
	'description' => __( 'Single image', 'lsvr-toolkit' ),
    'base' => 'lsvr_image_vc',
	'icon' => 'lsvr-vc-ico fa fa-file-image-o',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'image',
            'type' => 'attach_image',
            'heading' => __( 'Image', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'size',
            'type' => 'textfield',
            'heading' => __( 'Size of image', 'lsvr-toolkit' ),
			'description' => __( 'You can specify an image size which will be used, e.g. "large" or "full". Sizes can be defined under <strong>Settings / Media</strong>. Leave blank to use a "medium" size.', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'max_width',
            'type' => 'textfield',
            'heading' => __( 'Max width', 'lsvr-toolkit' ),
			'description' => __( 'You can define maximum width (in pixels, e.g. "100") to restrict image dimensions.', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'link',
            'type' => 'textfield',
            'heading' => __( 'Link', 'lsvr-toolkit' ),
        ),
        array(
			'param_name' => 'rounded',
            'type' => 'checkbox',
			'heading' => __( 'Rounded', 'lsvr-toolkit' ),
			'description' => __( 'Make sure to use an image with square aspect ratio (1:1), for example 400x400px.', 'lsvr-toolkit' ),
			'value' => array( __( 'Yes', 'lsvr-toolkit' ) => 'yes' ),
        ),
        array(
			'param_name' => 'lightbox',
            'type' => 'checkbox',
			'heading' => __( 'Open in lightbox', 'lsvr-toolkit' ),
			'description' => __( 'Open the full size of the image in lightbox.', 'lsvr-toolkit' ),
			'value' => array( __( 'Open', 'lsvr-toolkit' ) => 'yes' ),
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
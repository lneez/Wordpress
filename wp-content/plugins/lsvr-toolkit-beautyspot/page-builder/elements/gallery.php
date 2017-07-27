<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Gallery', 'lsvr-toolkit' ),
	'description' => __( 'Simple image gallery', 'lsvr-toolkit' ),
    'base' => 'lsvr_gallery_vc',
	'icon' => 'lsvr-vc-ico fa fa-th',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
        array(
			'param_name' => 'images',
            'type' => 'attach_images',
            'heading' => __( 'Images', 'lsvr-toolkit' ),
        ),
        array(
			'param_name' => 'carousel',
            'type' => 'checkbox',
			'heading' => __( 'Display as Carousel', 'lsvr-toolkit' ),
			'value' => array( __( 'Yes', 'lsvr-toolkit' ) => 'yes' ),
        ),
        array(
			'param_name' => 'items_per_slide',
            'type' => 'dropdown',
			'heading' => __( 'Images per Row/Slide', 'lsvr-toolkit' ),
			'description' => __( 'Items per slide if displayed as carousel or items per row if displayed as grid.', 'lsvr-toolkit' ),
			'value' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5 ),
        ),
		array(
			'param_name' => 'items_under_1200',
            'type' => 'dropdown',
			'heading' => __( 'Items per Slide under 1200px if displayed as Carousel', 'lsvr-toolkit' ),
			'value' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5 ),
        ),
		array(
			'param_name' => 'items_under_992',
            'type' => 'dropdown',
			'heading' => __( 'Items per Slide under 992px if displayed as Carousel', 'lsvr-toolkit' ),
			'value' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5 ),
        ),
		array(
			'param_name' => 'items_under_768',
            'type' => 'dropdown',
			'heading' => __( 'Items per Slide under 768px if displayed as Carousel', 'lsvr-toolkit' ),
			'value' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5 ),
        ),
		array(
			'param_name' => 'items_under_481',
            'type' => 'dropdown',
			'heading' => __( 'Items per Slide under 481px if displayed as Carousel', 'lsvr-toolkit' ),
			'value' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5 ),
        ),
		array(
			'param_name' => 'size',
            'type' => 'textfield',
            'heading' => __( 'Size of images', 'lsvr-toolkit' ),
			'description' => __( 'You can specify an image size which will be used, e.g. "large" or "full". Sizes can be defined under <strong>Settings / Media</strong>. Leave blank to use a "medium" size.', 'lsvr-toolkit' ),
        ),
        array(
			'param_name' => 'crop',
            'type' => 'checkbox',
			'heading' => __( 'Crop images', 'lsvr-toolkit' ),
			'description' => __( 'Useful if you want to use images with different aspect ratio.', 'lsvr-toolkit' ),
			'value' => array( __( 'Crop', 'lsvr-toolkit' ) => 'yes' ),
        ),
		array(
			'param_name' => 'crop_aspect_ratio',
            'type' => 'textfield',
            'heading' => __( 'Crop aspect ratio', 'lsvr-toolkit' ),
			'description' => __( 'Percentual value of height relative to width. For example "100" for 1:1 aspect ratio, "75" for 4:3, "56" for 16:9 etc. This will work only if you enable <strong>Crop Images</strong>.', 'lsvr-toolkit' ),
			'value' => '70'
        ),
		array(
			'param_name' => 'click_action',
            'type' => 'dropdown',
			'heading' => __( 'Click action', 'lsvr-toolkit' ),
			'value' => array( __( 'Open in Lightbox', 'lsvr-toolkit' ) => 'lightbox', __( 'Open in new tab', 'lsvr-toolkit' ) => 'tab', __( 'No click action', 'lsvr-toolkit' ) => 'disable' ),
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
<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Slider', 'lsvr-toolkit' ),
    'base' => 'lsvr_slider',
	'icon' => 'lsvr-vc-ico fa fa-list-alt',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
        array(
			'param_name' => 'slider',
            'type' => 'textfield',
            'heading' => __( 'Slider', 'lsvr-toolkit' ),
			'description' => __( 'Add a slider slug to load projects from. Sliders can be managed under <strong>Slides / Sliders</strong>. Leave blank to load slides regardless of category.', 'lsvr-toolkit' ),
			'holder' => 'div',
        ),
		array(
			'param_name' => 'fullsize',
            'type' => 'checkbox',
			'heading' => __( 'Fullsize', 'lsvr-toolkit' ),
			'description' => __( 'Enable if you are using this slider in Fullsize template.', 'lsvr-toolkit' ),
			'value' => array( __( 'Yes', 'lsvr-toolkit' ) => 'yes' ),
        ),
		array(
			'param_name' => 'interval',
            'type' => 'textfield',
			'heading' => __( 'Autoplay Speed', 'lsvr-toolkit' ),
			'description' => __( 'Duration between transitions in seconds. Leave blank to disable automatic slideshow.', 'lsvr-toolkit' ),
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